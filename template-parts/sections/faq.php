<?php
/**
 * Section: FAQ accordion (two columns). Ported from sections.jsx <Faq>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$head = $D['faq_head'];
$items = l7_rows( 'faq', array( 'q_ua', 'q_en', 'a_ua', 'a_en' ), $D['faq'] );

$total = count( $items );
$mid   = (int) ceil( $total / 2 );
$cols  = array( array_slice( $items, 0, $mid ), array_slice( $items, $mid ) );
$gidx  = -1; // global index across both columns (first one is open)
?>
<section class="section bg-soft" id="faq">
	<div class="container-wide">
		<div class="section-head">
			<h2 class="h-section"><?php l7_bi( 'faq_title', $head['title_ua'], $head['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'faq_sub', $head['sub_ua'], $head['sub_en'] ); ?></div>
		</div>
		<div class="faq-grid">
			<?php foreach ( $cols as $col ) : ?>
				<div>
					<?php foreach ( $col as $item ) :
						$gidx++;
						$is_open = ( 0 === $gidx ); ?>
						<div class="faq-item<?php echo $is_open ? ' open' : ''; ?>">
							<button class="faq-q">
								<span><?php echo l7_bi_vals( $item['q_ua'], $item['q_en'] ); ?></span>
								<span class="ic"></span>
							</button>
							<div class="faq-a"><?php echo l7_bi_vals( $item['a_ua'], $item['a_en'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
