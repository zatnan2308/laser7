<?php
/**
 * Section: Services / price list. Ported from sections.jsx <Services>.
 * price_groups is a nested repeater (group → rows).
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$head = $D['services_head'];

// Build groups from ACF nested repeater, else fall back to defaults.
$groups = array();
if ( function_exists( 'have_rows' ) && have_rows( 'price_groups' ) ) {
	while ( have_rows( 'price_groups' ) ) {
		the_row();
		$rows = array();
		if ( have_rows( 'rows' ) ) {
			while ( have_rows( 'rows' ) ) {
				the_row();
				$rows[] = array(
					'item_ua' => get_sub_field( 'item_ua' ),
					'item_en' => get_sub_field( 'item_en' ),
					'price'   => get_sub_field( 'price' ),
				);
			}
		}
		$groups[] = array(
			'name_ua' => get_sub_field( 'name_ua' ),
			'name_en' => get_sub_field( 'name_en' ),
			'unit_ua' => get_sub_field( 'unit_ua' ),
			'unit_en' => get_sub_field( 'unit_en' ),
			'rows'    => $rows,
		);
	}
}
if ( empty( $groups ) ) {
	$groups = $D['price_groups'];
}
?>
<section class="section" id="services">
	<div class="container-wide">
		<div class="section-head">
			<div class="idx"><?php l7_bi( 'services_idx', $head['idx_ua'], $head['idx_en'] ); ?></div>
			<h2 class="h-section"><?php l7_bi( 'services_title', $head['title_ua'], $head['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'services_note', $head['note_ua'], $head['note_en'] ); ?></div>
		</div>
		<div class="price-grid">
			<?php foreach ( $groups as $g ) : ?>
				<div class="price-card">
					<h3><?php echo l7_bi_vals( $g['name_ua'], $g['name_en'] ); ?></h3>
					<div class="unit"><?php echo l7_bi_vals( $g['unit_ua'], $g['unit_en'] ); ?></div>
					<ul>
						<?php foreach ( $g['rows'] as $r ) : ?>
							<li>
								<span><?php echo l7_bi_vals( $r['item_ua'], $r['item_en'] ); ?></span>
								<span class="price"><?php echo esc_html( $r['price'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="price-note"><?php l7_bi( 'services_foot', $head['foot_ua'], $head['foot_en'] ); ?></p>
	</div>
</section>
