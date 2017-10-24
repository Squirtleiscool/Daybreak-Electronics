<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();
$old_user = $_SESSION['admin_user'];  // store  to test if they *were* logged in
$old_user_type = $_SESSION['user_type'];
unset($_SESSION['admin_user']);
unset($_SESSION['user_type']);
//session_destroy();

// start output html
do_html_header("Logging Out");

?>
<div class="middlecontainer2">
  
<?php

echo "<h2>Logging Out</h2>";

if (!empty($old_user) & !empty($old_user_type)) 
{
  echo "<p>Logged out.</p>";
  do_html_url("login.php", "Login");
} 
else 
{
  // if they weren't logged in but came to this page somehow
  echo "<p>You were not logged in, and so have not been logged out.</p>";
  do_html_url("login.php", "Login");
}
?>

</div>

<?php

do_html_footer();

?>
