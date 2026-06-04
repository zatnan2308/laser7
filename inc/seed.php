<?php
/**
 * One-time content seeding.
 *
 * Runs once after theme activation (on the next admin load, when ACF is ready):
 *  1. imports the bundled .webp images into the Media Library;
 *  2. fills every ACF field (theme options + front page) with the default
 *     content from inc/defaults.php, wiring image fields to the imports.
 *
 * Result: the admin opens the page / theme settings and sees EVERYTHING
 * pre-filled and editable — text, photos, prices, contacts.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', 'l7_maybe_seed', 99 );
function l7_maybe_seed() {
	if ( ! get_option( 'laser7_needs_seed' ) ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) || ! function_exists( 'acf_get_field' ) ) {
		return; // ACF Pro not ready yet — try again next admin load.
	}
	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		return;
	}
	l7_seed_content( $page_id );
	delete_option( 'laser7_needs_seed' );
}

/** Import a bundled asset image into the Media Library; returns attachment ID (cached). */
function l7_import_asset_image( $filename ) {
	if ( ! $filename ) {
		return 0;
	}
	$map = get_option( 'laser7_img_map', array() );
	if ( isset( $map[ $filename ] ) && get_post( $map[ $filename ] ) ) {
		return (int) $map[ $filename ];
	}
	$src = LASER7_DIR . '/assets/images/' . $filename;
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( $filename, null, file_get_contents( $src ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$filetype = wp_check_filetype( $upload['file'], null );
	$attach   = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', sanitize_file_name( $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$id = wp_insert_attachment( $attach, $upload['file'] );
	if ( ! $id || is_wp_error( $id ) ) {
		return 0;
	}
	$meta = wp_generate_attachment_metadata( $id, $upload['file'] );
	wp_update_attachment_metadata( $id, $meta );

	$map[ $filename ] = $id;
	update_option( 'laser7_img_map', $map );
	return (int) $id;
}

/** Convert a default rows array's photo filename to an attachment ID in place. */
function l7_seed_photo_rows( $rows, $key = 'photo' ) {
	foreach ( $rows as &$r ) {
		$r[ $key ] = ! empty( $r[ $key ] ) ? l7_import_asset_image( $r[ $key ] ) : '';
	}
	unset( $r );
	return $rows;
}

/** Create the legal pages (privacy / cookies / terms) if missing; returns key→ID. */
function l7_ensure_legal_pages() {
	$D   = l7_defaults();
	$ids = array();
	foreach ( $D['legal'] as $key => $L ) {
		$existing = get_page_by_path( $L['slug'] );
		if ( $existing ) {
			$id = $existing->ID;
		} else {
			$id = wp_insert_post( array(
				'post_title'   => $L['title_ua'],
				'post_name'    => $L['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			) );
		}
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-legal.php' );
			$ids[ $key ] = (int) $id;
		}
	}
	return $ids;
}

function l7_seed_content( $page_id ) {
	$D = l7_defaults();

	/* ---------------- THEME OPTIONS -------------------------------- */
	update_field( 'accent', 'red', 'option' );
	update_field( 'show_topbar', 1, 'option' );
	update_field( 'brand_name_ua', $D['brand']['name_ua'], 'option' );
	update_field( 'brand_name_en', $D['brand']['name_en'], 'option' );
	update_field( 'brand_mark', $D['brand']['mark'], 'option' );
	update_field( 'topbar_address_ua', $D['topbar']['address_ua'], 'option' );
	update_field( 'topbar_address_en', $D['topbar']['address_en'], 'option' );
	update_field( 'topbar_hours_ua', $D['topbar']['hours_ua'], 'option' );
	update_field( 'topbar_hours_en', $D['topbar']['hours_en'], 'option' );
	update_field( 'topbar_phone', $D['topbar']['phone'], 'option' );
	update_field( 'nav_items', $D['nav'], 'option' );

	update_field( 'contact_phone', $D['contact_phone'], 'option' );
	update_field( 'contact_email', $D['contact_email'], 'option' );
	update_field( 'channels', $D['channels'], 'option' );

	update_field( 'footer_tagline_ua', $D['footer']['tagline_ua'], 'option' );
	update_field( 'footer_tagline_en', $D['footer']['tagline_en'], 'option' );
	update_field( 'footer_copyright_ua', $D['footer']['copyright_ua'], 'option' );
	update_field( 'footer_copyright_en', $D['footer']['copyright_en'], 'option' );
	update_field( 'footer_note_ua', $D['footer']['note_ua'], 'option' );
	update_field( 'footer_note_en', $D['footer']['note_en'], 'option' );
	update_field( 'footer_col_a_ua', $D['footer']['col_a_ua'], 'option' );
	update_field( 'footer_col_a_en', $D['footer']['col_a_en'], 'option' );
	update_field( 'footer_col_b_ua', $D['footer']['col_b_ua'], 'option' );
	update_field( 'footer_col_b_en', $D['footer']['col_b_en'], 'option' );
	update_field( 'footer_col_c_ua', $D['footer']['col_c_ua'], 'option' );
	update_field( 'footer_col_c_en', $D['footer']['col_c_en'], 'option' );
	update_field( 'footer_links', $D['footer']['links'], 'option' );
	update_field( 'footer_credit_name', $D['footer']['credit_name'], 'option' );
	update_field( 'footer_credit_url', $D['footer']['credit_url'], 'option' );

	// SEO (brand_logo left empty on purpose → text wordmark until user uploads one).
	update_field( 'seo_title_ua', $D['seo']['title_ua'], 'option' );
	update_field( 'seo_title_en', $D['seo']['title_en'], 'option' );
	update_field( 'seo_description_ua', $D['seo']['desc_ua'], 'option' );
	update_field( 'seo_description_en', $D['seo']['desc_en'], 'option' );
	update_field( 'seo_og_image', l7_import_asset_image( $D['seo']['og_image'] ), 'option' );
	update_field( 'seo_geo_lat', $D['seo']['geo_lat'], 'option' );
	update_field( 'seo_geo_lng', $D['seo']['geo_lng'], 'option' );

	// Cookie banner
	$ck = $D['cookie'];
	update_field( 'cookie_text_ua', $ck['text_ua'], 'option' );
	update_field( 'cookie_text_en', $ck['text_en'], 'option' );
	update_field( 'cookie_accept_ua', $ck['accept_ua'], 'option' );
	update_field( 'cookie_accept_en', $ck['accept_en'], 'option' );
	update_field( 'cookie_decline_ua', $ck['decline_ua'], 'option' );
	update_field( 'cookie_decline_en', $ck['decline_en'], 'option' );
	update_field( 'cookie_more_ua', $ck['more_ua'], 'option' );
	update_field( 'cookie_more_en', $ck['more_en'], 'option' );

	// Legal pages: create + fill content, then point footer links at real permalinks.
	$legal = l7_ensure_legal_pages();
	foreach ( $D['legal'] as $key => $L ) {
		$pid = isset( $legal[ $key ] ) ? $legal[ $key ] : 0;
		if ( ! $pid ) {
			continue;
		}
		update_field( 'legal_heading_ua', $L['heading_ua'], $pid );
		update_field( 'legal_heading_en', $L['heading_en'], $pid );
		update_field( 'legal_content_ua', $L['content_ua'], $pid );
		update_field( 'legal_content_en', $L['content_en'], $pid );
	}
	$order = array(
		'privacy' => array( 'Конфіденційність', 'Privacy Policy' ),
		'cookies' => array( 'Файли cookie', 'Cookie Policy' ),
		'terms'   => array( 'Умови використання', 'Terms of Use' ),
	);
	$links = array();
	foreach ( $order as $key => $lab ) {
		if ( ! empty( $legal[ $key ] ) ) {
			$links[] = array( 'ua' => $lab[0], 'en' => $lab[1], 'url' => get_permalink( $legal[ $key ] ) );
		}
	}
	if ( $links ) {
		update_field( 'footer_links', $links, 'option' );
	}

	/* ---------------- FRONT PAGE ----------------------------------- */
	$p = $page_id;
	$h = $D['hero'];

	// Hero
	update_field( 'hero_eyebrow_ua', $h['eyebrow_ua'], $p );
	update_field( 'hero_eyebrow_en', $h['eyebrow_en'], $p );
	update_field( 'hero_title1_ua', $h['title1_ua'], $p );
	update_field( 'hero_title1_en', $h['title1_en'], $p );
	update_field( 'hero_title2_ua', $h['title2_ua'], $p );
	update_field( 'hero_title2_en', $h['title2_en'], $p );
	update_field( 'hero_lede_ua', $h['lede_ua'], $p );
	update_field( 'hero_lede_en', $h['lede_en'], $p );
	update_field( 'hero_cta1_ua', $h['cta1_ua'], $p );
	update_field( 'hero_cta1_en', $h['cta1_en'], $p );
	update_field( 'hero_cta2_ua', $h['cta2_ua'], $p );
	update_field( 'hero_cta2_en', $h['cta2_en'], $p );
	update_field( 'hero_figure', l7_import_asset_image( $h['figure'] ), $p );
	update_field( 'hero_figure_tag_ua', $h['figure_tag_ua'], $p );
	update_field( 'hero_figure_tag_en', $h['figure_tag_en'], $p );
	update_field( 'hero_trust', $D['hero_trust'], $p );
	update_field( 'hero_cards', l7_seed_photo_rows( $D['hero_cards'] ), $p );

	// Advantages
	$ah = $D['advantages_head'];
	update_field( 'advantages_idx_ua', $ah['idx_ua'], $p );
	update_field( 'advantages_idx_en', $ah['idx_en'], $p );
	update_field( 'advantages_title_ua', $ah['title_ua'], $p );
	update_field( 'advantages_title_en', $ah['title_en'], $p );
	update_field( 'advantages_lede_ua', $ah['lede_ua'], $p );
	update_field( 'advantages_lede_en', $ah['lede_en'], $p );
	update_field( 'advantages', $D['advantages'], $p );

	// About
	$ab = $D['about'];
	update_field( 'about_kicker_ua', $ab['kicker_ua'], $p );
	update_field( 'about_kicker_en', $ab['kicker_en'], $p );
	update_field( 'about_title_ua', $ab['title_ua'], $p );
	update_field( 'about_title_en', $ab['title_en'], $p );
	update_field( 'about_tagline_ua', $ab['tagline_ua'], $p );
	update_field( 'about_tagline_en', $ab['tagline_en'], $p );
	update_field( 'about_years', $ab['years'], $p );
	update_field( 'about_years_label_ua', $ab['years_label_ua'], $p );
	update_field( 'about_years_label_en', $ab['years_label_en'], $p );
	update_field( 'about_cta_ua', $ab['cta_ua'], $p );
	update_field( 'about_cta_en', $ab['cta_en'], $p );
	update_field( 'about_photo_big', l7_import_asset_image( $ab['photo_big'] ), $p );
	update_field( 'about_photo_two', l7_import_asset_image( $ab['photo_two'] ), $p );
	update_field( 'about_photo_three', l7_import_asset_image( $ab['photo_three'] ), $p );
	update_field( 'about_paras', $D['about_paras'], $p );
	update_field( 'about_services', $D['about_services'], $p );

	// Portfolio
	$ph = $D['portfolio_head'];
	update_field( 'portfolio_idx_ua', $ph['idx_ua'], $p );
	update_field( 'portfolio_idx_en', $ph['idx_en'], $p );
	update_field( 'portfolio_title_ua', $ph['title_ua'], $p );
	update_field( 'portfolio_title_en', $ph['title_en'], $p );
	update_field( 'portfolio_lede_ua', $ph['lede_ua'], $p );
	update_field( 'portfolio_lede_en', $ph['lede_en'], $p );
	update_field( 'portfolio_page_size', 9, $p );
	update_field( 'categories', $D['categories'], $p );
	update_field( 'works', l7_seed_photo_rows( $D['works'] ), $p );

	// Prices
	$sh = $D['services_head'];
	update_field( 'services_idx_ua', $sh['idx_ua'], $p );
	update_field( 'services_idx_en', $sh['idx_en'], $p );
	update_field( 'services_title_ua', $sh['title_ua'], $p );
	update_field( 'services_title_en', $sh['title_en'], $p );
	update_field( 'services_note_ua', $sh['note_ua'], $p );
	update_field( 'services_note_en', $sh['note_en'], $p );
	update_field( 'services_foot_ua', $sh['foot_ua'], $p );
	update_field( 'services_foot_en', $sh['foot_en'], $p );
	update_field( 'price_groups', $D['price_groups'], $p );

	// Materials
	$mh = $D['materials_head'];
	update_field( 'materials_idx_ua', $mh['idx_ua'], $p );
	update_field( 'materials_idx_en', $mh['idx_en'], $p );
	update_field( 'materials_title_ua', $mh['title_ua'], $p );
	update_field( 'materials_title_en', $mh['title_en'], $p );
	update_field( 'materials_lede_ua', $mh['lede_ua'], $p );
	update_field( 'materials_lede_en', $mh['lede_en'], $p );
	update_field( 'materials', l7_seed_photo_rows( $D['materials'] ), $p );

	// Testimonial
	$t = $D['testimonial'];
	update_field( 'testimonial_quote_ua', $t['quote_ua'], $p );
	update_field( 'testimonial_quote_en', $t['quote_en'], $p );
	update_field( 'testimonial_author_ua', $t['author'], $p );
	update_field( 'testimonial_author_en', $t['author_en'], $p );
	update_field( 'testimonial_role_ua', $t['role_ua'], $p );
	update_field( 'testimonial_role_en', $t['role_en'], $p );
	update_field( 'testimonial_photo', l7_import_asset_image( $t['photo'] ), $p );

	// FAQ
	$fh = $D['faq_head'];
	update_field( 'faq_title_ua', $fh['title_ua'], $p );
	update_field( 'faq_title_en', $fh['title_en'], $p );
	update_field( 'faq_sub_ua', $fh['sub_ua'], $p );
	update_field( 'faq_sub_en', $fh['sub_en'], $p );
	update_field( 'faq', $D['faq'], $p );

	// Location
	$lh = $D['location_head'];
	update_field( 'location_idx_ua', $lh['idx_ua'], $p );
	update_field( 'location_idx_en', $lh['idx_en'], $p );
	update_field( 'location_title_ua', $lh['title_ua'], $p );
	update_field( 'location_title_en', $lh['title_en'], $p );
	update_field( 'location_lede_ua', $lh['lede_ua'], $p );
	update_field( 'location_lede_en', $lh['lede_en'], $p );
	update_field( 'location_city', $lh['city'], $p );
	update_field( 'location_coords', $lh['coords'], $p );
	update_field( 'location_bazaar_ua', $lh['bazaar_ua'], $p );
	update_field( 'location_bazaar_en', $lh['bazaar_en'], $p );
	update_field( 'location_pin_ua', $lh['pin_ua'], $p );
	update_field( 'location_pin_en', $lh['pin_en'], $p );
	update_field( 'location_here_ua', $lh['here_ua'], $p );
	update_field( 'location_here_en', $lh['here_en'], $p );
	update_field( 'location_maps_ua', $lh['maps_ua'], $p );
	update_field( 'location_maps_en', $lh['maps_en'], $p );
	update_field( 'location_maps_url', $lh['maps_url'], $p );
	update_field( 'location_stage_eyebrow_ua', $lh['stage_eyebrow_ua'], $p );
	update_field( 'location_stage_eyebrow_en', $lh['stage_eyebrow_en'], $p );
	update_field( 'location_rows', $D['location_rows'], $p );
	update_field( 'location_stage', $D['location_stage'], $p );

	// Contact
	$c = $D['contact'];
	update_field( 'contact_eyebrow_ua', $c['eyebrow_ua'], $p );
	update_field( 'contact_eyebrow_en', $c['eyebrow_en'], $p );
	update_field( 'contact_title_ua', $c['title_ua'], $p );
	update_field( 'contact_title_en', $c['title_en'], $p );
	update_field( 'contact_title_accent_ua', $c['title_accent_ua'], $p );
	update_field( 'contact_title_accent_en', $c['title_accent_en'], $p );
	update_field( 'contact_lede_ua', $c['lede_ua'], $p );
	update_field( 'contact_lede_en', $c['lede_en'], $p );
	update_field( 'contact_form_title_ua', $c['form_title_ua'], $p );
	update_field( 'contact_form_title_en', $c['form_title_en'], $p );
	update_field( 'contact_form_name_ua', $c['form_name_ua'], $p );
	update_field( 'contact_form_name_en', $c['form_name_en'], $p );
	update_field( 'contact_form_contact_ua', $c['form_contact_ua'], $p );
	update_field( 'contact_form_contact_en', $c['form_contact_en'], $p );
	update_field( 'contact_form_brief_ua', $c['form_brief_ua'], $p );
	update_field( 'contact_form_brief_en', $c['form_brief_en'], $p );
	update_field( 'contact_form_btn_ua', $c['form_btn_ua'], $p );
	update_field( 'contact_form_btn_en', $c['form_btn_en'], $p );
	update_field( 'contact_form_telegram', $c['form_telegram'], $p );
}
