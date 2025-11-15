<?php
/**
 * tools/import-notes-journal.php
 * Run:
 * docker exec -it wp-nano bash -lc 'php /var/www/html/wp-content/themes/nano-design-build/tools/import-notes-journal.php'
 */

/* ---------- Bootstrap WordPress (5 levels up to /var/www/html) ---------- */
$WP_ROOT   = dirname(__FILE__, 5);          // → /var/www/html
$bootstrap = $WP_ROOT . '/wp-load.php';
if (!file_exists($bootstrap)) {
  fwrite(STDERR, "Bootstrap not found at: {$bootstrap}\n");
  exit(1);
}
require_once $bootstrap;

/* ---------- Admin media includes ---------- */
if ( ! function_exists('media_sideload_image') ) {
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';
}

/* ---------- Preconditions ---------- */
if ( ! post_type_exists('journal') ) {
  echo "ERROR: journal CPT missing.\n";
  exit(1);
}

/* ---------- Config ---------- */
$FORCE_UPDATE = true;     // overwrite content even if exists (fix old labels)
$VERBOSE      = true;     // print chosen image + links per entry
$SITE_HOST    = preg_replace('#^www\.#i','', parse_url(home_url(), PHP_URL_HOST) ?: 'nanodesignbuild.com');

/* ---------- Helpers ---------- */
function ndb_clean_text($s){
  if ($s === null) return '';
  $s = html_entity_decode($s, ENT_QUOTES|ENT_HTML5, 'UTF-8');
  // NBSP variants → space
  $s = preg_replace('/\xC2\xA0|\xE2\x80\xAF|\x{00A0}/u', ' ', $s);
  // collapse whitespace
  $s = preg_replace('/\s+/u', ' ', $s);
  return trim($s);
}
function ndb_abs_url($u, $base='https://nanodesignbuild.com'){
  if (!$u) return '';
  if (strpos($u,'//')===0) return 'https:'.$u;
  if (!preg_match('#^https?://#i',$u)) return rtrim($base,'/').'/'.ltrim($u,'/');
  return $u;
}
function ndb_is_theme_img($src){
  return (bool)preg_match('#/wp-content/themes/nanodesignbuild/images/#i',$src);
}
function ndb_is_candidate_img($src){
  return (bool)preg_match('#/wp-content/(uploads|gallery)/#i',$src);
}
function ndb_bg_url($style){
  if (!$style) return '';
  if (preg_match('#url\((["\']?)([^)\'"]+)\1\)#i',$style,$m)) return $m[2];
  return '';
}
function ndb_host_label($url){
  $h = parse_url($url, PHP_URL_HOST);
  if (!$h) return 'Link';
  return preg_replace('#^www\.#i','',$h);
}

/** HTTP helper (friendly UA) */
function ndb_http_get($url){
  $args = [
    'timeout'    => 25,
    'user-agent' => 'WordPress/Importer (https://nano.local)',
    'headers'    => ['Accept-Language' => 'en-CA,en;q=0.9']
  ];
  return wp_remote_get($url, $args);
}

/** Parse DOM helper */
function ndb_dom_xpath($html){
  libxml_use_internal_errors(true);
  $dom = new DOMDocument('1.0','UTF-8');
  $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
  return new DOMXPath($dom);
}

/* ---------- Fetch Notes page ---------- */
$resp = ndb_http_get('https://nanodesignbuild.com/notes/');
if (is_wp_error($resp)) { echo "Fetch failed: ".$resp->get_error_message()."\n"; exit(1); }
$html = wp_remote_retrieve_body($resp);
if (!$html){ echo "Empty body\n"; exit(1); }
$xp_index = ndb_dom_xpath($html);

/* ---------- Image strategies ---------- */

/* 1) Date-aware: pick any <img> under /uploads/YYYY/MM/ (prefer size-suffixed like -260x385) */
function ndb_img_for_ym(DOMXPath $xp, $Y, $m){
  $ym = sprintf('/wp-content/uploads/%04d/%02d/', $Y, $m);
  // Prefer common WP thumbnail sizes (your samples use -260x385)
  $prefer = $xp->query('//img[contains(@src, "'.$ym.'") and (contains(@src,"-260x385") or contains(@src,"-385x260") or contains(@src,"-300x") or contains(@src,"-400x"))]');
  if ($prefer && $prefer->length){
    foreach ($prefer as $n){
      $src = ndb_abs_url($n->getAttribute('src'));
      if (!ndb_is_theme_img($src) && ndb_is_candidate_img($src)) return $src;
    }
  }
  // Otherwise, any image in that month
  $any = $xp->query('//img[contains(@src, "'.$ym.'")]');
  if ($any && $any->length){
    foreach ($any as $n){
      $src = ndb_abs_url($n->getAttribute('src'));
      if (!ndb_is_theme_img($src) && ndb_is_candidate_img($src)) return $src;
    }
  }
  return '';
}

