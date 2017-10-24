<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Updating book");
?>

<div class="middlecontainer2">

<?php
echo "<h2>Updating Product</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if (filled_out($_POST)) 
  {
    $oldproductid = $_POST['oldproductid'];
    $productid = $_POST['productid'];
    $title = $_POST['title'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if(update_product($oldproductid, $productid, $title, $catid, $price, $description)) 
    {
      echo "<p>Product was updated.</p>";
    } 
    else 
    {
      echo "<p>Product could not be updated.</p>";
    }
  } 
  else 
  {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url("my_account.php", "Back to your account menu");
} 
else 
{
  echo "<p>You are not authorised to view this page.</p>";
}

echo "</div>";

do_html_footer();

?>
