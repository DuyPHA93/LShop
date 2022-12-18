$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
});

let validator = $("#frm").validate({
    rules: {
        startDate:          { required: true, dateFormat: true },
        endDate:            { required: true, dateFormat: true, dateGreaterThan: "#startDate" }
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