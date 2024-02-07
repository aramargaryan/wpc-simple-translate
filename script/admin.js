jQuery(document).ready(function(){
	
	// on deactivate
	jQuery(document).on("click", "#deactivate-easy-translate", function () {
		jQuery("#et-skip-and-deactivate").attr( "href", jQuery(this).attr("href") );
		jQuery("#et-deactivate-url").val( jQuery(this).attr("href") );
		jQuery("#et-deactivate-popup").show();
		return false;
	});

   // show / hide other deactivate reason fields
   jQuery(".et-deactivate-form-body input").on("change", function(){

      // hide and disable all other reason field / textarea
      jQuery(".et-reason-other-field").hide();
      jQuery(".et-deactivate-form-body textarea").prop('disabled', true);

      // show and enable current reason field / textarea
      jQuery("#et-reason-other-field-"+jQuery(this).val()).show();
      jQuery("#et-reason-other-field-"+jQuery(this).val()+" textarea").prop('disabled', false);

   });

   jQuery("#et-deactivate-popup form").submit(function(event) {
      
      if ( ! jQuery(".et-deactivate-form-body input[type=radio]").is(':checked') ){
         jQuery("#et-deactivation-error-msg").show();
         return false; 
      }

   });
	
   jQuery(".popupClose, .popupCloseButton").on("click", function() {
      jQuery(".et-popup").hide();
   });
	
   jQuery(document).keyup(function(e) {
      if (e.key === "Escape") {
         jQuery(".et-popup").hide();
      }
   });	

})