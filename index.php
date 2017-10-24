<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Welcome to Daybreak Electronics");
?>

<head>
  <!-- Start WOWSlider.com HEAD section -->
  <link rel="stylesheet" type="text/css" href="engine1/style.css" />
  <script type="text/javascript" src="engine1/jquery.js"></script>
  <!-- End WOWSlider.com HEAD section -->
</head>

<!-- Start WOWSlider.com BODY section -->
<div id="wowslider-container1">
<div class="ws_images"><ul>
		<li><img src="data1/images/ps4vsxboxone.jpg" alt="Claim your side before Daybreak!" title="Claim your side before Daybreak!" id="wows1_0"/>#PS4vsXboxOne </li>
		<li><a href="show_product.php?productid=Galaxys7" target="_self"><img src="data1/images/samsunggalaxys7.jpg" alt="Samsung Galaxy S7 is here." title="Samsung Galaxy S7 is here." id="wows1_1"/></a>Purchase before supplies run out!</li>
		<li><img src="data1/images/laptops.jpg" alt="Our vintage laptops" title="Our vintage laptops" id="wows1_2"/></li>
	</ul></div>
	<div class="ws_bullets"><div>
		<a href="#" title="Claim your side before Daybreak!"><span><img src="data1/tooltips/ps4vsxboxone.jpg" alt="Claim your side before Daybreak!"/>1</span></a>
		<a href="#" title="Samsung Galaxy S7 is here."><span><img src="data1/tooltips/samsunggalaxys7.jpg" alt="Samsung Galaxy S7 is here."/>2</span></a>
		<a href="#" title="Our vintage laptops"><span><img src="data1/tooltips/laptops.jpg" alt="Our vintage laptops"/>3</span></a>
	</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.com/vi">image slider</a> by WOWSlider.com v8.7</div>
<div class="ws_shadow"></div>
</div>	
<script type="text/javascript" src="engine1/wowslider.js"></script>
<script type="text/javascript" src="engine1/script.js"></script>
<!-- End WOWSlider.com BODY section -->
 <div class="freeshipping"><center><img src="img/free-shipping.png" style="width:12%;"></img>Free Shipping on all PURCHASES! Limited time offer.<img src="img/free-shipping.png" style="width:12%;"></img></center></div>
 
 <br />
 <div class="middlecontainer">
  <center><h1>Welcome to Daybreak Electronics!</h1></center>
 <br />
 
   <div class="subject">
      <h4> New Products </h4>
   </div>
   <div class="row">
   <?php 
       $num_display_products = 4;
       $bootstrap_grid_type = "col-lg-3";
       
       $random_product_id_array = get_random_productid($num_display_products);
       if (is_array($random_product_id_array))
       {
          echo "<div>";
          foreach ($random_product_id_array as $rpid)
          {
              $name = $rpid['productid'];
              $title = $rpid['title'];
              $price = $rpid['price'];
              $url = "show_product.php?productid=".$name;
              
              // http://stackoverflow.com/questions/11918491/using-two-css-classes-on-one-element
              echo "<div class=\"".$bootstrap_grid_type." clickable-row random_display_container\" data-href=\"".$url."\">
                        <a href=\"".$url."\">
                         <img src=\"images/".$name.".jpg\" alt=\"".$name."\"><br>
                         ".$title."<br/><span class=\"pricetext\">$".$price."</span>
                        </a>
                    </div>";    
          }
          echo "</div>";
       }
   ?>
   </div>
  </div>
  
  <div class="middlecontainer">
   <div class="subject2">
     <h4> Popular Products</h4>
   </div>
   <div class="row">
   <?php 
       $popular_product_id_array = get_popular_productid($num_display_products);
       if (is_array($popular_product_id_array))
       {
          echo "<div>";
          foreach ($popular_product_id_array as $ppid)
          {
              $name = $ppid['productid'];
              $title = $ppid['title'];
              $price = $ppid['price'];
              $url = "show_product.php?productid=".$name;
              
              // http://stackoverflow.com/questions/11918491/using-two-css-classes-on-one-element
              echo "<div class=\"".$bootstrap_grid_type." clickable-row random_display_container\" data-href=\"".$url."\">
                      <a href=\"".$url."\">
                       <img src=\"images/".$name.".jpg\" alt=\"".$name."\"><br>
                       ".$title."<br/><span class=\"pricetext\">$".$price."</span>
                      </a>
                    </div>";
          }
          echo "</div>";
       }
   ?>
   </div>
  </div><br/>
 
<div class="middlecontainer">
 <table>
   <tr>
    <td style="width:50%;border:none">
    <h4 style=" font-weight: bold;
                text-align: center;
                font-family: Courier New, Times, serif;
                color: black;
                background-color: #f28523;
                border: 2px groove #f28523;
                border-radius: 10px
               "> Employee of the Month </h4>
    </td>
    <td style="width:50%; border:none">
    <h4 style=" font-weight: bold;
                text-align: center;
                font-family: Courier New, Times, serif;
                color: black;
                background-color: #fdbe16;
                border: 2px groove #fdbe16;
                border-radius: 10px
                "> Shop through Daybreak </h4> 
    </td>
   </tr>
   <tr>
    <td style="width:50%; border:none">
     <center><img src="img/EmployeeoftheMonth.jpg" style="width: 50%; margin-top:5px">
     </img><br /><p><i>"I just want 
     to thank my boss for giving me the oppuntunity
     to give back to the tech community. I will celebrate with some strong 
     vodka!"</i></p><div style="width: 50%; text-align: center; font-family: 'Courier New', Arial, Helvetica, sans-serif;font-size: 20px;color: blue; font-weight: bold"> ~ Victor Zamora
     </center>
   </td>
   <td style="width:50%; border:none">
    <center><img src="img/PriceMatch.jpg" style="width: 50%;">
    </img><br/><p>Nobody can challenge us in Price! <br />
    <a href="PriceMatch.php">Learn more</a></p>
    <img src="img/Locator.jpg" style="width: 50%;"></img><br/>
    <p>Find the location of our store here. <br />
    <a href="Contact.php">Click Here</a></p></center>
   </td>
  </tr>
 </table>

</div>

<br />

<?php
  do_html_footer();
?>
