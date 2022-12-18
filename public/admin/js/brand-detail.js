let validator = $("#frm").validate();

$('#save_btn').click(function(e) {
	e.preventDefault();

	if (!validator.form()) return false;

	saveForm();
})

$('#cancel_btn').click(function(e) {
	e.preventDefault();
	window.location.href = $('#frm').data('list-url');
})