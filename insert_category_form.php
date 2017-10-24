<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Add a category");

?>

<div class="middlecontainer2">
  
<?php

echo "<h2>Add a category</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  $maincatid = $_REQUEST['maincatid'];
  if ($maincatid)
  {
    display_category_form(null, $maincatid);
  }
  else
  {
    display_category_form();
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
