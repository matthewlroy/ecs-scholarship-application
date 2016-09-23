<?php
/*******************************************************************************
 * File Name   : final.php
 * Description : The final page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/18/15 - Created
 *			   : 04/21/15 - Added session variables
 *			   : 04/23/15 - Added the array session variables for courses
 *			   : 04/25/15 - Updated content tables, added message to user
 *			   : 04/25/15 - Added back button capability to all forms
 *			   : 04/28/15 - Added session info session variables
 *			   : 04/28/15 - Added button to start over
 *			   : 05/01/15 - Added code that writes html to a file
 *			   : 05/02/15 - Added debugging session variable switch
 *			   : 05/02/15 - Fixed empty "other college" option for course list
 *			   : 05/02/15 - Fixed the php fopen error with folder permissions
 *			   : 05/08/15 - Fixed session erros, ran csh script, html -> PDF
 *			   : 05/14/15 - Fixed no course info set errors
 *			   : 05/16/15 - Updated variable names for consistency
 *			   : 05/16/15 - Fixed the conversion/deletion of html file script
 *			   : 05/16/15 - Updated debugging to depend on DEBUG session var
 *			   : 05/16/15 - Updated button to now open in a new tab
 *			   : 05/16/15 - Updated styling of html to be the pdf (better look)
*******************************************************************************/
// EXPIRE SESSION FIX 
//(http://stackoverflow.com/a/27199534)
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too

// Error handling
if ($_SESSION["DEBUGGING"] == 1)
{
	error_reporting(E_ALL);
	ini_set('display_errors',1);
}

// Session / Includes
session_start();
include_once('../../portal/pages.php');

// INITIALIZE ALL COURSE INFO VARIABLES
///////////////////////////////////
///////////////////////////////////
// COURSE INFO SESSION VARIABLES
$_SESSION["COURSE_NUM"] = $_POST['courseNum'];
for ($i = 0; $i < $_SESSION["COURSE_NUM"]; $i++)
{
	if(isset($_POST['courseName_id#'.$i.'']))
		$_SESSION["COURSE_NAMES"][$i] = $_POST['courseName_id#'.$i.''];
	else
		$_SESSION["COURSE_NAMES"][$i] = "";
		
	if(isset($_POST['couresSemester_id#'.$i.'']))
		$_SESSION["COURSE_SEMESTERS"][$i] = $_POST['couresSemester_id#'.$i.''];
	else
		$_SESSION["COURSE_SEMESTERS"][$i] = "";
		
	if(isset($_POST['courseYear_id#'.$i.'']))
		$_SESSION["COURSE_YEARS"][$i] = $_POST['courseYear_id#'.$i.''];
	else
		$_SESSION["COURSE_YEARS"][$i] = "";
	
	if(isset($_POST['courseGrade_id#'.$i.'']))
		$_SESSION["COURSE_GRADES"][$i] = $_POST['courseGrade_id#'.$i.''];
	else
		$_SESSION["COURSE_GRADES"][$i] = "";
	
	// Get whether or not other was selected, and assign session var accordingly
	if(isset($_POST['collegeOrUniversity_id#'.$i.'']))
	{
		if (strcmp($_POST['collegeOrUniversity_id#'.$i.''], "Other") == 0)
		{
			if (strcmp($_POST['otherCollege#'.$i.''], "") == 0)
				$_SESSION["COURSE_COLLEGES"][$i] = "Other";
			else
				$_SESSION["COURSE_COLLEGES"][$i] = $_POST['otherCollege#'.$i.''];
		}
		else
			$_SESSION["COURSE_COLLEGES"][$i] = $_POST['collegeOrUniversity_id#'.$i.''];
	}
	else if(!isset($_POST['collegeOrUniversity_id#'.$i.'']))
	{
		$_SESSION["COURSE_COLLEGES"][$i] = "";
	}
}

// SESSION INFO SESSION VARIABLES
// (http://www.w3schools.com/php/func_misc_uniqid.asp)
// GENERATE UNIQUE ID FOR HTML TO PDF HELP
$_SESSION["UNIQUE_ID"] = uniqid('', false);

