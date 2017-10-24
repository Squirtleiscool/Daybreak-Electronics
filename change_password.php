<?php
 require_once('product_sc_fns.php');
 session_start();
 do_html_header('Changing password');
 
 echo "<div class=\"middlecontainer2\">";
 echo '<h2>Changing password</h2>';
 
 if (check_admin_user($_SESSION['user_type']) || $_SESSION['user_type'] == 'Standard')
 {
    if (!filled_out($_POST)) 
    {
      echo "<p>You have not filled out the form completely.<br/>
            Please try again.</p>";
      do_html_url("my_account.php", "Back to your account menu");
      echo "</div>";
      do_html_footer();
      exit;
    } 
    else 
    {
      $new_passwd = $_POST['new_passwd'];
      $new_passwd2 = $_POST['new_passwd2'];
      $old_passwd = $_POST['old_passwd'];
      
      if ($new_passwd != $new_passwd2) 
      {
         echo "<p>Passwords entered were not the same.  Not changed.</p>";
      } 
      else if ((strlen($new_passwd)>16) || (strlen($new_passwd)<6)) 
      {
         echo "<p>New password must be between 6 and 16 characters.  Try again.</p>";
      } 
      else 
      {
         // attempt update
         if (change_password($_SESSION['admin_user'], $old_passwd, $new_passwd)) 
         {
            echo "<p>Password changed.</p>";
         } 
         else 
         {
            echo "<p>Password could not be changed.</p>";
         }
      }
    }
    do_html_url("my_account.php", "Back to your account menu");
 }
 else
 {
    echo "<br><p>You are not authorized to view the contents of this page. Please sign in to your account.</p>"; 
 }
 
 
 
 echo "</div>";
 
 do_html_footer();
?>
