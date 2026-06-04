<?php
/**
 * Section: Testimonial. Ported from sections.jsx <Testimonial>.
 * Optional video opens in an overlay (see main.js).
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$t = $D['testimonial'];

$video_val = function_exists( 'get_field' ) ? get_field( 'testimonial_video' ) : '';
$video_url = is_array( $video_val ) ? ( isset( $video_val['url'] ) ? $video_val['url'] : '' ) : ( is_numeric( $video_val ) ? wp_get_attachment_url( (int) $video_val ) : $video_val );
if ( ! $video_url ) {
	$video_url = $t['video'];
}
?>
<section class="section">
	<div class="container-wide">
		<div class="testi">
			<div class="testi-media has-photo">
				<?php echo l7_render_img( l7_get_raw( 'testimonial_photo' ), $t['photo'], 'Відгук клієнта про ЛАЗЕР·7', array( 'size' => 'large' ) ); ?>
				<button class="testi-play" title="Play"<?php echo $video_url ? ' data-video-play="' . esc_url( $video_url ) . '"' : ''; ?>><?php echo l7_icon( 'play' ); ?></button>
			</div>
			<div class="testi-body">
				<div class="qmark"><?php echo l7_icon( 'quote' ); ?></div>
				<blockquote><?php l7_bi( 'testimonial_quote', $t['quote_ua'], $t['quote_en'] ); ?></blockquote>
				<div class="testi-author">
					<div class="name"><?php l7_bi( 'testimonial_author', $t['author'], $t['author_en'] ); ?></div>
					<div class="role"><?php l7_bi( 'testimonial_role', $t['role_ua'], $t['role_en'] ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>
