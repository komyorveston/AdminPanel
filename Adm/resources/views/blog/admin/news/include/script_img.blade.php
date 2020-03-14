<script>

	function changeProfileNews() {
		$('#file_news').click();
	}

	$('#file_news').change(function () {
		if ($(this).val() != ''){
			upload(this);
		}
	});

	function uploadNews(img) {
		var form_data = new FormData();
		form_data.append('file_news', img.files[0]);
		form_data.append('_token', '{{csrf_token()}}');
		$('#loading').css('display', 'block');
		$.ajax({
			url: "{{url('/admin/news/ajax-image-upload')}}",
			data: form_data,
			type: 'POST',
			contentType: false,
			processData: false,
			success: function (data) {
				if (data.fail){
					$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
					alert(data.errors['file_news']);
				}
				else {
					$('#file_name').val(data);
					$('#preview_image').attr('src','{{asset('uploads/single')}}/' + data);
				}
				$ ('#loading').css('display', 'none');
			},
			error: function (xhr, status, error) {
				alert(xhr.responseText);
				$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
			}
		});
	}

		function removeFileNews() {
			if ($('#file_name').val() != '')
				if (confirm('Вы точно хотите удалить эту картинку news remove file news?')) {
					$('#loading').css('display', 'block');
					var form_data = new FormData();
					form_data.append('_method', 'DELETE');
					form_data.append('_token', '{{csrf_token()}}');
					$.ajax({
						url: '{{url('/admin/news/ajax-remove-image')}}' + '/' + $('#file_name').val(),
						data: form_data,
						type: 'POST',
						contentType: false,
						processData: false,
						success: function (data) {
							$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
							$('#file_name').val('');
							$('#loading').css('display', 'none');
						},
						error: function (xhr, status, error) {
							alert(xhr.responseText);
						}
					});
				}
		}

		function removeFileImgNews() {
			if ($('a.myimg_news').data('name') != '')
				if (confirm('Вы точно хотите удалить эту картинку news?')) {
					$('#loading').css('display', 'block');
					var form_data = new FormData();
					form_data.append('_method', 'DELETE');
					form_data.append('_token', '{{csrf_token()}}');
					$.ajax({
						url: '{{url('/admin/news/ajax-remove-image')}}' + '/' + $('a.myimg_news').data('name'),
						data: form_data,
						type: 'POST',
						contentType: false,
						processData: false,
						success: function (data) {
							$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
							$('#file_name').val('');
							$('#loading').css('display', 'none');
						},
						error: function (xhr, status, error) {
							alert(xhr.responseText);
						}
					});
				}
		}

</script>