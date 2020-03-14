<div class="box box-danger box-solid">
	<div class="box-header">
		<h3 class="box-title">Базовое изображение</h3>
	</div>
	<div class="box-body" id="image" style="border: 1px solid whitesmoke; text-align: center; position: relative">
		@if ($news->img == null)
			<img width="50%" height="50%" src='{{asset("/images/images/no_image.png")}}' id="preview_image" />
		@else
			<img width="50%" height="50%" src='{{asset("/uploads/single/$news->img")}}' id="preview_image" />
		@endif

		<i id="loading_news" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute; left: 40%; top: 40%; display: none"></i>
	</div>
	<p style="text-align: center">
		<a href="javascript:changeProfileNews()" style="text-decoration: none;" data-name="single">
			<i class="glyphicon glyphicon-edit"></i> Загрузить
		</a>&nbsp;&nbsp;
		@if ($news->img == null)
			<a href="javascript:removeFileNews()" style="color: red; text-decoration: none;" class="nothing">
				<i class="glyphicon glyphicon-trash"></i> Удалить
			</a>
		@else
			<a href="javascript:removeFileImgNews()" style="color: red; text-decoration: none;" class="myimg_news" data-name="{{$news->img}}">
				<i class="glyphicon glyphicon-trash"></i>Удалить
			</a>
		@endif
	</p>
	<input type="file" id="file_news" style="display: none" />
	<input type="hidden" id="file_name"/>
	<p style="text-align: center"><small>Рекомендуемые размеры: 125ш.х200в.</small></p>
</div>  