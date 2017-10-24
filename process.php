<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  do_html_header('Checkout');
  ?>
  
  <div class="middlecontainer2">
  
  <?php
  
  echo '<h2>Checkout</h2>';

  $card_type = $_POST['card_type'];
  $card_number = $_POST['card_number'];
  $card_month = $_POST['card_month'];
  $card_year = $_POST['card_year'];
  $card_name = $_POST['card_name'];

  if(($_SESSION['cart']) && ($card_type) && ($card_number) &&
     ($card_month) && ($card_name) && ($card_year)) 
     {
    //display cart, not allowing changes and without pictures
    display_cart($_SESSION['cart'], false, 0);

    display_shipping(calculate_shipping_cost());

    if(process_card($_POST)) 
    {
      $username = $_SESSION['admin_user'];
      $user_type = $_SESSION['user_type'];
      
      //empty shopping cart
      //session_destroy();
      unset($_SESSION['cart']);
      unset($_SESSION['items']);
      unset($_SESSION['total_price']);
      
      // User account is still active after the purchase
      $_SESSION['admin_user'] = $username;
      $_SESSION['user_type'] = $user_type;
      
      echo "<p>Thank you for shopping with us. Your order has been placed.</p>";
      display_button("index.php", "Continue Shopping");
    } 
    else 
    {
      echo "<p>Could not process your card. Please contact the card issuer or try again.</p>";
      display_button("purchase.php", "Back");
    }
  } 
  else 
  {
    echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    display_button("purchase.php", "Back");
  }

echo "</div>";

  do_html_footer();
?>
