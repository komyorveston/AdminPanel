@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Добавление нового сервиса @endslot
			@slot('parent') Главная @endslot
			@slot('service') Список сервисов @endslot
			@slot('active') Список сервисов @endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.services.store', $item->id)}}" data-toggle="validator">
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Наименование сервиса</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Наименование сервиса" value="{{old('title')}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label for="short_description">Краткое описание</label>
								<input type="text" name="short_description" class="form-control" id="description" placeholder="Кратке описание" value="{{old('short_description')}}">
							</div>
							<div class="form-group has-feedback">
								<label for="description">Полное описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{old('description')}}</textarea>
							</div>
							<div class="form-group">
								<label for="meta_desc">Мета описание</label>
								<input type="text" name="meta_desc" class="form-control" id="description" placeholder="Мета описание" value="{{old('meta_desc')}}">
							</div>
							<div class="form-group">
								<label for="meta_tags">Мета тэги</label>
								<input type="text" name="meta_tags" class="form-control" id="description" placeholder="Мета тэги" value="{{old('meta_tags')}}">
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status">  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.service.include.image_single_create')
								</div>
								<div class="col-md-8">
									@include('blog.admin.service.include.image_gallery_create')
								</div>
							</div>
						</div>
						<input type="hidden" id="_token" value="{{csrf_token()}}">
						<div class="box-footer">
							<button type="submit" class="btn btn-success">Добавить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!--/.content-->
@endsection