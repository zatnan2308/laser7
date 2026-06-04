<?php
/**
 * Helpers — bilingual output, ACF getters, image fallbacks.
 *
 * Bilingual model (1:1 with the prototype):
 *   every visible string is printed in BOTH languages, wrapped in
 *   <span class="lng lng-ua"> / <span class="lng lng-en">. A tiny JS sets
 *   data-lang on <html> and CSS shows only the active language. The choice
 *   is stored in localStorage, exactly like the original React app.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -----------------------------------------------------------------------
 * ACF getters with graceful fallback when ACF Pro is not active.
 * -------------------------------------------------------------------- */
function l7_field( $name, $default = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$v = get_field( $name, $post_id );
		if ( null !== $v && '' !== $v && array() !== $v ) {
			return $v;
		}
	}
	return $default;
}

function l7_opt( $name, $default = '' ) {
	return l7_field( $name, $default, 'option' );
}

function l7_sub( $name, $default = '' ) {
	if ( function_exists( 'get_sub_field' ) ) {
		$v = get_sub_field( $name );
		if ( null !== $v && '' !== $v && array() !== $v ) {
			return $v;
		}
	}
	return $default;
}

/* -----------------------------------------------------------------------
 * Bilingual markup.
 * -------------------------------------------------------------------- */

/**
 * Wrap a UA + EN pair into language spans (returns HTML-escaped text).
 */
function l7_t( $ua, $en, $tag = 'span' ) {
	$ua = esc_html( $ua );
	$en = esc_html( $en !== '' ? $en : $ua );
	return '<span class="lng lng-ua">' . $ua . '</span><span class="lng lng-en">' . $en . '</span>';
}

/** Same, but allowing inline HTML (e.g. line breaks) — used rarely, callers sanitise. */
function l7_t_raw( $ua, $en ) {
	if ( '' === $en ) {
		$en = $ua;
	}
	return '<span class="lng lng-ua">' . $ua . '</span><span class="lng lng-en">' . $en . '</span>';
}

/**
 * Echo a bilingual field: reads {$base}_ua / {$base}_en from ACF (page or option),
 * falling back to provided defaults so the site renders 1:1 out of the box.
 */
