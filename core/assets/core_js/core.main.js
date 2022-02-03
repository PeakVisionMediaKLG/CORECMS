/*
===========================================
Basics
===========================================
*/


function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


/*
===========================================
Core functions
===========================================
*/

function coreAction(element,serialize=0,reload=1)
    {
        var path = $(element).data('path');
        //var scroll = $(element).data('scroll');
        var timeOut = $(element).data('timeout') ?? 300;
        var appendTo = $(element).data('append-to');

        if(JQUERY_DEBUG_TO_CONSOLE)
        {
            /*var time = new Date();
            var identifier = 'action' + time.getTime();
            element.data({'actionIdentifier':identifier});*/
            console.log($(element).data());
        }

            if(serialize==1) 
            {
                var theData = serializeData(element); var serializeText=", Serialized Form used.";  
            } 
            else 
            {
                var theData = $(element).data(); var serializeText="";
            }
            
                $.ajax({
                    type: "POST",url:CORE_PROTOCOL + CORE_HOST + path,
                    data: {"data":theData},
                    success: function(msg){if(JQUERY_DEBUG_TO_CONSOLE){console.log(msg);}}
                })       
                .done(function(data){

                    if(JQUERY_DEBUG_TO_CONSOLE){console.log(data);}
                    if(JQUERY_DEBUG_TO_DOCUMENT)
                    {
                        
                        $.ajax({
                            type: "POST",url: CORE_PROTOCOL + CORE_HOST + 'core/actions/session.set.value.php',
                            data: {thekey: 'CORE.ACTIONMESSAGE',thevalue:data}
                                                                })  
                        .done(function(data){
                            console.log(data);
                            if(data.length != 0) $('.core-alert-space').append("<div class='alert alert-dismissable alert-info' role='alert'>" + data + "</div>");
                            //alert(data);
                        });
                    }

                    if(reload==1) {setTimeout(function(){window.location.reload();	},timeOut);}
                })       
                .fail(function(xhr) {
                    if(JQUERY_DEBUG_TO_CONSOLE){console.log('error callback:', xhr);} 
                });
    }

function serializeData(element)
    {
        var theform=$(element).closest("form");
        
        $(theform).find('select').each(function() {
            if ($(this).is(':disabled')){ $(this).removeAttr("disabled");}
        });
        
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
//---------------------------------------------------------------------------		
		$(theform).find(".chosen-select").each(function() {
			var selectedOptions = [];
			myname = $(this).attr('name');
			myid = $(this).attr('id');
			
			$(theform).find("#"+myid+"_chosen").each(function() {
				
				$(theform).find("ul.chosen-choices").each(function() {
					$(theform).find("li.search-choice > span").each(function() {
					 	selectedOptions.push($(this).html());
					});	
				});
			});

			serializedData.push({name: myname, value: JSON.stringify(selectedOptions)});
			//alert($(this).attr('name'));
		});
//---------------------------------------------------------------------------		
        serializedData.forEach(function(entry) {
            element.data({[entry['name']]:entry['value']});
        });
        console.log(element.data());
        return element.data();
    }

function inplaceAction (element)
	{ 
		element.data({'value':$(element).val()});
		element.data({'path':'core/actions/inplace.update.php'});
		coreAction(element,0);
	}

$(document).on('mouseenter','.iframe-btn', function(){ //alert();
    var theButton = $(this);
    $(this).fancybox({	
        'type'		: 'iframe',
        'autoScale'	: false,
        afterClose: function()  { 
                                    var relative = $(theButton).data('relative');
                                    $('.'+relative).val(pictureResource);
                                    dynamicField=""; pictureResource="";
                                }
    });
});
/*
$(document).on('shown.bs.modal','.modal', function () {
  	$('.chosen-select').chosen('destroy').chosen();
})
*/

/*--------------------------------------------------------------------------------------------*/

function coreModal(element)
    {	
        //getScrollPos();
        if(JQUERY_DEBUG_TO_CONSOLE){console.log($(element).data());}
		$.ajax({ 
                type: "POST",url:CORE_PROTOCOL + CORE_HOST + $(element).data('path'),
                data: {"data":$(element).data()},
				
                })
        .done(function(data) {
                    modal = data;
                    if(JQUERY_DEBUG_TO_CONSOLE){console.log(data);}
                    $(".modal").remove();	 
                    //$(modal).appendTo("body");
                    $(modal).modal("show");
			
					
				//var myModal = new bootstrap.Modal(document.getElementById(modal));
			
			
                });
    }

/*--------------------------------------------------------------------------------------------*/

