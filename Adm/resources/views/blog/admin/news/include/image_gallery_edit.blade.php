 
<div class="box box-primary box-solid file-upload">
	<div class="box-header">
		<h3 class="box-title">Картинки галереи</h3>
	</div>
	<div class="box-body" id="galleryjs-news">
		<div id="multi" class="btn btn-success" data-url="{{url('/admin/news/gallery')}}" data-name="multi">Загрузить</div>
		<div class="multi">
			@if (!empty($images))
				<p><small>Для удаления нажмите на картинку.</small></p>
				@foreach($images as $image)
					<img src='{{asset("/uploads/gallery/$image")}}' 
						alt="" 
						style="max-height: 150px; cursor: pointer;" 
						data-id="{{$news->id}}" 
						data-src="{{$image}}" 
						class="del-items-news"
					>
				@endforeach
			@endif
			<p><small>Рекомендуемые размеры: 700 ш. х 1000 в.</small></p>
		</div>
	</div>
	<!--my.css .overlay{}-->
	<div class="overlay">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
</div>