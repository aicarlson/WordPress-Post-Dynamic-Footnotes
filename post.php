<?php

// Enqueue scripts once pluggable.php is ready.
add_action( 'wp_loaded', 'itv_footnotes_resources' );

// Enqueue scripts function
function itv_footnotes_resources() {

	// Load our scripts, but only on the posts page!
	add_action('admin_enqueue_scripts', 'itv_footnotes_scripts');

	function itv_footnotes_scripts($hook) {

		if ($hook === 'post.php' || $hook === 'post-new.php') {

			wp_enqueue_script( 'itv-footnotes', plugins_url('/js/itv-footnotes.js', __FILE__), array('jquery') );
			wp_enqueue_style( 'itv-footnotes-style', plugins_url('/css/itv-footnotes.css', __FILE__));

		}

	}

}

// Register the post meta box.
add_action('add_meta_boxes', "itv_footnotes_meta_box");

function itv_footnotes_meta_box() {
	add_meta_box('itv_footnotes_meta_box', 'Footnotes', 'itv_footnotes_meta_box_callback', 'post', 'side', 'high');
}

// Meta box callback function.
function itv_footnotes_meta_box_callback($post) {

	wp_nonce_field('itv_footnotes_nonce_action', 'itv_footnotes_meta_nonce');
	$footnotes_default = get_post_meta($post->ID, 'itv_footnotes_value', true);

	if (is_array($footnotes_default) && count($footnotes_default) > 0) {

		$count = 1;

		foreach ($footnotes_default as $footnote) {
			echo "<div class='footnote_section'><label for='footnote_number_{$count}'>Footnote {$count}:</label><br /><input type='text' name='itv_footnotes_meta_value[]' class='footnote' id='footnote_number_{$count}' value='" . esc_attr( $footnote ) . "' /><br/></div>";
			$count++;
		}

	} else {
		echo "<div class='footnote_section'><label>Footnote 1:</label><br /><input type='text' name='itv_footnotes_meta_value[]' value='' class='footnote' id='footnote_number_1'/><br/></div>";
	}

}

// Save the data... 
function itv_footnotes_save_meta( $post_id ) {

	// Check for the nonce
	if ( ! isset( $_POST['itv_footnotes_meta_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['itv_footnotes_meta_nonce'];

	// Verify the nonce...
	if ( ! wp_verify_nonce( $nonce, 'itv_footnotes_nonce_action' ) ) {
		return $post_id;
	}

	// Don't do anything on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check that the admin has permissions
	if ( 'post' == $_POST['post_type']) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	}

	$itv_footnotes_value_to_add = array();

	if($_POST['itv_footnotes_meta_value'] && is_array($_POST['itv_footnotes_meta_value'])) {

		foreach ($_POST['itv_footnotes_meta_value'] as $footnote) {

			if ($footnote !== '') {
				array_push($itv_footnotes_value_to_add, wp_kses($footnote, array('a' => array('href' => array(), 'title' => array()), 'br' => array(), 'em' =>  array(), 'strong' => array(), 'b' => array(), 'i' => array())));
			}

		}

		update_post_meta( $post_id, "itv_footnotes_value", $itv_footnotes_value_to_add );

	}

}

add_action( 'save_post', 'itv_footnotes_save_meta' );

?>
