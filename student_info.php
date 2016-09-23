<?php
/*******************************************************************************
 * File Name   : student_info.php
 * Description : The student info page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/16/15 - Created
 *			   : 04/17/15 - Added select menus for major, grad semester & yr.
 *			   : 04/21/15 - Added session variables
 *			   : 04/25/15 - Updated major post values
 *			   : 04/25/15 - Added back button capability to all forms
 *			   : 05/01/15 - Added form validation (making sure not empty)
 *			   : 05/02/15 - Added debugging session variable switch
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

// INITIALIZE ALL CONTACT INFO VARIABLES
///////////////////////////////////
///////////////////////////////////
// CONTACT INFO SESSION VARIABLES
$_SESSION["FIRST_NAME"] = $_POST['firstName'];
$_SESSION["LAST_NAME"] = $_POST['lastName'];
$_SESSION["ADDRESS"] = $_POST['address'];
$_SESSION["CITY"] = $_POST['city'];
$_SESSION["STATE"] = $_POST['state'];
$_SESSION["ZIP_CODE"] = $_POST['zipCode'];
$_SESSION["EMAIL_ADDRESS"] = $_POST['email'];
$_SESSION["PHONE_NUMBER"] = $_POST['phone'];

// DEBUGGING SESSION VARIABLES
$DEBUGGING_CONTENT='
	'.$_SESSION["FIRST_NAME"].' <br>
	'.$_SESSION["LAST_NAME"].' <br>
	'.$_SESSION["ADDRESS"].' <br>
	'.$_SESSION["CITY"].' <br>
	'.$_SESSION["STATE"].' <br>
	'.$_SESSION["ZIP_CODE"].' <br>
	'.$_SESSION["EMAIL_ADDRESS"].' <br>
	'.$_SESSION["PHONE_NUMBER"].' <br>
';
///////////////////////////////////
///////////////////////////////////

// Initialize helper variables
$title="Scholarship App";
$page = new pages();
$page->ecs_top($title);
$content = '';
$year = date("Y");

// Begin page content here
if ($_SESSION["DEBUGGING"] == 1) $content.='<h2>DEBUGGING MODE</h2>';
$content.='
<div align="center">

<!-- BACK BUTTON / TITLE -->
<p style="text-align:center;"><strong>
	<button style="font-size:8pt;" onclick="window.history.back();">BACK</button>
	ECS SCHOLARSHIP APPLICATION | STUDENT INFO
</strong></p><hr>

<!-- THE FORMS FOR THE USERS STUDENT INFORMATION -->
<br><h1 style="color:black;"> 
	Please Fill Out Your Student Information:<b style="color:red;">*</b> 
</h1><br>
<script src="validate.js"></script>
<form id="studentForm" name="studentForm" action="scholarship_info.php" method="post" onsubmit="checkform(this)">

<table id="application_table" border="0">
<!-- STUDENT INFO FIELDS -->
<tr>
	<td><label> Sac State Student ID:<b style="color:red;">*</b> </label></td>
	<td><input name="studentID" type="text" maxlength="9" placeholder="000000000" required /></td>
</tr>

<!-- AREA OF INTEREST / MAJOR FIELD -->
<tr>
	<td><label> Major:<b style="color:red;">*</b> </label></td>
	<td>
		<select name="major" value="Civil Engineering" required >
			<option value="">--- Select a Major ---</option>
			<option value="Civil Engineering">Civil Engineering</option>
			<option value="Computer Engineering">Computer Engineering</option>
			<option value="Computer Science">Computer Science</option>
			<option value="Construction Management">Construction Management</option>
			<option value="Electrical and Electronic Engineering">Electrical and Electronic Engineering</option>
			<option value="Mechanical Engineering">Mechanical Engineering</option>
			<option value="Other">Other</option>
		</select>
	</td>
</tr>

<!-- EXPECTED GRAD DATE FIELDS -->
<tr>
	<td><label> Expected Graduation Semester:<b style="color:red;">*</b> </label></td>
	<td>
		<input type="radio" name="gradSemester" value="Fall" required > Fall<br>
		<input type="radio" name="gradSemester" value="Spring" required > Spring<br>
	</td>
</tr>
<tr>
	<td><label> Expected Graduation Year:<b style="color:red;">*</b> </label></td>
	<td>
		<select name="gradYear" required >
			<option value="">--- Select a Year ---</option>
';

// For loop that will manage the years for the expected grad yr by itself
// Allow for for 6 years ahead of this year for expected grad date
for ($i = 0; $i < 6; $i++)
{
	$content.='<option value="'.$year.'">'.$year.'</option>';
	$year++;
}

$content.='</select>
	</td>
</tr>

<!-- SAC STATE GPA FIELD -->
<tr>
	<td><label> Sacramento State GPA:<b style="color:red;">*</b> </label></td>
	<td><input name="sacGPA" type="text" maxlength="4" placeholder="3.85" required /></td>
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
if ($_SESSION["DEBUGGING"] == 1) echo $DEBUGGING_CONTENT;

// Footer
$page->ecs_bottom();
?>