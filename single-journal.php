<?php
// single-journal.php — Journal entries don’t have a dedicated single page.
wp_safe_redirect( get_post_type_archive_link( 'journal' ), 301 );
exit;
