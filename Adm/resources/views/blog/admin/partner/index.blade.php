@extends('layouts.app_admin')


@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Список сотрудников @endslot
			@slot('parent') Главная @endslot
			@slot('active') Список сотрудников @endslot
		@endcomponent
	</section>

	<!--Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>ID</th>
									<th>Наименование</th>
									<th>Статус</th>
									<th>Действия</th>
								</tr>
								</thead>
								<tbody>
								@foreach($getAllPartners as $partner)
									<tr @if($partner->status == 0) style="font-weight:bold"; @endif>
										<td>{{$partner->id}}</td>
										<td><b>{{$partner->name}} </b> </td>
										<!--если статус true или 1 то on если false или 0 то off-->
										<td>{{$partner->status ? 'On' : 'Off'}}</td>

										<td>
											<a href="{{route('blog.admin.partners.edit', $partner->id)}}" title="Редактировать"><i class="fa fa-fw fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											
											@if ($partner->status == 0)
												<a class="delete" href="{{route('blog.admin.partners.returnstatus', $partner->id)}}" title="Перевести status = On"><i class="fa fa-fw fa-refresh">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@else
												<a class="delete" href="{{route('blog.admin.partners.deletestatus', $partner->id)}}" title="Перевести status = Off"><i class="fa fa-fw fa-close">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@endif

											@if ($partner)
												<a class="delete" href="{{route('blog.admin.partners.deletepartner', $partner->id)}}" title="Удалить из БД"><i class="fa fa-fw fa-close text-danger"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-center">
							<p>{{count($getAllPartners)}} продуктов из {{$count}}</p>

							@if ($getAllPartners->total() > $getAllPartners->count())
							<br>
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
											{{$getAllPartners->links()}}
										</div>
									</div>
								</div>
							</div>
						@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/.content-->
@endsection