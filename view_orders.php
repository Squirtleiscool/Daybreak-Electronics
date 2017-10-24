<?php

// include function files for this application
require_once('product_sc_fns.php');
session_start();

do_html_header("Administration");
echo "<div class=\"middlecontainer2\">";

if ($_SESSION['admin_user'] == '' || $_SESSION['admin_user'] == null)
{
    echo "<p>You are not authorized to enter the this page. Please sign in.</p>";
}
else
{
    $action = $_REQUEST['action'];
    
    if ($_SESSION['user_type'] == 'Standard')
    {
      $username = $_SESSION['admin_user'];
      $customerid = get_account_customerid($username);
      
      if ($action == 'order_list')
      {
          $orders_array = get_orders($customerid);
          display_order_list($orders_array);
      }
      
      if ($action == 'order_detail')
      {
          $orderid = $_REQUEST['orderid'];
          //echo "<p>orderid: ".$orderid."</p>";
          $order_head_object = get_order_head($orderid);
          $order_detail_array = get_order_detail($orderid);
          
          display_order_detail($order_head_object, $order_detail_array);
      }
    }
}

echo "</div>";
do_html_footer();

?>