// Open/create the html file with the uniqid (save to apps dir)
$htmlFile = fopen("apps/".$_SESSION["UNIQUE_ID"].".html", "w")
	or die("Could not write to file : apps/".$_SESSION["UNIQUE_ID"].".html");


// HTML TO BE PUT INTO PDF
$_SESSION["HTML_TO_PDF"]='
<center>
<h2>COLLEGE OF ENGINEERING & COMPUTER SCIENCE</h2>
<h3>Scholarship Application Form</h3><br>
<!-- TABLE DISPLAYING CONTACT/STUDENT INFORMATION -->
<table border="1">
	<!-- TABLE TITLE -->
	<tr>
		<th colspan="2" style="background:lightgray;"><b>Contact & Student Information:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr>
		<td><b>Date:</b> '.date("M d, Y").'</td>
		<td><b>Major:</b> '.$_SESSION["MAJOR"].'</td>
	</tr>
	<tr>
		<td><b>Name:</b> '.$_SESSION["FIRST_NAME"].' '.$_SESSION["LAST_NAME"].'</td>
		<td><b>Student ID #:</b> '.$_SESSION["SAC_ID"].'</td>
	</tr>
	<tr>
		<td><b>Adress:</b> '.$_SESSION["ADDRESS"].'</td>
		<td><b>Phone:</b> '.$_SESSION["PHONE_NUMBER"].'</td>
	</tr>
	<tr>
		<td><b>City, State, Zip:</b> '.$_SESSION["CITY"].', '.$_SESSION["STATE"].' '.$_SESSION["ZIP_CODE"].'</td>
		<td><b>Expected Graduation Date:</b> '.$_SESSION["GRAD_SEMESTER"].' '.$_SESSION["GRAD_YEAR"].'</td>
	</tr>
	<tr>
		<td><b>E-mail:</b> '.$_SESSION["EMAIL_ADDRESS"].'</td>
		<td><b>Sac State GPA:</b> '.$_SESSION["SAC_GPA"].'</td>
	</tr>
</table>
<br><br>
<!-- TABLE DISPLAYING SCHOLARSHIP INFORMATION -->
<table border="1">
	<!-- TABLE TITLE -->
	<tr>
		<th style="background:lightgray;"><b>Scholarships Applying For:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr><td>'; 
		// Gets the user's selected scholarships	
		foreach ($_SESSION["SELECT_SCHOLARSHIPS"] as $scholarships=>$value)
			$_SESSION["HTML_TO_PDF"].=$value."<br>";
		$_SESSION["HTML_TO_PDF"].='</td>
	</tr>
</table>
<br><br>
<!-- TABLE DISPLAYING COURSE INFORMATION -->
<table border="1">
	<!-- TABLE TITLE -->
	<tr>
		<th colspan="4" style="background:lightgray;"><b>Top Five Major Courses or Courses Related to Your Degree:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr>
		<th>COURSE</th>
		<th>SEMSETER/YR.</th>
		<th>GRADE</th>
		<th>COLLEGE or UNIVERSITY</th>
	</tr>'; 
		// Gets the user's entered course information
		for ($i = 0; $i < $_SESSION["COURSE_NUM"]; $i++)
		{
			$_SESSION["HTML_TO_PDF"].='<tr><td>';
			$_SESSION["HTML_TO_PDF"].=$_SESSION["COURSE_NAMES"][$i].'</td><td>';
			$_SESSION["HTML_TO_PDF"].=$_SESSION["COURSE_SEMESTERS"][$i].' ';
			$_SESSION["HTML_TO_PDF"].=$_SESSION["COURSE_YEARS"][$i].'</td><td>';
			$_SESSION["HTML_TO_PDF"].=$_SESSION["COURSE_GRADES"][$i].'</td><td>';
			$_SESSION["HTML_TO_PDF"].=$_SESSION["COURSE_COLLEGES"][$i].'</td>';
			$_SESSION["HTML_TO_PDF"].='</tr>';
		}
		$_SESSION["HTML_TO_PDF"].='</td>
