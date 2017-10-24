<?php
// This file contains functions used by the admin interface
// for the Book-O-Rama shopping cart.

function display_category_form($category = '', $maincatid = '') {
// This displays the category form.
// This form can be used for inserting or editing categories.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_category.php.
// To update, pass an array containing a category.  The
// form will contain the old data and point to update_category.php.
// It will also add a "Delete category" button.

  // if passed an existing category, proceed in "edit mode"
  $edit = is_array($category);

  // most of the form is in plain HTML with some
  // optional PHP bits throughout
?>
  <form class="form-inline" method="post" action="<?php echo $edit ? 'edit_category.php' : 'insert_category.php'; ?>">
      <div class="form-group">
        <label for="exampleInputName2">Category Name:</label>
        <input type="text" class="form-control" id="exampleInputName2" maxlength="255" placeholder="Category Name" name="catname"
            value="<?php echo $edit ? $category['catname'] : ''; ?>">
      </div>
      <?php
         if ($edit) 
         {
            echo "<input type=\"hidden\" name=\"catid\" value=\"".$category['catid']."\" />";
         }
         
         if ($maincatid)
         {
            echo "<input type=\"hidden\" name=\"maincatid\" value=\"".$maincatid."\" />";
         }
         
         if ($edit)
         {
             
             echo "<button type=\"submit\" class=\"btn btn-default\">Update Category</button>";
             
             echo "<button type=\"submit\" formaction=\"delete_category.php?catid=".$category['catid']."\" 
                    class=\"btn btn-default\" formmethod=\"post\">Delete category
                   </button>";
         }
         else
         {
             echo "<button type=\"submit\" class=\"btn btn-default\">Add Category</button>";
         }
      ?>
      <!--<button type="submit" class="btn btn-default">Add Category</button>-->
    </form>
<?php
}

function display_product_form($product = '') 
{
// This displays the product form.
// It is very similar to the category form.
// This form can be used for inserting or editing books.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_product.php.
// To update, pass an array containing a product.  The
// form will be displayed with the old data and point to update_book.php.
// It will also add a "Delete product" button.


  // if passed an existing product, proceed in "edit mode"
  $edit = is_array($product);
  // most of the form is in plain HTML with some
  // optional PHP bits throughout
?>
    <form method="post" action="<?php echo $edit ? 'edit_product.php' : 'insert_product.php';?>">
        
      <div class="form-group">
        <label for="InputProductID">Product ID:</label>
        <input type="text" class="form-control" id="InputProductID" maxlength="255" placeholder="Product ID" name="productid"
            value="<?php echo $edit ? $product['productid'] : ''; ?>" 
            <?php echo $edit ? 'readonly' : ''; ?> >
      </div>
      
      <div class="form-group">
        <label for="InputTitle">Title:</label>
        <input type="text" class="form-control" id="InputTitle" maxlength="255" placeholder="Title" name="title" 
            value="<?php echo $edit ? $product['title'] : ''; ?>">
      </div>
      
      <div class="form-group">
        <label for="InputCategoryID">Category:</label>
        <select class="form-control" id="InputCategoryID" name="catid">
        <?php
          // list of possible categories comes from database
          $cat_array = get_categories(true);
          foreach ($cat_array as $thiscat) 
          {
               echo "<option value=\"".$thiscat['catid']."\"";
               // if existing book, put in current catgory
               if (($edit) && ($thiscat['catid'] == $product['catid'])) 
               {
                   echo " selected";
               }
               echo ">".$thiscat['catname']."</option>";
          }
        ?>
        </select>
      </div>
      
      <div class="form-group">
        <label for="InputPrice">Price:</label>
        <input type="text" class="form-control" id="InputPrice" placeholder="Price" name="price" 
            value="<?php echo $edit ? $product['price'] : ''; ?>">
      </div>
      
      <div class="form-group">
        <label for="InputDescription">Description:</label>
        <textarea class="form-control" rows="3" cols="50" id="InputDescription" name="description">
            <?php echo $edit ? trim($product['description']) : ''; ?>
        </textarea>
      </div>
      
      <?php
        if ($edit)
        {
            // we need the old productid to find book in database
            // if the productid is being updated
            echo "<input type=\"hidden\" name=\"oldproductid\" value=\"".$product['productid']."\" />";
            echo "<button type=\"submit\" class=\"btn btn-default\">Update Product</button>";
            echo "<button type=\"submit\" class=\"btn btn-default\" formmethod=\"post\" 
                    formaction=\"delete_product.php?productid=".$product['productid']."\" >
                    Delete Product
                  </button>";
        }
        else
        {
            echo "<button type=\"submit\" class=\"btn btn-default\">Add Product</button>";
        }
      ?>
    </form>
<?php
}

