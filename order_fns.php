<?php
function process_card($card_details) {
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details) 
{
  // extract order_details out as variables
  extract($order_details);

  // set shipping address same as address. The names came from the HTML form
  if((!$ship_name) && (!$ship_address) && (!$ship_city) && (!$ship_state) && (!$ship_zip) && (!$ship_country)) 
  {
    $ship_name = $name;
    $ship_address = $address;
    $ship_city = $city;
    $ship_state = $state;
    $ship_zip = $zip;
    $ship_country = $country;
  }

  $conn = db_connect();

  // we want to insert the order as a transaction
  // start one by turning off autocommit
  $conn->autocommit(FALSE);
  
  $customerid = '';
  
  if ($_SESSION['admin_user'] != '' || $_SESSION['admin_user'] != null)
  {
    $username = $_SESSION['admin_user'];
    $customerid = get_account_customerid($username);
    
    $query = "update customers 
              set name = ?, address = ?, city = ?, state = ?, zip = ?, country = ? 
              where customerid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $name , $address, $city, $state, $zip, $country, $customerid);
    $stmt->execute();
    $result = $stmt->affected_rows;
    
    $result = $conn->query($query);
    
    /* 
       MySQL database engine is smart enough to NOT update the same information 
       if it determine that a EXISTING data is in record. That is why checking
       the resultset is pointless for this scenrio.
    */
    // if (!$result) 
    // {
    //   return false;
    // }
  }
  else
  {
    $stmt = $conn->prepare("insert into customers (name, address, city, state, zip, country) 
                          values (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name , $address, $city, $state, $zip, $country);
    $stmt->execute();
    $result = $stmt->affected_rows;
    
    if (!$result) 
    {
       return false;
    }
  
    $customerid = $conn->insert_id;
  }
  
  $date = date("Y-m-d");
  $total_price = $_SESSION['total_price'];
  $order_status = "PARTIAL";
  $stmt = $conn->prepare("insert into orders (customerid, amount, date, order_status, ship_name, 
                            ship_address, ship_city, ship_state, ship_zip, ship_country) 
                          values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("idssssssss", $customerid, $total_price, $date, $order_status, $ship_name, 
                    $ship_address, $ship_city, $ship_state, $ship_zip, $ship_country);
  $stmt->execute();
  $result = $stmt->affected_rows;
  
  if (!$result) 
  {
    return false;
  }

  $orderid = $conn->insert_id;
  
  // insert each product
  foreach($_SESSION['cart'] as $productid => $quantity) 
  {
    $detail = get_product_details($productid);
    
    $price = $detail['price'];
    $stmt = $conn->prepare("insert into order_items (orderid, productid, item_price, quantity) 
                            values (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $orderid, $productid, $price, $quantity);
    $stmt->execute();
    $result = $stmt->affected_rows;
    
    if(!$result) 
    {
      return false;
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

function get_orders($customerid) 
{
  $conn = db_connect();
                          
  $stmt = $conn->prepare("SELECT o.orderid, o.ship_name, o.amount, o.order_status, SUM(oi.quantity), o.date
                          FROM customers as c, orders as o, order_items as oi, admin as a
                          WHERE a.customerid = c.customerid 
                          AND c.customerid = o.customerid 
                          AND o.orderid = oi.orderid
                          AND a.customerid = ?
                          GROUP BY o.orderid
                          ORDER BY o.orderid DESC");
  
  $stmt->bind_param("s", $customerid);
  $stmt->execute();
  $result = $stmt->get_result();
  
  $result = db_result_to_array($result);
  return $result;
}

function get_order_head($orderid) 
{
  $conn = db_connect();
  
  $stmt = $conn->prepare("SELECT *
                          FROM orders as o
                          WHERE o.orderid = ?");
  $stmt->bind_param("s", $orderid);
  $stmt->execute();
  $result = $stmt->get_result();
  $order_detail = $result->fetch_object();
  
  return $order_detail;
}

function get_order_detail($orderid) 
{
  $conn = db_connect();
  
  $stmt = $conn->prepare("SELECT *
                          FROM orders as o, order_items as oi, products as p
                          WHERE o.orderid = oi.orderid AND oi.productid = p.productid
                          AND oi.orderid = ?");
  $stmt->bind_param("s", $orderid);
  $stmt->execute();
  $result = $stmt->get_result();
  
  $result = db_result_to_array($result);
  return $result;
}

?>
