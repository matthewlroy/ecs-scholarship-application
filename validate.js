/*******************************************************************************
 * File Name   : validate.js
 * Description : The validation script for the scholarship application forms.
 * Author	   : Matthew Roy
 * Version	   : 05/02/15 - Created
 * 			   : 05/05/15 - Commented course validation function
*******************************************************************************/
/*******************************************************************************
 * Function Name   : checkform(form)
 * Precondition    : An un-checked form.
 * Postcondition   : Alert to the user to fill in an empty field.
 * (http://stackoverflow.com/questions/18640051/js-form-check-empty)
*******************************************************************************/
function checkform(form)
{
    // Get all the inputs within the submitted form
    var inputs = form.getElementsByTagName('input');
	
	// Iterate over all the inputs
    for (var i = 0; i < inputs.length; i++)
	{
        // Only validate the inputs that have the required attribute
        if(inputs[i].hasAttribute("required"))
		{
            if(inputs[i].value == "")
			{
                // Found an empty field that is required
                alert("Please fill all required fields");
                return false;
            }
        }
    }
	
	// Successful validation
    return true;
}
/*******************************************************************************
 * Function Name   : checkboxes(checkboxForm)
 * Precondition    : An un-checked form of checkboxes.
 * Postcondition   : Alert to the user to fill in at least one checkbox.
*******************************************************************************/
function checkboxes(checkboxForm)
{
    // Get all the boxes within the submitted checkboxForm
    var boxes = checkboxForm.getElementsByTagName('input');
	
	// Iterate over all the boxes
    for (var i = 0; i < boxes.length; i++)
	{
		// At least one check box is checked, successful validation
		if (boxes[i].checked)
			return true;
	}
	
	// Found no checkboxes checked, failed validation
	alert("Please select at least one scholarship");
	return false;
}
/*******************************************************************************
 * Function Name   : alertcourse(courseForm)
 * Precondition    : No courses are selected in the course_info.php file.
 * Postcondition   : Alert to the user to fill in at least one course.
function alertcourse(courseForm)
{
	alert("Please enter at least one course");
	return false;
}
*******************************************************************************/