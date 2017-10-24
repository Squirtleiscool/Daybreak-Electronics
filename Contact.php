 <?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Welcome to Daybreak Electronics");
?>
 
  <div class="middlecontainer2">
   
    
     <div class="location"> <h2 style="border-bottom: 1px solid black;"> Location </h2>
     <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:440px;width:500px;'><div id='gmap_canvas' style='height:400px;width:500px;'></div><style>#gmap_canvas img{max-width:30%!height:auto!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:11,center:new google.maps.LatLng(34.04528678537745,-117.85038545850523),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(34.04528678537745,-117.85038545850523)});infowindow = new google.maps.InfoWindow({content:'<strong>Daybreak Electronics</strong><br>1100 N Grand Ave, Walnut, CA 91789<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
     </div>
     
   <div class="info">
    
    <h1>Daybreak Electronics </h1>
    <div class="address">1100 N Grand Ave, Walnut, CA 91789<br /><br/>
    Tel:(123)-456-7890 <br />
    Fax:(098)-765-4321 <br /><br/>
    GoGoGadget@dbelectronics.com
    </div>
   </div>
   
   <div class="info">
   
<form name="contactform" method="post" action="send_form_email.php">
  <h2 style="border-bottom: 1px solid black;">Contact Us</h2>
<table width=auto>
<tr>
 <td valign="top">
  <label for="first_name">First Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="last_name">Last Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td
</tr>
<tr>
 <td valign="top">
  <label for="telephone">Telephone Number</label>
 </td>
 <td valign="top">
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="comments">Comments *</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit">
 </td>
</tr>
</table>
</form>
  
  </div>
</div>

  <?php
  do_html_footer();
?>
