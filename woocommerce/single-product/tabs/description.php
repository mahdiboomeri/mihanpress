<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
echo '<section id="mp-description" class="single-product-desc box box-shadow-lg mp-scrollspy-section pr-2 pl-2 pr-md-3 pl-md-3 pr-lg-4 pl-lg-4">';
$heading = apply_filters( 'woocommerce_product_description_heading', the_title( '<h1 class="product_title entry-title">', '</h1>' ) );

if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>
<div class="product_long-desc article-body">
	<?php the_content(); ?>
</div>
<?php
echo '</section>'
?>