function display_password_form() 
{
// displays html change password form
?>
    <form action="change_password.php" method="post">
      <div class="form-group" >
        <label for="InputOldPassword">Old password</label>
        <input type="password" class="form-control" id="InputOldPassword" 
            placeholder="Old Password" name="old_passwd">
      </div>
      <div class="form-group">
        <label for="InputNewPassword">New password</label>
        <input type="password" class="form-control" id="InputNewPassword" 
            placeholder="New Password" name="new_passwd">
      </div>
      <div class="form-group">
        <label for="InputRepeatNewPassword">Repeat new password</label>
        <input type="password" class="form-control" id="InputRepeatNewPassword" 
            placeholder="Repeat New Password" name="new_passwd2">
      </div>
      <button type="submit" class="btn btn-default">Change Password</button>
    </form>
<?php
}

function insert_category($catname, $maincatid = '') 
{
  // inserts a new category into the database
  $conn = db_connect();
   
  $stmt = $conn->prepare("select * from categories where catname = ?");
  $stmt->bind_param("s", $catname);
  $stmt->execute();
  $result = $stmt->fetch();
  
  if (($result != '') || ($result != null)) 
  {
     return false;
  }
   
   $stmt = $conn->prepare("insert into categories (catname, subcatid) values (?, ?)");
   $stmt->bind_param("ss", $catname, $maincatid);
   $stmt->execute();
   $result = $stmt->affected_rows;

   
   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}

function insert_product($productid, $title, $catid, $price, $description) {
   // insert a new product into the database

   $conn = db_connect();

   $stmt = $conn->prepare("select * from products where productid = ?");
   $stmt->bind_param("s", $productid);
   $stmt->execute();
   $result = $stmt->fetch();
   
   
   if (($result != '') || ($result != 0)) 
   {
      return false;
   }

   $stmt = $conn->prepare("insert into products (productid, title, catid, price, description) values (?, ?, ?, ?, ?)");
   $stmt->bind_param("ssids", $productid, $title, $catid, $price, $description);
   $stmt->execute();
   $result = $stmt->affected_rows;
             
   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}

function update_category($catid, $catname) {
// change the name of category with catid in the database

   $conn = db_connect();
   
   $stmt = $conn->prepare("update categories set catname = ? where catid = ?");
   $stmt->bind_param("ss", $catname, $catid);
   $stmt->execute();
   $result = $stmt->affected_rows;
   
   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}

function update_product($oldproductid, $productid, $title, $catid,
                     $price, $description) 
{
// change details of product stored under old productid in
// the database to new details in arguments

   $conn = db_connect();

   $stmt = $conn->prepare("update products 
                            set productid = ?,
                            title = ?,
                            catid = ?,
                            price = ?,
                            description = ? 
                           where productid = ?");
   $trimmed_description = trim($description);
   $stmt->bind_param("ssidss", $productid, $title, $catid, $price, $trimmed_description, $oldproductid);
   $stmt->execute();
   $result = $stmt->affected_rows;

   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}

function delete_category($catid) {
// Remove the category identified by catid from the db
// If there are product in the category, it will not
// be removed and the function will return false.

   $conn = db_connect();
             
  $stmt = $conn->prepare("select * from products where catid = ?");
  $stmt->bind_param("s", $catid);
  $stmt->execute();
  $result = $stmt->fetch();

  if (($result != '') || ($result != null)) 
  {
        return false;
  }
   
   $stmt = $conn->prepare("delete from categories where catid = ?");
   $stmt->bind_param("s", $catid);
   $stmt->execute();
   $result = $stmt->affected_rows;
   
   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}


function delete_product($productid) {
// Deletes the product identified by productid from the database.

   $conn = db_connect();
   
   $stmt = $conn->prepare("delete from products where productid = ?");
   $stmt->bind_param("s", $productid);
   $stmt->execute();
   $result = $stmt->affected_rows;
   
   if (!$result) 
   {
     return false;
   } 
   else 
   {
     return true;
   }
}

?>