function l7_bi( $base, $def_ua = '', $def_en = '', $post_id = false ) {
	echo l7_bi_get( $base, $def_ua, $def_en, $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput
}

function l7_bi_get( $base, $def_ua = '', $def_en = '', $post_id = false ) {
	$ua = l7_field( $base . '_ua', $def_ua, $post_id );
	$en = l7_field( $base . '_en', $def_en, $post_id );
	return l7_t( $ua, $en );
}

/** Bilingual from explicit values (used inside repeater loops / defaults arrays). */
function l7_bi_vals( $ua, $en ) {
	return l7_t( $ua, $en );
}

/** Return [ua, en] strings (for places that need raw text, e.g. attributes/JS). */
function l7_pair( $base, $def_ua = '', $def_en = '', $post_id = false ) {
	return array(
		l7_field( $base . '_ua', $def_ua, $post_id ),
		l7_field( $base . '_en', $def_en, $post_id ),
	);
}

/** Bilingual placeholder/aria via data attributes (JS swaps it). */
function l7_attr_bi( $ua, $en, $attr = 'placeholder' ) {
	if ( '' === $en ) {
		$en = $ua;
	}
	return ' data-' . esc_attr( $attr ) . '-ua="' . esc_attr( $ua ) . '" data-' . esc_attr( $attr ) . '-en="' . esc_attr( $en ) . '" ' . esc_attr( $attr ) . '="' . esc_attr( $ua ) . '"';
}

/* -----------------------------------------------------------------------
 * Images — ACF image field with a bundled default (webp) fallback.
 * -------------------------------------------------------------------- */

/**
 * Resolve an ACF image value (id|array|url) to a URL.
 * If empty, fall back to a bundled asset filename in /assets/images/.
 */
function l7_img_url( $acf_value, $default_filename = '', $size = 'large' ) {
	$url = '';
	if ( is_array( $acf_value ) ) {
		$url = isset( $acf_value['sizes'][ $size ] ) ? $acf_value['sizes'][ $size ] : ( isset( $acf_value['url'] ) ? $acf_value['url'] : '' );
	} elseif ( is_numeric( $acf_value ) ) {
		$src = wp_get_attachment_image_src( (int) $acf_value, $size );
		$url = $src ? $src[0] : '';
	} elseif ( is_string( $acf_value ) && '' !== $acf_value ) {
		$url = $acf_value;
	}
	if ( '' === $url && '' !== $default_filename ) {
		$url = LASER7_URI . '/assets/images/' . ltrim( $default_filename, '/' );
	}
	return $url;
}

/** Alt text from an ACF image value, with fallback string. */
function l7_img_alt( $acf_value, $fallback = '' ) {
	if ( is_array( $acf_value ) && ! empty( $acf_value['alt'] ) ) {
		return $acf_value['alt'];
	}
	if ( is_numeric( $acf_value ) ) {
		$alt = get_post_meta( (int) $acf_value, '_wp_attachment_image_alt', true );
		if ( $alt ) {
			return $alt;
		}
	}
	return $fallback;
}

/**
 * Echo an <img> for a content photo (ACF field + default webp filename).
 */
function l7_img( $field_name, $default_filename, $alt = '', $size = 'large', $post_id = false ) {
	$val = function_exists( 'get_field' ) ? get_field( $field_name, $post_id ) : '';
	$url = l7_img_url( $val, $default_filename, $size );
	$alt = l7_img_alt( $val, $alt );
	if ( ! $url ) {
		return;
	}
	echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" decoding="async" />';
}

/**
 * Resolve a photo value that may be either an ACF image (id|array|url) OR a
 * bare asset filename coming from the defaults array. Returns a usable URL.
 */
function l7_photo( $value, $fallback_filename = '' ) {
	if ( is_array( $value ) ) {
		return isset( $value['url'] ) ? $value['url'] : '';
	}
	if ( is_numeric( $value ) ) {
		$s = wp_get_attachment_image_src( (int) $value, 'large' );
		return $s ? $s[0] : '';
	}
	if ( is_string( $value ) && '' !== $value ) {
		if ( preg_match( '#^https?://#', $value ) || 0 === strpos( $value, '/' ) ) {
			return $value;
		}
		return LASER7_URI . '/assets/images/' . $value; // bare filename → bundled asset
	}
	if ( '' !== $fallback_filename ) {
		return LASER7_URI . '/assets/images/' . $fallback_filename;
	}
	return '';
}

/** Alt text for an l7_photo() value (ACF image alt, else fallback). */
function l7_photo_alt( $value, $fallback = '' ) {
	return l7_img_alt( $value, $fallback );
}

/** Background-image inline style (for hero figure / about / testimonial / swatches). */
function l7_bg_style( $field_name, $default_filename, $size = 'large', $post_id = false ) {
	$val = function_exists( 'get_field' ) ? get_field( $field_name, $post_id ) : '';
	$url = l7_img_url( $val, $default_filename, $size );
	if ( ! $url ) {
		return '';
	}
	return ' style="background-image:url(' . esc_url( $url ) . ')"';
}

/* -----------------------------------------------------------------------
 * Misc.
 * -------------------------------------------------------------------- */

/** Telephone href (strip spaces). */
function l7_tel( $phone ) {
	return 'tel:' . preg_replace( '/\s+/', '', $phone );
}

/** Active accent class chosen in theme options (default red). */
function l7_accent_class() {
	$accent = l7_opt( 'accent', 'red' );
	$allowed = array( 'red', 'amber', 'blue', 'green', 'graphite' );
	if ( ! in_array( $accent, $allowed, true ) ) {
		$accent = 'red';
	}
	return 'accent-' . $accent;
}

/**
 * Normalise an ACF repeater into a plain array of rows, each guaranteed to
 * contain every requested sub-field key (missing/null → ''). Falls back to the
 * defaults array (also normalised) when the repeater is empty / ACF inactive.
 */
function l7_rows( $name, $sub_fields, $defaults, $post_id = false ) {
	$rows = null;

	if ( function_exists( 'have_rows' ) && have_rows( $name, $post_id ) ) {
		$rows = array();
		while ( have_rows( $name, $post_id ) ) {
			the_row();
			$r = array();
			foreach ( $sub_fields as $sf ) {
				$v = get_sub_field( $sf );
				$r[ $sf ] = ( null === $v ) ? '' : $v;
			}
			$rows[] = $r;
		}
		if ( empty( $rows ) ) {
			$rows = null;
		}
	}

	if ( null === $rows ) {
		$rows = array();
		foreach ( (array) $defaults as $row ) {
			$r = array();
			foreach ( $sub_fields as $sf ) {
				$r[ $sf ] = isset( $row[ $sf ] ) ? $row[ $sf ] : '';
			}
			$rows[] = $r;
		}
	}

	return $rows;
}
