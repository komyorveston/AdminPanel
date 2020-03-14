@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Добавление новой вакансии @endslot
			@slot('parent') Главная @endslot
			@slot('vacancy') Список вакансий @endslot
			@slot('active') Список вакансий @endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.vacancies.store', $item->id)}}" data-toggle="validator">
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Заголовок вакансии</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Заголовок вакансии" value="{{old('title')}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group has-feedback">
								<label for="description">Описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{old('description')}}</textarea>
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status">  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.vacancy.include.image_single_create')
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