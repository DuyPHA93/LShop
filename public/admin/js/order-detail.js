$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

let validator = $("#frm").validate({
	errorPlacement: function(error, element) {
		if (element.attr("name") == "totalWeight") {
			error.insertAfter(element.closest(".d-input-group"));
		}
		else {
			error.insertAfter(element);
		}
	}
});

function apply(isDeny) {
	let myForm = document.getElementById('frm');
	let formData = new FormData(myForm);

	if (isDeny) {
		formData.append('isDeny', 1);
	}

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
					text: "Đơn hàng đã được cập nhật trạng thái.",
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

$('#apply_btn').click(function() {
	$("textarea[name=reasonCancelOrder]").rules("remove", "required");
	if (!validator.form()) return false;

	apply(false);
})

$('#cancel_order_btn').click(function() {
	$("textarea[name=reasonCancelOrder]").rules("add", "required");
	if (!validator.form()) return false;

	Swal.fire({
		title: 'Bạn có chắc không ?',
		text: "Bạn sẽ không thể hoàn tác điều này !",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#428bca',
		cancelButtonColor: '#d9534f',
		confirmButtonText: 'Đồng ý, hủy nó!',
		cancelButtonText: 'Hủy bỏ'
	  }).then((result) => {
		if (result.isConfirmed) {
			apply(true);
		}
	})
})