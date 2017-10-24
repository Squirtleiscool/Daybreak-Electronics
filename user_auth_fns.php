<?php

require_once('db_fns.php');

function register_account($username, $password)
{
  $conn = db_connect();
  
  $stmt = $conn->prepare("select * from admin where username= ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_object();
  $get_username = $user->username;
  
  if ($get_username == $username)
  {
    // Account exists
    $_SESSION['register_message'] = "A username of ".$username." already exists. Please use a different username.";
    return false;
  }
  else
  {
    $query = "insert into customers values ('', '', '', '', '', '', '')";
    $result = $conn->query($query);
    
    if (!$result) 
    {
       $_SESSION['register_message'] = "Could not connect to database. Please try again.";
       return false;
    }
    
    $customerid = $conn->insert_id;
    
    $user_type = 'Standard';
    $stmt = $conn->prepare("insert into admin (username, password, user_type, customerid) 
                            values (?, sha1(?), ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $user_type, $customerid);
    $stmt->execute();
    $result = $stmt->affected_rows;
    $username = $conn->insert_id;
    
    if (!$result) 
    {
      $_SESSION['register_message'] = "Could not connect to database. Please try again.";
      return false;
    }
    else
    {
      $_SESSION['register_message'] = "Thank you for registering an account with us.";
      return true;
    }
  }
}

function login($username, $password) 
{
// check username and password with db
// if yes, return true
// else return false

  // connect to db
  $conn = db_connect();
  if (!$conn) 
  {
    return 0;
  }
                         
  $stmt = $conn->prepare("select * from admin where username= ? and password = sha1(?)");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_object();
  $_SESSION['admin_user'] = $user->username;
  $_SESSION['user_type'] = $user->user_type;
                         
  if (!$result) 
  {
     return 0;
  }

  if ($result->num_rows > 0) 
  {
     return 1;
  } 
  else 
  {
     return 0;
  }
}

function check_admin_user($user_type) 
{
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['admin_user']) & $user_type == 'Administrator') 
  {
    return true;
  } 
  else 
  {
    return false;
  }
}

function change_password($username, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  if (login($username, $old_password)) 
  {

    if (!($conn = db_connect())) 
    {
      return false;
    }
                            
    $stmt = $conn->prepare("update admin set password = sha1(?) where username = ?");
    $stmt->bind_param("ss", $new_password, $username);
    $stmt->execute();
    $result = $stmt->affected_rows;
   
    if (!$result) 
    {
      return false;  // not changed
    } 
    else 
    {
      return true;  // changed successfully
    }
  } 
  else 
  {
    return false; // old password was wrong
  }
}

function get_account_customerid($username)
{
  $conn = db_connect();
  
  $stmt = $conn->prepare("select * from admin where username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if (!$result) 
  {
     return false;
  }
  
  $user = $result->fetch_object();
  $customerid = $user->customerid;
  
  return $customerid;
}



?>
