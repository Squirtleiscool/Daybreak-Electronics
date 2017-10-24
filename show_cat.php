<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  
  $catid = $_GET['catid'];
  $subcatid = $_GET['subcatid'];
  $name = get_category_name($catid);

  do_html_header($name);
  ?>
  
  <div class="middlecontainer2">
  
  <?php
  echo "<h2>".$name."</h2>";

  $subcategory_array = get_subcategories($catid);
  
  $num_subcats = 0;
  if (is_array($subcategory_array))
  {
    $num_subcats = count($subcategory_array);
  }
  //echo "<p>num_subcats is ".$num_subcats."</p>";
  
  ?>
   
  <?php

  display_products($subcategory_array, $name, $catid, $num_subcats);

  // if logged in as admin, show add, delete product links
  if(isset($_SESSION['admin_user']) & $_SESSION['user_type'] == 'Administrator') 
  {
    display_button("index.php", "Continue Shopping");
    display_button("insert_category_form.php?maincatid=".$catid, "Add Subcategory");
    display_button("edit_category_form.php?catid=".$catid, "Edit Category");
  } 
  else 
  {
    display_button("index.php", "Continue Shopping");
  }
?>
 </div>
 
<?php
  do_html_footer();
?>
