// Show image after uploaded
$('#file_upload').change(function(e) {
	const photo = document.getElementById('result_photo');
	const file = e.target.files[0];

	// Display
	photo.src = URL.createObjectURL(file);
	photo.onload = function() {
		URL.revokeObjectURL(photo.src) // free memory
	}
});

// ------ DEFAULT VALIDATION SETTING --------
jQuery.validator.setDefaults({
	errorClass: "error",
	success: function(label) {
		// Add check icon success
		label.addClass("success").html("<span><i class='fas fa-check'></i><span>");
	},
});

// Compare confirm password Method
jQuery.validator.addMethod("repassword", function(value, element) {
    const data = $("input[name='password']").val();
    return this.optional(element) || value === data;
}, jQuery.validator.format("Those passwords didn’t match. Try again."));

// Compare file size upload Method
jQuery.validator.addMethod("filesize", function(value, element, param) {
	return this.optional(element) || (element.files[0].size <= param);
}, jQuery.validator.format("Sorry, your file is too large."));

// Check file upload is valid image Method
jQuery.validator.addMethod("fileImage", function(value, element) {
	return this.optional(element) || ($.inArray(element.files[0].type, ["image/gif", "image/jpeg", "image/png"]) >= 0);
}, jQuery.validator.format("File is not an image."));

jQuery.validator.addMethod("dateFormat", function(value, element, params) {
	var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
	return this.optional(element) || (dateRegex.test($(element).val()));
}, jQuery.validator.format("Please enter a valid date."));

jQuery.validator.addMethod("dateGreaterThan", function(value, element, params) {
	return this.optional(element) || (new Date(parseDMY(value)) >= new Date(parseDMY($(params).val())));
}, jQuery.validator.format("Must be greater than Start date."));

function parseDMY(value) {
    var date = value.split("/");
    var d = parseInt(date[0], 10),
        m = parseInt(date[1], 10),
        y = parseInt(date[2], 10);
    return new Date(y, m - 1, d);
}

// $('#save_btn').click(function(e) {
// 	e.preventDefault();

// 	$("#frm").validate();

// 	let myForm = document.getElementById('frm');
// 	let formData = new FormData(myForm);

// 	$.ajax({
// 		url: $(myForm).attr('action'),
// 		data: formData,
// 		processData: false,
// 		contentType: false,
// 		type: 'POST',
// 		success: function(data){
// 		  	Swal.fire({
// 				title: 'Thành công!',
// 				text: "Dữ liệu của bạn đã được lưu.",
// 				icon: 'success',
// 				confirmButtonColor: '#428bca',
// 			  }).then(function() { window.location.href = $(myForm).data('list-url'); })
// 		},
// 		error: function(data, status) {
// 			Swal.fire({
// 				title: 'Oops...',
// 				text: "Có lỗi xảy ra ở máy chủ!",
// 				icon: 'error',
// 				confirmButtonColor: '#428bca',
// 			})
// 		},
// 	});
// })

// $('#cancel_btn').click(function(e) {
// 	e.preventDefault();
// 	window.location.href = $('#frm').data('list-url');
// })

function saveForm() {
	let myForm = document.getElementById('frm');
	let formData = new FormData(myForm);

	$.ajax({
		url: $(myForm).attr('action'),
		data: formData,
		processData: false,
		contentType: false,
		type: 'POST',
		success: function(data){
			if (data.status === 200) {
				Swal.fire({
					title: 'Thành công!',
					text: "Dữ liệu của bạn đã được lưu.",
					icon: 'success',
					confirmButtonColor: '#428bca',
				  }).then(function() { window.location.href = $(myForm).data('list-url'); })
			} else {
				Swal.fire({
					title: 'Oops...',
					text: data.message,
					icon: 'error',
					confirmButtonColor: '#428bca',
				})
			}
		},
		error: function(data, status) {
			Swal.fire({
				title: 'Oops...',
				text: "Có lỗi xảy ra ở máy chủ!",
				icon: 'error',
				confirmButtonColor: '#428bca',
			})
		},
	});
}