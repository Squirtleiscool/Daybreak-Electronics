<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Edit category");
?>

<div class="middlecontainer2">

<?php

echo "<h2>Edit category</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if ($catname = get_category_name($_GET['catid'])) 
  {
    $catid = $_GET['catid'];
    $cat = compact('catname', 'catid');
    
    display_category_form($cat);
  } 
  else 
  {
    echo "<p>Could not retrieve category details.</p>";
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
