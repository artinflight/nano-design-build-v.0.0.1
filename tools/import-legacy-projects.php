<?php
/**
 * tools/import-legacy-projects.php (DRY-RUN capable)
 *
 * Examples:
 *  # Preview everything, no DB/media writes:
 *  docker exec -it wp-nano bash -lc 'php /var/www/html/wp-content/themes/nano-design-build/tools/import-legacy-projects.php --dry-run'
 *
 *  # Preview first 3 projects only:
 *  docker exec -it wp-nano bash -lc 'php /var/www/html/wp-content/themes/nano-design-build/tools/import-legacy-projects.php --dry-run --limit=3'
 *
 *  # Import for real (no overwrite of existing unless --force):
 *  docker exec -it wp-nano bash -lc 'php /var/www/html/wp-content/themes/nano-design-build/tools/import-legacy-projects.php'
 *
 *  # Force overwrite of bodies/galleries on existing posts:
 *  docker exec -it wp-nano bash -lc 'php /var/www/html/wp-content/themes/nano-design-build/tools/import-legacy-projects.php --force'
 */

//// Bootstrap WordPress (robust up-walk) ////
$bootstrap = null;
$dir = __DIR__;                  // .../wp-content/themes/nano-design-build/tools
for ($i = 0; $i < 6; $i++) {     // walk up max 6 levels
  $try = $dir . '/wp-load.php';
  if (file_exists($try)) { $bootstrap = $try; break; }
  $dir = dirname($dir);
}
if (!$bootstrap) {
  $try = '/var/www/html/wp-load.php';
  if (file_exists($try)) { $bootstrap = $try; }
}
if (!$bootstrap) {
  fwrite(STDERR, "wp-load not found (started at ".__DIR__.")\n");
  exit(1);
}
require_once $bootstrap;

// Media helpers (CLI)
if (!function_exists('media_sideload_image')) {
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';
}

/* ---------- CLI flags ---------- */
$opts = [
  'dry-run' => false,
  'force'   => false,
  'limit'   => 0,        // 0 = no limit
];
foreach ($argv as $arg) {
  if ($arg === '--dry-run') $opts['dry-run'] = true;
  if ($arg === '--force')   $opts['force']   = true;
  if (preg_match('/^--limit=(\d+)/', $arg, $m)) $opts['limit'] = (int)$m[1];
}

$DRY_RUN      = $opts['dry-run'];   // <<< SAFE MODE
$FORCE_UPDATE = $opts['force'];
$LIMIT        = $opts['limit'];

$BASE      = 'https://nanodesignbuild.com';
$INDEX_URL = $BASE . '/projects/';
$VERBOSE   = true;

if (!post_type_exists('project')) { fwrite(STDERR, "ERROR: CPT 'project' missing.\n"); exit(1); }

/* ---------- HTTP helpers ---------- */
function ndb_fetch($url, $timeout=25){
  $resp = wp_remote_get($url, [
    'timeout'=> $timeout,
    'user-agent' => 'NDB-Importer/1.2 (projects)',
    'headers' => ['Accept-Language' => 'en-CA,en;q=0.9'],
    'sslverify'=> false,
    'redirection'=>5,
  ]);
  if (is_wp_error($resp)) return $resp;
  $code = (int) wp_remote_retrieve_response_code($resp);
  if ($code >= 400) return new WP_Error('http_'.$code, "HTTP $code for $url");
  return wp_remote_retrieve_body($resp);
}
function ndb_head_ok_fuzzy($url){
  $try = function($u){
    $r = wp_remote_head($u, ['redirection'=>5,'sslverify'=>false,'timeout'=>20]);
    if (is_wp_error($r)) return false;
    $c = (int) wp_remote_retrieve_response_code($r);
    return ($c >= 200 && $c < 400);
  };
  if ($try($url)) return true;
  $p = wp_parse_url($url);
  if (!$p || empty($p['scheme'])) return false;
  $alt = $p; $alt['scheme'] = strtolower($p['scheme']) === 'https' ? 'http' : 'https';
  $alt_url = (isset($alt['scheme'])?$alt['scheme'].'://':'')
           . (isset($alt['host'])?$alt['host']:'')
           . (isset($alt['path'])?$alt['path']:'')
           . (isset($alt['query'])?'?'.$alt['query']:'')
           . (isset($alt['fragment'])?'#'.$alt['fragment']:'');
  return $try($alt_url);
}
function ndb_dom($html){
  libxml_use_internal_errors(true);
  $dom = new DOMDocument('1.0','UTF-8');
  $dom->loadHTML(mb_convert_encoding($html,'HTML-ENTITIES','UTF-8'));
  return [$dom, new DOMXPath($dom)];
}
function ndb_abs($u, $base){
  if (!$u) return '';
  if (preg_match('#^https?://#i',$u)) return $u;
  if (strpos($u,'//')===0) return 'https:'.$u;
  return rtrim($base,'/').'/'.ltrim($u,'/');
}
function ndb_clean($s){
  if ($s===null) return '';
  $s = html_entity_decode($s, ENT_QUOTES|ENT_HTML5, 'UTF-8');
  $s = preg_replace('/\xC2\xA0|\xE2\x80\xAF|\x{00A0}/u', ' ', $s);
  $s = preg_replace('/\s+/u', ' ', $s);
  return trim($s);
}
// Extract first http(s) URL from arbitrary text (e.g., <span>raw url</span>)
function ndb_first_url_in_text($s){
  if ($s === null) return '';
  if (preg_match('~https?://[^\s\'"]+~i', $s, $m)) return $m[0];
  return '';
}
// Promote legacy gallery thumbs → full-size
function ndb_fullsize_url($url){
  if (!$url) return $url;
  // strip -260x385 etc.
  $url = preg_replace('~-(\d+)x(\d+)(\.[a-z0-9]+)(\?.*)?$~i', '$3$4', $url);
  // remove /thumbs/ directory
  $url = preg_replace('~/thumbs/~i', '/', $url);
  // drop filename prefixes like thumbs_ or thumb-
  $url = preg_replace('~/(thumbs?[_-])~i', '/', $url);
  // strip query sizing hints
  $url = preg_replace('~\?(?:[^#]+)$~', '', $url);
  return $url;
}
// Accept both uploads and gallery paths (including old /wordpress/ prefix)
function ndb_is_upload_img($src){
  return (bool)preg_match('#/(wp-content|wordpress)/(uploads|gallery)/#i', $src);
}
// Accept common image extensions
function ndb_is_img_ext($url){
  return (bool)preg_match('~\.(jpe?g|png|gif|webp|svg)(\?.*)?$~i', $url);
}

