<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  
  $searchterm = $_REQUEST['srch-term'];

  do_html_header();
?>
  
  <div class="middlecontainer1">
  
<?php
  echo "<h2>Search Results for \"".$searchterm."\"</h2>";

  if (!$searchterm) 
  {
     echo '<p>You have not entered search details. Please go back and try again.</p>';
     exit;
  }

  if (!get_magic_quotes_gpc())
  {
    $searchterm = addslashes($searchterm);
  }
?>
   </div>  
   <div class="middlecontainer2">
<?php

  $searchtermarray = explode(' ', $searchterm);
  display_search_results($searchtermarray);
  display_button("index.php", "Continue Shopping");
?>
 </div>
 
<?php
  do_html_footer();
?>
