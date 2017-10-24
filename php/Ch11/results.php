<html>
<head>
  <title>Product Search Results</title>
</head>
<body>
<h1>Product Search Results</h1>
<?php

  function search_query($searchtype, $searchterm)
  {
    $query = "select * from products where ".$searchtype." like '%".$searchterm."%'";
    return $query;
  }

  // create short variable names
  //$searchtype=$_POST['searchtype'];
  $searchterm=trim($_POST['searchterm']);

  //if (!$searchtype || !$searchterm) 
  if (!$searchterm) 
  {
     echo 'You have not entered search details.  Please go back and try again.';
     exit;
  }

  if (!get_magic_quotes_gpc())
  {
    //$searchtype = addslashes($searchtype);
    $searchterm = addslashes($searchterm);
  }

  @ $db = new mysqli('localhost', 'cisw31_final_db', 'password', 'cisw31_final_db');

  if (mysqli_connect_errno()) 
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
  
  // Start of MySQL retrieve column name
  $query = "select * from products limit 1";
  $result = $db->query($query);
  $finfo = mysqli_fetch_fields($result);
  
  $all_column_names = '';
  foreach ($finfo as $val) 
  {
    //echo "<p>".$val->name."<p>";
    $all_column_names .= $val->name.",";
  }
  // End of MySQL retrieve column name
  
  echo "<p>".$all_column_names."</p>";

  $searchtermarray = explode(' ', $searchterm);
  $column_array = explode(',', $all_column_names);
  
  $column_array_length = count($column_array);
  $display = '';
  $count = 0;
  $pid_array = array();
  
  foreach($searchtermarray as $term)
  {
    for ($x = 0; $x < $column_array_length; $x++) 
    {
      if ($column_array[$x])
      {
        $searchtype = $column_array[$x];
        $query = search_query($searchtype, $term);
        echo "<p>".$query."</p>";
        echo "searchtype: ".$searchtype;
        echo "<br>";
        
        $result = $db->query($query);
        $num_results = $result->num_rows;
        echo "<p>".$num_results."</p>";
        
        for ($i = 0; $i < $num_results; $i++) 
        {
          $products = $result->fetch_assoc();
          
          $title = $products['title'];
          $description = $products['description'];
          $productid = $products['productid'];
          $price = $products['price'];
          
          if (array_key_exists($productid, $pid_array) === false)
          {
            $display .= "<p><strong>".($i+1).". Title: ";
            $display .= htmlspecialchars(stripslashes($title));
            $display .= "</strong><br />Description: ";
            $display .= stripslashes($description);
            $display .= "<br />Product ID: ";
            $display .= stripslashes($productid);
            $display .= "<br />Price: ";
            $display .= stripslashes($price);
            $display .= "</p>";
            
            $pid_array[$productid] = $productid;
             
            $count++;
          }
        }
      }
    }
  }

  $result->free();
  $db->close();

  echo "<p>Number of products found: ".$count."</p>";
  echo $display;
?>
</body>
</html>
