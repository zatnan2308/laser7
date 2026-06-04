<?php
/**
 * Section: Location (stylised map + details). Ported from sections.jsx <Location>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$l = $D['location_head'];
$rows  = l7_rows( 'location_rows', array( 'k_ua', 'k_en', 'v_ua', 'v_en' ), $D['location_rows'] );
$stage = l7_rows( 'location_stage', array( 'label_ua', 'label_en', 'body_ua', 'body_en' ), $D['location_stage'] );
$maps_url = l7_field( 'location_maps_url', $l['maps_url'] );
?>
<section class="section bg-soft" id="location">
	<div class="container-wide">
		<div class="section-head">
			<div class="idx"><?php l7_bi( 'location_idx', $l['idx_ua'], $l['idx_en'] ); ?></div>
			<h2 class="h-section"><?php l7_bi( 'location_title', $l['title_ua'], $l['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'location_lede', $l['lede_ua'], $l['lede_en'] ); ?></div>
		</div>
		<div class="loc-grid">
			<div class="map-card">
				<div class="map-canvas"></div>
				<svg class="map-roads" viewBox="0 0 400 460" preserveAspectRatio="none">
					<path d="M -10 280 Q 120 200, 250 240 T 420 200" stroke="rgba(244,234,212,0.18)" stroke-width="22" fill="none"/>
					<path d="M 80 -10 L 240 200 L 200 460" stroke="rgba(244,234,212,0.10)" stroke-width="14" fill="none"/>
					<path d="M -10 380 L 420 380" stroke="rgba(244,234,212,0.08)" stroke-width="10" fill="none"/>
				</svg>

				<div class="map-overlay">
					<div class="city"><?php echo esc_html( l7_field( 'location_city', $l['city'] ) ); ?></div>
					<div class="row">
						<span><?php echo esc_html( l7_field( 'location_coords', $l['coords'] ) ); ?></span>
						<span><?php l7_bi( 'location_bazaar', $l['bazaar_ua'], $l['bazaar_en'] ); ?></span>
					</div>
				</div>

				<div class="map-pin">
					<div class="ring"></div>
					<div class="label"><?php l7_bi( 'location_pin', $l['pin_ua'], $l['pin_en'] ); ?></div>
				</div>

				<div class="map-footer">
					<div class="coord">★ <?php l7_bi( 'location_here', $l['here_ua'], $l['here_en'] ); ?></div>
					<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php l7_bi( 'location_maps', $l['maps_ua'], $l['maps_en'] ); ?> →
					</a>
				</div>
			</div>

			<div class="loc-info">
				<div class="loc-rows">
					<?php foreach ( $rows as $r ) : ?>
						<div class="loc-row">
							<div class="k"><?php echo l7_bi_vals( $r['k_ua'], $r['k_en'] ); ?></div>
							<div class="v"><?php echo l7_bi_vals( $r['v_ua'], $r['v_en'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>

				<div>
					<div class="eyebrow" style="margin-bottom:0.7rem">
						<?php l7_bi( 'location_stage_eyebrow', $l['stage_eyebrow_ua'], $l['stage_eyebrow_en'] ); ?>
					</div>
					<div class="stage-strip">
						<?php foreach ( $stage as $s ) : ?>
							<div class="cell">
								<div class="key"><?php echo l7_bi_vals( $s['label_ua'], $s['label_en'] ); ?></div>
								<div class="val"><?php echo l7_bi_vals( $s['body_ua'], $s['body_en'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