/* ---------- Discover project URLs ---------- */
$index_html = ndb_fetch($INDEX_URL);
if (is_wp_error($index_html)) { echo "Fetch index failed: ".$index_html->get_error_message()."\n"; exit(1); }
list($dom, $xp) = ndb_dom($index_html);

$urls = [];
foreach ($xp->query('//a[@href]') as $a){
  $href = $a->getAttribute('href');
  if (!preg_match('#/projects/[^/]+/?$#i', $href)) continue;
  $abs = ndb_abs($href, $BASE);
  if (rtrim($abs,'/') === rtrim($INDEX_URL,'/')) continue;
  $urls[$abs] = true;
}
$project_urls = array_values(array_keys($urls));
sort($project_urls);
if ($LIMIT > 0) $project_urls = array_slice($project_urls, 0, $LIMIT);
printf("Discovered %d project URLs%s\n",
  count($project_urls),
  $LIMIT ? " (limited to $LIMIT)" : ''
);
if (!$project_urls) exit(0);

/* ---------- Prepare report ---------- */
$report = [
  'dry_run' => $DRY_RUN,
  'force'   => $FORCE_UPDATE,
  'limit'   => $LIMIT,
  'index'   => $INDEX_URL,
  'when'    => gmdate('c'),
  'items'   => [],
];

