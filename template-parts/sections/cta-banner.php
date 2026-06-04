<?php
/**
 * Section: red CTA banner. Ported from sections.jsx <CtaBanner>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$c = $D['cta'];
?>
<section class="cta-banner">
	<div class="container-wide cta-banner-inner">
		<div>
			<h2><?php l7_bi( 'cta_title', $c['title_ua'], $c['title_en'] ); ?></h2>
			<p><?php l7_bi( 'cta_sub', $c['sub_ua'], $c['sub_en'] ); ?></p>
		</div>
		<a href="#contact" class="btn btn-dark"><?php l7_bi( 'cta_btn', $c['btn_ua'], $c['btn_en'] ); ?> <span class="arrow"><?php echo l7_icon( 'arrow' ); ?></span></a>
	</div>
</section>
