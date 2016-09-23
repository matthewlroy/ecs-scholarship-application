<?php
/*******************************************************************************
 * File Name   : contact_info.php
 * Description : The contact info page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/16/15 - Created
 *			   : 04/21/15 - Added session variables
 *			   : 04/25/15 - Added back button capability to all forms
 *			   : 05/01/15 - Added form validation (making sure not empty)
 *			   : 05/16/15 - Updated debugging to depend on DEBUG session var
*******************************************************************************/
// EXPIRE SESSION FIX 
//(http://stackoverflow.com/a/27199534)
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too

// Session / Includes
session_start();
include_once('../../portal/pages.php');

// Initialize helper variables
$title="Scholarship App";
$page = new pages();
$page->ecs_top($title);
$content = '';

// Begin page content here
if ($_SESSION["DEBUGGING"] == 1) $content.='<h2>DEBUGGING MODE</h2>';
$content.='
<div align="center">

<!-- BACK BUTTON / TITLE -->
<p style="text-align:center;"><strong>
	<button style="font-size:8pt;" onclick="window.history.back();">BACK</button>
	ECS SCHOLARSHIP APPLICATION | CONTACT INFO
</strong></p><hr>

<!-- THE FORMS FOR THE USERS CONTACT INFORMATION -->
<br><h1 style="color:black;"> 
	Please Fill Out Your Contact Information:<b style="color:red;">*</b> 
</h1><br>
<script src="validate.js"></script>
<form id="contactForm" name="contactForm" action="student_info.php" method="post" onsubmit="checkform(this)">

<table id="application_table" border="0">
<!-- NAME FIELDS -->
<tr>
	<td><label> First Name:<b style="color:red;">*</b> </label></td>
	<td><input name="firstName" type="text" maxlength="40" placeholder="John" required /></td>
</tr>
<tr>
	<td><label> Last Name:<b style="color:red;">*</b> </label></td>
	<td><input name="lastName" type="text" maxlength="40" placeholder="Doe" required /></td>
</tr>

<!-- ADDRESS FIELDS -->
<tr>
	<td><label> Address:<b style="color:red;">*</b> </label></td>
	<td><input name="address" type="text" maxlength="40" placeholder="6000 J St" required /></td>
</tr>
<tr>
	<td><label> City:<b style="color:red;">*</b> </label></td>
	<td><input name="city" type="text" maxlength="40" placeholder="Sacramento" required /></td>
</tr>
<tr>
	<td><label> State:<b style="color:red;">*</b> </label></td>
	<td><input name="state" type="text" maxlength="2" placeholder="CA" required /></td>
</tr>
<tr>
	<td><label> Zip Code:<b style="color:red;">*</b> </label></td>
	<td><input name="zipCode" type="text" maxlength="5" placeholder="95819" required /></td>
</tr>

<!-- EMAIL / PHONE -->
<tr>
	<td><label> Email:<b style="color:red;">*</b> </label></td>
	<td><input name="email" type="text" maxlength="40" placeholder="email@csus.edu" required /></td>
</tr>
<tr>
	<td><label> Phone:<b style="color:red;">*</b> </label></td>
	<td><input name="phone" type="text" maxlength="14" placeholder="(000) 000-0000" required /></td>
</tr>

<!-- NOTE TO USER ABOUT WHAT FIELDS ARE REQUIRED -->
<tr>
<td colspan="2"> <b style="color:red;">*</b> Required Fields </td>
</tr>
</table> <!-- END TABLE STYLING -->

<!-- FORM CONTINUE / RESET BUTTONS -->
<span id="upButton"> 
<input name="submit" type="submit" value="CONTINUE" />
</span>

<span id="delButton"> 
<input name="reset" type="reset" value="RESET" />  
</span>
</form> <!-- END FORM STYLING -->

</div>
<!-- END THE PAGE DESIGN (HTML) -->
';

echo $content;

// Footer
$page->ecs_bottom();
?>