

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

<footer class="primary-footer">
	<div class="footer-top-section">
		<div class="container">
			<div class="customer-service">
				<h3>Customer <span>Service</span></h3>
				<ul class="with-icons">
					<li class="contact-link"><a href="/">Contact</a></li>
					<li class="findstore-link"><a href="/">Find a Store</a></li>
					<li class="checkout-link"><a href="/">Checkout</a></li>
					<li class="rewards-icon-footer"><a href="/">My Active Rewards</a></li>
					<li class="gift-card-footer"><a href="/">Gift Cards</a></li>
				</ul>

				<ul>
					<li><a href="/">FAQs</a></li>
					<li><a href="/">Ordering</a></li>
					<li><a href="/">Shipping</a></li>
					<li><a href="/">Returns</a></li>
					<li><a href="/">Track Your Order</a></li>
					<li><a href="/">Customer Service</a></li>
					<li><a href="/">About Us</a></li>
				</ul>
			</div>
			<div class="connect-with-us">
				<div class="wrap">
					<h3>Connect with us</h3>
					<ul>
						<li><a href="/"><img src="https://www.nutritionwarehouse.com.au/media/wysiwyg/fb.png" alt=""></a></li>
						<li><a href="/"><img src="https://www.nutritionwarehouse.com.au/media/wysiwyg/instagram.png" alt=""></a></li>
						<li><a href="/"><img src="https://www.nutritionwarehouse.com.au/media/wysiwyg/twitter.png" alt=""></a></li>
					</ul>
				</div>

				<div class="wrap">
					<h3>SIGN UP & SAVE</h3>
					
					<div class="newsletter-subscribe">
						<?php echo do_shortcode( '[wpforms id="5192"]' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="footer-bottom-section">
		<?php
      /**
      * @hooked electro_footer_widgets - 10
      * @hooked electro_credit - 20
      */
      do_action( 'electro_footer_v2' ); ?>
	</div>
	<!-- <div class="copyright"></div> -->
</footer>

<!-- #colophon -->
<?php do_action( 'electro_after_footer_v2' ); ?>
</div><!-- #page -->
</div>
<?php do_action( 'electro_after_page' ); ?>
<?php wp_footer(); ?>
</body>
</html>

