/* 

===========================================
Triggers
===========================================
*/
$(document).on('click','.core-action-btn', function($e) {
	$e.preventDefault();
    core_action($(this));
});

$(document).on('click','.core-action-notimeout-btn', function($e) {
	$e.preventDefault();
    core_action_notimeout($(this));
});

$(document).on('click','.core-serialize-btn', function($e) {
	$e.preventDefault();
    core_serialize($(this));
});

$(document).on('click','.core-modal-btn', function($e) {
	$e.preventDefault();
    core_modal($(this));
});

$(document).on('change', 'select.core-extend', function($e){
	$e.preventDefault();
    core_select_append($(this));	
});

$(document).on('click', '.core-extend-btn', function($e){
	$e.preventDefault();
    core_button_append($(this));	
});

$(document).on('blur', '.core-editable', function($e){
    
                getscrollpos();

    
        
				/*for(var instanceName in CKEDITOR.instances) {
                    console.log( CKEDITOR.instances[instanceName] );
                }
                var myinitialname = $(this).attr('aria-label');
                var shortenedname = myinitialname.substring(-3);
                var numberonly = shortenedname.replace(/\D/g,'');
                    
                var truedata = CKEDITOR.instances['editor'+numberonly].getData(); //alert(truedata);

                $.ajax({ 
				type: "POST",url:('core/modals/content.save.modal.php'),
                data: {"content":truedata,"id":$(this).data('id')}, 
				complete: function(){},
				success: function(data){
					modal = data; logdata(data);
					$(".modal").remove();	 
					$(modal).appendTo("body");
					$(modal).modal("show");}
				});*/
                var the_element_to_green = $(this).data('id');
        //alert(the_element_to_green);
                $.ajax({ 
					type: "POST",url: "core/actions/ckeditor.update.php",
					data: {"content":$(this).html(),"id":$(this).data('id')},
					complete: function(){ },
					success: function(data){console.log(data);$('*[data-id="'+the_element_to_green+'"]').addClass("core-sanitized"); /*setTimeout(function(){window.location.reload();	},1000);*/ }
				});
    
    
		});

$(document).on('focus','.core-in-place-edit', function() { 
    $(this).removeClass('core-sanitized'); 
    $(this).removeClass('core-unsanitized'); 
    $('.core-red').remove();
});

$(document).on('blur','.core-in-place-edit', function() {
    if($(this).attr('type')!='checkbox'){
	core_in_place_action($(this));
    }
});

$(document).on('change','input:checkbox.core-checkbox', function() { 
    if($(this).prop('checked')==true) 
	{ $(this).prop('value', 1); $(this).prop('checked', 1); $(this).attr('checked',1);} 
    else if($(this).prop('checked')==false) 
	{ $(this).prop('value', 0);$(this).removeAttr('checked'); }
    
    if($(this).hasClass('core-in-place-edit')){
        core_in_place_action_checkbox($(this));
    }
});

/*$(document).on('blur','.core-sanitize-this', function() {
	core_sanitize($(this));
});*/

$( document ).ready(function() {
    $('.core-content-description').parent().each(function(e){ 
        if($(this).width()<450 || ($(this).children().width() > $(this).width()-220)) 
        {
            $(this).find('.core-content-description').hide(); $(this).find('.core-expendable').hide();
        }
        else
        {   $(this).find('.core-relocated').hide(); }
    });
});



/*------------------content copy/paste--------------------*/
$( document ).ready(function() {
    $('.core-cut-element').closest('.core-admin-view').addClass('core-greyed-out');
});

if (Core_js_currentMode == "branch_copied" || Core_js_currentMode == "branch_cut") {
    if (Core_js_currentMode == "branch_copied"){
    $('.core-alert-copy').remove();
           $.ajax({
                type: "POST",url: "core/actions/content.copy.alert.php",
                data: {"id":Core_js_copiedContentID,"type":Core_js_elementType,"mode":"remove"},
                complete: function(){ },
                success: function(data){$(data).prependTo(".core-admin-viewport");}
            });	
    }
    if (Core_js_currentMode == "branch_cut"){
    $('.core-alert-copy').remove();
           $.ajax({
                type: "POST",url: "core/actions/content.cut.alert.php",
                data: {"id":Core_js_copiedContentID,"type":Core_js_elementType,"mode":"remove"},
                complete: function(){ },
                success: function(data){$(data).prependTo(".core-admin-viewport");}
            });	    
    }
    $(document).on('click', '.core-cancel-copy', function (e) { 
        $.ajax({
                        type: "POST",url: "core/actions/content.cut.copy.php",
                        data: {"id":Core_js_copiedContentID,"mode":"remove"},
                        complete: function(){ },
                        success: function(data){console.log(data);
                                                setTimeout(function(){window.location.reload();
                                                },100);}
                    });
    });
}

/*
===========================================
Reusable Functions
===========================================
*/
function getscrollpos()
{
            var scrollPos = $(document).scrollTop();
            console.log('Position: '+scrollPos);
            
            $.ajax({
                type: "POST",url: "core/actions/session.save.scrollpos.php",
                data: {"time":$.now(), "scrollpos":scrollPos},
                complete: function(){ },
                success: function(data){console.log(data);}
            });
}

