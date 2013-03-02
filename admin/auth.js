jQuery(document).ready( function() {
   
    //submit form using ajax
    jQuery("#createtoken").submit( function() {
        
        var site_domain = jQuery("#site_domain").val();

        jQuery.post(ajaxurl,
        {
            action: "form_submit_action",
            site_domain: site_domain
        },
        function(response) {
            console.log(response);
            if(response.status === "success") {
                // do something with response.message or whatever other data on success
                jQuery('.message').html("<div class='updated'>"+response.message+"</div>");
                jQuery('#site_domain').val(" ");
                
                jQuery('.viewtoken').show();

            } else if(response.status === "error") {
                // do something with response.message or whatever other data on error
                jQuery('.message').html("<div class='error'>"+response.message+"</div>");
            }
        },"json");

        return false;
    });//end of submit
    
    
    // delete record using ajax
    jQuery(".listtoken").on("click",".del_button",function(e){
        
        e.preventDefault();
        var delid = this.id;
       
       
       
        jQuery.post(ajaxurl,
        {
            action: "delete_key",
            record_id: delid
        },
        function(response) {
           console.log(response);
           if(response.status === "deleted") {
                // do something with response.message or whatever other data on success
                jQuery('.message').html("<div class='updated'>"+response.message+"</div>");
                jQuery('#token_'+delid).fadeOut("slow");

            } 
        },"json");

        return false;   
    });
   // reset auth key here
   
   
});//end of dom ready

