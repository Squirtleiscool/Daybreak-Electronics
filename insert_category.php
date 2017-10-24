<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Adding a category");

?>

<div class="middlecontainer2">

<?php

echo "<h2>Adding a category</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if (filled_out($_POST))   
  {
    $catname = $_POST['catname'];
    $maincatid = $_POST['maincatid'];
    
    //echo "<p>maincatid is ".$maincatid."</p>";
    
    if ($maincatid == '' || $maincatid == null)
    {
      $maincatid = 0;
    }
    
    if(insert_category($catname, $maincatid)) 
    {
      echo "<p>Category \"".$catname."\" was added to the database.</p>";
    } 
    else 
    {
      echo "<p>Category \"".$catname."\" could not be added to the database.</p>";
    }
  } 
  else 
  {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url('my_account.php', 'Back to administration menu');
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
?>

</div>

<?php
do_html_footer();

?>
