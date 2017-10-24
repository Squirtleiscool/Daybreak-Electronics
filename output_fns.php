<?php

function do_html_header($title = '') {
  // print an HTML header

  // declare the session variables we want access to inside the function
  if (!$_SESSION['items']) {
    $_SESSION['items'] = '0';
  }
  if (!$_SESSION['total_price']) {
    $_SESSION['total_price'] = '0.00';
  }
?>
  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Daybreak Electronics - <?php echo $title; ?></title>
    <!-- Start WOWSlider.com HEAD section -->
    <link rel="stylesheet" type="text/css" href="engine1/style.css" />
    <script type="text/javascript" src="engine1/jquery.js"></script>
    <!-- End WOWSlider.com HEAD section -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
  <body>
    <div class="container">
      <div class="page-header"></div>
      <?php include 'navigation.php' ?>
    </div>
    <!--<div class="middlecontainer2">-->
<?php
  // ($title) {
  //   do_html_heading($title);
  // }
}

function do_html_footer() {
  // print an HTML footer
?>
  <!--</div>-->
  <div style="margin 20px 0 0 0">&nbsp;</div>
  <footer class="footer">
      <div class="container">
        <?php include 'footer.php' ?>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
  </body>
</html>
<?php
}

function do_html_heading($heading) {
  // print heading
?>
  <h2><?php echo $heading; ?></h2>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a>
<?php
}

function display_products($subcategory_array, $name, $catid, $num_subcats)
{
  $product_array = get_products($catid);
  $num_products = 0;
  if (is_array($product_array))
  {
    $num_products = count($product_array);
  }
  //echo "<p>num_products is ".$num_products."<br>num_subcats is ".$num_subcats."</p>";
  
  /*-------------------------Start of Subcategory display---------------------*/
  if ($num_subcats > 0)
  {
    $subcathtmlstr = "<div class=\"subcategory_container\"><ul>";
    
    foreach ($subcategory_array as $subcategory)
    {
      $url = "show_cat.php?catid=".$subcategory['catid'];
      $title = $subcategory['catname'];
      $subcathtmlstr .= "<li>";
      $subcathtmlstr .= "<a href=\"".$url."\">".$title."</a>";
      $subcathtmlstr .= "</li>";
    }
    
    $subcathtmlstr .= "</ul></div>";
    
    echo $subcathtmlstr; // display to the browser
  }
  /*-------------------------End of Subcategory display-----------------------*/
  
  /*-------------------------Start of Product display-------------------------*/
  if ($num_subcats == 0)
  {
    echo "<div class=\"products_container_1\">";
  }
  else
  {
    echo "<div class=\"products_container\">";
  }
  
  //create table
  echo "<table class=\"table-hover\">";
  //create a table row for each product based on number of subcategories
  if ($num_subcats == 0)
  {
    //echo "<p>You have reached condition 1</p>";
    $product_array = get_products($catid);
    if (is_array($product_array))
    {
      build_product_list_display($catid);
    }
    else
    {
      echo "<p>No ".$name." currently available in this category</p>";
    }
  }
  else
  {
    //echo "<p>You have reached condition 2</p>";
    build_product_list_display($catid);
    foreach ($subcategory_array as $subcategory)
    {
      $catid = $subcategory['catid'];
      build_product_list_display($catid);
    }
  }
  /*---------------------------End of Product display-------------------------*/
  
  echo "</table>";
  echo "</div>";
  echo "<hr />";
}

function build_product_list_display($catid)
{
  $product_array = get_products($catid);
  if (is_array($product_array))
  {
    foreach ($product_array as $product) 
    {
      $price = $product['price'];
      $url = "show_product.php?productid=".$product['productid'];
      
      //echo "<tr><td>";
      echo "<tr class=\"clickable-row\" data-href=\"".$url."\"><td>";
      
      if (@file_exists("images/".$product['productid'].".jpg")) 
      {
        $title = "<img src=\"images/".$product['productid'].".jpg\"/>";
        do_html_url($url, $title);
      } 
      else 
      {
        echo "&nbsp;";
      }
      echo "</td><td>";
      $title = $product['title'];
      do_html_url($url, $title);
      echo "<br><span>$".$price."</span></td></tr>";
    }
  }
}

