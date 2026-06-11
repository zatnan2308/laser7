<?php
/**
 * Inline SVG icons + decorative motifs — ported 1:1 from js/icons.jsx.
 *
 * Usage: echo l7_icon('arrow');  /  l7_motif('tag');
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function l7_icon( $name ) {
	$icons = array(

		'arrow' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',

		'plus' => '<svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>',

		'telegram' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',

		'viber' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.398.002C9.473.027 5.331.339 3.014 2.467 1.294 4.177.693 6.698.623 9.82c-.06 3.11-.13 8.95 5.5 10.541v2.42s-.038.97.602 1.17c.79.25 1.24-.499 1.99-1.299l1.4-1.58c3.85.32 6.8-.419 7.14-.529.78-.25 5.181-.811 5.901-6.652.74-6.022-.36-9.831-2.34-11.551l-.01-.002c-.6-.55-3-2.3-8.37-2.32 0 0-.396-.025-1.038-.016zm.067 1.697c.545-.003.88.02.88.02 4.54.01 6.711 1.38 7.221 1.84 1.671 1.429 2.528 4.856 1.9 9.892h-.02c-.6 4.882-4.17 5.19-4.83 5.4-.28.09-2.88.73-6.152.52 0 0-2.439 2.941-3.199 3.701-.12.12-.26.17-.35.15-.13-.03-.17-.19-.17-.42l.03-4.019c-4.771-1.32-4.491-6.302-4.441-8.902.06-2.6.55-4.733 2-6.182 1.957-1.77 5.475-2.01 6.991-2.02zm.36 2.6a.299.299 0 0 0-.3.299.3.3 0 0 0 .3.3 4.842 4.842 0 0 1 3.45 1.34c.91.95 1.36 2.219 1.371 3.879a.3.3 0 0 0 .599 0c.022-1.71-.51-3.16-1.54-4.27l-.001-.002c-1.04-1.11-2.49-1.74-3.879-1.886zm-3.535.998a.795.795 0 0 0-.617.15l-.013.01c-.41.3-.78.66-1.078 1.07-.25.34-.39.69-.43 1.03-.04.27-.02.54.06.81.27.83.81 1.8 1.66 2.78.47.55 1.02 1.04 1.62 1.46l.01.01.04.03.06.04c.62.42 1.31.78 2.04 1.04.85.32 1.7.52 2.46.52.07.01.13.01.2.01.27 0 .57-.07.84-.26l.001-.001c.41-.31.66-.78.74-1.27.04-.21.03-.43-.04-.62-.07-.18-.5-.42-.81-.6l-.18-.1c-.31-.18-.58-.32-.77-.41-.27-.13-.55-.05-.71.16l-.34.43c-.17.21-.49.18-.49.18l-.01.01c-2.36-.6-2.99-2.99-2.99-2.99s-.03-.32.18-.49l.43-.34c.2-.16.28-.44.16-.71-.09-.19-.23-.46-.41-.77l-.1-.18c-.18-.31-.42-.74-.6-.81a.83.83 0 0 0-.22-.05zm3.535 1.002a.3.3 0 0 0-.32.279.3.3 0 0 0 .28.32c.7.05 1.16.27 1.46.59.3.33.45.74.48 1.31a.3.3 0 0 0 .599-.03c-.03-.69-.24-1.27-.65-1.7-.42-.44-.99-.69-1.81-.749l-.039-.02z"/></svg>',

		'whatsapp' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>',

		'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4.2"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor" stroke="none"/></svg>',

		'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke-linecap="round" stroke-linejoin="round"/></svg>',

		'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z M22 6l-10 7L2 6" stroke-linecap="round" stroke-linejoin="round"/></svg>',

		'chat' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke-linecap="round" stroke-linejoin="round"/></svg>',

		'target' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="0.6" fill="currentColor"/></svg>',

		'pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M12 21s7-6.5 7-12a7 7 0 0 0-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>',

		'rocket' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M5 15c-1.5 1.5-2 5-2 5s3.5-.5 5-2c.8-.8.8-2 0-2.8-.8-.8-2-.8-3 0z"/><path d="M9 13l-2-2c1-4 4-7 9-8 0 5-3 8-8 9z"/><circle cx="14" cy="9" r="1.3"/></svg>',

		'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>',

		'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M12 3l7 3v5c0 5-3.5 8-7 10-3.5-2-7-5-7-10V6z"/><path d="M9 12l2 2 4-4"/></svg>',

		'play' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>',

		'quote' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 7H6a3 3 0 0 0-3 3v7h7v-7H6a1 1 0 0 1 1-1h3zm11 0h-4a3 3 0 0 0-3 3v7h7v-7h-4a1 1 0 0 1 1-1h3z"/></svg>',

		'expand' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>',

		'chevron-left' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>',

		'chevron-right' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>',

		'play-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M10 8.5l5 3.5-5 3.5z" fill="currentColor" stroke="none"/></svg>',

		'top' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/** Decorative laser-cut motif SVGs (hero-card fallback / portfolio placeholder). */
function l7_motif( $name ) {
	$p = 'fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"';
	$motifs = array(
		'tag'    => '<svg viewBox="0 0 100 100" ' . $p . '><path d="M14 50 L 50 14 L 86 14 L 86 50 L 50 86 Z"/><circle cx="70" cy="30" r="5"/></svg>',
		'logo'   => '<svg viewBox="0 0 100 100" ' . $p . '><circle cx="50" cy="50" r="36"/><circle cx="50" cy="50" r="22"/><line x1="50" y1="14" x2="50" y2="86"/><line x1="14" y1="50" x2="86" y2="50"/></svg>',
		'anchor' => '<svg viewBox="0 0 100 100" ' . $p . '><circle cx="50" cy="22" r="8"/><line x1="50" y1="30" x2="50" y2="78"/><line x1="38" y1="40" x2="62" y2="40"/><path d="M22 60 C 22 78, 50 86, 50 86 C 50 86, 78 78, 78 60"/></svg>',
	);
	return isset( $motifs[ $name ] ) ? $motifs[ $name ] : $motifs['logo'];
}
