<script>

	function changeProfileTopGallery() {
		$('#file_topgallery').click();
	}

	$('#file_topgallery').change(function () {
		if ($(this).val() != ''){
			upload(this);
		}
	});

	function uploadTopGallery(img) {
		var form_data = new FormData();
		form_data.append('file_topgallery', img.files[0]);
		form_data.append('_token', '{{csrf_token()}}');
		$('#loading').css('display', 'block');
		$.ajax({
			url: "{{url('/admin/topgalleries/ajax-image-upload')}}",
			data: form_data,
			type: 'POST',
			contentType: false,
			processData: false,
			success: function (data) {
				if (data.fail){
					$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
					alert(data.errors['file_topgallery']);
				}
				else {
					$('#file_name_topgallery').val(data);
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

		function removeFileTopGallery() {
			if ($('#file_name').val() != '')
				if (confirm('Вы точно хотите удалить эту картинку?')) {
					$('#loading').css('display', 'block');
					var form_data = new FormData();
					form_data.append('_method', 'DELETE');
					form_data.append('_token', '{{csrf_token()}}');
					$.ajax({
						url: '{{url('/admin/topgalleries/ajax-remove-image')}}' + '/' + $('#file_name').val(),
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

		function removeFileImgTopGallery() {
			if ($('a.myimg_topgallery').data('name') != '')
				if (confirm('Вы точно хотите удалить эту картинку?')) {
					$('#loading').css('display', 'block');
					var form_data = new FormData();
					form_data.append('_method', 'DELETE');
					form_data.append('_token', '{{csrf_token()}}');
					$.ajax({
						url: '{{url('/admin/topgalleries/ajax-remove-image')}}' + '/' + $('a.myimg_topgallery').data('name'),
						data: form_data,
						type: 'POST',
						contentType: false,
						processData: false,
						success: function (data) {
							$('#preview_image').attr('src', '{{asset('images/images/no_image.png')}}');
							$('#file_name_topgallery').val('');
							$('#loading').css('display', 'none');
						},
						error: function (xhr, status, error) {
							alert(xhr.responseText);
						}
					});
				}
		}


</script>