function display_search_results($searchtermarray)
{
  $column_array = get_columnname_by_table('products');
  
  $column_array_length = count($column_array);
  $display = "<div class=\"products_container_1\">
                <table class=\"table-hover\">";
  $count = 0;
  $pid_array = array();
  
  foreach($searchtermarray as $term)
  {
    for ($x = 0; $x < $column_array_length; $x++) 
    {
      if ($column_array[$x])
      {
        $searchtype = $column_array[$x];
        $product_results_array = search_query_results($searchtype, $term);
        
        if (is_array($product_results_array))
        {
          foreach ($product_results_array as $product)
          {
            $title = $product['title'];
            $description = $product['description'];
            $productid = $product['productid'];
            $price = $product['price'];
            
            if (array_key_exists($productid, $pid_array) === false)
            {
              $url = "show_product.php?productid=".$productid;
              
              $img_title = "<img src=\"images/".$productid.".jpg\"/>";
              $img_url = "<a href=\"".$url."\">".$img_title."</a>";
              $url_link = "<a href=\"".$url."\">".$title."</a>";
              
              $display .= "<tr class=\"clickable-row\" data-href=\"".$url."\">
                            <td>".$img_url."</td>
                            <td>".$url_link."<br><span>$".$price."</span></td>
                           </tr>";
                          
              $pid_array[$productid] = $productid;
               
              $count++;
            }
          }
        }
      }
    }
  }
  
  $display .= "</table>
              </div>
              <hr/>";
  
  echo "<p>Number of products found: ".$count."</p>";
  echo $display;
}

// Modifly by Michael Tu
function display_product_details($productid, $productTitle) {
  // display all details about this product
  
  if (is_array($productid)) 
  {
    $display_product_detail = "
    <div class=\"product_img_detail_container\">
      <img src=\"images/".$productid['productid'].".jpg\"/>
    </div>
    
    <div class=\"product_detail_container\">
      <header>
        <h2>".$productTitle."</h2>
      </header>
      <div>
        <p><span>SKU:</span> ".$productid['productid']."<br>
        <span>Price:</span> <span style=\"color: #406bb3;\">$".number_format($productid['price'], 2)."</span><br>
        <span>Description:</span> ".$productid['description']."</p>
      </div>
    </div>";
    
    echo $display_product_detail;
  } 
  else 
  {
    echo "<p>The details of this item, ".$productTitle." cannot be displayed at this time.</p>";
  }
  echo "<hr />";
}

function display_checkout_form() 
{
  //display the form that asks for name and address
?>
  <br />
  <table class="checkout_form_container">
  <form action="purchase.php" method="post">
    <tr>
      <th colspan="2">Your Details</th>
    </tr>
    <tr>
      <td>Name</td>
      <td><input type="text" name="name" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><input type="text" name="address" value="" size="40"/></td>
    </tr>
    <tr>
      <td>City/Suburb</td>
      <td><input type="text" name="city" value="" size="40"/></td>
    </tr>
    <tr>
      <td>State/Province</td>
      <td><input type="text" name="state" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Postal Code or Zip Code</td>
      <td><input type="text" name="zip" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><input type="text" name="country" value="" size="40"/></td>
    </tr>
    <tr><th colspan="2" bgcolor="#cccccc">Shipping Address (leave blank if as above)</th></tr>
    <tr>
      <td>Name</td>
      <td><input type="text" name="ship_name" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><input type="text" name="ship_address" value="" size="40"/></td>
    </tr>
    <tr>
      <td>City/Suburb</td>
      <td><input type="text" name="ship_city" value="" size="40"/></td>
    </tr>
    <tr>
      <td>State/Province</td>
      <td><input type="text" name="ship_state" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Postal Code or Zip Code</td>
      <td><input type="text" name="ship_zip" value="" size="40"/></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><input type="text" name="ship_country" value="" size="40"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
           your purchase, or Continue Shopping to add or remove items.</strong></p>
       <?php display_form_button("Purchase", "Purchase These Items"); ?>
      </td>
    </tr>
  </form>
  </table><hr />
<?php
}

