<?php
add_filter( 'the_content', 'itv_footnotes_filter' );

function itv_footnotes_filter($content) {

	if (is_single()) {

		global $post;
		$footnotes = get_post_meta($post->ID, 'itv_footnotes_value', true);

		if (is_array($footnotes)) {

			$itv_footnotes_to_add = "<div class='footnotes'>";
			$count = 1;

			foreach ($footnotes as $footnote) {
				$itv_footnotes_to_add .= "<p id='footnote_{$count}' class='footnote_paragraph'>" . $count . ": " . $footnote . "</p>";
				$count = $count + 1;
			};

			$itv_footnotes_to_add .= "</div>";
			$content .= $itv_footnotes_to_add;
			
		};

	}; /* Only run this on post pages...is_single() */

	return $content;

}; ?>
