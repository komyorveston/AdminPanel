<div class="box box-danger box-solid">
	<div class="box-header">
		<h3 class="box-title">Базовое изображение</h3>
	</div>
	<div class="box-body" id="image" style="border: 1px solid whitesmoke; text-align: center; position: relative">
		@if ($team->img == null)
			<img width="50%" height="50%" src='{{asset("/images/images/no_image.png")}}' id="preview_image" />
		@else
			<img width="50%" height="50%" src='{{asset("/uploads/single/$team->img")}}' id="preview_image" />
		@endif

		<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute; left: 40%; top: 40%; display: none"></i>
	</div>
	<p style="text-align: center">
		<a href="javascript:changeProfileTeam()" style="text-decoration: none;" data-name="single">
			<i class="glyphicon glyphicon-edit"></i> Загрузить
		</a>&nbsp;&nbsp;
		@if ($team->img == null)
			<a href="javascript:removeFileTeam()" style="color: red; text-decoration: none;" class="nothing">
				<i class="glyphicon glyphicon-trash"></i> Удалить
			</a>
		@else
			<a href="javascript:removeFileImgTeam()" style="color: red; text-decoration: none;" class="myimg_team" data-name="{{$team->img}}">
				<i class="glyphicon glyphicon-trash"></i>Удалить
			</a>
		@endif
	</p>
	<input type="file" id="file_team" style="display: none" />
	<input type="hidden" id="file_name_team"/>
	<p style="text-align: center"><small>Рекомендуемые размеры: 125ш.х200в.</small></p>
</div>