function display_shipping($shipping) {
  // display table row with shipping cost and total price including shipping
?>
  <table border="0" width="100%" cellspacing="0">
  <tr><td align="left">Shipping</td>
      <td align="right"> <?php echo number_format($shipping, 2); ?></td></tr>
  <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
  </tr>
  </table><br />
<?php
}

function display_card_form($name) 
{
  //display form asking for credit card details
?>
  <table class="card_form_container">
  <form action="process.php" method="post">
  <tr><th colspan="2">Credit Card Details</th></tr>
  <tr>
    <td>Type</td>
    <td><select name="card_type">
        <option value="VISA">VISA</option>
        <option value="MasterCard">MasterCard</option>
        <option value="American Express">American Express</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Number</td>
    <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
  </tr>
  <tr>
    <td>AMEX code (if required)</td>
    <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
  </tr>
  <tr>
    <td>Expiry Date</td>
    <td>Month
       <select name="card_month">
       <option value="01">01</option>
       <option value="02">02</option>
       <option value="03">03</option>
       <option value="04">04</option>
       <option value="05">05</option>
       <option value="06">06</option>
       <option value="07">07</option>
       <option value="08">08</option>
       <option value="09">09</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       Year
       <select name="card_year">
       <?php
          $ccDate = "";
          
         for ($y = date("Y"); $y < date("Y") + 10; $y++) 
         {
           echo "<option value=\"".$y."\">".$y."</option>";
         }
       ?>
       </select>
  </tr>
  <tr>
    <td>Name on Card</td>
    <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      add or remove items</strong></p>
     <?php display_form_button('Purchase', 'Purchase These Items'); ?>
    </td>
  </tr>
  </table>
<?php
}

