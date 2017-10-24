<?php
function calculate_shipping_cost() 
{
  // as we are shipping products all over the world
  // via teleportation, shipping is fixed
  // return 20.00;
  return 0.00;
}

function get_columnname_by_table($table_name)
{
  $conn = db_connect();
  $query = "select * from ".$table_name." limit 1";
  
  $result = @$conn->query($query);
  if (!$result) 
  {
   return false;
  }
  
  $num_column = @$result->num_rows;
  if ($num_column == 0) 
  {
    return false;
  }
   
  $finfo = mysqli_fetch_fields($result);
  $all_column_names = '';
  foreach ($finfo as $val) 
  {
    $all_column_names .= $val->name.",";
  }
  
  $column_array = explode(',', $all_column_names);
  return $column_array;
}

function search_query_results($searchtype, $searchterm)
{
    $conn = db_connect();
    $query = "select * from products where ".$searchtype." like '%".$searchterm."%'";
    $result = @$conn->query($query);
    
    if (!$result) 
    {
        return false;
    }
    
    $num_column = @$result->num_rows;
    if ($num_column == 0) 
    {
        return false;
    }
    
    $result = db_result_to_array($result);
    return $result;
}

function get_categories($allCategories = false) {
   // query database for a list of categories
   $conn = db_connect();
   
   $query = "";
   if ($allCategories == false)
   {
       $query = "select catid, catname from categories where subcatid = '0'";
   }
   else
   {
       $query = "select catid, catname from categories";
   }
   
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) {
      return false;
   }
   $result = db_result_to_array($result);
   return $result;
}

function get_subcategories($catid) {
   // query database for a list of categories
   $conn = db_connect();
   
   $stmt = $conn->prepare("select catid, catname from categories where subcatid = ?");
   $stmt->bind_param("i", $catid);
   $stmt->execute();
   $result = $stmt->get_result();
   
   if (!$result) 
   {
     return false;
   }
   
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) 
   {
      return false;
   }
   
   $result = db_result_to_array($result);
   return $result;
}

function get_category_name($catid) {
   // query database for the name for a category id
   $conn = db_connect();
             
   $stmt = $conn->prepare("select catname from categories where catid = ?");
   $stmt->bind_param("s", $catid);
   $stmt->execute();
   $result = $stmt->get_result();
   
   if (!$result) {
     return false;
   }
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) {
      return false;
   }
   $row = $result->fetch_object();
   return $row->catname;
}

function get_subcategory_name($catid)
{
  // query database for the name for a category id
  $conn = db_connect();
  
  $stmt = $conn->prepare("select catname from categories where catid = 
                            (select subcatid from categories where catid = ?");
  $stmt->bind_param("s", $catid);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if (!$result) {
     return false;
  }
   
  $num_cats = @$result->num_rows;
  if ($num_cats == 0) {
      return false;
  }
   
  $row = $result->fetch_object();
  return $row->catname;
}


function get_products($catid) {
   // query database for the books in a category
   if ((!$catid) || ($catid == '')) {
     return false;
   }

   $conn = db_connect();
   
   $stmt = $conn->prepare("select * from products where catid = ?");
   $stmt->bind_param("s", $catid);
   $stmt->execute();
   $result = $stmt->get_result();
   
   if (!$result) {
     return false;
   }
   $num_products = @$result->num_rows;
   if ($num_products == 0) 
   {
      return false;
   }
   $result = db_result_to_array($result);
   return $result;
}

function get_random_productid($limit) 
{
    // http://stackoverflow.com/questions/8779585/select-random-rows-from-mysql-table
    $conn = db_connect();
    
   $stmt = $conn->prepare("select p.productid, p.price, p.title 
                            from products as p
                            ORDER BY RAND() LIMIT ?");
   $stmt->bind_param("i", $limit);
   $stmt->execute();
   $result = $stmt->get_result();
    
    if (!$result) 
    {
     return false;
    }
    
    $num_products = @$result->num_rows;
    if ($num_products == 0) 
    {
      return false;
    }
    
    $result = db_result_to_array($result);
    return $result;
}

function get_user_detail($username)
{
    $conn = db_connect();
    
    $stmt = $conn->prepare("SELECT * 
                          FROM customers as c, orders as o, admin as a
                          WHERE a.customerid = c.customerid 
                          AND c.customerid = o.customerid 
                          AND a.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result) 
    {
     return false;
    }
    
    $num_products = @$result->num_rows;
    if ($num_products == 0) 
    {
      return false;
    }
    
    $result = db_result_to_array($result);
    return $result;
}

function get_popular_productid($limit) 
{
    // http://dba.stackexchange.com/questions/52476/how-to-get-a-list-result-of-best-selling-items
    $conn = db_connect();
    
    $stmt = $conn->prepare("SELECT p.productid, p.description, p.price, p.title, SUM(oi.quantity) AS TotalQuantity 
                            FROM order_items as oi, products as p, orders as o
                            WHERE p.productid = oi.productid AND o.orderid = oi.orderid
                            GROUP BY productid 
                            ORDER BY SUM(quantity) DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result) 
    {
     return false;
    }
    
    $num_products = @$result->num_rows;
    if ($num_products == 0) 
    {
      return false;
    }
    
    $result = db_result_to_array($result);
    return $result;
}

function get_product_details($productid) 
{
  // query database for all details for a particular book
  if ((!$productid) || ($productid == '')) 
  {
     return false;
  }
  
  $conn = db_connect();
  
  $stmt = $conn->prepare("select * from products where productid = ?");
  $stmt->bind_param("s", $productid);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if (!$result) 
  {
     return false;
  }
  
  $result = @$result->fetch_assoc();
  return $result;
}

function calculate_price($cart) 
{
  // sum total price for all items in shopping cart
  $price = 0.0;
  if(is_array($cart)) 
  {
    $conn = db_connect();
    foreach($cart as $productid => $qty) 
    {
      
      $stmt = $conn->prepare("select price from products where productid = ?");
      $stmt->bind_param("s", $productid);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result) 
      {
        $item = $result->fetch_object();
        $item_price = $item->price;
        $price += $item_price*$qty;
      }
    }
  }
  return $price;
}

function calculate_items($cart) 
{
  // sum total items in shopping cart
  $items = 0;
  if(is_array($cart))   
  {
    foreach($cart as $isbn => $qty) 
    {
      $items += $qty;
    }
  }
  return $items;
}
?>
