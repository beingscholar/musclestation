<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package electro
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	wp_body_open();
	?>
<div class="off-canvas-wrapper">
<div id="page" class="hfeed site">
	<div class="full-color-background">
		<?php
		/**
		 * @hooked electro_skip_links - 0
		 * @hooked electro_top_bar - 10
		 */
		do_action( 'electro_before_header' ); ?>

		<header id="masthead" class="site-header stick-this header-v4">
		<div class="topbar_head">
			
				<div class="container">
				<marquee width = "50%">
<ul>
<li>
<span class="font28_bi_red">FREE SHIPPING</span> <span class="font28_mi_blk">OR</span> <span class="font28_bi_red">GIFT </span>
<span class="font28_mi_blk">ON ALL ORDERS OVER $150*</span>
</li>
<li>
<span class="font28_bi_red">SAME DAY DISPATCH</span> <span class="font28_mi_blk">ON ORDERS </span>
<span class="font28_bi_red">BEFORE </span><span class="font28_mi_blk">3PM*</span>
</li>
<li>
<span class="font28_bi_red">30 DAY</span> <span class="font28_mi_blk"> MONEY BACK </span>
<span class="font28_bi_red">GUARANTEE</span>
</li>
</ul>
</marquee>
					
				</div>
			
		</div>
			<div class="container <?php echo esc_attr( has_electro_mobile_header() ? electro_desktop_header_responsive_class() : '' );  ?>">
				<?php
				/**
				 * @hooked electro_row_wrap_start - 0
				 * @hooked electro_header_logo - 10
				 * @hooked electro_primary_menu - 20
				 * @hooked electro_header_support_info - 30
				 * @hooked electro_row_wrap_end - 40
				 */
				do_action( 'electro_header_v4' ); ?>

			</div>

			<?php
			/**
			 * @hooked electro_handheld_header - 10
			 */
			do_action( 'electro_after_header' ); ?>

		</header><!-- #masthead -->
	</div>
	<?php
	/**
	 * @hooked electro_navbar - 10
	 */
	do_action( 'electro_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
<div class="special-deals-wrapper">
			<div class="special-deals-block">
				<div class="container">
					<a href="#" title="View BOGOs &amp; Deals">
						<span class="title">Supplement Specials &amp; Deals!</span>
						<span class="arrow-container">
							<span class="arrow arrow__left"></span>
							<span class="link">View BOGOs &amp; Deals</span>
							<span class="arrow arrow__right"></span>
						</span>
					</a>
				</div>
			</div>
		</div>
		<div class="container">
		
		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'electro_content_top' ); ?>