function coreModalSelectAppend(element)
	{	
        if(JQUERY_DEBUG_TO_CONSOLE){console.log($(element).data());}
		theData = serializeData(element);
        $.ajax({ 
			    type: "POST",url:$(element).data('path'),
			    data: {"data":theData} //"data":[$(element).val(),Core_js_pUID],
                })
			.done(function(data) {
                if(JQUERY_DEBUG_TO_CONSOLE){console.log(data);}
                $(data).appendTo(element.parent());
                $(element).prop("disabled", true);
                var $modalid=$(element).closest("div.modal").attr('id'); 
                //alert('.'+$modalid+'-action-btn');    
                $('.'+$modalid+'-action-btn').prop("disabled", false);					   
			});
    }
    
/*--------------------------------------------------------------------------------------------*/

function coreToggleElement(element)
{
    $(element).slideToggle();
}
/*
===========================================
Triggers
===========================================
*/

$(document).on('click','.core-action-btn', function($e) {
    $e.preventDefault();
    coreAction($(this),0);
});


$(document).on('click','.core-action-btn-nr', function($e) {
    //$e.preventDefault();
    coreAction($(this),0,0);
});

$(document).on('click','.core-add-action-btn', function($e) {
    coreAction($(this),0,0);
});

$(document).on('change','input:checkbox.core-checkbox', function() { 
    if($(this).prop('checked')==true) 
	{ 
		$(this).prop('value', 1); $(this).prop('checked', 1); $(this).attr('checked',1);
	} 
    else if($(this).prop('checked')==false) 
	{ 
		$(this).prop('value', 0);$(this).removeAttr('checked'); 
	}
    
    if($(this).hasClass('core-in-place-edit')){
        inplaceAction($(this));
    }
});

$(document).on('blur','.core-in-place-edit', function() {
    if($(this).attr('type')!='checkbox'){
	   inplaceAction($(this));
    }
});

$(document).on('click','.core-serialize-btn', function($e) {
    $e.preventDefault();
    coreAction($(this),1);
});

$(document).on('click','.core-serialize-btn-nr', function($e) {
    $e.preventDefault();
    coreAction($(this),1,0);
});

$(document).on('click','.core-modal-btn', function($e) {
	$e.preventDefault();
    coreModal($(this));
});


$(document).on('click','.core-toggle-btn', function($e) {
	//$e.preventDefault();
    coreToggleElement($(this).data("elementtotoggle"));
});

$(document).on('click','.core-toggle-action-btn', function($e) {
	$e.preventDefault();
    coreToggleElement($(this).data("elementtotoggle"));
    coreAction($(this),0,0);
});

var CoreCloneNumber=0;
$(document).on('click','.core-clone-btn', function($e) {
    //alert(CoreCloneNumber);
        var clonedElement =  $("#" + $(this).data("elementtoclone")).clone();
            var CoreClonedNumber=CoreCloneNumber+1;
            clonedElement.find('input').each(function() {
                this.name = this.name.replace('[0]','['+ CoreClonedNumber +']');
            });
            
            $(clonedElement).appendTo("." + $(this).data("appendtoelement"));

            CoreCloneNumber++; //alert(CoreCloneNumber);
});

function basic_validate(element)
{
    var myform = $(element).closest('form');
    $(myform).addClass('needs-validation');

    $(myform).find('input[required]').each(function() {
        if(!$(this)[0].checkValidity()) {$(this).addClass('is-invalid'); $(this).removeClass('is-valid');} else {$(this).removeClass('is-invalid'); $(this).addClass('is-valid');}
    });  
    
    if($(myform)[0].checkValidity()){
        $(myform).find('.core-serialize-btn').removeAttr('disabled');    
    }
    else  $(myform).find('.core-serialize-btn').attr('disabled','disabled');
}


$(document).on('keyup','input[required]', function($e) {
    basic_validate(this);
});

$(document).on('change', '.core-checkbox', function() {
    basic_validate(this);
});


$(document).on('change', 'select.core-extend', function($e){
	$e.preventDefault();
    coreModalSelectAppend($(this));	
});




$(document).on('blur', '.core-editable', function($e){
    
                //getscrollpos();

                var the_element_to_green = $(this).data('id');

                $.ajax({ 
					type: "POST",url: "core/actions/ckeditor.update.php",
					data: {"content":$(this).html(),"id":$(this).data('id')},
					complete: function(){ },
					success: function(data){console.log(data);/*$('*[data-id="'+the_element_to_green+'"]').addClass("core-sanitized");*/  }
				});
		});



