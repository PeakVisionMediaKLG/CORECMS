
<script>
var CKEDITOR_BASEPATH = 'components/ckeditor/';
</script>
<script src="components/ckeditor/ckeditor.js"></script>


<script>
	function openKCFinder(field) {
		window.KCFinder = {
			callBack: function(url) {
				field.value = url;
				//alert (field.value);
				window.KCFinder = null;
				
				$.ajax({ 
					type: "POST",url: "../../core/actions/img.update.src.php",
					data: {"id":field.id,"content":url},
					complete: function(){ },
					success: function(data){console.log(data)}
				});
				
			}
		};
		window.open('/components/kcfinder/browse.php?type=images', 'kcfinder_textbox',
			'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
			'resizable=1, scrollbars=0, width=800, height=600'
		);
	}
</script>