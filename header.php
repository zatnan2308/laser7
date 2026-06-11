<?php
/**
 * Header: topbar + sticky nav + mobile drawer.
 * Ported 1:1 from portfolio.jsx <Nav>. Globals come from ACF options.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$D = l7_defaults();

// Global brand / topbar / nav / channels (ACF option → default).
$brand_ua = l7_opt( 'brand_name_ua', $D['brand']['name_ua'] );
$brand_en = l7_opt( 'brand_name_en', $D['brand']['name_en'] );
$brand_mark = l7_opt( 'brand_mark', $D['brand']['mark'] );

$tb_phone = l7_opt( 'topbar_phone', $D['topbar']['phone'] );
$show_topbar = l7_opt( 'show_topbar', true );
$show_topbar = ( '' === $show_topbar ) ? true : (bool) $show_topbar;

$nav_items = l7_rows( 'nav_items', array( 'anchor', 'label_ua', 'label_en' ), $D['nav'], 'option' );
$channels  = l7_rows( 'channels', array( 'id', 'label', 'handle', 'url', 'note_ua', 'note_en' ), $D['channels'], 'option' );
$ch_class  = array( 'telegram' => 'tg', 'viber' => 'vb', 'whatsapp' => 'wa' );
?>
<!doctype html>
<html <?php language_attributes(); ?> data-lang="ua">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
	<script>
	/* set saved language before paint to avoid a flash of both languages */
	(function(){try{var l=localStorage.getItem('laser7_lang');if(l==='en'||l==='ua'){document.documentElement.setAttribute('data-lang',l);}}catch(e){}})();
	</script>
</head>

<body <?php body_class( l7_accent_class() . ( $show_topbar ? '' : ' hide-topbar' ) ); ?>>
<?php wp_body_open(); ?>

<?php if ( $show_topbar ) : ?>
<div class="topbar">
	<div class="topbar-inner">
		<div class="tb-left">
			<span class="tb-item tb-address"><?php echo l7_icon( 'pin' ); ?><?php l7_bi( 'topbar_address', $D['topbar']['address_ua'], $D['topbar']['address_en'], 'option' ); ?></span>
			<span class="tb-item tb-hours"><?php echo l7_icon( 'clock' ); ?><?php l7_bi( 'topbar_hours', $D['topbar']['hours_ua'], $D['topbar']['hours_en'], 'option' ); ?></span>
		</div>
		<div class="tb-right">
			<div class="tb-lang" role="tablist" aria-label="language">
				<button class="is-active" data-set-lang="ua">UA</button>
				<span style="color:var(--ink-muted)">/</span>
				<button data-set-lang="en">EN</button>
			</div>
			<a class="tb-item tb-phone" href="<?php echo esc_attr( l7_tel( $tb_phone ) ); ?>"><?php echo l7_icon( 'phone' ); ?><?php echo esc_html( $tb_phone ); ?></a>
		</div>
	</div>
</div>
<?php endif; ?>

<header class="nav">
	<div class="nav-inner">
		<a href="<?php echo esc_url( home_url( '/#top' ) ); ?>" class="nav-mark">
			<?php echo l7_logo(); ?>
		</a>
		<ul class="nav-links">
			<?php foreach ( $nav_items as $l ) : ?>
				<li><a href="#<?php echo esc_attr( $l['anchor'] ); ?>"><?php echo l7_bi_vals( $l['label_ua'], $l['label_en'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="nav-right">
			<div class="nav-contacts">
				<?php foreach ( $channels as $c ) :
					$cls = isset( $ch_class[ $c['id'] ] ) ? $ch_class[ $c['id'] ] : '';
					if ( ! $c['url'] ) { continue; } ?>
					<a class="nav-contact <?php echo esc_attr( $cls ); ?>" href="<?php echo esc_url( $c['url'] ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $c['label'] ); ?>" aria-label="<?php echo esc_attr( $c['label'] ); ?>"><?php echo l7_icon( $c['id'] ); ?></a>
				<?php endforeach; ?>
				<?php $insta = l7_opt( 'instagram_url', '' ); if ( $insta ) : ?>
					<a class="nav-contact in" href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Instagram"><?php echo l7_icon( 'instagram' ); ?></a>
				<?php endif; ?>
			</div>
			<button class="nav-burger" aria-label="Open menu" aria-expanded="false" data-burger>
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<!-- mobile drawer -->
<div class="mobile-menu" data-mobile-menu>
	<div class="mm-backdrop" data-menu-close></div>
	<nav class="mm-panel" aria-label="mobile">
		<div class="mm-head">
			<?php echo l7_logo(); ?>
			<button class="mm-close" aria-label="Close" data-menu-close>×</button>
		</div>
		<ul class="mm-links">
			<?php foreach ( $nav_items as $l ) : ?>
				<li><a href="#<?php echo esc_attr( $l['anchor'] ); ?>" data-menu-close><?php echo l7_bi_vals( $l['label_ua'], $l['label_en'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="mm-lang">
			<button class="is-active" data-set-lang="ua">UA</button>
			<button data-set-lang="en">EN</button>
		</div>
		<a href="<?php echo esc_attr( l7_tel( $tb_phone ) ); ?>" class="mm-phone"><?php echo l7_icon( 'phone' ); ?> <?php echo esc_html( $tb_phone ); ?></a>
		<div class="mm-channels">
			<?php foreach ( $channels as $c ) :
				$cls = isset( $ch_class[ $c['id'] ] ) ? $ch_class[ $c['id'] ] : '';
				if ( ! $c['url'] ) { continue; } ?>
				<a class="channel-btn <?php echo esc_attr( $cls ); ?>" href="<?php echo esc_url( $c['url'] ); ?>" target="_blank" rel="noopener noreferrer" data-menu-close><?php echo l7_icon( $c['id'] ); ?><span><?php echo esc_html( $c['label'] ); ?></span></a>
			<?php endforeach; ?>
			<?php if ( ! empty( $insta ) ) : ?>
				<a class="channel-btn in" href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener noreferrer" data-menu-close><?php echo l7_icon( 'instagram' ); ?><span>Instagram</span></a>
			<?php endif; ?>
		</div>
		<div class="mm-info">
			<div><?php echo l7_icon( 'pin' ); ?> <?php l7_bi( 'topbar_address', $D['topbar']['address_ua'], $D['topbar']['address_en'], 'option' ); ?></div>
			<div><?php echo l7_icon( 'clock' ); ?> <?php l7_bi( 'topbar_hours', $D['topbar']['hours_ua'], $D['topbar']['hours_en'], 'option' ); ?></div>
		</div>
	</nav>
</div>