function display_cart($cart, $change = true, $images = 1) {
  // display items in shopping cart
  // optionally allow changes (true or false)
  // optionally include images (1 - yes, 0 - no)

  // echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
  //       <form action=\"show_cart.php\" method=\"post\">
  //       <tr><th bgcolor=\"#cccccc\">Item</th>
  //       <th bgcolor=\"#cccccc\">Price</th>
  //       <th bgcolor=\"#cccccc\">Quantity</th>
  //       <th bgcolor=\"#cccccc\">Total</th>
  //       </tr>";
         
  // echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" class=\"cart_container\">
  //       <form action=\"show_cart.php\" method=\"post\">
  //       <tr>
  //         <th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
  //         <th bgcolor=\"#cccccc\">Price</th>
  //         <th bgcolor=\"#cccccc\">Quantity</th>
  //         <th bgcolor=\"#cccccc\">Total</th>
  //       </tr>";
        
  echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" class=\"cart_container\">
        <form action=\"show_cart.php\" method=\"post\">
        <tr>
          <th colspan=\"".(1 + 0)."\" bgcolor=\"#cccccc\">Item</th>
          <th bgcolor=\"#cccccc\">Price</th>
          <th bgcolor=\"#cccccc\">Quantity</th>
          <th bgcolor=\"#cccccc\" colspan=\"2\">Total</th>
        </tr>";

  //display each item as a table row
  foreach ($cart as $productid => $qty)  
  {
    $product = get_product_details($productid);
    echo "<tr>";
    
    if($images == true) 
    {
      echo "<td>";
      if (file_exists("images/".$productid.".jpg")) 
      {
        echo "<img src=\"images/".$productid.".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"100px\" height=\"100px\ />";
                  
        $size = GetImageSize("images/".$productid.".jpg");
        if(($size[0] > 0) && ($size[1] > 0)) 
        {
          // echo "<img src=\"images/".$productid.".jpg\"
          //         style=\"border: 1px solid black\"
          //         width=\"".($size[0]/3)."\"
          //         height=\"".($size[1]/3)."\"/>";
        }
      } 
      else 
      {
         //echo "&nbsp;";
      }
      
      echo "</td>";
    }
    echo "<td align=\"left\">
          <a href=\"show_product.php?productid=".$productid."\">".$product['title']."</a></td>"
          ."<td align=\"center\">\$".number_format($product['price'], 2)."</td>
          <td align=\"center\">";

    // if we allow changes, quantities are in text boxes
    if ($change == true) 
    {
      echo "<input type=\"text\" name=\"".$productid."\" value=\"".$qty."\" size=\"3\">";
    } 
    else 
    {
      echo $qty;
    }
    echo "</td><td align=\"center\" colspan=\"2\">\$".number_format($product['price']*$qty,2)."</td></tr>\n";
  }
  // display total row
  echo "<tr>
        <th colspan=\"".(2+0)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";
        
  // echo "<tr>
  //       <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
  //       <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
  //       <th align=\"center\" bgcolor=\"#cccccc\">
  //           \$".number_format($_SESSION['total_price'], 2)."
  //       </th>
  //       </tr>";

  // display save change button
  if($change == true) 
  {
    echo "<tr>
            <td colspan=\"".(2+$images)."\">&nbsp;</td>
            <td align=\"center\">
               <input type=\"hidden\" name=\"save\" value=\"true\"/>
               <input class= \"btn\" type=\"submit\" value=\"Save Changes\" alt=\"Save Changes\"/>
            </td>
          </tr>";
          
    // echo "<tr>
    //       <td colspan=\"".(2+$images)."\">&nbsp;</td>
    //       <td align=\"center\">
    //         <input type=\"hidden\" name=\"save\" value=\"true\"/>
    //         <input type=\"image\" src=\"images/save-changes.gif\"
    //                 border=\"0\" alt=\"Save Changes\"/>
    //       </td>
    //       <td>&nbsp;</td>
    //       </tr>";
  }
  echo "</form></table>";
}

function display_login_form($form_type = '', $title = '') 
{
  // dispaly form asking for name and password
?>
<div class=\"login_form_container\">
<?php echo $title ? "<h2><span>".$title."</span></h2>" : ''?>
 <form class="form-horizontal" method="post" action="my_account.php">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputEmail3" name="username" placeholder="Username">
      </div>
    </div>
    <?php 
        if ($form_type == 'new_user')
        {
    ?>
    <div class="form-group">
      <label for="inputEmail4" class="col-sm-2 control-label">Confirm Username</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputEmail4" name="username1" placeholder="Confirm Username">
      </div>
    </div>
    <?php 
        }
    ?>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3" name="passwd" placeholder="Password">
      </div>
    </div>
    <?php 
        if ($form_type == 'new_user')
        {
    ?>
    <div class="form-group">
      <label for="inputPassword4" class="col-sm-2 control-label">Confirm Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword4" name="passwd1" placeholder="Confirm Password">
      </div>
    </div>
    <?php 
        }
    ?>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
      <?php 
        if ($form_type != 'new_user')
        {
      ?>
          <button type="submit" class="btn btn-default">Log in</button>
          <a href="login.php?new_user=new_user">New User? Click Here</a>
      <?php 
        }
        else
        {
      ?>
          <button type="submit" class="btn btn-default">Sign Up</button>
          <input type="hidden" name="new_user" value="new_user" />
      <?php 
        }
      ?>
      </div>
    </div>
  </form>
</div>
<?php

}

?>


<?php


