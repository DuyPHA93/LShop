$('#product_type_select').change(function() {
	const productTypeId = $(this).val();
	$.get($(this).data('ajax-url'), {productTypeId: productTypeId}, function(data, status){
		$('#brand_select').html(data);
  	});
})

const isNew = $('#product_id').val() ? false : true;

let validator = $("#frm").validate({
	ignore: [],
	rules: {
		file:               { required: isNew, fileImage: true, filesize: 500000 },
		description:       	{ required: function(mydata) { 
			CKEDITOR.instances[mydata.id].updateElement();
			var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
			return memberdatacontent.length === 0;
		  } 
		},
	},
	invalidHandler: function(event, validator) {
		var errors = validator.numberOfInvalids();
		// $('#ShowAlert').alertDanger("<b>Oh snap!</b> Change a few things up and try submitting again.");
		if (errors) {                    
			validator.errorList[0].element.focus();
		}
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "file" ) {
			$("#file_errorMsg").append(error);
		}
		else if (element.attr("name") == "price") {
			error.insertAfter(element.closest(".d-input-group"));
		} else if (element.attr("name") == "description") {
			error.insertBefore("textarea#editor1");
		}
		else {
			error.insertAfter(element);
		}
	}
});

$('#save_btn').click(function(e) {
	e.preventDefault();

	if (!validator.form()) return false;

	saveForm();
})

$('#cancel_btn').click(function(e) {
	e.preventDefault();
	window.location.href = $('#frm').data('list-url');
})

CKEDITOR.replace( 'editor1',
{
    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
    // filebrowserUploadUrl: 'http://localhost:8080/MobiShop-Layout/master/upload/upload.php',
    // filebrowserImageUploadUrl: 'http://localhost:8080/MobiShop-Layout/master/upload/upload.php',
    filebrowserUploadUrl: '',
    filebrowserImageUploadUrl: '',
    filebrowserUploadMethod: 'form',
});

CKEDITOR.instances.editor1.on('change', function() { 
	// $('#editor1').text(CKEDITOR.instances.editor1.getData());
	// $("#editor1").change();
	$("#frm").validate().element("#editor1");
});