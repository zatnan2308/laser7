<?php
/**
 * Section: Materials. Ported from sections.jsx <Materials>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$head = $D['materials_head'];
$items = l7_rows( 'materials', array( 'name_ua', 'name_en', 'note_ua', 'note_en', 'swatch', 'photo', 'cut' ), $D['materials'] );
?>
<section class="section" id="materials">
	<div class="container-wide">
		<div class="section-head">
			<div class="idx"><?php l7_bi( 'materials_idx', $head['idx_ua'], $head['idx_en'] ); ?></div>
			<h2 class="h-section"><?php l7_bi( 'materials_title', $head['title_ua'], $head['title_en'] ); ?></h2>
			<div class="lede"><?php l7_bi( 'materials_lede', $head['lede_ua'], $head['lede_en'] ); ?></div>
		</div>
		<div class="mat-grid">
			<?php foreach ( $items as $it ) :
				$photo   = l7_photo( $it['photo'] );
				$swatch  = ! empty( $it['swatch'] ) ? $it['swatch'] : 'wood';
				$can_cut = ! empty( $it['cut'] );
				?>
				<article class="mat">
					<div class="mat-swatch sw-<?php echo esc_attr( $swatch ); ?><?php echo $photo ? ' has-photo' : ''; ?>"<?php echo $photo ? ' style="background-image:url(' . esc_url( $photo ) . ')"' : ''; ?>></div>
					<div class="mat-body">
						<div class="name"><?php echo l7_bi_vals( $it['name_ua'], $it['name_en'] ); ?></div>
						<div class="note"><?php echo l7_bi_vals( $it['note_ua'], $it['note_en'] ); ?></div>
						<div class="mat-tags">
							<span class="mat-tag<?php echo $can_cut ? ' on' : ''; ?>"><?php echo l7_bi_vals( 'Різка', 'Cut' ); ?></span>
							<span class="mat-tag on"><?php echo l7_bi_vals( 'Гравіювання', 'Engrave' ); ?></span>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
