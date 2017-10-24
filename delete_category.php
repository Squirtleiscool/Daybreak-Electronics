<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Deleting category");

?>

<div class="middlecontainer2">
  
<?php

echo "<h2>Deleting category</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  $catid = $_REQUEST['catid'];
  
  if (isset($_REQUEST['catid'])) 
  {
    if(delete_category($_REQUEST['catid'])) 
    {
      echo "<p>Category was deleted.</p>";
    } 
    else 
    {
      echo "<p>Category could not be deleted.<br />
            This is usually because it is not empty.</p>";
    }
  } 
  else 
  {
    echo "<p>No category specified.  Please try again.</p>";
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