</table><br><br>
</center>
';

// Write the html code to the open file, then close file
fwrite($htmlFile, $_SESSION["HTML_TO_PDF"]);
fclose($htmlFile);

// Run script to generate PDF and remove html file
$uniqid = $_SESSION["UNIQUE_ID"]; // Helper variable for the script below
shell_exec("htmldoc --webpage -f apps/$uniqid.pdf apps/$uniqid.html");// Convert
unlink("apps/$uniqid.html");// Delete

// DEBUGGING ALL SESSION VARIABLES
$DEBUGGING_CONTENT=' // CONTACT INFO <br>
	'.$_SESSION["FIRST_NAME"].' <br>
	'.$_SESSION["LAST_NAME"].' <br>
	'.$_SESSION["ADDRESS"].' <br>
	'.$_SESSION["CITY"].' <br>
	'.$_SESSION["STATE"].' <br>
	'.$_SESSION["ZIP_CODE"].' <br>
	'.$_SESSION["EMAIL_ADDRESS"].' <br>
	'.$_SESSION["PHONE_NUMBER"].' <br> <br>
';
$DEBUGGING_CONTENT.=' // STUDENT INFO  <br>
	'.$_SESSION["SAC_ID"].' <br>
	'.$_SESSION["MAJOR"].' <br>
	'.$_SESSION["GRAD_SEMESTER"].' <br>
	'.$_SESSION["GRAD_YEAR"].' <br>
	'.$_SESSION["SAC_GPA"].' <br> <br>
';
$DEBUGGING_CONTENT.=' // SCHOLARSHIP INFO <br>';
foreach ($_SESSION["SELECT_SCHOLARSHIPS"] as $scholarships=>$value)
	$DEBUGGING_CONTENT.=$value."<br>";
$DEBUGGING_CONTENT.='<br>';
$DEBUGGING_CONTENT.=' // COURSE INFO <br>
	'.$_SESSION["COURSE_NUM"].' <br>
';
for ($i = 0; $i < $_SESSION["COURSE_NUM"]; $i++)
{
	$DEBUGGING_CONTENT.=$_SESSION["COURSE_NAMES"][$i].' ';
	$DEBUGGING_CONTENT.=$_SESSION["COURSE_SEMESTERS"][$i].' ';
	$DEBUGGING_CONTENT.=$_SESSION["COURSE_YEARS"][$i].' ';
	$DEBUGGING_CONTENT.=$_SESSION["COURSE_GRADES"][$i].' ';
	$DEBUGGING_CONTENT.=$_SESSION["COURSE_COLLEGES"][$i].' ';
	$DEBUGGING_CONTENT.='<br>';
}
$DEBUGGING_CONTENT.='<br> //  SESSION INFO <br>
	'.$_SESSION["UNIQUE_ID"].' <br>
	'.$_SESSION["HTML_TO_PDF"].' <br> <br>
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

<!-- BACK BUTTON / TITLE / START OVER BUTTON -->
<p style="text-align:center;"><strong>
	<button style="font-size:8pt;" onclick="window.history.back();">BACK</button>
	ECS SCHOLARSHIP APPLICATION | FINAL PAGE
	<button style="font-size:8pt;" onclick="parent.location=\'index.php\'">START OVER</button>
</strong></p><hr>

<!-- NOTE TO USER ABOUT APP -->
<p style="text-align:center;">
	You have successfully finished your scholarship application.<br><br>
	Make sure that all the information below is correct, and click <b>"VIEW PDF"</b><br><br>
	<i>**NOTE: If you have to use the back button, you may have to re-enter information.</i>
</p>

