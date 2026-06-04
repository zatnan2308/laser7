<?php
/**
 * ACF Pro field registration.
 *
 *  • Theme settings  → options page "laser7-settings" (header, contacts, footer)
 *  • Page settings   → fields shown on the static front page (all sections)
 *
 * Builders below keep the (very long) schema DRY. Every visible string has a
 * UA + EN pair; images/videos/prices/urls are language-neutral.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---- tiny field builders ------------------------------------------------ */
function l7f( $type, $name, $label, $default = '', $extra = array(), $kp = '' ) {
	$base = array(
		'key'   => 'field_l7_' . $kp . $name,
		'label' => $label,
		'name'  => $name,
		'type'  => $type,
	);
	if ( in_array( $type, array( 'text', 'textarea', 'number', 'url', 'select', 'true_false' ), true ) ) {
		$base['default_value'] = $default;
	}
	return array_merge( $base, $extra );
}
/** Bilingual pair (UA + EN). Returns a list of two fields. */
function l7f_bi( $base, $label, $du = '', $de = '', $type = 'text', $kp = '', $extra = array() ) {
	return array(
		l7f( $type, $base . '_ua', $label . ' · UA', $du, $extra, $kp ),
		l7f( $type, $base . '_en', $label . ' · EN', $de, $extra, $kp ),
	);
}
function l7f_tab( $label, $key ) {
	return array( 'key' => 'field_l7_tab_' . $key, 'label' => $label, 'name' => '', 'type' => 'tab', 'placement' => 'top' );
}
function l7f_img( $name, $label, $kp = '' ) {
	return l7f( 'image', $name, $label, '', array( 'return_format' => 'array', 'preview_size' => 'medium', 'library' => 'all' ), $kp );
}
function l7f_video( $name, $label, $kp = '' ) {
	return l7f( 'file', $name, $label, '', array( 'return_format' => 'url', 'library' => 'all', 'mime_types' => 'mp4,webm,mov,m4v', 'instructions' => 'Відео (mp4/webm) — опційно / optional' ), $kp );
}
/** Flatten a list of chunks (single fields or pairs) into a flat fields array. */
function l7_collect( $chunks ) {
	$out = array();
	foreach ( $chunks as $c ) {
		if ( isset( $c['key'] ) ) {
			$out[] = $c;
		} else {
			foreach ( $c as $f ) {
				$out[] = $f;
			}
		}
	}
	return $out;
}

