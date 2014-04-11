<?php 

add_shortcode('footnote', 'itv_footnotes_shortcode');
function itv_footnotes_shortcode($atts) {
  extract(shortcode_atts(array(
    "number" => '0'
  ), $atts));
  return "<sup class=\"footnote\"><a class=\"footnote_link\" href=\"#footnote_{$number}\">{$number}</a></sup>";
};

?>