/* ---------- Process ---------- */
$total = 0;
foreach ($project_urls as $proj_url){
  $item = ['url'=>$proj_url, 'title'=>'', 'action'=>'', 'images'=>[], 'notes'=>[]];

  $html = ndb_fetch($proj_url);
  if (is_wp_error($html)) { $item['notes'][] = 'fetch-error: '.$html->get_error_message(); $report['items'][]=$item; continue; }
  list($pdom, $px) = ndb_dom($html);

  // Title
  $title = '';
  $h1 = $px->query('//h1');
  if ($h1 && $h1->length) $title = ndb_clean($h1->item(0)->textContent);
  if ($title===''){
    $ts = $px->query('//title');
    if ($ts && $ts->length) $title = ndb_clean($ts->item(0)->textContent);
    $title = preg_replace('#\s*\|\s*.*$#','',$title);
  }
  if ($title===''){ $item['notes'][]='no-title'; $report['items'][]=$item; continue; }
  $item['title'] = $title;

  // Content (light extraction)
  $content_html = '';
  $cands = [
    '//article',
    '//*[@id="content"]',
    '//*[@class[contains(.,"entry-content")]]',
    '//*[@class[contains(.,"post-content")]]'
  ];
  foreach ($cands as $q){
    $nodes = $px->query($q);
    if ($nodes && $nodes->length){
      $node = $nodes->item(0);
      $bits = [];
      foreach ($px->query('.//p | .//h2 | .//h3', $node) as $el){
        $bits[] = $pdom->saveHTML($el);
      }
      if ($bits){ $content_html = implode("\n", $bits); break; }
    }
  }
  if ($content_html===''){
    $ps = $px->query('//p');
    $grab = [];
    foreach ($ps as $p) {
      $t = ndb_clean($p->textContent);
      if (mb_strlen($t) >= 40) $grab[] = '<p>'.esc_html($t).'</p>';
      if (count($grab) >= 6) break;
    }
    $content_html = implode("\n", $grab);
  }
  $content_html .= "\n\n<p class=\"import-note\"><em>Imported from <a href=\"".esc_url($proj_url)."\" target=\"_blank\" rel=\"noopener\">legacy project</a>.</em></p>";

  // ---------- Images: collect from img, a[href], style url(...), span raw URLs ----------
  $img_urls = [];
  $add_img = function($raw) use (&$img_urls, $BASE){
    if (!$raw) return;
    $abs = ndb_abs($raw, $BASE);
    if (!(ndb_is_upload_img($abs) || ndb_is_img_ext($abs))) return;
    // normalize/promote to full-size; keep raw as fallback
    $promoted = ndb_fullsize_url($abs);
    $img_urls[$promoted] = true;
    $img_urls[$abs]      = true;
  };

  // <img src>
  foreach ($px->query('//img[@src]') as $img){
    $add_img($img->getAttribute('src'));
  }
  // <a href> direct image links
  foreach ($px->query('//a[@href]') as $a){
    $add_img($a->getAttribute('href'));
  }
  // inline background-image
  foreach ($px->query('//*[@style]') as $el){
    if (preg_match('#url\((["\']?)([^)\'"]+)\1\)#i', $el->getAttribute('style'), $m)) {
      $add_img($m[2]);
    }
  }
  // raw image URL inside <span>...</span>
  foreach ($px->query('//span') as $span){
    $raw = ndb_first_url_in_text($span->textContent);
    if ($raw) $add_img($raw);
  }
  // og:image as last hint
  foreach ($px->query('//meta[@property="og:image"][@content]') as $m){
    $add_img($m->getAttribute('content'));
  }

  $img_urls = array_keys($img_urls); // dedup, keep promoted-first order

  // HEAD check images in dry-run
  if ($DRY_RUN){
    foreach ($img_urls as $u) {
      $item['images'][] = ['url'=>$u, 'exists'=> ndb_head_ok_fuzzy($u)];
    }
  }

  // Existing?
  $existing = get_posts([
    'post_type'=>'project',
    'title'=>$title,
    'posts_per_page'=>1,
    'fields'=>'ids'
  ]);
  $exists = (bool)$existing;

  if ($exists && !$FORCE_UPDATE){
    $item['action'] = 'skip (exists)';
    $report['items'][] = $item;
    if ($VERBOSE) echo "SKIP: $title\n";
    continue;
  }

  if ($DRY_RUN){
    $item['action'] = $exists ? 'would update' : 'would import';
    $item['notes'][] = 'dry-run: no DB / media writes';
    $report['items'][] = $item;
    echo strtoupper($item['action']).": $title\n";
    $total++;
    continue;
  }

  // --- REAL WRITE PATH ---
  if ($exists){
    $post_id = $existing[0];
    wp_update_post(['ID'=>$post_id,'post_content'=>$content_html]);
    if ($VERBOSE) echo "UPDATED: $title\n";
  } else {
    $post_id = wp_insert_post([
      'post_type'=>'project','post_status'=>'publish',
      'post_title'=>$title,'post_content'=>$content_html
    ]);
    if ($VERBOSE) echo "IMPORTED: $title\n";
  }
  if (is_wp_error($post_id) || !$post_id){ echo "  ↳ ERROR: insert/update failed\n"; continue; }

  // Download images
  $gallery_ids = [];
  foreach ($img_urls as $i=>$u){
    $att_id = media_sideload_image($u, $post_id, $title, 'id');
    if (is_wp_error($att_id)){ if ($VERBOSE) echo "  ↳ image error: ".$att_id->get_error_message()."\n"; continue; }
    update_post_meta($att_id, '_source_url', $u);
    if ($i===0 && !has_post_thumbnail($post_id)){ set_post_thumbnail($post_id, $att_id); if ($VERBOSE) echo "  ↳ featured set\n"; }
    $gallery_ids[] = (int)$att_id;
  }
  if ($gallery_ids){
    update_post_meta($post_id, 'project_gallery', $gallery_ids);
    if ($VERBOSE) echo "  ↳ gallery: ".count($gallery_ids)." images\n";
  } else {
    if ($VERBOSE) echo "  ↳ no images found\n";
  }

  $item['action'] = $exists ? 'updated' : 'imported';
  $item['images'] = array_map(fn($u)=>['url'=>$u, 'downloaded'=>true], $img_urls);
  $report['items'][] = $item;
  $total++;
}

/* ---------- Save report ---------- */
$uploads = wp_upload_dir();
$dir = trailingslashit($uploads['basedir']).'import-reports';
if (!is_dir($dir)) wp_mkdir_p($dir);
$fname = sprintf('%s/projects-import-%s%s.json',
  $dir,
  gmdate('Ymd-His'),
  $DRY_RUN ? '-DRYRUN' : ''
);
file_put_contents($fname, json_encode($report, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
echo "Total processed: $total\n";
echo "Report: $fname\n";
