@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Редактирование сервиса @endslot
			@slot('parent') Главная @endslot
			@slot('service') Список сервисов @endslot
			@slot('active') Редактирование сервиса {{$service->title}}@endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.services.update', $service->id)}}" data-toggle="validator">
						@method('PATCH')
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Наименование сервиса</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Наименование сервиса" value="{{$service->title}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label for="short_description">Краткое описание</label>
								<input type="text" name="short_description" class="form-control" id="description" placeholder="Краткое описание" value="{{$service->short_description}}">
							</div>
							<div class="form-group has-feedback">
								<label for="description">Полное описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{$service->description}}</textarea>
							</div>
							<div class="form-group">
								<label for="meta_desc">Мета описание</label>
								<input type="text" name="meta_desc" class="form-control" id="description" placeholder="Мета описание" value="{{$service->meta_desc}}">
							</div>
							<div class="form-group">
								<label for="meta_tags">Мета тэги</label>
								<input type="text" name="meta_tags" class="form-control" id="description" placeholder="Мета тэги" value="{{$service->meta_tags}}">
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status" {{ $service->status ? 'checked' : null}}>  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.service.include.image_single_edit')
								</div>
								<div class="col-md-8">
									@include('blog.admin.service.include.image_gallery_edit')
								</div>
							</div>
						</div>
						<input type="hidden" id="_token" value="{{csrf_token()}}">
						<div class="box-footer">
							<button type="submit" class="btn btn-success">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!--/.content-->
	<div class='hidden' data-name='{{$id}}'></div>
@endsection