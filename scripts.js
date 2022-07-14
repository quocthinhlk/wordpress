// Only input number

jQuery("#manual_point").on("keypress keyup blur",function (event) {    
  jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