add_action( 'acf/init', 'laser7_register_fields' );
function laser7_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$D = l7_defaults();

	/* =================================================================
	 * GROUP 1 — THEME SETTINGS (options page)
	 * ================================================================= */
	$opt = array();

	// -- Tab: Бренд / Шапка ------------------------------------------------
	$opt[] = l7f_tab( 'Бренд / Шапка', 'brand' );
	$opt[] = l7f( 'select', 'accent', 'Акцентний колір / Accent', 'red', array(
		'choices' => array( 'red' => 'Червоний (за замовч.)', 'amber' => 'Бурштин', 'blue' => 'Синій', 'green' => 'Зелений', 'graphite' => 'Графіт' ),
		'ui' => 1,
	) );
	$opt[] = l7f( 'true_false', 'show_topbar', 'Показувати верхню панель (адреса/графік/телефон)', 1, array( 'ui' => 1 ) );
	$opt = array_merge( $opt, l7f_bi( 'brand_name', 'Назва бренду', $D['brand']['name_ua'], $D['brand']['name_en'] ) );
	$opt[] = l7f( 'text', 'brand_mark', 'Цифра логотипу', $D['brand']['mark'] );
	$opt[] = l7f_img( 'brand_logo', 'Логотип (зображення)' );
	$opt[ count( $opt ) - 1 ]['instructions'] = 'Якщо завантажити — замінює текстовий логотип «ЛАЗЕР · 7» у шапці та підвалі. Рекомендовано PNG/SVG/WebP з прозорим фоном, висота ~80px.';
	$opt = array_merge( $opt, l7f_bi( 'topbar_address', 'Адреса (топбар)', $D['topbar']['address_ua'], $D['topbar']['address_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'topbar_hours', 'Графік (топбар)', $D['topbar']['hours_ua'], $D['topbar']['hours_en'] ) );
	$opt[] = l7f( 'text', 'topbar_phone', 'Телефон (топбар)', $D['topbar']['phone'] );
	$opt[] = l7f( 'repeater', 'nav_items', 'Пункти меню', '', array(
		'button_label' => 'Додати пункт', 'layout' => 'table',
		'sub_fields' => l7_collect( array(
			l7f( 'text', 'anchor', 'Якір (id секції)', '', array( 'instructions' => 'portfolio / services / materials / location / contact' ), 'nav_' ),
			l7f_bi( 'label', 'Підпис', '', '', 'text', 'nav_' ),
		) ),
	) );

	// -- Tab: Контакти / Месенджери ---------------------------------------
	$opt[] = l7f_tab( 'Контакти / Месенджери', 'contacts' );
	$opt[] = l7f( 'text', 'contact_phone', 'Телефон', $D['contact_phone'] );
	$opt[] = l7f( 'text', 'contact_email', 'E-mail', $D['contact_email'] );
	$opt[] = l7f( 'repeater', 'channels', 'Месенджери (Telegram / Viber / WhatsApp)', '', array(
		'button_label' => 'Додати канал', 'layout' => 'block',
		'instructions' => 'Використовуються в шапці, секції «Контакти», підвалі та плаваючій кнопці.',
		'sub_fields' => l7_collect( array(
			l7f( 'select', 'id', 'Тип', 'telegram', array( 'choices' => array( 'telegram' => 'Telegram', 'viber' => 'Viber', 'whatsapp' => 'WhatsApp' ), 'ui' => 1 ), 'ch_' ),
			l7f( 'text', 'label', 'Назва', '', array(), 'ch_' ),
			l7f( 'text', 'handle', 'Контакт (@нік / номер)', '', array(), 'ch_' ),
			l7f( 'text', 'url', 'Посилання', '', array( 'instructions' => 'https://t.me/… · viber://chat?number=… · https://wa.me/…' ), 'ch_' ),
			l7f_bi( 'note', 'Примітка', '', '', 'text', 'ch_' ),
		) ),
	) );

	// -- Tab: Підвал -------------------------------------------------------
	$opt[] = l7f_tab( 'Підвал', 'footer' );
	$opt = array_merge( $opt, l7f_bi( 'footer_tagline', 'Слоган', $D['footer']['tagline_ua'], $D['footer']['tagline_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'footer_copyright', 'Копірайт', $D['footer']['copyright_ua'], $D['footer']['copyright_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'footer_note', 'Підпис праворуч унизу', $D['footer']['note_ua'], $D['footer']['note_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'footer_col_a', 'Заголовок колонки A', $D['footer']['col_a_ua'], $D['footer']['col_a_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'footer_col_b', 'Заголовок колонки B', $D['footer']['col_b_ua'], $D['footer']['col_b_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'footer_col_c', 'Заголовок колонки «Контакти»', $D['footer']['col_c_ua'], $D['footer']['col_c_en'] ) );
	$opt[] = l7f( 'repeater', 'footer_links', 'Додаткові посилання (оферта, повернення…)', '', array(
		'button_label' => 'Додати посилання', 'layout' => 'table',
		'sub_fields' => l7_collect( array(
			l7f( 'text', 'ua', 'Підпис UA', '', array(), 'fl_' ),
			l7f( 'text', 'en', 'Підпис EN', '', array(), 'fl_' ),
			l7f( 'text', 'url', 'URL', '#contact', array(), 'fl_' ),
		) ),
	) );
	$opt[] = l7f( 'text', 'footer_credit_name', 'Кредит розробника — назва', $D['footer']['credit_name'] );
	$opt[] = l7f( 'url', 'footer_credit_url', 'Кредит розробника — посилання', $D['footer']['credit_url'] );

	// -- Tab: SEO ----------------------------------------------------------
	$seo = $D['seo'];
	$opt[] = l7f_tab( 'SEO', 'seo' );
	$opt = array_merge( $opt, l7f_bi( 'seo_title', 'Title сторінки (вкладка браузера / Google)', $seo['title_ua'], $seo['title_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'seo_description', 'Meta description (опис у пошуку)', $seo['desc_ua'], $seo['desc_en'], 'textarea' ) );
	$opt[] = l7f_img( 'seo_og_image', 'Зображення для соцмереж (OG / Twitter, бажано 1200×630)' );
	$opt[] = l7f( 'text', 'seo_geo_lat', 'Гео-широта (для schema.org)', $seo['geo_lat'] );
	$opt[] = l7f( 'text', 'seo_geo_lng', 'Гео-довгота (для schema.org)', $seo['geo_lng'] );

	// -- Tab: Cookie-банер -------------------------------------------------
	$ck = $D['cookie'];
	$opt[] = l7f_tab( 'Cookie-банер', 'cookie' );
	$opt = array_merge( $opt, l7f_bi( 'cookie_text', 'Текст банера', $ck['text_ua'], $ck['text_en'], 'textarea' ) );
	$opt = array_merge( $opt, l7f_bi( 'cookie_accept', 'Кнопка «Прийняти»', $ck['accept_ua'], $ck['accept_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'cookie_decline', 'Кнопка «Відхилити»', $ck['decline_ua'], $ck['decline_en'] ) );
	$opt = array_merge( $opt, l7f_bi( 'cookie_more', 'Посилання «Детальніше»', $ck['more_ua'], $ck['more_en'] ) );

	acf_add_local_field_group( array(
		'key'      => 'group_l7_options',
		'title'    => 'ЛАЗЕР · 7 — глобальні налаштування',
		'fields'   => $opt,
		'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'laser7-settings' ) ) ),
		'menu_order' => 0,
	) );

	/* =================================================================
	 * GROUP 2 — FRONT PAGE CONTENT (all sections)
	 * ================================================================= */
	$pg = array();

	// -- Hero --------------------------------------------------------------
	$h = $D['hero'];
	$pg[] = l7f_tab( 'Hero', 'hero' );
	$pg = array_merge( $pg, l7f_bi( 'hero_eyebrow', 'Надзаголовок', $h['eyebrow_ua'], $h['eyebrow_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'hero_title1', 'Заголовок · рядок 1', $h['title1_ua'], $h['title1_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'hero_title2', 'Заголовок · рядок 2 (червоний)', $h['title2_ua'], $h['title2_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'hero_lede', 'Опис', $h['lede_ua'], $h['lede_en'], 'textarea' ) );
	$pg = array_merge( $pg, l7f_bi( 'hero_cta1', 'Кнопка 1', $h['cta1_ua'], $h['cta1_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'hero_cta2', 'Кнопка 2', $h['cta2_ua'], $h['cta2_en'] ) );
	$pg[] = l7f_img( 'hero_figure', 'Велике фото (праворуч)' );
	$pg = array_merge( $pg, l7f_bi( 'hero_figure_tag', 'Підпис на фото', $h['figure_tag_ua'], $h['figure_tag_en'] ) );
	$pg[] = l7f( 'repeater', 'hero_trust', 'Лічильники довіри', '', array(
		'button_label' => 'Додати', 'layout' => 'table',
		'sub_fields' => l7_collect( array(
			l7f( 'text', 'n', 'Число', '', array(), 'herotrust_' ),
			l7f_bi( 'l', 'Підпис', '', '', 'text', 'herotrust_' ),
		) ),
	) );
	$pg[] = l7f( 'repeater', 'hero_cards', 'Картки послуг (3 шт.)', '', array(
		'button_label' => 'Додати картку', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'title', 'Заголовок', '', '', 'text', 'herocards_' ),
			l7f_bi( 'sub', 'Підзаголовок', '', '', 'text', 'herocards_' ),
			l7f_img( 'photo', 'Фото', 'herocards_' ),
			l7f( 'select', 'motif', 'Іконка-замінник (якщо без фото)', 'logo', array( 'choices' => array( 'tag' => 'Бирка', 'logo' => 'Лого', 'anchor' => 'Якір' ), 'ui' => 1 ), 'herocards_' ),
			l7f_bi( 'cta', 'Кнопка', '', '', 'text', 'herocards_' ),
		) ),
	) );

	// -- Advantages --------------------------------------------------------
	$ah = $D['advantages_head'];
	$pg[] = l7f_tab( 'Переваги', 'adv' );
	$pg = array_merge( $pg, l7f_bi( 'advantages_idx', 'Надзаголовок', $ah['idx_ua'], $ah['idx_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'advantages_title', 'Заголовок', $ah['title_ua'], $ah['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'advantages_lede', 'Опис', $ah['lede_ua'], $ah['lede_en'] ) );
	$pg[] = l7f( 'repeater', 'advantages', 'Переваги', '', array(
		'button_label' => 'Додати перевагу', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f( 'select', 'icon', 'Іконка', 'pin', array( 'choices' => array( 'pin' => 'Доставка', 'rocket' => 'Швидкість', 'clock' => 'Час', 'shield' => 'Якість' ), 'ui' => 1 ), 'adv_' ),
			l7f_bi( 'title', 'Заголовок', '', '', 'text', 'adv_' ),
			l7f_bi( 'body', 'Текст', '', '', 'textarea', 'adv_' ),
		) ),
	) );

	// -- About -------------------------------------------------------------
	$ab = $D['about'];
	$pg[] = l7f_tab( 'Про майстерню', 'about' );
	$pg = array_merge( $pg, l7f_bi( 'about_kicker', 'Надзаголовок', $ab['kicker_ua'], $ab['kicker_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'about_title', 'Заголовок', $ab['title_ua'], $ab['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'about_tagline', 'Слоган', $ab['tagline_ua'], $ab['tagline_en'] ) );
	$pg[] = l7f( 'text', 'about_years', 'Років досвіду (число)', $ab['years'] );
	$pg = array_merge( $pg, l7f_bi( 'about_years_label', 'Підпис до років', $ab['years_label_ua'], $ab['years_label_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'about_cta', 'Кнопка', $ab['cta_ua'], $ab['cta_en'] ) );
	$pg[] = l7f_img( 'about_photo_big', 'Фото велике (зверху)' );
	$pg[] = l7f_img( 'about_photo_two', 'Фото 2' );
	$pg[] = l7f_img( 'about_photo_three', 'Фото 3' );
	$pg[] = l7f( 'repeater', 'about_paras', 'Абзаци тексту', '', array(
		'button_label' => 'Додати абзац', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f( 'textarea', 'ua', 'UA', '', array(), 'aboutpara_' ),
			l7f( 'textarea', 'en', 'EN', '', array(), 'aboutpara_' ),
		) ),
	) );
	$pg[] = l7f( 'repeater', 'about_services', 'Список послуг', '', array(
		'button_label' => 'Додати послугу', 'layout' => 'table',
		'sub_fields' => l7_collect( array(
			l7f( 'text', 'ua', 'UA', '', array(), 'aboutsvc_' ),
			l7f( 'text', 'en', 'EN', '', array(), 'aboutsvc_' ),
		) ),
	) );

	// -- Portfolio ---------------------------------------------------------
	$ph = $D['portfolio_head'];
	$pg[] = l7f_tab( 'Портфоліо', 'portfolio' );
	$pg = array_merge( $pg, l7f_bi( 'portfolio_idx', 'Надзаголовок', $ph['idx_ua'], $ph['idx_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'portfolio_title', 'Заголовок', $ph['title_ua'], $ph['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'portfolio_lede', 'Опис', $ph['lede_ua'], $ph['lede_en'], 'textarea' ) );
	$pg[] = l7f( 'number', 'portfolio_page_size', 'Скільки робіт показувати спочатку', 9, array( 'min' => 1 ) );
	$pg[] = l7f( 'repeater', 'categories', 'Категорії (фільтр)', '', array(
		'button_label' => 'Додати категорію', 'layout' => 'table',
		'instructions' => 'Перша категорія зазвичай «all / Все».',
		'sub_fields' => l7_collect( array(
			l7f( 'text', 'id', 'ID (латиницею)', '', array( 'instructions' => 'all, souvenirs, decor, corporate, keychains, magnets, coasters, glass, scratchers' ), 'cat_' ),
			l7f_bi( 'label', 'Назва', '', '', 'text', 'cat_' ),
		) ),
	) );
	$pg[] = l7f( 'repeater', 'works', 'Роботи', '', array(
		'button_label' => 'Додати роботу', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_img( 'photo', 'Фото', 'work_' ),
			l7f_video( 'video', 'Відео (опційно)', 'work_' ),
			l7f( 'text', 'cat', 'Категорія (ID)', '', array( 'instructions' => 'ID однієї з категорій вище' ), 'work_' ),
			l7f_bi( 'title', 'Назва', '', '', 'text', 'work_' ),
			l7f_bi( 'material', 'Матеріал / опис', '', '', 'text', 'work_' ),
			l7f( 'select', 'tone', 'Тон плейсхолдера', 'warm', array( 'choices' => array( 'warm' => 'warm', 'deep' => 'deep', 'light' => 'light', 'dark' => 'dark', 'bright' => 'bright' ), 'ui' => 1 ), 'work_' ),
		) ),
	) );

	// -- Prices ------------------------------------------------------------
	$sh = $D['services_head'];
	$pg[] = l7f_tab( 'Прайс', 'prices' );
	$pg = array_merge( $pg, l7f_bi( 'services_idx', 'Надзаголовок', $sh['idx_ua'], $sh['idx_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'services_title', 'Заголовок', $sh['title_ua'], $sh['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'services_note', 'Опис під заголовком', $sh['note_ua'], $sh['note_en'], 'textarea' ) );
	$pg = array_merge( $pg, l7f_bi( 'services_foot', 'Примітка під таблицями', $sh['foot_ua'], $sh['foot_en'], 'textarea' ) );
	$pg[] = l7f( 'repeater', 'price_groups', 'Групи прайсу', '', array(
		'button_label' => 'Додати групу', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'name', 'Назва групи', '', '', 'text', 'pg_' ),
			l7f_bi( 'unit', 'Одиниця', '', '', 'text', 'pg_' ),
			l7f( 'repeater', 'rows', 'Рядки', '', array(
				'button_label' => 'Додати рядок', 'layout' => 'table',
				'sub_fields' => l7_collect( array(
					l7f( 'text', 'item_ua', 'Позиція UA', '', array(), 'pgrow_' ),
					l7f( 'text', 'item_en', 'Позиція EN', '', array(), 'pgrow_' ),
					l7f( 'text', 'price', 'Ціна', '', array(), 'pgrow_' ),
				) ),
			), 'pg_' ),
		) ),
	) );

	// -- Materials ---------------------------------------------------------
	$mh = $D['materials_head'];
	$pg[] = l7f_tab( 'Матеріали', 'materials' );
	$pg = array_merge( $pg, l7f_bi( 'materials_idx', 'Надзаголовок', $mh['idx_ua'], $mh['idx_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'materials_title', 'Заголовок', $mh['title_ua'], $mh['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'materials_lede', 'Опис', $mh['lede_ua'], $mh['lede_en'], 'textarea' ) );
	$pg[] = l7f( 'repeater', 'materials', 'Матеріали', '', array(
		'button_label' => 'Додати матеріал', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'name', 'Назва', '', '', 'text', 'mat_' ),
			l7f_bi( 'note', 'Опис', '', '', 'text', 'mat_' ),
			l7f( 'select', 'swatch', 'Текстура (фон)', 'wood', array( 'choices' => array(
				'wood' => 'wood', 'mdf' => 'mdf', 'oak' => 'oak', 'acrylic' => 'acrylic', 'plastic' => 'plastic', 'fabric' => 'fabric', 'leather' => 'leather', 'cardboard' => 'cardboard', 'paper' => 'paper', 'glass' => 'glass', 'mirror' => 'mirror', 'stone' => 'stone', 'metal' => 'metal',
			), 'ui' => 1 ), 'mat_' ),
			l7f_img( 'photo', 'Фото (замінює текстуру)', 'mat_' ),
			l7f( 'true_false', 'cut', 'Можлива різка', 1, array( 'ui' => 1, 'instructions' => 'Вимкніть для матеріалів «тільки гравіювання»' ), 'mat_' ),
		) ),
	) );

	// -- Testimonial -------------------------------------------------------
	$t = $D['testimonial'];
	$pg[] = l7f_tab( 'Відгук', 'testi' );
	$pg = array_merge( $pg, l7f_bi( 'testimonial_quote', 'Цитата', $t['quote_ua'], $t['quote_en'], 'textarea' ) );
	$pg = array_merge( $pg, l7f_bi( 'testimonial_author', 'Автор', $t['author'], $t['author_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'testimonial_role', 'Роль / посада', $t['role_ua'], $t['role_en'] ) );
	$pg[] = l7f_img( 'testimonial_photo', 'Фото / прев’ю' );
	$pg[] = l7f_video( 'testimonial_video', 'Відео відгуку (опційно)' );

	// -- FAQ ---------------------------------------------------------------
	$fh = $D['faq_head'];
	$pg[] = l7f_tab( 'FAQ', 'faq' );
	$pg = array_merge( $pg, l7f_bi( 'faq_title', 'Заголовок', $fh['title_ua'], $fh['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'faq_sub', 'Підзаголовок', $fh['sub_ua'], $fh['sub_en'] ) );
	$pg[] = l7f( 'repeater', 'faq', 'Запитання', '', array(
		'button_label' => 'Додати запитання', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'q', 'Запитання', '', '', 'text', 'faq_' ),
			l7f_bi( 'a', 'Відповідь', '', '', 'textarea', 'faq_' ),
		) ),
	) );

	// -- Location ----------------------------------------------------------
	$lh = $D['location_head'];
	$pg[] = l7f_tab( 'Локація', 'location' );
	$pg = array_merge( $pg, l7f_bi( 'location_idx', 'Надзаголовок', $lh['idx_ua'], $lh['idx_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'location_title', 'Заголовок', $lh['title_ua'], $lh['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'location_lede', 'Опис', $lh['lede_ua'], $lh['lede_en'], 'textarea' ) );
	$pg[] = l7f( 'text', 'location_city', 'Місто на карті', $lh['city'] );
	$pg[] = l7f( 'text', 'location_coords', 'Координати (підпис)', $lh['coords'] );
	$pg = array_merge( $pg, l7f_bi( 'location_bazaar', 'Назва ринку (на карті)', $lh['bazaar_ua'], $lh['bazaar_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'location_pin', 'Підпис мітки', $lh['pin_ua'], $lh['pin_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'location_here', 'Підпис «Ми тут»', $lh['here_ua'], $lh['here_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'location_maps', 'Текст кнопки Google Maps', $lh['maps_ua'], $lh['maps_en'] ) );
	$pg[] = l7f( 'url', 'location_maps_url', 'Посилання Google Maps', $lh['maps_url'] );
	$pg = array_merge( $pg, l7f_bi( 'location_stage_eyebrow', 'Надзаголовок «що на вітрині»', $lh['stage_eyebrow_ua'], $lh['stage_eyebrow_en'] ) );
	$pg[] = l7f( 'repeater', 'location_rows', 'Реквізити (таблиця)', '', array(
		'button_label' => 'Додати рядок', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'k', 'Назва', '', '', 'text', 'locrow_' ),
			l7f_bi( 'v', 'Значення', '', '', 'text', 'locrow_' ),
		) ),
	) );
	$pg[] = l7f( 'repeater', 'location_stage', 'Що на вітрині (3 картки)', '', array(
		'button_label' => 'Додати', 'layout' => 'block',
		'sub_fields' => l7_collect( array(
			l7f_bi( 'label', 'Заголовок', '', '', 'text', 'locstage_' ),
			l7f_bi( 'body', 'Текст', '', '', 'text', 'locstage_' ),
		) ),
	) );

	// -- Contact -----------------------------------------------------------
	$c = $D['contact'];
	$pg[] = l7f_tab( 'Контакти (секція)', 'contact' );
	$pg = array_merge( $pg, l7f_bi( 'contact_eyebrow', 'Надзаголовок', $c['eyebrow_ua'], $c['eyebrow_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_title', 'Заголовок', $c['title_ua'], $c['title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_title_accent', 'Заголовок · акцент (червоний)', $c['title_accent_ua'], $c['title_accent_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_lede', 'Опис', $c['lede_ua'], $c['lede_en'], 'textarea' ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_form_title', 'Форма · заголовок', $c['form_title_ua'], $c['form_title_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_form_name', 'Форма · плейсхолдер «Імʼя»', $c['form_name_ua'], $c['form_name_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_form_contact', 'Форма · плейсхолдер «Контакт»', $c['form_contact_ua'], $c['form_contact_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_form_brief', 'Форма · плейсхолдер «Бриф»', $c['form_brief_ua'], $c['form_brief_en'] ) );
	$pg = array_merge( $pg, l7f_bi( 'contact_form_btn', 'Форма · кнопка', $c['form_btn_ua'], $c['form_btn_en'] ) );
	$pg[] = l7f( 'text', 'contact_form_telegram', 'Telegram-нік для форми (без @)', $c['form_telegram'] );

	acf_add_local_field_group( array(
		'key'      => 'group_l7_front',
		'title'    => 'ЛАЗЕР · 7 — контент сторінки',
		'fields'   => $pg,
		'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
	) );

	/* =================================================================
	 * GROUP 3 — LEGAL PAGES (privacy / cookies / terms)
	 * ================================================================= */
	acf_add_local_field_group( array(
		'key'      => 'group_l7_legal',
		'title'    => 'ЛАЗЕР · 7 — юридична сторінка',
		'fields'   => l7_collect( array(
			l7f_bi( 'legal_heading', 'Заголовок', '', '' ),
			l7f_bi( 'legal_content', 'Текст сторінки', '', '', 'wysiwyg' ),
		) ),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-legal.php' ) ) ),
	) );
}
