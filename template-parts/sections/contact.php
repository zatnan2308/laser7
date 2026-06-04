<?php
/**
 * Section: Contact (dark) — direct lines + messenger channels + brief form.
 * Ported from sections.jsx <Contact>. Phone/email/channels are global (options).
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();
$c = $D['contact'];

$phone = l7_opt( 'contact_phone', $D['contact_phone'] );
$email = l7_opt( 'contact_email', $D['contact_email'] );
$channels = l7_rows( 'channels', array( 'id', 'label', 'handle', 'url', 'note_ua', 'note_en' ), $D['channels'], 'option' );
$class_map = array( 'telegram' => 'channel-tg', 'viber' => 'channel-vb', 'whatsapp' => 'channel-wa' );

$tg_handle = l7_field( 'contact_form_telegram', $c['form_telegram'] );
?>
<section class="contact" id="contact">
	<div class="container-wide contact-inner">
		<div>
			<div class="eyebrow" style="color:rgba(243,243,245,0.5);margin-bottom:1rem">
				<?php l7_bi( 'contact_eyebrow', $c['eyebrow_ua'], $c['eyebrow_en'] ); ?>
			</div>
			<h2>
				<?php l7_bi( 'contact_title', $c['title_ua'], $c['title_en'] ); ?>
				<span class="accent"><?php l7_bi( 'contact_title_accent', $c['title_accent_ua'], $c['title_accent_en'] ); ?></span>
			</h2>
			<p class="lede"><?php l7_bi( 'contact_lede', $c['lede_ua'], $c['lede_en'] ); ?></p>
			<div class="direct">
				<a href="<?php echo esc_attr( l7_tel( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			</div>
		</div>

		<div class="channels">
			<?php foreach ( $channels as $ch ) :
				if ( ! $ch['url'] ) { continue; }
				$cls = isset( $class_map[ $ch['id'] ] ) ? $class_map[ $ch['id'] ] : ''; ?>
				<a class="channel <?php echo esc_attr( $cls ); ?>" href="<?php echo esc_url( $ch['url'] ); ?>" target="_blank" rel="noopener noreferrer">
					<div class="icon"><?php echo l7_icon( $ch['id'] ); ?></div>
					<div class="body">
						<div class="name"><?php echo esc_html( $ch['label'] ); ?></div>
						<div class="handle"><?php echo esc_html( $ch['handle'] ); ?></div>
					</div>
					<div>
						<div class="note"><?php echo l7_bi_vals( $ch['note_ua'], $ch['note_en'] ); ?></div>
					</div>
					<div class="arrow"><?php echo l7_icon( 'arrow' ); ?></div>
				</a>
			<?php endforeach; ?>

			<form class="quick-form" data-quick-form data-telegram="<?php echo esc_attr( $tg_handle ); ?>">
				<div class="qf-title"><?php l7_bi( 'contact_form_title', $c['form_title_ua'], $c['form_title_en'] ); ?></div>
				<div class="qf-row">
					<input class="qf-input" name="name"<?php echo l7_attr_bi( $c['form_name_ua'], $c['form_name_en'] ); ?> />
					<input class="qf-input" name="contact"<?php echo l7_attr_bi( $c['form_contact_ua'], $c['form_contact_en'] ); ?> />
				</div>
				<textarea class="qf-input" name="brief" rows="3" style="resize:vertical"<?php echo l7_attr_bi( $c['form_brief_ua'], $c['form_brief_en'] ); ?>></textarea>
				<button type="submit" class="btn btn-burn" style="justify-content:center">
					<?php l7_bi( 'contact_form_btn', $c['form_btn_ua'], $c['form_btn_en'] ); ?> <?php echo l7_icon( 'arrow' ); ?>
				</button>
			</form>
		</div>
	</div>
</section>
