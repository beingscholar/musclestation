

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
					<li class="contact-link"><a href="/contact">Contact</a></li>
					<li class="checkout-link"><a href="/checkout">Cart</a></li>
					<li class="rewards-icon-footer"><a href="/my-account">My Account</a></li>
					<!-- <li class="gift-card-footer"><a href="my-account">My Account</a></li> -->
				</ul>

				<ul>
					<li><a href="/faq">FAQs</a></li>
					<li><a href="/my-account">Login</a></li>
					<li><a href="/track-your-order">Track Your Order</a></li>
					<li><a href="/customer-service">Customer Service</a></li>
					<li><a href="/about">About Us</a></li>
				</ul>
			</div>
			<div class="connect-with-us">
				<div class="wrap">
					<h3>Connect with us</h3>
					<ul>
						<li><a target="_blank" href="https://www.facebook.com/musclestationsupplement"><img width="40" height="40" src="/wp-content/uploads/2020/11/fb-contact.png" alt=""></a></li>
						<li><a target="_blank" href="https://www.instagram.com/musclestationsupplements/"><img width="40" height="40" src="/wp-content/uploads/2020/11/ig-logo.png" alt=""></a></li>
						<li><a target="_blank" href="https://www.youtube.com/channel/UCE9Lgjv8Jw1tO6C-Vu1Qt7w"><img width="40" height="40" src="/wp-content/uploads/2020/11/yt.png" alt=""></a></li>
					</ul>
				</div>

				<div class="wrap">
					<h3>SIGN UP & GET 10% OFF ON FIRST ORDER</h3>
					
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
			
			<a href="#" class="site-lock" onclick="window.open('https://www.sitelock.com/verify.php?site=musclestation.com.au','SiteLock','width=600,height=600,left=160,top=170');"><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/musclestation.com.au"></a>
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

