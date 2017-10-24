<?php 
  include ('product_sc_fns.php'); 
?>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-inverse navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Logo is the homepage nav based on other electronics webstores -Anthony -->
       <a href="index.php"><img src="img/daybreaklogo.jpg" height="75px" width="112px"> <a class="navbar-brand" href="#"></a></a></img>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <div class="navbarleft">
        <ul class="nav navbar-nav">
          <li ><a href="About.php">About</a></li>
          <li><a href="Service.php">Services</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php 
                // get categories out of database
                $cat_array = get_categories();
                
                foreach ($cat_array as $category) 
                {
                  $url = "show_cat.php?catid=".$category['catid'];
                  $title = $category['catname'];
                  echo "<li>";
                  do_html_url($url, $title);
                  echo "</li>";
                }
              ?>
            </ul>
          </li>
          <li><a href="Contact.php">Contact</a></li>
        </ul>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <?php 
            $user_type = $_SESSION['user_type'];
            $username = $_SESSION['admin_user'];
            
            $numberOfItems = $_SESSION['items'];
            $totalPrice = number_format($_SESSION['total_price'],2);
            
            $login_text_display = "";
            $session_distination = "";
            if ($username)
            {
              $login_text_display = "Log Out, [".$username."]";
              $session_distination = "logout.php";
            }
            else
            {
              $login_text_display = "Sign In";
              $session_distination = "login.php";
            }
            
            $account_menu = "<li>
                              <a class=\"navbar-brand\" href=\"show_cart.php\">
                                <span class=\"glyphicon glyphicon-shopping-cart\" aria-hidden=\"true\"></span>".intval($numberOfItems)."
                              </a>
                            </li>
                            <li class=\"dropdown\">
                              <a href=\"#\" class=\"navbar-brand\" data-toggle=\"dropdown\" role=\"button\" 
                                aria-haspopup=\"true\" aria-expanded=\"false\">
                                <span class=\"glyphicon glyphicon-user\"></span>
                              </a>
                              <ul class=\"dropdown-menu\" id=\"my_account_menu_container\">";
                                
            if ($username)
            {
              $account_menu .= "<li>
                                  <a href=\"my_account.php\" class=\"navbar-brand\">
                                    <span>
                                      <span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span>
                                      My Account
                                    </span>
                                  </a>
                                </li>";
            }
                            
            $account_menu .= "<li>
                                  <a href=\"$session_distination\" class=\"navbar-brand\">
                                    <span>
                                      <span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span>
                                      $login_text_display
                                    </span>
                                  </a>
                                </li>
                              </ul>
                            </li>";
                  
            echo $account_menu;
          ?>
        </ul>
        <!-- Start of search bar -->
        <!-- http://stackoverflow.com/questions/18619740/how-to-add-a-search-box-with-icon-to-the-navbar-in-bootstrap-3 -->
        <form class="navbar-form" role="search" action="show_results.php" method="get">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term" size="19">
            <!--<input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term" size="9">-->
            <div class="input-group-btn">
                <button class="btn btn-default" name="Search" type="submit" style="padding: 2px 10px 2px 10px;" >
                  <i class="glyphicon glyphicon-search"></i>
                </button>
            </div>
        </div>
        </form>
        <!-- End of search bar -->
      </div><!--/.nav-collapse -->
    </div>
  </nav>