function logdata(mydata)
    {
        if(Core_jQueryDebugging==1) console.log(mydata);
    }

function core_action (element)
	{
		getscrollpos();
        $.ajax({    type: "POST",url:$(element).data('action-path'),
				    data: {"data":$(element).data(),"scrollpos":$(element).scrollTop()}, //,"scrollpos":$(element).scrollTop
					complete: function(){ },
					success: function(data){logdata(data);}
				});
		setTimeout(function(){window.location.reload();	},100);	
	}

function core_action_notimeout(element)
{
 		$.ajax({    type: "POST",url:$(element).data('action-path'),
				    data: {"data":$(element).data()},
					complete: function(){ },
					success: function(data){logdata(data);}
				});   
}

function core_action_w_path(path,element)
{
 		getscrollpos();
        $.ajax({    type: "POST",url:path,
				    data: {"data":$(element).data()},
					complete: function(){ },
					success: function(data){logdata(data);}
				});   
}

function core_in_place_action (element)
	{ 
        $.ajax({    type: "POST",url:'core/actions/in.place.action.php',
				    data: {"data":$(element).data(),value:$(element).val()},
					complete: function(){ },
					success: function(data){logdata(data);
                                            if(data.startsWith('\\')){
                                                $(element).addClass('core-unsanitized');
                                                $(element).closest('div').append('<br><p class="core-red">'+data+'</p>')
                                            }
                                            else{
                                                $(element).addClass('core-sanitized');
                                                $(element).val(data);
                                                
                                            }

                                           }
				});
	}

function core_in_place_action_checkbox (element)
	{ 
        $.ajax({    type: "POST",url:'core/actions/in.place.action.php',
				    data: {"data":$(element).data(),value:$(element).val()},
					complete: function(){ },
					success: function(data){logdata(data);}
				});
	}


function core_modal (element)
	{	
		getscrollpos();
        $.ajax({ 
				type: "POST",url:$(element).data('action-path'),
				data: {"data":$(element).data()},
				complete: function(){ },
				success: function(data){
					modal = data;	logdata(data);
					$(".modal").remove();	 
					$(modal).appendTo("body");
					$(modal).modal("show")
					}
				});
	}

function core_select_append(element)
	{	
		$.ajax({ 
			type: "POST",url:$(element).data('action-path'),
			data: {"data":[$(element).val(),Core_js_pUID]},
			complete: function(){ },
			success: function(data)
			{
			logdata(data);
			$(data).appendTo(element.parent());
			$(element).prop("disabled", true);
            var $modalid=$(element).closest("div.modal").attr('id'); 
            //alert('.'+$modalid+'-action-btn');    
			$('.'+$modalid+'-action-btn').prop("disabled", false);					   
			}
		});

	}


function core_button_append(element)
	{	
		$.ajax({ 
			type: "POST",url:$(element).data('action-path'),
			data: {},
			complete: function(){ },
			success: function(data)
			{
			logdata(data);
			$(data).appendTo($(element).data('append-to')).slideDown();
			}
		});

	}

function core_serialize (element)
	{	
		var theform=$(element).closest("form");
        
        $(theform).find('select').each(function() {
            if ($(this).is(':disabled')){ $(this).removeAttr("disabled");}
        });

		var serializeddata=theform.serializeArray();
		
		$("input:checkbox.core-checkbox").each(function() {
		if ($(this).is(":checked"))
		{serializeddata.push({name: $(this).attr("name"), value: 1});} 
		else 
		{serializeddata.push({name: $(this).attr("name"), value: 0});}		
		});
        
		$.ajax({ 
					type: "POST", url:$(element).data('action-path'),
					data:serializeddata,
					complete: function(){ },
					success: function(data){logdata(data);}
				});
		setTimeout(function(){window.location.reload();	},100);	
	}

function remove_modals()
	{
		$(".modal").remove();
		$(".modal-backdrop").remove();
		$("body").removeClass("modal-open");
        //setTimeout(function(){window.location.reload();	},100);
	}

/*
===========================================
Basics
===========================================
*/
wow = new WOW({
			  boxClass:     'core-wow', // default
			  animateClass: 'animated', // default
			  offset:       0,          // default
			  mobile:       true,       // default
			  live:         true        // default
			})
wow.init();


/*------------------General--------------------*/
$(document).on('hide', '.modal', function(){remove_modals;});

$(document).on('click','.core-accordion', function() {
        $(this).next().slideToggle(400);
    });


$( document ).ready(function() {    
    $.ajax({
                type: "POST",url: "core/actions/session.get.scrollpos.php",
                data: {},
                complete: function(){ },
                success: function(data){if(parseInt(data)!=0){$('html, body').animate({scrollTop:parseInt(data)},500);console.log(data);}}
            });
});

/*function load(div)
{ alert();
  div.fadeOut(0, function() {
    div.fadeIn(1000);
  });
}
$('div.core-lazyload-this').lazyload({load: load});*/

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

//-----------------------------------------------smooth scroll---------------------------
// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });


