@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Добавление нового партнёра @endslot
			@slot('parent') Главная @endslot
			@slot('partner') Список партнёров @endslot
			@slot('active') Список партнёров @endslot
		@endcomponent
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<form method="POST" action="{{route('blog.admin.partners.store', $item->id)}}" data-toggle="validator">
						@csrf
						<div class="box-body">
							<div class="form-group has-feedback">
								<label for="name">Наименование партнёра</label>
								<input type="text" name="name" class="form-control" id="title" placeholder="Наименование партнёра" value="{{old('name')}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group has-feedback">
								<label for="web_site">Вебсайт</label>
								<input type="text" name="web_site" class="form-control" id="title" placeholder="Вебсайт" value="{{old('web_site')}}" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="form-group">
								<label>
									<input type="checkbox" name="status">  Статус
								</label>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									@include('blog.admin.partner.include.image_single_create')
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