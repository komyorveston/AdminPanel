@extends('layouts.app_admin')

@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Редактирование страницы @endslot
			@slot('parent') Главная @endslot
			@slot('staticpage') Список продуктов @endslot
			@slot('active') Редактирование продукта {{$staticpage->title}}@endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.staticpages.update', $staticpage->id)}}" data-toggle="validator">
						@method('PATCH')
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Наименование страницы</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Наименование страницы" value="{{$staticpage->title}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label for="short_description">Краткое описание</label>
								<input type="text" name="short_description" class="form-control" id="description" placeholder="Краткое описание" value="{{$staticpage->short_description}}">
							</div>
							<div class="form-group has-feedback">
								<label for="description">Полное описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{$staticpage->description}}</textarea>
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status" {{ $staticpage->status ? 'checked' : null}}>  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.staticpage.include.image_single_edit')
								</div>
								<div class="col-md-8">
									@include('blog.admin.staticpage.include.image_gallery_edit')
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