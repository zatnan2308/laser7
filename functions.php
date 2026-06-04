<?php
/**
 * ЛАЗЕР · 7 — theme functions
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LASER7_VERSION', '1.0.0' );
define( 'LASER7_DIR', get_template_directory() );
define( 'LASER7_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * 1. Theme setup
 * ---------------------------------------------------------------------- */
function laser7_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Editor / front images: make sure WebP is allowed in the media library.
	load_theme_textdomain( 'laser7', LASER7_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'laser7_setup' );

/* Allow WebP uploads (older WP / hosts sometimes block it). */
function laser7_mime_types( $mimes ) {
	$mimes['webp'] = 'image/webp';
	return $mimes;
}
add_filter( 'upload_mimes', 'laser7_mime_types' );

/* Keep the viber:// scheme intact through esc_url() (messenger links). */
function laser7_allowed_protocols( $protocols ) {
	if ( ! in_array( 'viber', $protocols, true ) ) {
		$protocols[] = 'viber';
	}
	return $protocols;
}
add_filter( 'kses_allowed_protocols', 'laser7_allowed_protocols' );

/* -------------------------------------------------------------------------
 * 2. Assets
 * ---------------------------------------------------------------------- */
function laser7_assets() {
	// Google Fonts (Montserrat + Manrope), exactly as in the design.
	wp_enqueue_style(
		'laser7-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Manrope:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Design styles — copied 1:1 from the handoff bundle.
	wp_enqueue_style( 'laser7-styles', LASER7_URI . '/assets/css/styles.css', array(), LASER7_VERSION );

	// Theme additions (bilingual + WP tweaks).
	wp_enqueue_style( 'laser7-theme', LASER7_URI . '/assets/css/theme.css', array( 'laser7-styles' ), LASER7_VERSION );

	// Front-end behaviour (lang toggle, menu, FAQ, portfolio filter, lightbox…).
	wp_enqueue_script( 'laser7-main', LASER7_URI . '/assets/js/main.js', array(), LASER7_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'laser7_assets' );

/* Preconnect to Google Fonts (matches the design's <head>). */
function laser7_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'laser7_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * 3. Includes
 * ---------------------------------------------------------------------- */
require_once LASER7_DIR . '/inc/helpers.php';
require_once LASER7_DIR . '/inc/icons.php';
require_once LASER7_DIR . '/inc/defaults.php';

/* ACF: register field groups + options pages (only if ACF Pro is active). */
if ( function_exists( 'acf_add_local_field_group' ) ) {
	require_once LASER7_DIR . '/inc/acf-fields.php';
}

/* One-time content seeding (imports webp images + fills all ACF fields). */
require_once LASER7_DIR . '/inc/seed.php';

/* Admin notice if ACF Pro is missing — the theme needs it. */
function laser7_acf_notice() {
	if ( ! function_exists( 'acf_add_local_field_group' ) && current_user_can( 'install_plugins' ) ) {
		echo '<div class="notice notice-warning"><p><strong>ЛАЗЕР · 7:</strong> для редагування контенту встановіть та активуйте плагін <em>Advanced Custom Fields PRO</em>. / Please install &amp; activate <em>Advanced Custom Fields PRO</em> to edit content.</p></div>';
	}
}
add_action( 'admin_notices', 'laser7_acf_notice' );

/* -------------------------------------------------------------------------
 * 4. ACF options page (Theme settings) + Local JSON
 * ---------------------------------------------------------------------- */
function laser7_acf_options() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => 'ЛАЗЕР · 7 — Налаштування теми',
			'menu_title' => 'ЛАЗЕР · 7',
			'menu_slug'  => 'laser7-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'icon_url'   => 'dashicons-superhero',
			'position'   => 2,
		) );
	}
}
add_action( 'acf/init', 'laser7_acf_options' );

/* Keep ACF field definitions in /acf-json so they version-control nicely. */
function laser7_acf_json_save( $path ) {
	return LASER7_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'laser7_acf_json_save' );

function laser7_acf_json_load( $paths ) {
	$paths[] = LASER7_DIR . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'laser7_acf_json_load' );

/* -------------------------------------------------------------------------
 * 5. Front page: make sure a "front page" exists & uses our template.
 *    On first run we create a page and set it as the static front page so
 *    the landing shows up immediately with all default content.
 * ---------------------------------------------------------------------- */
function laser7_setup_front_page() {
	if ( get_option( 'laser7_front_done' ) ) {
		return;
	}
	if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
		$existing = get_page_by_path( 'golovna' );
		if ( ! $existing ) {
			$page_id = wp_insert_post( array(
				'post_title'   => 'Головна',
				'post_name'    => 'golovna',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			) );
		} else {
			$page_id = $existing->ID;
		}
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );
		}
	}
	update_option( 'laser7_front_done', 1 );
	// Ask the seeder to populate ACF fields on the next admin load (when ACF is ready).
	update_option( 'laser7_needs_seed', 1 );
}
add_action( 'after_switch_theme', 'laser7_setup_front_page' );

/* Use front-page.php for the configured front page automatically (it already is
 * the WP template hierarchy default, this is just a safety net for child setups). */
