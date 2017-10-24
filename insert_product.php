<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Adding a product");
?>

<div class="middlecontainer2">
  
<?php

echo "<h2>Adding a product</h2>";

if (check_admin_user($_SESSION['user_type'])) 
{
  if (filled_out($_POST)) 
  {
    $productid = $_POST['productid'];
    $title = $_POST['title'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (insert_product($productid, $title, $catid, $price, $description)) 
    {
      echo "<p>Product <em>".stripslashes($title)."</em> was added to the database.</p>";
    } 
    else 
    {
      echo "<p>Product <em>".stripslashes($title)."</em> could not be added to the database.</p>";
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
