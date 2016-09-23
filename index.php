<?php
/*******************************************************************************
 * File Name   : index.php
 * Description : The initial index page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/16/15 - Created
 *			   : 04/21/15 - Added session variables
 *			   : 04/30/15 - Fixed wording / grammar / spelling
 *			   : 05/02/15 - Added debugging session variable switch
 *			   : 05/16/15 - Updated variable names for consistency
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

// INITIALIZE ALL SESSION VARIABLES
///////////////////////////////////
///////////////////////////////////
// DEBUGGING SESSION VARIABLE
$_SESSION["DEBUGGING"] = 0; // [0] OFF, [1] ON

// CONTACT INFO SESSION VARIABLES
$_SESSION["FIRST_NAME"] = "";
$_SESSION["LAST_NAME"] = "";
$_SESSION["ADDRESS"] = "";
$_SESSION["CITY"] = "";
$_SESSION["STATE"] = "";
$_SESSION["ZIP_CODE"] = "";
$_SESSION["EMAIL_ADDRESS"] = "";
$_SESSION["PHONE_NUMBER"] = "";

// STUDENT INFO SESSION VARIABLES
$_SESSION["SAC_ID"] = "";
$_SESSION["MAJOR"] = "";
$_SESSION["GRAD_SEMESTER"] = "";
$_SESSION["GRAD_YEAR"] = "";
$_SESSION["SAC_GPA"] = "";

// SCHOLARSHIP INFO SESSION VARIABLES
$_SESSION["SELECT_SCHOLARSHIPS"] = array();

// COURSE INFO SESSION VARIABLES
$_SESSION["COURSE_NUM"] = 0;
$_SESSION["COURSE_NAMES"] = array();
$_SESSION["COURSE_SEMESTERS"] = array();
$_SESSION["COURSE_YEARS"] = array();
$_SESSION["COURSE_GRADES"] = array();
$_SESSION["COURSE_COLLEGES"] = array();

// SESSION INFO SESSION VARIABLES
$_SESSION["UNIQUE_ID"] = "";
$_SESSION["HTML_TO_PDF"] = "";
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

<!-- EXIT BUTTON / TITLE -->
<p style="text-align:center;"><strong>
	<button style="font-size:8pt;" onclick="location.href=\'../scholarships.php\';">EXIT</button>
	ECS SCHOLARSHIP APPLICATION
</strong></p><hr>
<br><br>

<!-- NOTE TO USER ABOUT APP -->
<p style="text-align:center;">
	Begin the online scholarship application by clicking the <b>"START"</b> button below.<br>
	This online application provides you with the first page of the PDF package. (The scholarship online form.)<br><br>
	<i>**NOTE: If you have to use the back button at any point during the application, you may have to re-enter information.<br>
	Also, make sure that the information you enter is valid as it pertains to you. There will be no validation besides your own during the application.</i>
</p>

<!-- BEGIN APP BUTTON -->
<p style="text-align:center;"><strong>
	<button style="font-size:12pt;" onclick="location.href=\'contact_info.php\';">START</button>
</strong></p>

</div>
<!-- END THE PAGE DESIGN (HTML) -->
';

echo $content;

// Footer
$page->ecs_bottom();
?>
