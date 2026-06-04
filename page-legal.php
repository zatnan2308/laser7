<?php
/**
 * Template Name: Юридична сторінка (ЛАЗЕР·7)
 *
 * Bilingual legal page (privacy / cookies / terms). Content comes from ACF
 * (legal_heading_*, legal_content_*) with a per-slug default fallback.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
if ( have_posts() ) {
	the_post();
}

$D    = l7_defaults();
$slug = get_post_field( 'post_name', get_the_ID() );
$map  = array( 'konfidentsiynist' => 'privacy', 'cookies' => 'cookies', 'umovy' => 'terms' );
$def  = ( isset( $map[ $slug ] ) && isset( $D['legal'][ $map[ $slug ] ] ) ) ? $D['legal'][ $map[ $slug ] ] : array();

$heading_ua  = l7_field( 'legal_heading_ua', isset( $def['heading_ua'] ) ? $def['heading_ua'] : get_the_title() );
$heading_en  = l7_field( 'legal_heading_en', isset( $def['heading_en'] ) ? $def['heading_en'] : get_the_title() );
$content_ua  = l7_field( 'legal_content_ua', isset( $def['content_ua'] ) ? $def['content_ua'] : '' );
$content_en  = l7_field( 'legal_content_en', isset( $def['content_en'] ) ? $def['content_en'] : '' );
?>
<main>
	<section class="section legal">
		<div class="container-wide">
			<div class="legal-wrap">
				<div class="section-head left" style="margin-bottom:1.5rem">
					<div class="idx"><?php echo l7_bi_vals( 'ЛАЗЕР · 7', 'LASER · 7' ); ?></div>
					<h1 class="h-section"><?php echo l7_bi_vals( $heading_ua, $heading_en ); ?></h1>
				</div>
				<div class="legal-body">
					<div class="lng lng-ua"><?php echo wp_kses_post( $content_ua ); ?></div>
					<div class="lng lng-en"><?php echo wp_kses_post( $content_en ); ?></div>
				</div>
				<p style="margin-top:2rem">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary"><?php echo l7_bi_vals( 'На головну', 'Back to home' ); ?></a>
				</p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
