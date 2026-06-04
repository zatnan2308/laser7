<?php
/**
 * Section: Advantages / УТП. Ported from sections.jsx <Advantages>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$head = $D['advantages_head'];
$items = l7_rows( 'advantages', array( 'icon', 'title_ua', 'title_en', 'body_ua', 'body_en' ), $D['advantages'] );
?>
<section class="section" id="advantages">
	<div class="container-wide">
		<div class="section-head">
			<div class="idx"><?php l7_bi( 'advantages_idx', $head['idx_ua'], $head['idx_en'] ); ?></div>
			<h2 class="h-section"><?php l7_bi( 'advantages_title', $head['title_ua'], $head['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'advantages_lede', $head['lede_ua'], $head['lede_en'] ); ?></div>
		</div>
		<div class="adv">
			<?php foreach ( $items as $a ) : ?>
				<div class="adv-cell">
					<div class="ico"><?php echo l7_icon( $a['icon'] ); ?></div>
					<h3><?php echo l7_bi_vals( $a['title_ua'], $a['title_en'] ); ?></h3>
					<p><?php echo l7_bi_vals( $a['body_ua'], $a['body_en'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
