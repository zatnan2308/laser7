<?php
/**
 * Fallback template. The site is a one-page landing rendered by front-page.php;
 * this exists so the theme is valid for any other request.
 *
 * @package laser7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main>
	<section class="section">
		<div class="container-wide">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class(); ?>>
						<h1 class="h-section"><?php the_title(); ?></h1>
						<div class="hero-lede"><?php the_content(); ?></div>
					</article>
					<?php
				endwhile;
			else :
				?>
				<h1 class="h-section"><?php esc_html_e( 'Нічого не знайдено', 'laser7' ); ?></h1>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
