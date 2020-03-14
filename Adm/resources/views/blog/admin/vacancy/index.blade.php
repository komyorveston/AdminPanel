@extends('layouts.app_admin')

@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Список вакансий @endslot
			@slot('parent') Главная @endslot
			@slot('active') Список вакансий @endslot
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
								@foreach($getAllVacancies as $vacancy)
									<tr @if($vacancy->status == 0) style="font-weight:bold"; @endif>
										<td>{{$vacancy->id}}</td>
										<td><b>{{$vacancy->title}} </b></td>
										<!--если статус true или 1 то on если false или 0 то off-->
										<td>{{$vacancy->status ? 'On' : 'Off'}}</td>

										<td>
											<a href="{{route('blog.admin.vacancies.edit', $vacancy->id)}}" title="Редактировать"><i class="fa fa-fw fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											
											@if ($vacancy->status == 0)
												<a class="delete" href="{{route('blog.admin.vacancies.returnstatus', $vacancy->id)}}" title="Перевести status = On"><i class="fa fa-fw fa-refresh">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@else
												<a class="delete" href="{{route('blog.admin.vacancies.deletestatus', $vacancy->id)}}" title="Перевести status = Off"><i class="fa fa-fw fa-close">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@endif

											@if ($vacancy)
												<a class="delete" href="{{route('blog.admin.vacancies.deletevacancy', $vacancy->id)}}" title="Удалить из БД"><i class="fa fa-fw fa-close text-danger"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-center">
							<p>{{count($getAllVacancies)}} продуктов из {{$count}}</p>

							@if ($getAllVacancies->total() > $getAllVacancies->count())
							<br>
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
											{{$getAllVacancies->links()}}
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