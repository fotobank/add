    This script can be used to validate a form or a control.
          
    This script requires jQuery.
    
    To load this script, use the following:

        <script language="JavaScript" src="validation.js"></script>
        <script language="JavaScript">
            var valid = new validate();
        </script>
    
    The form definitions should be as follows:
    
        <form method="POST" action="targetPage" name="FormName" id="FormName" onsubmit="return valid.validateForm(this);">
    
    Items to be validated should be described as follows:
        
        <label for="FacilityState">Facility State</label>
        <input type="text" name="FacilityState" id="FacilityState" class="a list of validations and other classes" size="3" onchange="javascript: valid.validateInput(this);">
        <div id="FacilityStateError" class="validationError" style="display:none;"></div>
    
You might be able to use onblur events but if you display a popup, that gets to be problematic and by default, this script creates a popup.

You can also put a div as follows on your page to display any validation errors from the form:

        <div id="ValidationError" class="validationError" style="display: none;"></div>

Valid validations are:
    
        required
        email
        date - in dd-mon-yyyy,  dd-mm-yyyy, yyyy-mon-dd or yyyy-mm-dd formats
        time
        currency
        numeric
        alphanumeric
        alpha
        phone
        state
        zipcode
        urlentry
        
Valid controls are:

        text
        testarea
        select - Required only, value not '' or 0
        radio buttons - one must be checked
       
