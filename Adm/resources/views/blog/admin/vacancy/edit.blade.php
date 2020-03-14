@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Редактирование вакансии @endslot
			@slot('parent') Главная @endslot
			@slot('vacancy') Список вакансий @endslot
			@slot('active') Редактирование вакансии {{$vacancy->title}}@endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.vacancies.update', $vacancy->id)}}" data-toggle="validator">
						@method('PATCH')
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Заголовок вакансии</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Заголовок вакансии" value="{{$vacancy->title}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group has-feedback">
								<label for="description">Описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{$vacancy->description}}</textarea>
								
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status" {{ $vacancy->status ? 'checked' : null}}>  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.vacancy.include.image_single_edit')
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