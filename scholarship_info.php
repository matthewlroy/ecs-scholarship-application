<?php
/*******************************************************************************
 * File Name   : scholarship_info.php
 * Description : The scholarship info page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/16/15 - Created
 *			   : 04/18/15 - Added auto generated list for scholarships from db
 *			   : 04/21/15 - Added session variables
 *			   : 04/25/15 - Added back button capability to all forms
 *			   : 05/02/15 - Added form validation (making sure at least one box)
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

// INITIALIZE ALL STUDENT INFO VARIABLES
///////////////////////////////////
///////////////////////////////////
// STUDENT INFO SESSION VARIABLES
$_SESSION["SAC_ID"] = $_POST['studentID'];
$_SESSION["MAJOR"] = $_POST['major'];
$_SESSION["GRAD_SEMESTER"] = $_POST['gradSemester'];
$_SESSION["GRAD_YEAR"] = $_POST['gradYear'];
$_SESSION["SAC_GPA"] = $_POST['sacGPA'];

// DEBUGGING SESSION VARIABLES
$DEBUGGING_CONTENT='
	'.$_SESSION["SAC_ID"].' <br>
	'.$_SESSION["MAJOR"].' <br>
	'.$_SESSION["GRAD_SEMESTER"].' <br>
	'.$_SESSION["GRAD_YEAR"].' <br>
	'.$_SESSION["SAC_GPA"].' <br>
';
///////////////////////////////////
///////////////////////////////////

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
	ECS SCHOLARSHIP APPLICATION | SCHOLARSHIP INFO
</strong></p><hr>

<!-- THE FORMS FOR THE USERS SCHOLARSHIP INFORMATION -->
<br><h1 style="color:black;"> 
	Please Fill Out Your Scholarship Information:<b style="color:red;">*</b> 
</h1><br>
<script src="validate.js"></script>
<form id="scholarshipForm" name="scholarshipForm" action="course_info.php" method="post" onsubmit="return checkboxes(this);">

<table id="application_table" border="0">
<!-- SCHOLARSHIPS APPLYING FOR FIELDS -->
<tr>
	<td><label> Check all scholarships applying for:<b style="color:red;">*</b> </label></td>
	<td>';
	
// For loop that will manage the selecting of scholarships
//<!--<input type="checkbox" name="selectScholarships" value="Test"> Test<br>-->
// Connect to the scholarship database
mysql_connect('mysql.ecs.csus.edu','design_web','a8c51ff99e5b055909d860ad842f27cc44021435')
	or die ("Could not connect to mysql.ecs.csus.edu- ".mysql_error());
mysql_select_db('ecsweb') or die ("Could not connect to ecsweb- ".mysql_error());

// Select the names of the scholarships from ecsweb database, scholarshipList table
$sql="SELECT names FROM scholarshipList ORDER BY names ASC"; // Construct query
$result = mysql_query($sql); // Query db
if (!$result) die ("Could not query scholarshipList- :".mysql_error()); // Die if unable to query

// Get all the names for the scholarships, set them next to checkboxes
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
$content.='<input type="checkbox" name="selectScholarships[]" value="'.$row["names"].'">'.$row["names"].'</input><br>';

$content.='</td>
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
