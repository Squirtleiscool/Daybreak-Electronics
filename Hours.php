<?php
  include ('product_sc_fns.php');
  session_start();
  do_html_header("Store Hours");
?>

<div class="middlecontainer1">
 <div class="info"> 
    <h2 style="border-bottom: 1px solid black;">Store Hours</h2><br/>
    <strong>Sunday: 10:00AM - 8:00PM <br/>
    Monday: 10:00AM - 9:00PM <br />
    Tuesday: 10:00AM - 9:00PM <br />
    Wednesday: 10:00AM - 9:00PM <br />
    Thursday: 10:00AM - 9:00PM <br />
    Friday: 10:00AM - 9:00PM <br />
    Saturday: 10:00AM - 9:00PM</strong><br/><br/>
    *<i>Changes for Select Holidays</i>*
    </div><br/>
    
<iframe src="https://calendar.google.com/calendar/embed?title=Daybreak%20Electronics&amp;
height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=mrsquirtleiscool%40gmail.com&amp;
color=%2329527A&amp;src=en.usa%23holiday%40group.v.calendar.google.com&amp;
color=%2329527A&amp;ctz=America%2FLos_Angeles" style="border-width:0" width="800" 
height="600" frameborder="0" scrolling="no"></iframe>

    
</div>

<?php
  do_html_footer();
?>