/* 2) Nearest valid image around a node on the index */
$nearest_img = function(DOMNode $node) use ($xp_index){
  // previous <img>
  $prev = $xp_index->query('preceding::img[@src][1]', $node);
  if ($prev && $prev->length) {
    $src = ndb_abs_url($prev->item(0)->getAttribute('src'));
    if (!ndb_is_theme_img($src) && ndb_is_candidate_img($src)) return $src;
  }
  // next <img>
  $next = $xp_index->query('following::img[@src][1]', $node);
  if ($next && $next->length) {
    $src = ndb_abs_url($next->item(0)->getAttribute('src'));
    if (!ndb_is_theme_img($src) && ndb_is_candidate_img($src)) return $src;
  }
  // previous background-image
  $bgp = $xp_index->query('preceding::*[@style][contains(translate(@style,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"url(")][1]', $node);
  if ($bgp && $bgp->length){
    $u = ndb_abs_url(ndb_bg_url($bgp->item(0)->getAttribute('style')));
    if (!ndb_is_theme_img($u) && ndb_is_candidate_img($u)) return $u;
  }
  // next background-image
  $bgn = $xp_index->query('following::*[@style][contains(translate(@style,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"url(")][1]', $node);
  if ($bgn && $bgn->length){
    $u = ndb_abs_url(ndb_bg_url($bgn->item(0)->getAttribute('style')));
    if (!ndb_is_theme_img($u) && ndb_is_candidate_img($u)) return $u;
  }
  return '';
};

/* 3) From an internal detail page: og:image or first content <img> */
function ndb_image_from_internal($url){
  $resp = ndb_http_get($url);
  if (is_wp_error($resp)) return '';
  $html = wp_remote_retrieve_body($resp);
  if (!$html) return '';
  $xp = ndb_dom_xpath($html);

  // og:image
  $og = $xp->query('//meta[@property="og:image"]/@content');
  if ($og && $og->length){
    $img = ndb_abs_url($og->item(0)->value, $url);
    if (ndb_is_candidate_img($img)) return $img;
  }

  // first content image (skip theme)
  $imgs = $xp->query('//img[@src]');
  if ($imgs && $imgs->length){
    foreach ($imgs as $n){
      $src = ndb_abs_url($n->getAttribute('src'), $url);
      if (!ndb_is_theme_img($src) && ndb_is_candidate_img($src)) return $src;
    }
  }
  return '';
}

/* ---------- Process entries (H1 dates) ---------- */
$h1s   = $xp_index->query('//h1');
$total = 0;

