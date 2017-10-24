<?php
 require_once('product_sc_fns.php');
 do_html_header("Administration");
 
?>
<div class="middlecontainer2">
  
<?php
 
 if ($_REQUEST['new_user'] == 'new_user')
 {
  display_login_form($_REQUEST['new_user'], "Create Account");
 }
 else
 {
  display_login_form("", "My Account");
 }
 
?>
</div>

<?php
 do_html_footer();
?>
