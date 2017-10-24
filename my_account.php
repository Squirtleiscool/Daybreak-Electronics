<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

if ($_REQUEST['new_user'] == 'new_user')
{
  $_SESSION['register_message'] = '';
  
  $username = $_REQUEST['username'];
  $passwd = $_REQUEST['passwd'];
  $username1 = $_REQUEST['username1'];
  $passwd1 = $_REQUEST['passwd1'];
  
  if (($username != $username1) | ($passwd != $passwd1))
  {
    do_html_header("Problem:");
    echo "<div class=\"middlecontainer2\">";
    echo "<h2>Account Registration Status</h2>";
    $error_message = "The entries you have entered does not match. Please try again.";
    echo "<p>".$error_message."</p>";
    echo "</div>";
    do_html_footer();
    exit;
  }
  
  // unsuccessful login
  do_html_header("Problem:");
  echo "<div class=\"middlecontainer2\">";
  echo "<h2>Account Registration Status</h2>";
  
  if (register_account($username, $passwd) == true)
  {
    $message = $_SESSION['register_message'];
    echo "<br><p>".$message."</p>";
    echo "<a href=\"login.php\">Go to the login page to access your account</a>";
  }
  else
  {
    // Return an error message based on account creation
    $error_message = $_SESSION['register_message'];
    echo "<p>".$error_message."</p>";
  }
  
  echo "</div>";
  do_html_footer();
  exit;
}

if (($_POST['username']) && ($_POST['passwd'])) 
{
	// they have just tried logging in

    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    if (login($username, $passwd)) 
    {
      // if they are in the database register the user id
      $_SESSION['admin_user'] = $username;
    
    } 
    else 
    {
      // unsuccessful login
      do_html_header("Problem:");
      echo "<div class=\"middlecontainer2\">";
      echo "<h2>Problem:</h2>";
      echo "<p>You could not be logged in.<br/>
            You must be logged in to view this page.</p>";
      do_html_url('login.php', 'Login');
      echo "</div>";
      do_html_footer();
      exit;
    }
}

do_html_header("Administration");

?>

<div class="middlecontainer2">

<?php

if (check_admin_user($_SESSION['user_type'])) 
{
  echo "<div class=\"admin_operation_container\">";
  echo "<h2>Administration</h2>";
  display_admin_menu();
  //echo "<p>User Type: ".$_SESSION['user_type']."</p>";
  echo "</div>";
  
} 

if ($_SESSION['user_type'] == 'Standard')
{
  // Standard User
  echo "<div class=\"admin_operation_container\">";
  echo "<h2>Hello, ".$_SESSION['admin_user']."</h2>";
  display_admin_menu($_SESSION['user_type']);
  //echo "<p>Welcome to your standard user account</p>";
  echo "</div>";
}

if ($_SESSION['admin_user'] == '' || $_SESSION['admin_user'] == null)
{
  echo "<br><p>You are not authorized to enter the My account area. Please sign in.</p>";
}

?>

</div>

<?php

do_html_footer();

?>
