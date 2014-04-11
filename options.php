<?php
// Add the page to the side menu 
add_action( "admin_menu", "itv_hero_menu" );
// Enqueue scripts once pluggable.php is ready.
add_action( 'wp_loaded', "itv_hero_resources" );
// Add all of our sections, fields and settings during admin_init
add_action( 'admin_init', "itv_hero_settings_init" );
// Side menu callback function
function itv_hero_menu() {
	global $admin_page;
	$admin_page = add_utility_page( "Hero Image Options", "Hero Images", "manage_options", "itv_hero_options", "itv_hero_options" );
};
// Enqueue scripts function
function itv_hero_resources() {
	// Load our scripts, but only on the Hero Settings page!
	add_action('admin_enqueue_scripts', "itv_hero_scripts");
	function itv_hero_scripts($hook) {
		global $admin_page;
		if ($hook === $admin_page || $hook === 'post.php' || $hook === 'post-new.php') {
			wp_enqueue_media();
			wp_enqueue_script( "image_picker_js", plugins_url('/js/image-picker.min.js', __FILE__), array('jquery') );
        	wp_enqueue_script( "itv_hero_js", plugins_url( "/js/itv_hero.js", __FILE__ ), array('jquery', "image_picker_js"));
			wp_enqueue_style("itv_hero_css", plugins_url("/css/itv_hero.css", __FILE__ ));
			wp_enqueue_style("image_picker_css", plugins_url('/css/image-picker.css', __FILE__));
		};
	};
}; /* itv_hero_resources */
// Settings admin_init callback function 
function itv_hero_settings_init() {
	add_settings_section(
		"itv_hero_setting_section",
		false,
		false,
		"itv_hero_options"
	);
	add_settings_field(
		"itv_hero_options",
		"Default Images:",
		"itv_hero_setting_callback_function",
		"itv_hero_options",
		"itv_hero_setting_section"
	);
	register_setting( "itv_hero_options", "itv_hero_options" );
};

// Query all images in the media library...set it to $itv_hero_all_images
function itv_hero_all_images(){
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' =>'image',
        'post_status' => 'inherit',
        'posts_per_page' => -1,
    );
    $query_images = new WP_Query( $args );
    $images = array();
    foreach ( $query_images->posts as $image) {
        $images[] = $image->guid;
    }
    return $images;

};

$itv_hero_all_images = itv_hero_all_images();

function itv_hero_setting_callback_function() {
	global $itv_hero_all_images;
	echo "<select name=\"itv_hero_options[]\" class=\"image-picker\" multiple>";
	foreach ($itv_hero_all_images as $image) {
		echo "<option data-img-src=\"{$image}\" value=\"{$image}\" " . selected(true, in_array("{$image}", get_option("itv_hero_options")), false) . " >{$image}</option>";
	};
	echo '</select>';
};

function itv_hero_options() {
	echo "<div class=\"itv_hero_wrapper\">";
	echo "<h2>Hero Image Options</h2>";
	echo "<p>Select your 'default' images from below, or upload new images.</p>";
	// Media upload image.
    echo "<input id=\"upload_image_button\" class=\"button\" type=\"button\" value=\"Upload New Image\" />";
    echo "<div class=\"itv_hero_image-picker-wrapper\">";
    // Settings form
	echo "<form action=\"options.php\" method=\"POST\">";
	settings_fields("itv_hero_options");
	do_settings_sections("itv_hero_options");
	submit_button();
	echo "</form>";
	echo "</div>";
	echo "</div>";
};
?>