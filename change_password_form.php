<?php
 require_once('product_sc_fns.php');
 session_start();
 do_html_header("Change your user password");
 
 echo "<div class=\"middlecontainer2\">";
 
 echo "<h2>Change your user password</h2>";
 
 if (check_admin_user($_SESSION['user_type']) || $_SESSION['user_type'] == 'Standard')
 {
   display_password_form();
 }
 else
 {
   echo "<p>You are not authorized to view the contents of this page. Please sign in to your account.</p>";
 }

 do_html_url("my_account.php", "Back to your account menu");
 
 echo "</div>";
 do_html_footer();
?>
