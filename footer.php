<?php
/**
 * Footer + floating quick contact + scroll-to-top.
 * Ported 1:1 from sections.jsx <Footer>/<QuickContact>/<ScrollTop>.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();

$brand_ua = l7_opt( 'brand_name_ua', $D['brand']['name_ua'] );
$brand_en = l7_opt( 'brand_name_en', $D['brand']['name_en'] );
$brand_mark = l7_opt( 'brand_mark', $D['brand']['mark'] );

$phone = l7_opt( 'contact_phone', $D['contact_phone'] );
$email = l7_opt( 'contact_email', $D['contact_email'] );

$nav_items = l7_rows( 'nav_items', array( 'anchor', 'label_ua', 'label_en' ), $D['nav'], 'option' );
$channels  = l7_rows( 'channels', array( 'id', 'label', 'handle', 'url', 'note_ua', 'note_en' ), $D['channels'], 'option' );
$foot_links = l7_rows( 'footer_links', array( 'ua', 'en', 'url' ), $D['footer']['links'], 'option' );

$col_a = array_slice( $nav_items, 0, 4 );
$col_b = array_slice( $nav_items, 4 );
$ch_class = array( 'telegram' => 'tg', 'viber' => 'vb', 'whatsapp' => 'wa' );

// Channel URLs for the floating widget (telegram/viber/whatsapp by id).
$ch_by_id = array();
foreach ( $channels as $c ) { $ch_by_id[ $c['id'] ] = $c; }
?>

<footer class="footer">
	<div class="container-wide">
		<div class="footer-top">
			<div class="footer-brand">
				<?php echo l7_logo(); ?>
				<p class="tagline"><?php l7_bi( 'footer_tagline', $D['footer']['tagline_ua'], $D['footer']['tagline_en'], 'option' ); ?></p>
				<div class="footer-social">
					<?php foreach ( $channels as $c ) :
						if ( ! $c['url'] ) { continue; } ?>
						<a href="<?php echo esc_url( $c['url'] ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $c['label'] ); ?>"><?php echo l7_icon( $c['id'] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php l7_bi( 'footer_col_a', $D['footer']['col_a_ua'], $D['footer']['col_a_en'], 'option' ); ?></h4>
				<ul>
					<?php foreach ( $col_a as $l ) : ?>
						<li><a href="#<?php echo esc_attr( $l['anchor'] ); ?>"><?php echo l7_bi_vals( $l['label_ua'], $l['label_en'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php l7_bi( 'footer_col_b', $D['footer']['col_b_ua'], $D['footer']['col_b_en'], 'option' ); ?></h4>
				<ul>
					<?php foreach ( $col_b as $l ) : ?>
						<li><a href="#<?php echo esc_attr( $l['anchor'] ); ?>"><?php echo l7_bi_vals( $l['label_ua'], $l['label_en'] ); ?></a></li>
					<?php endforeach; ?>
					<?php foreach ( $foot_links as $fl ) : ?>
						<li><a href="<?php echo esc_url( $fl['url'] ? $fl['url'] : '#contact' ); ?>"><?php echo l7_bi_vals( $fl['ua'], $fl['en'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col footer-contact">
				<h4><?php l7_bi( 'footer_col_c', $D['footer']['col_c_ua'], $D['footer']['col_c_en'], 'option' ); ?></h4>
				<div class="ci"><?php echo l7_icon( 'phone' ); ?><a href="<?php echo esc_attr( l7_tel( $phone ) ); ?>" style="color:var(--ink);text-decoration:none"><?php echo esc_html( $phone ); ?></a></div>
				<div class="ci"><?php echo l7_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $email ); ?>" style="color:var(--ink);text-decoration:none"><?php echo esc_html( $email ); ?></a></div>
				<div class="ci"><?php echo l7_icon( 'pin' ); ?><?php l7_bi( 'topbar_address', $D['topbar']['address_ua'], $D['topbar']['address_en'], 'option' ); ?></div>
				<div class="ci"><?php echo l7_icon( 'clock' ); ?><?php l7_bi( 'topbar_hours', $D['topbar']['hours_ua'], $D['topbar']['hours_en'], 'option' ); ?></div>
			</div>
		</div>

		<div class="footer-bottom">
			<span><?php l7_bi( 'footer_copyright', $D['footer']['copyright_ua'], $D['footer']['copyright_en'], 'option' ); ?></span>
			<span><?php l7_bi( 'footer_note', $D['footer']['note_ua'], $D['footer']['note_en'], 'option' ); ?></span>
		</div>

		<?php
		$credit_name = l7_opt( 'footer_credit_name', $D['footer']['credit_name'] );
		$credit_url  = l7_opt( 'footer_credit_url', $D['footer']['credit_url'] );
		if ( $credit_name ) :
			?>
			<div class="footer-credit">
				<?php echo l7_bi_vals( 'Сайт від', 'Website by' ); ?>
				<?php if ( $credit_url ) : ?>
					<a href="<?php echo esc_url( $credit_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $credit_name ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $credit_name ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</footer>

<!-- floating quick contact -->
<div class="qc" data-qc>
	<button class="qc-toggle" data-qc-toggle title="Quick contact"><?php echo l7_icon( 'chat' ); ?></button>
	<div class="qc-stack">
		<?php
		$qc_colors = array( 'telegram' => '#229ED9', 'viber' => '#7B519D', 'whatsapp' => '#25D366' );
		foreach ( array( 'telegram', 'viber', 'whatsapp' ) as $id ) :
			if ( empty( $ch_by_id[ $id ]['url'] ) ) { continue; }
			$c = $ch_by_id[ $id ]; ?>
			<a class="qc-link" style="color:<?php echo esc_attr( $qc_colors[ $id ] ); ?>" href="<?php echo esc_url( $c['url'] ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $c['label'] ); ?>"><?php echo l7_icon( $id ); ?></a>
		<?php endforeach; ?>
	</div>
</div>

<!-- scroll to top -->
<button class="scroll-top" data-scrolltop aria-label="Back to top" title="Back to top"><?php echo l7_icon( 'top' ); ?></button>

<!-- cookie consent banner -->
<?php
$cookies_page = get_page_by_path( 'cookies' );
$cookies_url  = $cookies_page ? get_permalink( $cookies_page ) : home_url( '/cookies/' );
?>
<div class="l7-cookie" data-cookie hidden>
	<div class="l7-cookie-inner">
		<div class="l7-cookie-text">
			<?php l7_bi( 'cookie_text', $D['cookie']['text_ua'], $D['cookie']['text_en'], 'option' ); ?>
			<a class="l7-cookie-link" href="<?php echo esc_url( $cookies_url ); ?>"><?php l7_bi( 'cookie_more', $D['cookie']['more_ua'], $D['cookie']['more_en'], 'option' ); ?></a>
		</div>
		<div class="l7-cookie-btns">
			<button type="button" class="btn btn-ghost" data-cookie-decline><?php l7_bi( 'cookie_decline', $D['cookie']['decline_ua'], $D['cookie']['decline_en'], 'option' ); ?></button>
			<button type="button" class="btn btn-primary" data-cookie-accept><?php l7_bi( 'cookie_accept', $D['cookie']['accept_ua'], $D['cookie']['accept_en'], 'option' ); ?></button>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
