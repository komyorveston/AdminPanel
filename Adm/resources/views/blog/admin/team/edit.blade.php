@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Редактирование сотрудника @endslot
			@slot('parent') Главная @endslot
			@slot('team') Список сотрудников @endslot
			@slot('active') Редактирование сотрудников {{$team->name}}@endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.teams.update', $team->id)}}" data-toggle="validator">
						@method('PATCH')
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="name">Имя сотрудника</label>
								<input type="text" name="name" class="form-control" id="title" placeholder="Имя сотрудника" value="{{$team->name}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label for="short_description">Краткое описание</label>
								<input type="text" name="short_description" class="form-control" id="description" placeholder="Краткое описание" value="{{$team->short_description}}">
							</div>
							<div class="form-group has-feedback">
								<label for="description">Полное описание</label>
								<textarea name="description" id="editorl" cols="80" rows="10">{{$team->description}}</textarea>
								
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status" {{ $team->status ? 'checked' : null}}>  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.team.include.image_single_edit')
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