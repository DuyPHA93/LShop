let validator = $("#frm").validate({
	ignore: [],
	rules: {
		file:               { fileImage: true, filesize: 500000 }
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