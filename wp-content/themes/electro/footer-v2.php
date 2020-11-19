

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
					<li class="contact-link"><a target="_blank" href="contact">Contact</a></li>
					<li class="directory-link"><a target="_blank" href="store-directory">Store Directory</a></li>
					<li class="myaccount-link"><a target="_blank" href="my-account">MY ACCOUNT</a></li>
					<li class="checkout-link"><a target="_blank" href="checkout">Checkout</a></li>
				</ul>

				<ul>
					<li><a target="_blank" href="faq">FAQs</a></li>
					<li><a target="_blank" href="login">Login</a></li>
					<li><a target="_blank" href="track-your-order">Track Your Order</a></li>
					<li><a target="_blank" href="customer-service">Customer Service</a></li>
					<li><a target="_blank" href="about">About Us</a></li>
				</ul>
			</div>
			<div class="connect-with-us">
				<div class="wrap">
					<h3>Connect with us</h3>
					<ul>
						<li><a target="_blank" href="https://www.facebook.com/musclestationsupplement"><img src="wp-content/uploads/2020/11/fb.png" alt=""></a></li>
						<li><a target="_blank" href="https://www.instagram.com/musclestationsupplements/"><img src="wp-content/uploads/2020/11/instagram.png" alt=""></a></li>
						<li><a target="_blank" href="https://www.youtube.com/channel/UCE9Lgjv8Jw1tO6C-Vu1Qt7w"><img src="wp-content/uploads/2020/11/twitter.png" alt=""></a></li>
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

