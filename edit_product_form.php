<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Edit book details");
?>

<div class="middlecontainer2">

<?php

echo "<h2>Edit Product details</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if ($book = get_product_details($_GET['productid'])) 
  {
    display_product_form($book);
  } 
  else 
  {
    echo "<p>Could not retrieve product details.</p>";
  }
  do_html_url("my_account.php", "Back to your account menu");
} 
else 
{
  echo "<p>You are not authorized to enter the administration area.</p>";
}
?>

</div>

<?php
do_html_footer();

?>
