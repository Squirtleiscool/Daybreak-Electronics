<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Deleting Product");
?>

<div class="middlecontainer2">

<?php
echo "<h2>Deleting Product</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if (isset($_POST['productid'])) 
  {
    $getproductid = $_POST['productid'];
    if(delete_product($getproductid)) 
    {
      echo "<p>Product ".$getproductid." was deleted.</p>";
    } 
    else 
    {
      echo "<p>Product ".$getproductid." could not be deleted.</p>";
    }
  } 
  else 
  {
    echo "<p>We need an Product ID to delete a product.  Please try again.</p>";
  }
  do_html_url("my_account.php", "Back to your account menu");
} 
else 
{
  echo "<p>You are not authorised to view this page.</p>";
}
?>

</div>

<?php
do_html_footer();

?>
