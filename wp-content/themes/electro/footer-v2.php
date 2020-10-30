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
<div class="connect-with-us"> <h2>Connect with us</h2> <ul> <li> <a href="https://www.facebook.com/nutritionwarehouse" target="_blank"> <img src="media/wysiwyg/fb.png" alt=""> </a> </li> <li> <a href="https://instagram.com/nutritionwarehouse" target="_blank"> <img src="media/wysiwyg/instagram.png" alt=""> </a> </li> <li> <a href="https://twitter.com/nutritionwareho" target="_blank"> <img src="media/wysiwyg/twitter.png" alt=""> </a> </li>  </ul> </div>
<div class="newsletter-wrapper clearer">
<div id="feedback" style="display:none" class="mini-newsletter del_updt_pop_main">
<div class="del_updt_pop_heading">
<div class="popup_heading_txt">
SIGN UP SUCCESSFUL </div>
</div>
<div class="del_updt_pop_mid">
<div class="zblock zblock-content-popup-subscribe-success" id="zblock-741"><div class="zblock-item"><style>
.popup_mid_btn a {
    text-align: center !important;
    padding: 20px 20px;
}
</style>
<div class="popup_mid_txt" style="font-size: 20px; color: #222; text-transform: uppercase; margin-bottom: 25px; text-align: center">
Thanks for signing up, here's your $5 Off Code:
<div style="background: #fff; margin: 15px auto; width: 250px; padding: 13px 10px 10px; border: 3px dashed #e31e31; border-radius: 5px; font-size: 30px;">GH63AU</div>
<p style="font-family: Arial,Helvetica,sans-serif;font-size: 14px;line-height: 16px;text-transform: none;">
An email has been sent to you with your code if you want to use it at a later time.
</p>
</div>
</div></div> <div class="popup_mid_btn_main mrgn_t20">
<div class="popup_mid_btn">
<a class="closepopup1" href="">
CONTINUE SHOPPING </a>
&nbsp;
</div>
</div>
</div>
</div>
<div class="newsletter-wrap">
<form action="collection/subscriber/new/" name="newsletter-form" id="newsletter-footer" method="post">
<div class="signup_coupon"><img src="skin/frontend/ultimo/nwh/images/discountcard.png"></div>
<div class="home_signup">
<h2>
<span class="red">SIGN UP</span> &amp; SAVE </h2>
<div class="subscribe-input">
<button type="submit" name="submit" title="Submit" class="submit_btn b-main">
Submit  </button>
<button type="submit" name="submit" title="Sign up" class="submit_btn b-foot">
Sign up </button>
<input placeholder="Enter email here" type="email" name="email" id="newsletter" title="Subscribe to Our Newsletter" class="signup_field required-entry validate-email input-subscribe">

</div>
</div>
</form>
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
