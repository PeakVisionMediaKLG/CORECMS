jQuery(function($){$('ul.sortable').multisortable({
    
    selectedClass: "selected",
	click: function(e){ /*console.log("I'm selected.");*/ },
    
    stop: function(e){ 
        console.log("I've been sorted.");
        var path = $('.core-sortable').data('path');
        //var serializedData = $(this).sortable('serialize');
        console.log("path:" + path);
        var theform=$('.core-sortable').closest("form");

        var serializedData = $(theform).serializeArray();
        $(theform).find("input:checkbox.core-checkbox").each(function() {
            if ($(this).is(":checked"))
                {
                    serializedData.push({name: $(this).attr("name"), value: 1});
                } 
            else 
                {
                    serializedData.push({name: $(this).attr("name"), value: 0});
                }		
		});
        serializedData.push({name: 'table', value: $('ul.sortable').data('table')});
        $.ajax({
            type: "POST",url:path,
            data: {"data":serializedData},
            success: function(msg){if(JQUERY_DEBUG_CONSOLE){console.log(msg);}}
        })       
        .done(function(data){
            setTimeout(function(){window.location.reload();	},100);
        })       
        .fail(function(xhr) {
            if(JQUERY_DEBUG_CONSOLE){console.log('error callback:', xhr);}
        });
        }
    });
});