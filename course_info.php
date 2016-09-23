<?php
/*******************************************************************************
 * File Name   : course_info.php
 * Description : The course info page for the scholarship application form.
 * Author	   : Matthew Roy
 * Version	   : 04/18/15 - Created
 *			   : 04/21/15 - Added session variables
 *			   : 04/23/15 - Fixed year bug
 *			   : 04/25/15 - Updated college post values
 *			   : 04/25/15 - Added back button capability to all forms
 *			   : 05/02/15 - Added debugging session variable switch
 *			   : 05/02/15 - Added form valid (making sure at least one course)
 *			   : 05/05/15 - Fixed wording and placement of user note. Removed
 *							course validation, only enter top 5 courses.
 *			   : 05/08/15 - Removed course validation
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

// INITIALIZE ALL SCHOLARSHIP INFO VARIABLES
///////////////////////////////////
///////////////////////////////////
// SCHOLARSHIP INFO SESSION VARIABLES
if (isset($_POST['selectScholarships']))
	$_SESSION["SELECT_SCHOLARSHIPS"] = $_POST['selectScholarships'];

// DEBUGGING SESSION VARIABLES
$DEBUGGING_CONTENT='';
foreach ($_SESSION["SELECT_SCHOLARSHIPS"] as $scholarships=>$value)
	$DEBUGGING_CONTENT.=$value."<br>";
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
	ECS SCHOLARSHIP APPLICATION | COURSE INFO
</strong></p><hr>

<!-- THE FORMS FOR THE USERS COURSE INFORMATION -->
<br><h1 style="color:black;"> 
	Please Fill Out Your Course Information:<br>
</h1><br>

<!-- NOTE TO USER -->
<p style="text-align:center;">
	Enter your top 5 major courses or courses related to your degree which you are currently taking or have completed.<br><br>
	<i>**NOTE: Your Spring semester grades will be provided to the scholarship committee.</i><br>
</p>

<!-- GET HOW MANY COURSES THE USER WANTS TO ENTER, OLD 5/5/15 -->
<!-- <form id="couresNumForm" name="couresNumForm" method="post" onsubmit="checkform(this)"> -->
<!-- COURES NUMBER FIELD -->
<!-- How many courses would you like to add? -->
<!-- <input name="courseNum" type="text" maxlength="2" placeholder="4" required /> -->
<!-- SET BUTTON -->
<!-- <span id="upButton"> <input name="submit" type="submit" value="SET" /></span> -->
<!-- </form><br> -->

<script src="validate.js"></script>
<form id="courseForm" name="courseForm" action="final.php" method="post" onsubmit="checkform(this)">
<table id="application_table" border="0">
<!-- COURSE HEADER FIELDS -->
<tr>
	<th><label> COURSE:</th>
	<th colspan=2><label> SEMESTER/YR.:</th>
	<th><label> GRADE:</th>
	<th><label> COLLEGE or UNIVERSITY:</th>
</tr>

<!-- COURSE DATA FIELDS -->
'.addCourses().'

<!-- NOTE TO USER ABOUT WHAT FIELDS ARE REQUIRED -->
<tr>
<td colspan="5"> <b style="color:red;">*</b> Required Fields </td>
</tr>
</table> <!-- END TABLE STYLING -->

<!-- HIDDEN COURSE NUM INPUT, TO GET DATA ON NEXT PAGE -->
<input name="courseNum" type="hidden" maxlength="40" value="5" />

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

/*******************************************************************************
 * Function Name   : addCourses()
 * Precondition    : None
 * Postcondition   : A course is added to the table.
*******************************************************************************/
function addCourses()
{
	
// Initialize the helper variables
$courseContent='';
$year = date("Y");
$courseNum = 1;

// Get how many courses the user wanted
$courseNum = 5;

// Return how many courses the user wants to enter
for ($num = 0; $num < $courseNum; $num++)
{
$year = date("Y"); // Re-initialize the year
$courseContent.='
<tr>
	<!-- COURSE NAME CELL -->
	<td><input name="courseName_id#'.$num.'" type="text" maxlength="40" placeholder="CSC 161" /></td>
	
	<!-- COURSE SEMESTER CELL -->
	<td>
		<input type="radio" name="couresSemester_id#'.$num.'" value="Fall"> Fall<br>
		<input type="radio" name="couresSemester_id#'.$num.'" value="Spring"> Spring<br>
	</td>
	
	<!-- COURSE YEAR CELL -->
	<td>
		<select name="courseYear_id#'.$num.'">
			<option value="">--- Select a Year ---</option>';
			// For loop that will manage the years for courses by itself
			// Allow for for 10 year span for major course grades
			for ($i = 0; $i <= 10; $i++)
			{
				$courseContent.='<option value="'.$year.'">'.$year.'</option>';
				$year--;
			}
		$courseContent.='</select></td>
		
	<!-- COURSE GRADE CELL -->
	<td>
		<select name="courseGrade_id#'.$num.'">
			<option value="">--- Select a Grade ---</option>
			<option value="IP">In Progress</option>
			<option value="A">A</option>
			<option value="A-">A-</option>
			<option value="B+">B+</option>
			<option value="B">B</option>
			<option value="B-">B-</option>
			<option value="C+">C+</option>
			<option value="C">C</option>
			<option value="C-">C-</option>
			<option value="D+">D+</option>
			<option value="D">D</option>
			<option value="D-">D-</option>
			<option value="F+">F+</option>
			<option value="F">F</option>
		</select>
	</td>
	
	<!-- COLLEGE OR UNIVERSITY CELL -->
	<td>
		<input name="collegeOrUniversity_id#'.$num.'" type="radio"  value="California State University, Sacramento"> Sacramento State<br>
		<input name="collegeOrUniversity_id#'.$num.'" type="radio"  value="Other"> Other
		<input name="otherCollege#'.$num.'" type="text" maxlength="40" placeholder="Folsom Lake College"/>
	</td>
</tr>
';
}
return $courseContent;
}
?>