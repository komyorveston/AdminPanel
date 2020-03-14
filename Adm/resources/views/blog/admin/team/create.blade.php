@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Добавление нового сотрудника @endslot
			@slot('parent') Главная @endslot
			@slot('team') Список сотрудников @endslot
			@slot('active') Список сотрудников @endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.teams.store', $item->id)}}" data-toggle="validator">
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="name">Имя сотрудника</label>
								<input type="text" name="name" class="form-control" id="title" placeholder="Имя сотрудника" value="{{old('name')}}" required>
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
								<label>
									<input type="checkbox" name="status">  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.team.include.image_single_create')
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