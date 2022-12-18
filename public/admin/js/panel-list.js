$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$('#choose_all').change(function(e) {
	$('.choose').each(function(index, element) {
		if ($(e.target).is(':checked')) {
			$(element).prop('checked', true);
		} else {
			$(element).prop('checked', false);
		}

		$(element).change();
	})
})

$('.choose').change(function(e) {
	if ($(e.target).is(':checked')) {
		$(e.target).closest('tr').addClass("row-warning");
	} else {
		$(e.target).closest('tr').removeClass("row-warning");
	}
})

$('.table-paging ul li.disabled').click(function(e) {
	e.preventDefault();
});

$('#select_perPage').change(function() {
	$('#frm').submit();
})

$('#select_filter').change(function() {
	$('#frm').submit();
})

$('.action .delete').click(function(e) {
	e.preventDefault();
	
	const url = $(this).attr('href');
	const ids = $(this).data('id');

	Swal.fire({
		title: 'Bạn có chắc không ?',
		text: "Bạn sẽ không thể hoàn tác điều này !",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#428bca',
		cancelButtonColor: '#d9534f',
		confirmButtonText: 'Đồng ý, xóa nó!',
		cancelButtonText: 'Hủy bỏ'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post(url, { "id": [ids] }, function(data, status) {
				if (data.status === 200) {
					Swal.fire({
						title: 'Đã xóa!',
						text: "Dữ liệu của bạn đã được xóa.",
						icon: 'success',
						confirmButtonColor: '#428bca',
					  }).then(function() { location.reload(true); })
				} else {
					Swal.fire({
						title: 'Oops...',
						text: "Có lỗi xảy ra ở máy chủ!",
						icon: 'error',
						confirmButtonColor: '#428bca',
					})
				}
			});
		}
	  })
})

$('.action .disable').click(function(e) {
	e.preventDefault();

	const url = $(this).attr('href');
	const ids = $(this).data('id');

	$.post(url, { "id": [ids] }, function(data, status) {
		if (data.status === 200) {
			Swal.fire({
				title: 'Đã tắt!',
				text: "Dữ liệu của bạn đã được vô hiệu.",
				icon: 'success',
				confirmButtonColor: '#428bca',
			  }).then(function() { location.reload(true); })
		} else {
			Swal.fire({
				title: 'Oops...',
				text: "Có lỗi xảy ra ở máy chủ!",
				icon: 'error',
				confirmButtonColor: '#428bca',
			})
		}
	});
})

$('.table-bulk-action .delete').click(function(e) {
	e.preventDefault();

	const url = $(this).attr('href');
	// const ids = $(this).data('id');
	const checked = $('.choose').filter(':checked');
	let ids = [];

	$(checked).each(function(index) {
		const id = $(this).closest('tr').find('.action .delete').data('id');
		ids.push(id);
	})

	Swal.fire({
		title: 'Bạn có chắc không ?',
		text: "Đã tìm thấy "+ checked.length +" mục cần xóa. Bạn sẽ không thể hoàn tác điều này !",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#428bca',
		cancelButtonColor: '#d9534f',
		confirmButtonText: 'Đồng ý, xóa nó!',
		cancelButtonText: 'Hủy bỏ'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post(url, { "id": ids }, function(data, status) {
				if (data.status === 200) {
					Swal.fire({
						title: 'Đã xóa!',
						text: checked.length + " mục đã được xóa.",
						icon: 'success',
						confirmButtonColor: '#428bca',
					  }).then(function() { location.reload(true); })
				} else {
					Swal.fire({
						title: 'Oops...',
						text: "Có lỗi xảy ra ở máy chủ!",
						icon: 'error',
						confirmButtonColor: '#428bca',
					})
				}
			});
		}
	  })
})

$('.table-bulk-action .disable').click(function(e) {
	e.preventDefault();

	const url = $(this).attr('href');
	// const ids = $(this).data('id');
	const checked = $('.choose').filter(':checked');
	let ids = [];

	$(checked).each(function(index) {
		const id = $(this).closest('tr').find('.action .disable').data('id');
		ids.push(id);
	})

	$.post(url, { "id": ids }, function(data, status) {
		if (data.status === 200) {
			Swal.fire({
				title: 'Đã tắt!',
				text: checked.length + " mục đã được vô hiệu.",
				icon: 'success',
				confirmButtonColor: '#428bca',
			  }).then(function() { location.reload(true); })
		} else {
			Swal.fire({
				title: 'Oops...',
				text: "Có lỗi xảy ra ở máy chủ!",
				icon: 'error',
				confirmButtonColor: '#428bca',
			})
		}
	});
})