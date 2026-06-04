<?php
/**
 * Default content — mirrored from the design's js/data.js (UA + EN).
 * Used as ACF default values / fallbacks so the landing renders 1:1
 * before anything is edited. Images map to the compressed .webp assets.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function l7_defaults() {
	static $d = null;
	if ( null !== $d ) {
		return $d;
	}

	$d = array(

		/* ---- brand / header / global ------------------------------------ */
		'brand' => array(
			'name_ua' => 'ЛАЗЕР', 'name_en' => 'LASER', 'mark' => '7',
		),
		'topbar' => array(
			'address_ua' => 'Одеса · ринок «7 кілометр», ряд 308',
			'address_en' => 'Odesa · 7-km market, row 308',
			'hours_ua'   => 'Пн – Сб · 08:00 – 17:00',
			'hours_en'   => 'Mon – Sat · 08:00 – 17:00',
			'phone'      => '+380 67 484 71 42',
		),
		'nav' => array(
			array( 'anchor' => 'portfolio', 'label_ua' => 'Портфоліо',     'label_en' => 'Portfolio' ),
			array( 'anchor' => 'services',  'label_ua' => 'Послуги',       'label_en' => 'Pricing' ),
			array( 'anchor' => 'materials', 'label_ua' => 'Матеріали',     'label_en' => 'Materials' ),
			array( 'anchor' => 'location',  'label_ua' => 'Точка на 7 км', 'label_en' => '7-km point' ),
			array( 'anchor' => 'contact',   'label_ua' => 'Контакти',      'label_en' => 'Contact' ),
		),

		/* ---- contacts / channels (global, reused in nav/contact/footer) -- */
		'contact_phone' => '+380 67 484 71 42',
		'contact_email' => 'hello@laser7.ua',
		'channels' => array(
			array( 'id' => 'telegram', 'label' => 'Telegram', 'handle' => '@laser7_odesa', 'url' => 'https://t.me/laser7_odesa',          'note_ua' => 'відповідаємо за 15 хв', 'note_en' => 'we reply within 15 min' ),
			array( 'id' => 'viber',    'label' => 'Viber',    'handle' => '+380 67 484 71 42', 'url' => 'viber://chat?number=%2B380674847142', 'note_ua' => 'файли до 200 МБ',     'note_en' => 'files up to 200 MB' ),
			array( 'id' => 'whatsapp', 'label' => 'WhatsApp', 'handle' => '+380 67 484 71 42', 'url' => 'https://wa.me/380674847142',         'note_ua' => 'для іноземних замовлень', 'note_en' => 'for international orders' ),
		),

		/* ---- hero -------------------------------------------------------- */
		'hero' => array(
			'eyebrow_ua' => 'Майстерня лазерної різки та гравіювання · з 2017',
			'eyebrow_en' => 'Laser cutting & engraving workshop · since 2017',
			'title1_ua'  => 'Ріжемо світлом.',
			'title1_en'  => 'We cut with light.',
			'title2_ua'  => 'Гравіюємо з характером.',
			'title2_en'  => 'We engrave with intent.',
			'lede_ua'    => 'Дрібна серія, опт, корпоратив і одна штука «для душі». Фанера, акрил, тканина, картон, шкіра, скло. Точка на 7 кілометрі, Одеса.',
			'lede_en'    => 'Small batches, wholesale, corporate, and one-off pieces. Plywood, acrylic, fabric, cardboard, leather, glass. Find us at the 7-km market, Odesa.',
			'cta1_ua'    => 'Замовити прорахунок', 'cta1_en' => 'Request a quote',
			'cta2_ua'    => 'Подивитись роботи',   'cta2_en' => 'See the work',
			'figure'     => 'board-odesa.webp',
			'figure_tag_ua' => '7 км · Одеса', 'figure_tag_en' => '7 km · Odesa',
		),
		'hero_trust' => array(
			array( 'n' => '9+',     'l_ua' => 'років досвіду',   'l_en' => 'years of work' ),
			array( 'n' => '5000+',  'l_ua' => 'виробів зроблено', 'l_en' => 'items made' ),
			array( 'n' => '48 год', 'l_ua' => 'середній термін',  'l_en' => 'avg. turnaround' ),
		),
		'hero_cards' => array(
			array( 'title_ua' => 'Лазерна різка', 'title_en' => 'Laser cutting', 'sub_ua' => 'Фанера, акрил, тканина, картон', 'sub_en' => 'Plywood, acrylic, fabric, cardboard', 'photo' => 'beef-burger-signs.webp', 'motif' => 'tag',    'cta_ua' => 'Детальніше', 'cta_en' => 'Learn more' ),
			array( 'title_ua' => 'Гравіювання',  'title_en' => 'Engraving',     'sub_ua' => 'Дерево, скло, шкіра, метал',       'sub_en' => 'Wood, glass, leather, metal',         'photo' => 'board-odesa.webp',       'motif' => 'logo',   'cta_ua' => 'Детальніше', 'cta_en' => 'Learn more' ),
			array( 'title_ua' => 'Сувенірна продукція', 'title_en' => 'Souvenir products', 'sub_ua' => 'Магніти, брелоки, декор, шкіра', 'sub_en' => 'Magnets, keychains, decor, leather', 'photo' => 'passport-closed.webp', 'motif' => 'anchor', 'cta_ua' => 'Детальніше', 'cta_en' => 'Learn more' ),
		),

		/* ---- advantages -------------------------------------------------- */
		'advantages_head' => array(
			'idx_ua' => 'Переваги', 'idx_en' => 'Advantages',
			'title_ua' => 'Чому обирають нас', 'title_en' => 'Why clients choose us',
			'lede_ua' => 'Ми кращі у своїй справі — і ось чому', 'lede_en' => "We're the best at what we do — here's why",
		),
		'advantages' => array(
			array( 'icon' => 'pin',    'title_ua' => 'Доставляємо', 'title_en' => 'We deliver', 'body_ua' => 'У будь-яку точку України — Нова Пошта, Justin, Делівері.', 'body_en' => 'Anywhere in Ukraine — Nova Poshta, Justin, Delivery.' ),
			array( 'icon' => 'rocket', 'title_ua' => 'Швидко',      'title_en' => 'Fast',       'body_ua' => 'Беремо замовлення в роботу й виконуємо в найкоротші терміни.', 'body_en' => 'We take the order in and complete it in the shortest time.' ),
			array( 'icon' => 'clock',  'title_ua' => 'Вчасно',      'title_en' => 'On time',    'body_ua' => 'Завжди здаємо роботу вчасно й не затримуємо замовлення.', 'body_en' => 'We always finish on schedule and never delay an order.' ),
			array( 'icon' => 'shield', 'title_ua' => 'Якісно',      'title_en' => 'Quality',    'body_ua' => 'Суворо контролюємо якість на кожному етапі виконання.', 'body_en' => 'Strict quality control at every stage of the work.' ),
		),

		/* ---- about ------------------------------------------------------- */
		'about' => array(
			'kicker_ua' => 'Про майстерню', 'kicker_en' => 'About the workshop',
			'title_ua'  => 'ЛАЗЕР · 7', 'title_en' => 'LASER · 7',
			'tagline_ua' => 'Ми за високу якість послуг, швидкість і точність.',
			'tagline_en' => 'We stand for quality, speed and precision.',
			'years' => '9', 'years_label_ua' => 'років досвіду', 'years_label_en' => 'years of experience',
			'cta_ua' => 'Обговорити замовлення', 'cta_en' => 'Discuss your order',
			'photo_big'   => 'ukraine-maps-3.webp',
			'photo_two'   => 'name-boxes.webp',
			'photo_three' => 'rulers-names.webp',
		),
		'about_paras' => array(
			array( 'ua' => 'З 2017 року майстерня ЛАЗЕР·7 надає послуги з обробки різних матеріалів на лазерному обладнанні з ЧПУ. Працюємо на 7 кілометрі в Одесі — з власним виробництвом і торговою точкою в одному залі.', 'en' => 'Since 2017, the LASER·7 workshop has been processing a range of materials on CNC laser equipment. We work at the 7-km market in Odesa — with our own production and a storefront in one room.' ),
			array( 'ua' => 'Технологи майстерні розроблять власний стандарт якості, ви не доплачуєте. Ви також можете прийти з готовим макетом — перевіримо безкоштовно й одразу порахуємо вартість.', 'en' => "Our technologists set the quality standard so you don't overpay. You can also come with a finished file — we'll check it for free and quote on the spot." ),
			array( 'ua' => 'Сучасне обладнання, професіонали, досвід і злагоджена робота дозволяють доставляти результат точно та в строк.', 'en' => 'Modern machines, professionals, experience and coordinated work let us deliver the result precisely and on time.' ),
		),
		'about_services' => array(
			array( 'ua' => 'Різання й гравіювання на лазері', 'en' => 'Laser cutting & engraving' ),
			array( 'ua' => 'Контурна порізка', 'en' => 'Contour cutting' ),
			array( 'ua' => 'Серійне виробництво', 'en' => 'Batch production' ),
			array( 'ua' => 'Дизайн макету з нуля', 'en' => 'Design from scratch' ),
			array( 'ua' => 'Корпоративний мерч', 'en' => 'Corporate merch' ),
		),

		/* ---- portfolio --------------------------------------------------- */
		'portfolio_head' => array(
			'idx_ua' => '01 · Портфоліо', 'idx_en' => '01 · Portfolio',
			'title_ua' => 'Що ми зробили та що можемо зробити вам', 'title_en' => 'What we made — and what we can make for you',
			'lede_ua' => 'Відсортуйте за категорією. Ось частина наших робіт — від сувенірів до корпоративних тиражів.',
			'lede_en' => 'Filter by category. Here is a slice of our work — from souvenirs to corporate batches.',
		),
		'categories' => array(
			array( 'id' => 'all',        'label_ua' => 'Все',                 'label_en' => 'All' ),
			array( 'id' => 'souvenirs',  'label_ua' => 'Сувеніри',            'label_en' => 'Souvenirs' ),
			array( 'id' => 'decor',      'label_ua' => 'Декор',               'label_en' => 'Decor' ),
			array( 'id' => 'corporate',  'label_ua' => 'Корпоратив',          'label_en' => 'Corporate' ),
			array( 'id' => 'keychains',  'label_ua' => 'Брелоки та ключниці', 'label_en' => 'Keychains & holders' ),
			array( 'id' => 'magnets',    'label_ua' => 'Магніти',             'label_en' => 'Magnets' ),
			array( 'id' => 'coasters',   'label_ua' => 'Підставки',           'label_en' => 'Coasters' ),
			array( 'id' => 'glass',      'label_ua' => 'Бокали',              'label_en' => 'Glassware' ),
			array( 'id' => 'scratchers', 'label_ua' => 'Кігтеточки',          'label_en' => 'Scratchers' ),
		),
		'works' => array(
			array( 'cat' => 'corporate', 'photo' => 'camping-box.webp',     'title_ua' => 'Бокс «Protych Camping»',  'title_en' => '“Protych Camping” box', 'material_ua' => 'Фанера + гравіювання логотипу, магнітна кришка', 'material_en' => 'Plywood + logo engraving, magnetic lid', 'tone' => 'light' ),
			array( 'cat' => 'keychains', 'photo' => 'keychain-acacia.webp', 'title_ua' => 'Брелок «Біла Акація»',    'title_en' => '“Bila Akatsia” keychain', 'material_ua' => 'Фанера 4 мм, гравіювання + фурнітура', 'material_en' => 'Plywood 4 mm, engraving + hardware', 'tone' => 'light' ),
			array( 'cat' => 'decor',     'photo' => 'violin-holder.webp',   'title_ua' => 'Підставка для вина «Скрипка»', 'title_en' => '“Violin” wine holder', 'material_ua' => 'Фанера 6 мм, морилка + лак', 'material_en' => 'Plywood 6 mm, stain + varnish', 'tone' => 'deep' ),
			array( 'cat' => 'souvenirs', 'photo' => 'leather-wallet.jpg',   'title_ua' => 'Картхолдер зі шкіри',     'title_en' => 'Leather card holder', 'material_ua' => 'Натуральна шкіра, ручне зшивання', 'material_en' => 'Full-grain leather, hand-stitched', 'tone' => 'warm' ),
			array( 'cat' => 'souvenirs', 'photo' => 'passport-open.webp',   'title_ua' => 'Обкладинка на паспорт «Україна»', 'title_en' => '“Ukraine” passport cover', 'material_ua' => 'Шкіра + лазерне гравіювання герба', 'material_en' => 'Leather + laser-engraved emblem', 'tone' => 'warm' ),
			array( 'cat' => 'keychains', 'photo' => 'keyholder-house.webp', 'title_ua' => 'Ключниця «Все буде добре!»', 'title_en' => '“Vse bude dobre!” key holder', 'material_ua' => 'Фанера, гравіювання + контурна різка', 'material_en' => 'Plywood, engraving + contour cut', 'tone' => 'light' ),
			array( 'cat' => 'decor',     'photo' => 'ukraine-map-color.webp', 'title_ua' => 'Мапа України з гімном', 'title_en' => 'Ukraine map with anthem', 'material_ua' => 'Фанера, кольорове тонування по областях', 'material_en' => 'Plywood, region-by-region tinting', 'tone' => 'warm' ),
			array( 'cat' => 'souvenirs', 'photo' => 'rulers-names.webp',    'title_ua' => 'Іменні лінійки',          'title_en' => 'Personalized rulers', 'material_ua' => 'Фанера 4 мм, різка + гравіювання імен', 'material_en' => 'Plywood 4 mm, cut + name engraving', 'tone' => 'light' ),
			array( 'cat' => 'decor',     'photo' => 'corner-shelf.webp',    'title_ua' => 'Кутова поличка-божниця', 'title_en' => 'Corner icon shelf', 'material_ua' => 'Фанера, ажурна різка + морилка', 'material_en' => 'Plywood, fretwork cut + stain', 'tone' => 'deep' ),
			array( 'cat' => 'souvenirs', 'photo' => 'board-odesa.webp',     'title_ua' => 'Дошка «Odesa» з вітрильником', 'title_en' => '“Odesa” board with tall ship', 'material_ua' => 'Бук, гравіювання', 'material_en' => 'Beech, engraving', 'tone' => 'warm' ),
			array( 'cat' => 'decor',     'photo' => 'ukraine-maps-3.webp',  'title_ua' => 'Мапи України, серія',     'title_en' => 'Ukraine maps, series', 'material_ua' => 'Фанера, різні розміри під замовлення', 'material_en' => 'Plywood, custom sizes', 'tone' => 'light' ),
			array( 'cat' => 'decor',     'photo' => 'xmas-houses.webp',     'title_ua' => 'Новорічні будиночки',     'title_en' => 'Christmas houses', 'material_ua' => 'Фанера, фарбування + гравіювання', 'material_en' => 'Plywood, painting + engraving', 'tone' => 'light' ),
			array( 'cat' => 'keychains', 'photo' => 'keyholder-car.webp',   'title_ua' => 'Ключниця «Ретроавто»',    'title_en' => '“Retro car” key board', 'material_ua' => 'Фанера, гравіювання + різьблені гачки', 'material_en' => 'Plywood, engraving + cut hooks', 'tone' => 'light' ),
			array( 'cat' => 'corporate', 'photo' => 'calendar-director.webp', 'title_ua' => 'Органайзер-календар, подарунок директорці', 'title_en' => 'Organizer-calendar, gift to director', 'material_ua' => 'Фарбована фанера + гравіювання тексту', 'material_en' => 'Painted plywood + text engraving', 'tone' => 'light' ),
			array( 'cat' => 'corporate', 'photo' => 'star-award.webp',      'title_ua' => 'Нагорода «Найкраща перша вчителька»', 'title_en' => '“Best first teacher” award', 'material_ua' => 'Дзеркальний акрил + фанера, гравіювання', 'material_en' => 'Mirror acrylic + plywood, engraving', 'tone' => 'bright' ),
			array( 'cat' => 'corporate', 'photo' => 'calendar-deputy.webp', 'title_ua' => 'Органайзер-календар з гравіюванням', 'title_en' => 'Organizer-calendar, engraved', 'material_ua' => 'Фарбована фанера, гравіювання', 'material_en' => 'Painted plywood, engraving', 'tone' => 'light' ),
			array( 'cat' => 'corporate', 'photo' => 'beef-burger-signs.webp', 'title_ua' => 'Вивіски «Beef Burger Bar»', 'title_en' => '“Beef Burger Bar” signs', 'material_ua' => 'Фанера, двошарова різка + гравіювання', 'material_en' => 'Plywood, two-layer cut + engraving', 'tone' => 'light' ),
			array( 'cat' => 'souvenirs', 'photo' => 'name-boxes.webp',      'title_ua' => 'Іменні скриньки',         'title_en' => 'Personalized name boxes', 'material_ua' => 'Фанера, різка + гравіювання, тираж', 'material_en' => 'Plywood, cut + engraving, batch', 'tone' => 'light' ),
			array( 'cat' => 'decor',     'photo' => 'cat-keyholder.webp',   'title_ua' => 'Ключниця «Закохані коти»', 'title_en' => '“Cats in love” key holder', 'material_ua' => 'Фанера, ажурна різка + морилка', 'material_en' => 'Plywood, fretwork cut + stain', 'tone' => 'deep' ),
			array( 'cat' => 'souvenirs', 'photo' => 'passport-closed.webp', 'title_ua' => 'Обкладинка «Україна · паспорт»', 'title_en' => '“Ukraine · passport” cover', 'material_ua' => 'Шкіра, гравіювання + ручне зшивання', 'material_en' => 'Leather, engraving + hand-stitched', 'tone' => 'warm' ),
		),

		/* ---- cta banner -------------------------------------------------- */
		'cta' => array(
			'title_ua' => 'Реалізуємо завдання будь-якої складності', 'title_en' => 'We handle jobs of any complexity',
			'sub_ua' => 'Залиште заявку на безкоштовний прорахунок', 'sub_en' => 'Leave a request for a free quote',
			'btn_ua' => 'Залишити заявку', 'btn_en' => 'Leave a request',
		),

		/* ---- services / prices ------------------------------------------ */
		'services_head' => array(
			'idx_ua' => 'Прайс', 'idx_en' => 'Pricing',
			'title_ua' => 'Прайс на основні послуги', 'title_en' => 'Base price list',
			'note_ua' => 'Ціни орієнтовні. Точну вартість прорахуємо за вашим макетом — за 15 хвилин у відповідь у Telegram або Viber.',
			'note_en' => "Numbers are indicative. Send your file in Telegram or Viber and we'll quote the exact figure within 15 minutes.",
			'foot_ua' => 'Опт від 500 шт — знижка до 35 %. Постійним клієнтам — окремий тариф. Усі ціни без ПДВ; для корпоративних замовлень за заявою — рахунок з ПДВ.',
			'foot_en' => 'Wholesale from 500 pcs — up to 35 % off. Long-term clients get a custom rate. Prices exclude VAT; corporate orders may be invoiced with VAT on request.',
		),
		'price_groups' => array(
			array(
				'name_ua' => 'Лазерна різка', 'name_en' => 'Laser cutting', 'unit_ua' => 'грн / м різу', 'unit_en' => 'UAH / m of cut',
				'rows' => array(
					array( 'item_ua' => 'Фанера 3 мм', 'item_en' => 'Plywood 3 mm', 'price' => '18' ),
					array( 'item_ua' => 'Фанера 4 мм', 'item_en' => 'Plywood 4 mm', 'price' => '22' ),
					array( 'item_ua' => 'Фанера 6 мм', 'item_en' => 'Plywood 6 mm', 'price' => '32' ),
					array( 'item_ua' => 'Фанера 10 мм', 'item_en' => 'Plywood 10 mm', 'price' => '60' ),
					array( 'item_ua' => 'МДФ 3 мм', 'item_en' => 'MDF 3 mm', 'price' => '20' ),
					array( 'item_ua' => 'Акрил 3 мм', 'item_en' => 'Acrylic 3 mm', 'price' => '28' ),
					array( 'item_ua' => 'Акрил 5 мм', 'item_en' => 'Acrylic 5 mm', 'price' => '42' ),
					array( 'item_ua' => 'Картон / папір', 'item_en' => 'Cardboard / paper', 'price' => '8' ),
					array( 'item_ua' => 'Тканина, шкіра', 'item_en' => 'Fabric, leather', 'price' => '14' ),
				),
			),
			array(
				'name_ua' => 'Гравіювання', 'name_en' => 'Engraving', 'unit_ua' => 'грн / дм² поверхні', 'unit_en' => 'UAH / dm² of surface',
				'rows' => array(
					array( 'item_ua' => 'Деревина, фанера', 'item_en' => 'Wood, plywood', 'price' => '35' ),
					array( 'item_ua' => 'Акрил (матове)', 'item_en' => 'Acrylic (matte)', 'price' => '45' ),
					array( 'item_ua' => 'Скло, дзеркало', 'item_en' => 'Glass, mirror', 'price' => '70' ),
					array( 'item_ua' => 'Шкіра', 'item_en' => 'Leather', 'price' => '55' ),
					array( 'item_ua' => 'Камінь', 'item_en' => 'Stone', 'price' => '90' ),
					array( 'item_ua' => 'Метал (CO₂ + спрей)', 'item_en' => 'Metal (CO₂ + spray)', 'price' => '120' ),
				),
			),
			array(
				'name_ua' => 'Підготовка макету', 'name_en' => 'File prep', 'unit_ua' => 'грн', 'unit_en' => 'UAH',
				'rows' => array(
					array( 'item_ua' => 'Перевірка готового файлу', 'item_en' => 'Reviewing a ready file', 'price' => '0' ),
					array( 'item_ua' => 'Векторизація лого', 'item_en' => 'Logo vectorization', 'price' => '150 – 400' ),
					array( 'item_ua' => 'Розробка дизайну з нуля', 'item_en' => 'Design from scratch', 'price' => 'від 600' ),
				),
			),
		),

		/* ---- materials --------------------------------------------------- */
		'materials_head' => array(
			'idx_ua' => 'Матеріали', 'idx_en' => 'Materials',
			'title_ua' => 'З чим ми працюємо', 'title_en' => 'Materials we cut',
			'lede_ua' => '13 робочих матеріалів. Якщо вашого немає в списку — напишіть, протестуємо безкоштовно.',
			'lede_en' => "13 materials in production. If yours isn't on the list — write us, we'll test it for free.",
		),
		'materials' => array(
			array( 'name_ua' => 'Фанера', 'name_en' => 'Plywood', 'note_ua' => 'берёза, вільха · 3 / 4 / 6 / 8 / 10 мм', 'note_en' => 'birch, alder · 3 / 4 / 6 / 8 / 10 mm', 'swatch' => 'wood', 'photo' => 'mat-plywood.webp', 'cut' => true ),
			array( 'name_ua' => 'МДФ', 'name_en' => 'MDF', 'note_ua' => 'сирий і шпонований · до 8 мм', 'note_en' => 'raw and veneered · up to 8 mm', 'swatch' => 'mdf', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Дерево масив', 'name_en' => 'Solid wood', 'note_ua' => 'дуб, ясен, горіх · до 15 мм', 'note_en' => 'oak, ash, walnut · up to 15 mm', 'swatch' => 'oak', 'photo' => 'mat-solidwood.webp', 'cut' => true ),
			array( 'name_ua' => 'Акрил', 'name_en' => 'Acrylic', 'note_ua' => 'прозорий, кольоровий, дзеркальний · до 8 мм', 'note_en' => 'clear, colored, mirrored · up to 8 mm', 'swatch' => 'acrylic', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Пластик', 'name_en' => 'Plastic', 'note_ua' => 'двошаровий гравіювальний, ПВХ', 'note_en' => 'two-layer engraving stock, PVC', 'swatch' => 'plastic', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Тканина', 'name_en' => 'Fabric', 'note_ua' => 'льон, бавовна, фетр, повсть', 'note_en' => 'linen, cotton, felt, wool felt', 'swatch' => 'fabric', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Шкіра', 'name_en' => 'Leather', 'note_ua' => 'натуральна, нубук · до 4 мм', 'note_en' => 'full-grain, nubuck · up to 4 mm', 'swatch' => 'leather', 'photo' => 'mat-leather.webp', 'cut' => true ),
			array( 'name_ua' => 'Картон', 'name_en' => 'Cardboard', 'note_ua' => 'крафт, дизайнерський, мікрогофра', 'note_en' => 'kraft, designer, micro-flute', 'swatch' => 'cardboard', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Папір', 'name_en' => 'Paper', 'note_ua' => 'щільний дизайнерський, калька', 'note_en' => 'heavy designer stock, tracing', 'swatch' => 'paper', 'photo' => '', 'cut' => true ),
			array( 'name_ua' => 'Скло', 'name_en' => 'Glass', 'note_ua' => 'пляшки, бокали, плоскі панелі · гравіювання', 'note_en' => 'bottles, glassware, panels · engraving', 'swatch' => 'glass', 'photo' => '', 'cut' => false ),
			array( 'name_ua' => 'Дзеркало', 'name_en' => 'Mirror', 'note_ua' => 'звичайне, тоноване · гравіювання', 'note_en' => 'clear, tinted · engraving', 'swatch' => 'mirror', 'photo' => '', 'cut' => false ),
			array( 'name_ua' => 'Камінь', 'name_en' => 'Stone', 'note_ua' => 'сланець, мармур · гравіювання', 'note_en' => 'slate, marble · engraving', 'swatch' => 'stone', 'photo' => '', 'cut' => false ),
			array( 'name_ua' => 'Метал', 'name_en' => 'Metal', 'note_ua' => 'з захисним спреєм · тільки гравіювання', 'note_en' => 'with thermal spray · engraving only', 'swatch' => 'metal', 'photo' => '', 'cut' => false ),
		),

		/* ---- testimonial ------------------------------------------------- */
		'testimonial' => array(
			'quote_ua' => 'Працювали з ЛАЗЕР·7 кілька разів — якість бездоганна, різка й гравіювання на висоті. Прорахунок швидкий, відправили в день звернення. Однозначно рекомендую.',
			'quote_en' => 'We worked with LASER·7 several times — flawless quality, cutting and engraving on point. Quick quote, shipped the same day. Highly recommended.',
			'author' => 'Богдан В.', 'author_en' => 'Bohdan V.',
			'role_ua' => 'власник магазину подарунків', 'role_en' => 'gift-shop owner',
			'photo' => 'corner-shelf.webp', 'video' => '',
		),

		/* ---- faq --------------------------------------------------------- */
		'faq_head' => array(
			'title_ua' => 'Часті запитання', 'title_en' => 'Frequently asked questions',
			'sub_ua' => 'Відповідаємо на найпопулярніші запитання наших клієнтів', 'sub_en' => 'Answers to the questions our clients ask most',
		),
		'faq' => array(
			array( 'q_ua' => 'За яким графіком працюєте?', 'q_en' => 'What are your hours?', 'a_ua' => 'Пн – Сб з 08:00 до 17:00. Неділя — за домовленістю. Месенджери відповідають і поза графіком.', 'a_en' => 'Mon – Sat, 08:00 – 17:00. Sunday on request. Messengers reply outside hours too.' ),
			array( 'q_ua' => 'Як розмістити замовлення?', 'q_en' => 'How do I place an order?', 'a_ua' => 'Напишіть у Telegram, Viber або WhatsApp, надішліть фото/ескіз/файл — у відповідь отримаєте прорахунок і термін.', 'a_en' => "Message us on Telegram, Viber or WhatsApp, send a photo/sketch/file — you'll get a quote and a deadline." ),
			array( 'q_ua' => 'В якому форматі надсилати файли?', 'q_en' => 'What file format should I send?', 'a_ua' => 'Вектор: AI, CDR, SVG, DXF, PDF. Для гравіювання приймаємо також растр у високій якості (PNG, JPG, TIFF).', 'a_en' => 'Vector: AI, CDR, SVG, DXF, PDF. For engraving we also accept high-res raster (PNG, JPG, TIFF).' ),
			array( 'q_ua' => 'Де взяти матеріал для різання?', 'q_en' => 'Where do I get material for cutting?', 'a_ua' => 'Працюємо на власному матеріалі або на вашому. На точці є 13 позицій у наявності — можна обрати на місці.', 'a_en' => 'We work on our own material or yours. 13 options are in stock at the point — pick on site.' ),
			array( 'q_ua' => 'Приймете замовлення, якщо у мене немає макета?', 'q_en' => 'Will you take the order if I have no artwork?', 'a_ua' => 'Так. Наш дизайнер розробить макет з нуля або векторизує ваш логотип. Вартість — від 150 грн.', 'a_en' => 'Yes. Our designer can build the file from scratch or vectorize your logo. From 150 UAH.' ),
			array( 'q_ua' => 'Чи обробляються деталі після різання?', 'q_en' => 'Are parts finished after cutting?', 'a_ua' => 'За потреби — шліфування торців, видалення нагару, склейка та складання виробу.', 'a_en' => 'On request — edge sanding, soot removal, gluing and assembly of the product.' ),
			array( 'q_ua' => 'Чи упаковуються готові деталі?', 'q_en' => 'Are finished parts packed?', 'a_ua' => 'Так, кожне замовлення пакуємо для транспортування. Для опту — індивідуальне пакування партіями.', 'a_en' => 'Yes, every order is packed for transport. Wholesale gets individual batch packing.' ),
			array( 'q_ua' => 'Чи здійснюється доставка?', 'q_en' => 'Do you deliver?', 'a_ua' => 'Нова Пошта, Justin, Делівері по всій Україні. Самовивіз — на точці 7 км.', 'a_en' => 'Nova Poshta, Justin, Delivery across Ukraine. Pick-up at the 7-km point.' ),
			array( 'q_ua' => 'У чому наведені ціни?', 'q_en' => 'What are the prices in?', 'a_ua' => 'Різка — грн за метр різу, гравіювання — грн за дм² поверхні. Точну вартість рахуємо за вашим файлом.', 'a_en' => 'Cutting — UAH per metre of cut; engraving — UAH per dm² of surface. Exact price is quoted from your file.' ),
			array( 'q_ua' => 'Як проводиться оплата?', 'q_en' => 'How is payment handled?', 'a_ua' => 'Готівка, картка, на рахунок ФОП. Для тиражів — передоплата 50 %.', 'a_en' => 'Cash, card, to a sole-proprietor account. Batches require 50 % prepayment.' ),
			array( 'q_ua' => 'Чи працюєте по безналу?', 'q_en' => 'Do you work with invoices?', 'a_ua' => 'Так, для корпоративних і оптових замовлень виставляємо рахунок і видаємо документи.', 'a_en' => 'Yes — for corporate and wholesale orders we issue an invoice and paperwork.' ),
		),

		/* ---- location ---------------------------------------------------- */
		'location_head' => array(
			'idx_ua' => 'Локація', 'idx_en' => 'Location',
			'title_ua' => 'Точка на 7 кілометрі', 'title_en' => 'Point at the 7-km market',
			'lede_ua' => 'Реальна вітрина з готовими виробами, зразками матеріалів і працюючими машинами. Привозьте файл — підемо різати разом.',
			'lede_en' => "A real showroom with finished pieces, material samples and working machines. Bring your file — we'll cut together.",
			'city' => 'Odesa · 7 km', 'coords' => '46.4°N · 30.6°E',
			'bazaar_ua' => 'Ринок «7 кілометр»', 'bazaar_en' => '7-km bazaar',
			'pin_ua' => 'Ряд 308 · Корпус 12', 'pin_en' => 'Row 308 · Bldg 12',
			'here_ua' => 'Нас тут', 'here_en' => 'We are here',
			'maps_ua' => 'Маршрут у Google Maps', 'maps_en' => 'Open in Google Maps',
			'maps_url' => 'https://maps.google.com/?q=7+km+market+Odesa+row+308',
			'stage_eyebrow_ua' => 'Що знайдете на вітрині', 'stage_eyebrow_en' => "What you'll find on site",
		),
		'location_rows' => array(
			array( 'k_ua' => 'Адреса', 'k_en' => 'Address', 'v_ua' => 'ринок «7 кілометр», ряд 308, корпус 12, місце 1142', 'v_en' => '7-km market, row 308, building 12, spot 1142' ),
			array( 'k_ua' => 'Графік', 'k_en' => 'Hours', 'v_ua' => 'Пн – Сб · 08:00 – 17:00 · Нд — за домовленістю', 'v_en' => 'Mon – Sat · 08:00 – 17:00 · Sun on request' ),
			array( 'k_ua' => "В'їзд", 'k_en' => 'Entry', 'v_ua' => 'ворота №4, паркомісця в 50 м', 'v_en' => 'Gate №4, parking 50 m away' ),
			array( 'k_ua' => 'Доставка', 'k_en' => 'Shipping', 'v_ua' => 'Нова Пошта, Justin, Делівері — по всій Україні', 'v_en' => 'Nova Poshta, Justin, Delivery — Ukraine-wide' ),
		),
		'location_stage' => array(
			array( 'label_ua' => 'Вітрина', 'label_en' => 'Storefront', 'body_ua' => '≈ 200 готових виробів — магніти, бокали, декор', 'body_en' => '≈ 200 finished items — magnets, glassware, decor' ),
			array( 'label_ua' => 'Зразки', 'label_en' => 'Samples', 'body_ua' => '13 матеріалів — можна потримати в руках', 'body_en' => '13 materials — hold them in your hand' ),
			array( 'label_ua' => 'Виробництво', 'label_en' => 'Production', 'body_ua' => 'Машини працюють у залі, видно процес', 'body_en' => 'Machines run in the room, the process is visible' ),
		),

		/* ---- contact ----------------------------------------------------- */
		'contact' => array(
			'eyebrow_ua' => 'Контакти', 'eyebrow_en' => 'Contact',
			'title_ua' => 'Найшвидший шлях —', 'title_en' => 'The fastest way is',
			'title_accent_ua' => 'у месенджер', 'title_accent_en' => 'the messenger',
			'lede_ua' => 'Надішліть фото, ескіз або файл — у відповідь отримаєте прорахунок і термін.',
			'lede_en' => "Drop a photo, sketch or file — we'll reply with a quote and a deadline.",
			'form_title_ua' => 'Або залиште бриф', 'form_title_en' => 'Or leave a brief',
			'form_name_ua' => 'Імʼя', 'form_name_en' => 'Name',
			'form_contact_ua' => 'Telegram / телефон', 'form_contact_en' => 'Telegram / phone',
			'form_brief_ua' => 'Що різати, з якого матеріалу, скільки штук', 'form_brief_en' => 'What to cut, what material, quantity',
			'form_btn_ua' => 'Надіслати у Telegram', 'form_btn_en' => 'Send to Telegram',
			'form_telegram' => 'laser7_odesa',
		),

		/* ---- footer ------------------------------------------------------ */
		'footer' => array(
			'tagline_ua' => 'Майстерня лазерної різки та гравіювання · Одеса, 7 км',
			'tagline_en' => 'Laser cutting & engraving workshop · Odesa, 7-km market',
			'copyright_ua' => '© 2017 – 2026 ЛАЗЕР · 7. Всі права захищено.',
			'copyright_en' => '© 2017 – 2026 LASER · 7. All rights reserved.',
			'note_ua' => 'Зроблено з турботою про деталі', 'note_en' => 'Crafted with care for detail',
			'col_a_ua' => 'Розділи', 'col_a_en' => 'Sections',
			'col_b_ua' => 'Інформація', 'col_b_en' => 'Information',
			'col_c_ua' => 'Контакти', 'col_c_en' => 'Contact',
			'credit_name' => 'Alexey Kachan Agency',
			'credit_url'  => 'https://alexeykachan.com/',
			'links' => array(
				array( 'ua' => 'Публічна оферта', 'en' => 'Public offer', 'url' => '#contact' ),
				array( 'ua' => 'Політика повернень', 'en' => 'Returns', 'url' => '#contact' ),
				array( 'ua' => 'Конфіденційність', 'en' => 'Privacy', 'url' => '#contact' ),
			),
		),

		/* ---- SEO --------------------------------------------------------- */
		'seo' => array(
			'title_ua' => 'ЛАЗЕР · 7 — лазерна різка та гравіювання · Одеса',
			'title_en' => 'LASER · 7 — laser cutting & engraving · Odesa',
			'desc_ua'  => 'Майстерня лазерної різки та гравіювання на 7 км у Одесі. Магніти, бокали, брелоки, корпоративний мерч, опт. UA / EN.',
			'desc_en'  => 'Laser cutting & engraving workshop at the 7-km market in Odesa. Magnets, glassware, keychains, corporate merch, wholesale. UA / EN.',
			'og_image' => 'board-odesa.webp',
			'geo_lat'  => '46.4017',
			'geo_lng'  => '30.6500',
		),
	);

	return $d;
}
