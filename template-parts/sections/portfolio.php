<?php
/**
 * Section: Portfolio — filter + grid + "show more" + lightbox.
 * Ported from portfolio.jsx <Portfolio>. Filtering / pagination / lightbox
 * are re-implemented in assets/js/main.js (vanilla, reads data-* attributes).
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$head = $D['portfolio_head'];

$cats  = l7_rows( 'categories', array( 'id', 'label_ua', 'label_en' ), $D['categories'] );
$works = l7_rows( 'works', array( 'cat', 'photo', 'video', 'title_ua', 'title_en', 'material_ua', 'material_en', 'tone' ), $D['works'] );

// Build a lookup of category labels and counts.
$cat_label_ua = array();
$cat_label_en = array();
foreach ( $cats as $c ) {
	$cat_label_ua[ $c['id'] ] = $c['label_ua'];
	$cat_label_en[ $c['id'] ] = $c['label_en'];
}
$counts = array( 'all' => count( $works ) );
foreach ( $cats as $c ) {
	if ( 'all' === $c['id'] ) { continue; }
	$counts[ $c['id'] ] = 0;
}
foreach ( $works as $w ) {
	if ( isset( $counts[ $w['cat'] ] ) ) { $counts[ $w['cat'] ]++; }
}

$page_size = (int) l7_field( 'portfolio_page_size', 9 );
if ( $page_size < 1 ) { $page_size = 9; }
?>
<section class="section" id="portfolio" data-portfolio data-page="<?php echo (int) $page_size; ?>">
	<div class="container-wide">
		<div class="section-head">
			<div class="idx"><?php l7_bi( 'portfolio_idx', $head['idx_ua'], $head['idx_en'] ); ?></div>
			<h2 class="h-section"><?php l7_bi( 'portfolio_title', $head['title_ua'], $head['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'portfolio_lede', $head['lede_ua'], $head['lede_en'] ); ?></div>
		</div>

		<div class="portfolio-controls">
			<div class="cat-pills">
				<?php foreach ( $cats as $c ) : ?>
					<button class="cat-pill<?php echo ( 'all' === $c['id'] ) ? ' is-active' : ''; ?>" data-cat="<?php echo esc_attr( $c['id'] ); ?>">
						<?php echo l7_bi_vals( $c['label_ua'], $c['label_en'] ); ?>
						<span class="count"><?php echo (int) ( isset( $counts[ $c['id'] ] ) ? $counts[ $c['id'] ] : 0 ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="portfolio-grid" data-grid>
			<?php
			$idx = -1;
			foreach ( $works as $w ) :
				$idx++;
				$photo = l7_photo( $w['photo'] );
				$video = is_array( $w['video'] ) ? ( isset( $w['video']['url'] ) ? $w['video']['url'] : '' ) : ( is_numeric( $w['video'] ) ? wp_get_attachment_url( (int) $w['video'] ) : $w['video'] );
				$tone  = ! empty( $w['tone'] ) ? $w['tone'] : 'warm';
				$clu   = isset( $cat_label_ua[ $w['cat'] ] ) ? $cat_label_ua[ $w['cat'] ] : '';
				$cle   = isset( $cat_label_en[ $w['cat'] ] ) ? $cat_label_en[ $w['cat'] ] : '';
				$alt   = l7_photo_alt( $w['photo'], $w['title_ua'] );
				?>
				<article class="work tone-<?php echo esc_attr( $tone ); ?>"
					data-cat="<?php echo esc_attr( $w['cat'] ); ?>"
					data-index="<?php echo (int) $idx; ?>"
					data-photo="<?php echo esc_url( $photo ); ?>"
					data-video="<?php echo esc_url( $video ); ?>"
					data-title-ua="<?php echo esc_attr( $w['title_ua'] ); ?>"
					data-title-en="<?php echo esc_attr( $w['title_en'] ); ?>"
					data-mat-ua="<?php echo esc_attr( $w['material_ua'] ); ?>"
					data-mat-en="<?php echo esc_attr( $w['material_en'] ); ?>"
					data-cat-ua="<?php echo esc_attr( $clu ); ?>"
					data-cat-en="<?php echo esc_attr( $cle ); ?>">
					<div class="work-img<?php echo $photo ? '' : ' is-ph'; ?>">
						<?php if ( $photo ) : ?>
							<?php echo l7_render_img( $w['photo'], '', $alt, array( 'size' => 'laser7-portfolio' ) ); ?>
						<?php else : ?>
							<div class="work-placeholder"><?php echo l7_motif( 'logo' ); ?></div>
						<?php endif; ?>
						<div class="work-zoom"><?php echo $video ? l7_icon( 'play-circle' ) : l7_icon( 'expand' ); ?></div>
					</div>
					<div class="work-meta">
						<div class="top"><span class="cat"><?php echo l7_bi_vals( $clu, $cle ); ?></span></div>
						<h3 class="h-card"><?php echo l7_bi_vals( $w['title_ua'], $w['title_en'] ); ?></h3>
						<?php if ( $w['material_ua'] || $w['material_en'] ) : ?>
							<div class="mat"><?php echo l7_bi_vals( $w['material_ua'], $w['material_en'] ); ?></div>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>

			<div class="portfolio-empty" data-empty hidden>
				<span class="lng lng-ua">У цій категорії роботи скоро з’являться</span><span class="lng lng-en">Works in this category are coming soon</span>
			</div>
		</div>

		<div class="portfolio-more" data-more hidden>
			<button class="btn btn-secondary" data-more-btn>
				<span class="lng lng-ua">Показати ще</span><span class="lng lng-en">Show more</span>
				<span class="more-count"></span>
			</button>
		</div>
	</div>

	<!-- lightbox -->
	<div class="lb" data-lb aria-hidden="true">
		<div class="lb-bar">
			<span class="lb-counter" data-lb-counter></span>
			<button class="lb-close" data-lb-close aria-label="Close">×</button>
		</div>
		<div class="lb-stage">
			<button class="lb-nav prev" data-lb-prev aria-label="Previous"><?php echo l7_icon( 'chevron-left' ); ?></button>
			<div class="lb-media" data-lb-media></div>
			<button class="lb-nav next" data-lb-next aria-label="Next"><?php echo l7_icon( 'chevron-right' ); ?></button>
		</div>
		<div class="lb-cap">
			<div class="lb-catlabel" data-lb-cat></div>
			<div class="lb-title" data-lb-title></div>
			<div class="lb-mat" data-lb-mat></div>
		</div>
		<div class="lb-thumbs" data-lb-thumbs></div>
	</div>
</section>
