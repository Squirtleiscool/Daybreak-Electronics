<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Welcome to Daybreak Electronics");
?>

<div class="middlecontainer1">
 <h2> Price Match </h2>
</div>

<div class="middlecontainer2">
  <p style="font-size: 40px; font-family: 'Impact', Times, serif; color: silver"> DayBreak will not be beat! </p><br />
  
  <p>We offer competitive prices for our customers to feel like they made the right choice choosing us. 
  We encourage our customers to tell us whether 
  another electronic store sells a certain product for a lower price. Contact us
  or notify us to take advantage of this special offer. </p>
  
  <p>Certain rules may apply. Please call us or notify a staff whether a product applies.</p>
  
  <img src="img/PriceMatchDaybreak.jpg" style="width:75%"></img><br/><br/>
  
  <p style="font-size: 20px"> Don't wait til next Daybreak! Get shopping Now! </p>
  
  <br/><br/>
  
</div>

<?php
  do_html_footer();
?>
