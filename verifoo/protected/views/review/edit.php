<h3>Edit your Review</h3>
<?php

$this->renderPartial('_form', array('model'=>$model)); 

?>
<script type="text/javascript">
 	$(document).ready(function() {
		 $("#Review_comment").limit({
            limit: 3000,
            id_result: "txtCtr",
            alertClass: "alert"
          });
     });

function FitToContent(id, maxHeight)
	{
	   var text = id && id.style ? id : document.getElementById(id);
	   if ( !text )
	      return;
	
	   /* Accounts for rows being deleted, pixel value may need adjusting */
	   if (text.clientHeight == text.scrollHeight) {
	      text.style.height = "30px";
	   }       
	
	   var adjustedHeight = text.clientHeight;
	   if ( !maxHeight || maxHeight > adjustedHeight )
	   {
	      adjustedHeight = Math.max(text.scrollHeight, adjustedHeight);
	      if ( maxHeight )
	         adjustedHeight = Math.min(maxHeight, adjustedHeight);
	      if ( adjustedHeight > text.clientHeight )
	         text.style.height = adjustedHeight + "px";
	   }
	}	
	
(function($){
    $.fn.limit  = function(options) {
        var defaults = {
        limit: 200,
        id_result: false,
        alertClass: false
        }
        var options = $.extend(defaults,  options);
        return this.each(function() {
            var characters = options.limit;
            if(options.id_result != false)
            {
                $("#"+options.id_result).append("You have <strong>"+  characters+"</strong> characters remaining");
            }
            $(this).keyup(function(){
            	FitToContent(this, document.documentElement.clientHeight);
                if($(this).val().length > characters){
                    $(this).val($(this).val().substr(0, characters));
                }
                if(options.id_result != false)
                {
                    var remaining =  characters - $(this).val().length;
                    $("#"+options.id_result).html("You have <strong>"+  remaining+"</strong> characters remaining");
                    if(remaining <= 10)
                    {
                        $("#"+options.id_result).addClass(options.alertClass);
                    }
                    else
                    {
                        $("#"+options.id_result).removeClass(options.alertClass);
                    }
                }
            });
        });
    };
})(jQuery);
</script>