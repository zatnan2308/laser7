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

	// Responsive crops for nicely-sized delivery (generated on upload / import).
	add_image_size( 'laser7-card', 900, 560, true );        // hero cards / about side photos
	add_image_size( 'laser7-portfolio', 760, 570, true );   // portfolio grid (4:3)
	set_post_thumbnail_size( 1200, 0 );

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
function l7_ensure_front_page() {
	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id && get_post( $page_id ) ) {
		return $page_id;
	}
	$existing = get_page_by_path( 'golovna' );
	if ( $existing ) {
		$page_id = $existing->ID;
	} else {
		$page_id = wp_insert_post( array(
			'post_title'  => 'Головна',
			'post_name'   => 'golovna',
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_content' => '',
		) );
	}
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
		return (int) $page_id;
	}
	return 0;
}

function laser7_setup_front_page() {
	if ( get_option( 'laser7_front_done' ) ) {
		return;
	}
	l7_ensure_front_page();
	update_option( 'laser7_front_done', 1 );
	// Ask the seeder to populate ACF fields on the next admin load (when ACF is ready).
	update_option( 'laser7_needs_seed', 1 );
}
add_action( 'after_switch_theme', 'laser7_setup_front_page' );

/* -------------------------------------------------------------------------
 * 6. SEO — title, meta description, Open Graph / Twitter, canonical, schema.
 * ---------------------------------------------------------------------- */

/** Active-language helper for server-side SEO (search bots see one language). */
function laser7_seo_lang() {
	// Ukrainian is primary (html lang uk); meta uses UA.
	return 'ua';
}

/** Resolve the OG/share image to an absolute URL + dimensions. */
function laser7_og_image() {
	$D  = l7_defaults();
	$fp = (int) get_option( 'page_on_front' );

	$candidates = array(
		l7_opt( 'seo_og_image' ),
		l7_get_raw( 'hero_figure', $fp ),
	);
	foreach ( $candidates as $val ) {
		if ( ! $val ) {
			continue;
		}
		$id = is_array( $val ) ? ( ! empty( $val['ID'] ) ? (int) $val['ID'] : 0 ) : ( is_numeric( $val ) ? (int) $val : 0 );
		if ( $id ) {
			$src = wp_get_attachment_image_src( $id, 'large' );
			if ( $src ) {
				return array( 'url' => $src[0], 'w' => $src[1], 'h' => $src[2] );
			}
		}
	}
	// bundled default
	$file = $D['seo']['og_image'];
	$dims = function_exists( 'l7_asset_dims' ) ? l7_asset_dims( $file ) : null;
	return array(
		'url' => LASER7_URI . '/assets/images/' . $file,
		'w'   => $dims ? $dims[0] : 1200,
		'h'   => $dims ? $dims[1] : 630,
	);
}

