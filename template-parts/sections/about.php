<?php
/**
 * Section: About + experience badge. Ported from sections.jsx <About>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$a = $D['about'];
$paras = l7_rows( 'about_paras', array( 'ua', 'en' ), $D['about_paras'] );
$services = l7_rows( 'about_services', array( 'ua', 'en' ), $D['about_services'] );
?>
<section class="section bg-soft" id="about">
	<div class="container-wide">
		<div class="about">
			<div class="about-visual">
				<div class="about-photos">
					<div class="about-photo big"><?php echo l7_render_img( l7_get_raw( 'about_photo_big' ), $a['photo_big'], 'Вироби майстерні ЛАЗЕР·7 — мапи України', array( 'size' => 'large' ) ); ?></div>
					<div class="about-photo"><?php echo l7_render_img( l7_get_raw( 'about_photo_two' ), $a['photo_two'], 'Вироби майстерні ЛАЗЕР·7 — іменні скриньки', array( 'size' => 'laser7-card' ) ); ?></div>
					<div class="about-photo"><?php echo l7_render_img( l7_get_raw( 'about_photo_three' ), $a['photo_three'], 'Вироби майстерні ЛАЗЕР·7 — іменні лінійки', array( 'size' => 'laser7-card' ) ); ?></div>
				</div>
				<div class="exp-badge">
					<div class="y"><?php echo esc_html( l7_field( 'about_years', $a['years'] ) ); ?><sup>+</sup></div>
					<div class="l"><?php l7_bi( 'about_years_label', $a['years_label_ua'], $a['years_label_en'] ); ?></div>
				</div>
				<div class="exp-dots"></div>
			</div>
			<div class="about-body">
				<div class="section-head left" style="margin-bottom:0.4rem">
					<div class="idx"><?php l7_bi( 'about_kicker', $a['kicker_ua'], $a['kicker_en'] ); ?></div>
					<h2 class="h-section"><?php l7_bi( 'about_title', $a['title_ua'], $a['title_en'] ); ?></h2>
				</div>
				<div class="tagline"><?php l7_bi( 'about_tagline', $a['tagline_ua'], $a['tagline_en'] ); ?></div>
				<?php foreach ( $paras as $p ) : ?>
					<p><?php echo l7_bi_vals( $p['ua'], $p['en'] ); ?></p>
				<?php endforeach; ?>
				<ul class="about-services">
					<?php foreach ( $services as $s ) : ?>
						<li><?php echo l7_bi_vals( $s['ua'], $s['en'] ); ?></li>
					<?php endforeach; ?>
				</ul>
				<a href="#contact" class="btn btn-primary"><?php l7_bi( 'about_cta', $a['cta_ua'], $a['cta_en'] ); ?> <span class="arrow"><?php echo l7_icon( 'arrow' ); ?></span></a>
			</div>
		</div>
	</div>
</section>
