<?php
/**
 * Front page — the ЛАЗЕР · 7 landing.
 * Section order matches the design's app.jsx exactly.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Make the front page the current post so ACF get_field() resolves to it.
if ( have_posts() ) {
	the_post();
}
?>
<main>
	<?php
	$sections = array(
		'hero',
		'advantages',
		'about',
		'portfolio',
		'cta-banner',
		'services',
		'materials',
		'testimonial',
		'faq',
		'location',
		'contact',
	);
	foreach ( $sections as $s ) {
		get_template_part( 'template-parts/sections/' . $s );
	}
	?>
</main>
<?php
get_footer();
