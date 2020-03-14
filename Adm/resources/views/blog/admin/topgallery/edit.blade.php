@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Редактирование галереи @endslot
			@slot('parent') Главная @endslot
			@slot('topgallery') Список галереи @endslot
			@slot('active') Редактирование галереи {{$topgallery->title}}@endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.topgalleries.update', $topgallery->id)}}" data-toggle="validator">
						@method('PATCH')
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="title">Имя галереи</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Имя галереи" value="{{$topgallery->title}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status" {{ $topgallery->status ? 'checked' : null}}>  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.topgallery.include.image_single_edit')
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