<!-- TABLE DISPLAYING CONTACT/STUDENT INFORMATION -->
<table>
	<!-- TABLE TITLE -->
	<tr>
		<th colspan="2"><b>Contact & Student Information:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr>
		<td><b>Date:</b> '.date("M d, Y").'</td>
		<td><b>Major:</b> '.$_SESSION["MAJOR"].'</td>
	</tr>
	<tr>
		<td><b>Name:</b> '.$_SESSION["FIRST_NAME"].' '.$_SESSION["LAST_NAME"].'</td>
		<td><b>Student ID #:</b> '.$_SESSION["SAC_ID"].'</td>
	</tr>
	<tr>
		<td><b>Adress:</b> '.$_SESSION["ADDRESS"].'</td>
		<td><b>Phone:</b> '.$_SESSION["PHONE_NUMBER"].'</td>
	</tr>
	<tr>
		<td><b>City, State, Zip:</b> '.$_SESSION["CITY"].', '.$_SESSION["STATE"].' '.$_SESSION["ZIP_CODE"].'</td>
		<td><b>Expected Graduation Date:</b> '.$_SESSION["GRAD_SEMESTER"].' '.$_SESSION["GRAD_YEAR"].'</td>
	</tr>
	<tr>
		<td><b>E-mail:</b> '.$_SESSION["EMAIL_ADDRESS"].'</td>
		<td><b>Sac State GPA:</b> '.$_SESSION["SAC_GPA"].'</td>
	</tr>
</table>

<!-- TABLE DISPLAYING SCHOLARSHIP INFORMATION -->
<table>
	<!-- TABLE TITLE -->
	<tr>
		<th><b>Scholarships Applying For:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr><td>'; 
		// Gets the user's selected scholarships	
		foreach ($_SESSION["SELECT_SCHOLARSHIPS"] as $scholarships=>$value)
			$content.=$value."<br>";
		$content.='</td>
	</tr>
</table>

<!-- TABLE DISPLAYING COURSE INFORMATION -->
<table>
	<!-- TABLE TITLE -->
	<tr>
		<th colspan="4"><b>Top Five Major Courses or Courses Related to Your Degree:</b></th>
	</tr>
	
	<!-- TABLE DATA -->
	<tr>
		<th>COURSE</th>
		<th>SEMSETER/YR.</th>
		<th>GRADE</th>
		<th>COLLEGE or UNIVERSITY</th>
	</tr>'; 
		// Gets the user's entered course information dynamically
		for ($i = 0; $i < $_SESSION["COURSE_NUM"]; $i++)
		{
			$content.='<tr><td>';
			$content.=$_SESSION["COURSE_NAMES"][$i].'</td><td>';
			$content.=$_SESSION["COURSE_SEMESTERS"][$i].' ';
			$content.=$_SESSION["COURSE_YEARS"][$i].'</td><td>';
			$content.=$_SESSION["COURSE_GRADES"][$i].'</td><td>';
			$content.=$_SESSION["COURSE_COLLEGES"][$i].'</td>';
			$content.='</tr>';
		}
		$content.='</td>
</table>

<!-- VIEW PDF BUTTON 
**NOTE: BUGFIXING... TEMPORARILY JUST GOES TO HTML-->

<!-- NOTE TO USER ABOUT GENERATING PDF
<p style="text-align:center;">
	After clicking the <b>"VIEW PDF"</b> button, follow these instructions:<br><br>
	<i>
	To save the document as a PDF, press <b>CTRL + P</b> (WINDOWS) or <b>CMD + P</b> (Mac) as if you were going to print the page.<br>
	Then, select the list of printers. This is listed as either <b>"Select Printer:"</b> or <b>"Destination:"</b>, and a menu will appear.<br>
	Lastly, select the <b>"Save as a PDF"</b>  option and press print. Save the file in any location you prefer.<br>
	You now have the first page of the required PDF package.</i>
</p> -->

<button style="font-size:8pt;" onclick="window.open(\'apps/'.$_SESSION["UNIQUE_ID"].'.pdf\')">VIEW PDF</button>

</div>
<!-- END THE PAGE DESIGN (HTML) -->
';

echo $content;
if ($_SESSION["DEBUGGING"] == 1) echo $DEBUGGING_CONTENT;

// Footer
$page->ecs_bottom();
?>
