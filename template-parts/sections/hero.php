<?php
/**
 * Section: Hero (two-column + 3 service cards). Ported from portfolio.jsx <Hero>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$h = $D['hero'];

$trust = l7_rows( 'hero_trust', array( 'n', 'l_ua', 'l_en' ), $D['hero_trust'] );
$cards = l7_rows( 'hero_cards', array( 'title_ua', 'title_en', 'sub_ua', 'sub_en', 'photo', 'motif', 'cta_ua', 'cta_en' ), $D['hero_cards'] );
?>
<section class="hero" id="top">
	<div class="container-wide">
		<div class="hero-main">
			<div class="hero-copy">
				<div class="hero-eyebrow"><span class="dot"></span><?php l7_bi( 'hero_eyebrow', $h['eyebrow_ua'], $h['eyebrow_en'] ); ?></div>
				<h1 class="hero-h1">
					<span><?php l7_bi( 'hero_title1', $h['title1_ua'], $h['title1_en'] ); ?></span>
					<span class="accent"><?php l7_bi( 'hero_title2', $h['title2_ua'], $h['title2_en'] ); ?></span>
				</h1>
				<p class="hero-lede"><?php l7_bi( 'hero_lede', $h['lede_ua'], $h['lede_en'] ); ?></p>
				<div class="hero-btns">
					<a href="#contact" class="btn btn-primary"><?php l7_bi( 'hero_cta1', $h['cta1_ua'], $h['cta1_en'] ); ?> <span class="arrow"><?php echo l7_icon( 'arrow' ); ?></span></a>
					<a href="#portfolio" class="btn btn-secondary"><?php l7_bi( 'hero_cta2', $h['cta2_ua'], $h['cta2_en'] ); ?></a>
				</div>
				<div class="hero-trust">
					<?php foreach ( $trust as $t ) : ?>
						<div class="ht-item"><span class="n"><?php echo esc_html( $t['n'] ); ?></span><span class="l"><?php echo l7_bi_vals( $t['l_ua'], $t['l_en'] ); ?></span></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="hero-figure">
				<div class="hero-figure-img"<?php echo l7_bg_style( 'hero_figure', $h['figure'] ); ?>></div>
				<div class="hero-figure-tag">
					<span class="dot"></span><?php l7_bi( 'hero_figure_tag', $h['figure_tag_ua'], $h['figure_tag_en'] ); ?>
				</div>
			</div>
		</div>

		<div class="hero-cards">
			<?php
			$i = 0;
			foreach ( $cards as $c ) :
				$i++;
				$photo = l7_photo( $c['photo'] );
				$motif = ! empty( $c['motif'] ) ? $c['motif'] : 'logo';
				?>
				<a class="hero-card tone-<?php echo (int) $i; ?>" href="#portfolio">
					<?php if ( $photo ) : ?>
						<div class="bg" style="background-image:url(<?php echo esc_url( $photo ); ?>)"></div>
					<?php else : ?>
						<div class="bg-fallback"><?php echo l7_motif( $motif ); ?></div>
					<?php endif; ?>
					<div class="grid-tex"></div>
					<div class="card-body">
						<div class="card-title"><?php echo l7_bi_vals( $c['title_ua'], $c['title_en'] ); ?></div>
						<div class="card-sub"><?php echo l7_bi_vals( $c['sub_ua'], $c['sub_en'] ); ?></div>
						<span class="card-btn"><?php echo l7_bi_vals( $c['cta_ua'], $c['cta_en'] ); ?> <?php echo l7_icon( 'arrow' ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
