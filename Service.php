<?php
  include ('product_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Welcome to Daybreak Electronics");
  ?>

<div class="middlecontainer1">

<h2> Services </h2>

</div>

<div class="middlecontainer2">
 
  <img src="img/Electronics-Store2.jpg" style="float:right; margin:5px; width:50%;"></img>
  
<p> Daybreak Electronics offer services ranging from: </p>
<ul class="a">
  <li> 	Spyware and Virus Removal</li>
	<li>  Desktop and Laptop Repairs</li>
	<li>  Data Backup and Data Transfer</li>
	<li>  Data Recovery</li>
	<li>  PC Tune ups</li>
	<li>  Secure Data Wipe</li>
	<li>  Hardware Upgrades</li>
	<li>  Laptop Screen Repair</li>
	<li>  Printer Repairs</li>
	<li>  Network Troubleshooting</li>
	<li>  Laptop DC Jack Repair</li>
	<li>  Wireless Network Setup</li>
</ul>
<p> Call us today for prices on selected services!</p>
</div>


<?php
  do_html_footer();
?>