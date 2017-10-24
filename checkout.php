<?php
  //include our function set
  include ('product_sc_fns.php');

  // The shopping cart needs sessions, so start one
  session_start();

  do_html_header("Checkout");
  ?>
  
  <div class="middlecontainer4">
  
  <?php
  echo "<h2>Checkout</h2>";
  ?>
  
  </div>
  <div class="middlecontainer">
  
  <?php
  if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) 
  {
    display_cart($_SESSION['cart'], false, 0);
    display_checkout_form();
  } 
  else 
  {
    echo "<p>There are no items in your cart</p>";
  }

  display_button("show_cart.php", "Continue Shopping");
  ?>
  
  </div>
  
  <?php
  do_html_footer();
?>
