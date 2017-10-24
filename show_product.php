<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $getProductid = $_GET['productid'];

  // get this product out of database
  $productArray = get_product_details($getProductid);
  $productTitle = $productArray['title'];
  
  do_html_header($productTitle);
  ?>
  
  <!--<div class="middlecontainer1">-->
  
  <?php
  // echo "<h2>".$productTitle."</h2>";
  ?>
  
   <!--</div>-->
   <div class="middlecontainer2">
  
  <?php
  display_product_details($productArray, $productTitle);

  // set url for "continue button"
  $target = "index.php";
  if($productid['catid']) 
  {
    $target = "show_cat.php?catid=".$productArray['catid'];
  }

  // if logged in as admin, show edit book links
  if(check_admin_user($_SESSION['user_type'])) 
  {
    display_button("edit_product_form.php?productid=".$getProductid, "Edit Item");
    display_button($target, "Continue");
  } 
  else 
  {
    display_button("show_cart.php?new=".$getProductid, "Add To Cart");
    display_button($target, "Continue Shopping");
  }
  
  ?>
  
  </div>
  
  <?php
  do_html_footer();
?>
