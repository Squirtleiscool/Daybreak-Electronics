<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Add Product");


?>

 <div class="middlecontainer2">
  
<?php

echo "<h2>Add Product</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  display_product_form();
  do_html_url("my_account.php", "Back to your account menu");
  
} 
else 
{
  echo "<p>You are not authorized to enter the administration area.</p>";
}


  echo "</div>";


do_html_footer();

?>