function display_admin_menu($user_type = '')
{
  echo "<a href=\"index.php\">Go to main site</a><br />";
  
  if ($user_type == 'Standard')
  {
    echo "<a href=\"view_orders.php?action=order_list\">View order history</a><br />";
  }
  else
  {
    echo "<a href=\"insert_category_form.php\">Add a new category</a><br />";
    echo "<a href=\"insert_product_form.php\">Add a new product</a><br />";
  }

  echo "<a href=\"change_password_form.php\">Change your password</a><br />";
}

function display_order_list($orders_array)
{
  if (is_array($orders_array))
  {
    echo "<h2 style=\"text-align: center\">Order History</h2>";
    
    echo "<table class=\"table table-hover order_list_container\">
          <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Ship Name</th>
            <th>Total Amount</th>
            <th>Status</th>
          </tr>";
    
    foreach ($orders_array as $orders)
    {
      $orderid = $orders['orderid'];
      
      echo "<tr>
              <td>".$orderid."</td>
              <td>".$orders['date']."</td>
              <td>".$orders['ship_name']."</td>
              <td>$".$orders['amount']."</td>
              <td>".$orders['order_status']."</td>
              <td><a href=\"view_orders.php?action=order_detail&orderid=".$orderid."\">View</a></td>
            </tr>";
    }
    
    echo "</table>";
    do_html_URL("my_account.php", "Return to My Account");
  }
}

function display_order_detail($order_head_object, $order_detail_array)
{
  if (is_array($order_detail_array) & $order_head_object)
  {
      $orderid = $order_head_object->orderid;
      $date = $order_head_object->date;
      $order_status = $order_head_object->order_status;
      
      $ship_name = $order_head_object->ship_name;
      $ship_address = $order_head_object->ship_address;
      $ship_city = $order_head_object->ship_city;
      $ship_state = $order_head_object->ship_state;
      $ship_zip = $order_head_object->ship_zip;
      $ship_country = $order_head_object->ship_country;
      
      $order_head_text = "<div class=\"order_detail_container\">
                         <h2>Order ID: ".$orderid."</h2>".
                         "<p><span>Order Date:</span> ".$date."<br>".
                         "<span>Order Status:</span> ".$order_status."</p>".
                         "<p><span>Ship Address:</span><br>".
                         "".$ship_name."<br>".
                         "".$ship_address."<br>".
                         "".$ship_city.", ".$ship_state." ".$ship_zip."<br>".                  
                         "".$ship_country."</p>";
      
      $order_detail_text = "<table style=\"width: 100%\">
                            <tr>
                              <th>Quantity</th>
                              <th>Product Title</th>
                              <th>Price</th>
                            </tr>";
      $total = 0;
      foreach ($order_detail_array as $order_detail)
      {
        $title = $order_detail['title'];
        $price = $order_detail['price'];
        $quantity = $order_detail['quantity'];
        
        $order_detail_text .= "<tr>
                                <td>".$quantity."</td>
                                <td>".$title."</td>
                                <td>$".$price."</td>
                               </tr>";
        $total += $price;
      }
      $order_detail_text .= "<tr class=\"order_detail_footer\">
                                <td></td>
                                <td></td>
                                <td><span>Total:</span> $".$total."</td>
                            </tr>";
      $order_detail_text .= "</table>
                           </div><br>";
       
      echo $order_head_text;
      echo $order_detail_text;
      do_html_URL("view_orders.php?action=order_list", "Return to Order History");
  }
  
}

function display_button($target, $name) 
{
  echo "<div class=\"btnContainer\">
          <a href=\"".$target."\">
            <input class= \"btn\" type=\"button\" value=\"".$name."\"/>
          </a>
        </div>";
}

function display_form_button($name, $alt) 
{
 echo "<div class=\"btnContainer\">
        <input class= \"btn\" type=\"submit\" value=\"".$name."\" alt=\"".$alt."\"/>
       </div>";
}

?>
