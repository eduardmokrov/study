jQuery(document).ready(function() {
    jQuery('.module_textarea_input').append('<a href="?saved=progress_ok"  class="save_progress btn btn-success">Send</a>');
    jQuery("#save_student_progress").addClass('btn btn-success');
    
    jQuery('.text_input_module  .module_description, .module_response_description.text_input_module').prepend('<i class="fa fa-question-circle"></i>');
    jQuery('.text_input_module  .module_description i, .module_response_description.text_input_module i').on('click', function(){
        jQuery(this).parent().find('p').toggle();
    });
   jQuery('save_progress').on('click', function(e){   
       e.preventDefault();
       jQuery('#modules_form').append('<input type="hidden" id="save_student_progress_indication" name="save_student_progress_indication" />').submit();
   })

 
    
});


