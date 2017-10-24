<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Updating category");

?>

<div class="middlecontainer2">

<?php

echo "<h2>Updating category</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if (filled_out($_POST)) 
  {
    if(update_category($_POST['catid'], $_POST['catname'])) 
    {
      echo "<p>Category was updated.</p>";
    } 
    else 
    {
      echo "<p>Category could not be updated.</p>";
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
