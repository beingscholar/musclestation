<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package electro
 */
?>
			<?php
			/**
			 *
			 */
			do_action( 'electro_content_bottom' ); ?>
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'electro_before_footer_v2' ); ?>

	<footer id="colophon" class="site-footer footer-v2">
<div class="footer-top-container section-container">
		<div class="footer-top footer container stretched">
			<div class="inner-container">
				<div class="section clearer links-wrapper-separators">
					<div class="item item-left">
						<div class="ftr1_link1 ftr-title">
							<h2>Customer<br>Service</h2>
						</div>
						<div class="ftr1_link1 ftr-contact">
							<ul>
								<li class="contact-link"><a href="customer-service.html">Contact</a></li>
								<li class="findstore-link"><a href="locator/search">Find a Store</a></li>
								<li class="checkout-link"><a href="checkout/cart">Checkout</a></li>
								<li class="rewards-icon-footer"><a href="my-active-rewards.html">My Active Rewards</a></li>
								<li class="gift-card-footer"><a href="gift.html">Gift Cards</a></li>
							</ul>
						</div>
						<div class="ftr1_link1 ftr-cmspage">
							<ul>
								<li><a href="faqs.html">FAQs</a></li>
								<li><a href="ordering.html">Ordering</a></li>
								<li><a href="shipping.html">Shipping</a></li>
								<li><a href="returns.html">Returns</a></li>
								<li><a href="tracking.html">Track Your Order</a></li>
								<li><a href="customer-service.html">Customer Service</a></li>
								<li><a href="about-us.html">About Us</a></li>
							</ul>
						</div>
					</div>
					<div class="item item-right">
						<div class="connect-with-us">
							<h2>Connect with us</h2>
							<ul>
								<li> <a href="https://www.facebook.com/musclestationsupplement/" target="_blank"> <img src="wp-content/uploads/2020/11/fb.png" alt=""> </a> </li>
								<li> <a href="https://instagram.com/musclestationsupplements/" target="_blank"> <img src="wp-content/uploads/2020/11/instagram.png" alt=""> </a> </li>
								<li> <a href="https://twitter.com/musclestation" target="_blank"> <img src="wp-content/uploads/2020/11/twitter.png" alt=""> </a> </li>
							</ul>
						</div>
						<div class="newsletter-wrapper clearer">
							<div class="newsletter-wrap">
								<?php echo do_shortcode( '[wpforms id="5192"]' ); ?>
							</div>
						</div>
						<div class="footer-links-mb">
							<h3>1300 837 785</h3>
							<p><a href="mailto:sales@musclestation.com.au">sales@musclestation.com.au</a></p>
							<ul>
								<li><a href="faqs.html">FAQs</a></li>
								<li><a href="ordering.html">Ordering</a></li>
								<li><a href="shipping.html">Shipping</a></li>
								<li><a href="returns.html">Returns</a></li>
								<li><a href="tracking.html">Track Your Order</a></li>
								<li><a href="customer-service.html">Customer Service</a></li>
								<li><a href="about-us.html">About Us</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		<?php
		/**
		 * @hooked electro_footer_widgets - 10
		 * @hooked electro_credit - 20
		 */
		do_action( 'electro_footer_v2' ); ?>


	</footer><!-- #colophon -->

	<?php do_action( 'electro_after_footer_v2' ); ?>

</div><!-- #page -->
</div>
<?php do_action( 'electro_after_page' ); ?>

<?php wp_footer(); ?>

</body>
</html>
