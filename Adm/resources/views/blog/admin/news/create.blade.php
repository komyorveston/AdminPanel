@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Добавление новости @endslot
			@slot('parent') Главная @endslot
			@slot('news') Список новостей @endslot
			@slot('active') Список новостей @endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.news.store', $item->id)}}" data-toggle="validator">
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Наименование новости</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Наименование новости" value="{{old('title')}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label name="keywords">Ключевые слова</label>
								<input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова" value="{{old('keywords')}}">
							</div>
							<div class="form-group">
								<label for="description">Краткое описание</label>
								<input type="text" name="description" class="form-control" id="description" placeholder="Краткое описание" value="{{old('description')}}">
							</div>
							<div class="form-group has-feedback">
								<label for="content">Контент</label>
								<textarea name="content" id="editorl" cols="80" rows="10">{{old('content')}}</textarea>
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
									@include('blog.admin.news.include.image_single_create')
								</div>
								<div class="col-md-8">
									@include('blog.admin.news.include.image_gallery_create')
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