/** Front-page <title>. */
function laser7_document_title_parts( $parts ) {
	if ( is_front_page() ) {
		$D = l7_defaults();
		$parts = array( 'title' => l7_opt( 'seo_title_ua', $D['seo']['title_ua'] ) );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'laser7_document_title_parts' );

/** Output meta description, Open Graph, Twitter, canonical, JSON-LD. */
function laser7_seo_head() {
	$D = l7_defaults();
	$fp = (int) get_option( 'page_on_front' );

	$title = l7_opt( 'seo_title_ua', $D['seo']['title_ua'] );
	$desc  = l7_opt( 'seo_description_ua', $D['seo']['desc_ua'] );
	$desc  = wp_strip_all_tags( $desc );
	$url   = is_front_page() ? home_url( '/' ) : home_url( add_query_arg( array() ) );
	$site  = get_bloginfo( 'name' );
	$og    = laser7_og_image();

	echo "\n<!-- ЛАЗЕР·7 SEO -->\n";
	echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . "\n";

	echo '<meta property="og:type" content="website" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:locale" content="uk_UA" />' . "\n";
	echo '<meta property="og:locale:alternate" content="en_US" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og['url'] ) . '" />' . "\n";
	echo '<meta property="og:image:width" content="' . (int) $og['w'] . '" />' . "\n";
	echo '<meta property="og:image:height" content="' . (int) $og['h'] . '" />' . "\n";

	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $og['url'] ) . '" />' . "\n";

	if ( is_front_page() ) {
		$phone   = l7_opt( 'contact_phone', $D['contact_phone'] );
		$email   = l7_opt( 'contact_email', $D['contact_email'] );
		$address = l7_field( 'topbar_address_ua', $D['topbar']['address_ua'], 'option' );
		$channels = l7_rows( 'channels', array( 'id', 'label', 'handle', 'url', 'note_ua', 'note_en' ), $D['channels'], 'option' );
		$same = array();
		foreach ( $channels as $c ) {
			if ( ! empty( $c['url'] ) && preg_match( '#^https?://#', $c['url'] ) ) {
				$same[] = $c['url'];
			}
		}
		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'LocalBusiness',
			'name'        => $D['brand']['name_ua'] . ' · ' . $D['brand']['mark'],
			'description' => $desc,
			'image'       => $og['url'],
			'url'         => home_url( '/' ),
			'telephone'   => preg_replace( '/\s+/', '', $phone ),
			'email'       => $email,
			'priceRange'  => '$$',
			'address'     => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $address,
				'addressLocality' => 'Одеса',
				'addressCountry'  => 'UA',
			),
			'geo'         => array(
				'@type'     => 'GeoCoordinates',
				'latitude'  => l7_opt( 'seo_geo_lat', $D['seo']['geo_lat'] ),
				'longitude' => l7_opt( 'seo_geo_lng', $D['seo']['geo_lng'] ),
			),
			'openingHoursSpecification' => array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
				'opens'     => '08:00',
				'closes'    => '17:00',
			),
		);
		if ( $same ) {
			$schema['sameAs'] = array_values( $same );
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
	echo "<!-- /ЛАЗЕР·7 SEO -->\n";
}
add_action( 'wp_head', 'laser7_seo_head', 5 );

/* -------------------------------------------------------------------------
 * 7. Admin: one-click data import (fills all ACF fields, both languages).
 * ---------------------------------------------------------------------- */
function laser7_import_menu() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return; // parent options page only exists with ACF Pro
	}
	add_submenu_page(
		'laser7-settings',
		'Імпорт демо-контенту',
		'Імпорт контенту',
		'edit_theme_options',
		'laser7-import',
		'laser7_import_page'
	);
}
add_action( 'admin_menu', 'laser7_import_menu', 100 );

function laser7_import_page() {
	$done = false;
	$err  = '';
	if ( isset( $_POST['laser7_do_import'] ) && check_admin_referer( 'laser7_import' ) ) {
		if ( ! function_exists( 'update_field' ) ) {
			$err = 'Плагін ACF Pro неактивний.';
		} else {
			$page_id = l7_ensure_front_page();
			if ( ! $page_id ) {
				$err = 'Не вдалося знайти/створити головну сторінку.';
			} elseif ( ! function_exists( 'l7_seed_content' ) ) {
				$err = 'Модуль імпорту недоступний.';
			} else {
				l7_seed_content( $page_id );
				delete_option( 'laser7_needs_seed' );
				$done = true;
			}
		}
	}
	?>
	<div class="wrap">
		<h1>Імпорт демо-контенту · ЛАЗЕР · 7</h1>
		<?php if ( $done ) : ?>
			<div class="notice notice-success"><p><strong>Готово!</strong> Усі поля ACF заповнені демо-контентом (українською та англійською), а зображення (webp) імпортовані в медіабібліотеку. Перевірте сторінку «Головна» та налаштування теми.</p></div>
		<?php elseif ( $err ) : ?>
			<div class="notice notice-error"><p><?php echo esc_html( $err ); ?></p></div>
		<?php endif; ?>
		<p>Ця кнопка заповнює <strong>усі</strong> поля ACF — і «Налаштування теми» (шапка, контакти, підвал, SEO), і контент сторінки «Головна» (усі секції) — демо-контентом <strong>двома мовами (UA + EN)</strong>, а також імпортує всі <strong>webp</strong>-зображення в медіабібліотеку.</p>
		<p style="color:#b32d2e;"><strong>Увага:</strong> поточні значення цих полів будуть перезаписані демо-контентом.</p>
		<form method="post">
			<?php wp_nonce_field( 'laser7_import' ); ?>
			<p><button type="submit" name="laser7_do_import" value="1" class="button button-primary button-hero">Імпортувати / оновити всі поля</button></p>
		</form>
	</div>
	<?php
}
