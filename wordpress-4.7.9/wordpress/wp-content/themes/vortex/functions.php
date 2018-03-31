<?php
/** Load the Core Files */
require_once( trailingslashit( get_template_directory() ) . 'lib/init.php' );
new Vortex();

/** Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'vortex_theme_setup' );

/** Theme setup function. */
function vortex_theme_setup() {
	
	/** Add theme support for Feed Links. */
	add_theme_support( 'automatic-feed-links' );
	
	/** Add theme support for Custom Background. */
	add_theme_support( 'custom-background', array( 'default-color' => 'fff' ) );
	
	/** Set content width. */
	vortex_set_content_width( 640 );
	
	/** Add custom image sizes. */
	add_action( 'init', 'vortex_add_image_sizes' );	

	register_sidebar(
		array(
			'id' => 'true_side', // унікальний id
			'name' => 'Лівий сайдбар', // назва сайдбару
			'description' => 'Перенесіть віджети сюди щоб додати їх в сайдбар', // опис
			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // віджети виводяться li-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по-замовчуванню заголовки -  <h2>
			'after_title' => '</h3>'
		)
	);
	
}

/** Adds custom image sizes */
function vortex_add_image_sizes() {
	add_image_size( 'vortex-image-featured', 640, 375, true );
}
?>