foreach ($h1s as $h1){
  $date_raw = ndb_clean_text($h1->textContent);
  if (!preg_match('#^\d{2}\.\d{2}\.\d{4}$#',$date_raw)) continue;

  // Parse Y-m from date dd.mm.YYYY
  $d = DateTime::createFromFormat('d.m.Y', $date_raw);
  $Y = (int)$d->format('Y');
  $m = (int)$d->format('m');
  $date_iso = $d ? $d->format('Y-m-d 10:00:00') : current_time('mysql');

  // Collect forward block up to next H1
  $title=''; $body='';
  $links = []; // [ [href,label], ... ]
  $n = $h1;
  while ($n = $n->nextSibling){
    if ($n->nodeType===XML_ELEMENT_NODE && strtolower($n->nodeName)==='h1') break;
    if ($n->nodeType!==XML_ELEMENT_NODE) continue;
    $name = strtolower($n->nodeName);
    if ($name==='h2' && !$title) $title = ndb_clean_text($n->textContent);
    if ($name==='p'  && !$body)  $body  = ndb_clean_text($n->textContent);

    // collect anchors within this sibling
    $a_nodes = (new DOMXPath($n->ownerDocument))->query('.//a[@href]', $n);
    if ($a_nodes){
      foreach($a_nodes as $a){
        $href  = ndb_abs_url($a->getAttribute('href'));
        $label = ndb_clean_text($a->textContent);
        if ($label === '') {
          $label = ndb_clean_text($a->getAttribute('title')) ?: ndb_clean_text($a->getAttribute('aria-label')) ?: ndb_host_label($href);
        }
        $links[] = [$href,$label];
      }
    }
  }

  /* --- IMAGE PICKING ORDER ---
     (A) By year/month under /uploads/YYYY/MM/ (matches your examples)
     (B) Nearest index image/background
     (C) First internal-link page og:image / first content image
  */
  $image = ndb_img_for_ym($xp_index, $Y, $m);
  if (!$image) $image = $nearest_img($h1);
  if (!$image && $links){
    foreach ($links as $pair){
      $u = $pair[0];
      $host = preg_replace('#^www\.#i','', parse_url($u, PHP_URL_HOST));
      if ($host && $host === $GLOBALS['SITE_HOST']){
        $image = ndb_image_from_internal($u);
        if ($image) break;
      }
    }
  }

  // Copy touch-up (once)
  $improved = $body;
  $t = strtolower($title);
  $prefix = '';
  if (strpos($t,'globe')!==false && stripos($improved,'globe')===false){
    $prefix = 'Featured in The Globe and Mail — a profile of our work around light, proportion, and context. ';
  } elseif ((strpos($t,'green')!==false || strpos($t,'cagbc')!==false) && stripos($improved,'green')===false){
    $prefix = 'Joined the Canada Green Building Council — reflecting our focus on high-performance, durable construction. ';
  } elseif (strpos($t,'tarion')!==false && stripos($improved,'tarion')===false){
    $prefix = 'Licensed by Tarion (New Home Warranty) — formalizing our commitment to quality and aftercare. ';
  } elseif ((strpos($t,'establish')!==false || strpos($t,'founded')!==false) && stripos($improved,'establish')===false){
    $prefix = 'Nano Design Build is established in Toronto — a studio dedicated to bright, modern homes. ';
  }

  // Content + links
  $content = wpautop(ndb_clean_text($prefix.' '.$improved));
  if ($links){
    $uniq = [];
    foreach ($links as $pair){ $uniq[$pair[0].'|'.$pair[1]] = $pair; }
    $links = array_values($uniq);
    $links_html = array_map(function($pair){
      list($u,$label) = $pair;
      return '<a href="'.esc_url($u).'" target="_blank" rel="noopener">'.esc_html($label).'</a>';
    }, $links);
    $content .= "\n\n<p class=\"journal-sources\"><strong>Links:</strong> ".implode(' · ',$links_html)."</p>";
  }

  $safe_title = $title ?: 'Journal';

  // Update or insert
  $existing = get_posts([
    'post_type'=>'journal',
    'title'=>$safe_title,
    'date_query'=>[['after'=>substr($date_iso,0,10).' 00:00:00','before'=>substr($date_iso,0,10).' 23:59:59']],
    'fields'=>'ids','posts_per_page'=>1
  ]);

  if ($existing && !$FORCE_UPDATE){
    echo "SKIP (exists): {$safe_title} (".substr($date_iso,0,10).")\n";
    continue;
  }

  if ($existing){
    $post_id = $existing[0];
    wp_update_post(['ID'=>$post_id,'post_content'=>$content]);
    echo "UPDATED: {$safe_title} (".substr($date_iso,0,10).")\n";
  } else {
    $post_id = wp_insert_post([
      'post_type'=>'journal','post_status'=>'publish',
      'post_title'=>$safe_title,'post_content'=>$content,'post_date'=>$date_iso
    ]);
    echo "IMPORTED: {$safe_title} (".substr($date_iso,0,10).")\n";
  }

  // Featured image
  if ($post_id && !is_wp_error($post_id) && $image){
    if (!has_post_thumbnail($post_id)){
      $att_id = media_sideload_image($image, $post_id, $safe_title, 'id');
      if (!is_wp_error($att_id)) {
        set_post_thumbnail($post_id, $att_id);
        echo "  ↳ thumbnail set: $image\n";
      } else {
        echo "  ↳ thumb error: ".$att_id->get_error_message()."\n";
      }
    } else {
      if ($VERBOSE) echo "  ↳ thumb already present\n";
    }
  } else {
    if ($VERBOSE) echo "  ↳ no image found (ym+index+internal)\n";
  }

  // Verbose: print links we embedded
  if ($VERBOSE && $links){
    foreach ($links as $pair){
      echo "  ↳ link: {$pair[1]} — {$pair[0]}\n";
    }
  }

  $total++;
}
echo "Total processed: $total\n";
