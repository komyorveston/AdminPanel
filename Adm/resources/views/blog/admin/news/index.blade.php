@extends('layouts.app_admin')

@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Список новостей @endslot
			@slot('parent') Главная @endslot
			@slot('active') Список новостей @endslot
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
									<th>Дата создания</th>
									<th>Дата обновления</th>
									<th>Статус</th>
									<th>Действия</th>
								</tr>
								</thead>
								<tbody>
								@foreach($getAllNews as $news)
									<tr @if($news->status == 0) style="font-weight:bold"; @endif>
										<td>{{$news->id}}</td>
										<td><b>{{$news->title}} </b> </td>
										<td>{{$news->created_at}}</td>
										<td>{{$news->updated_at}}</td>
										<!--если статус true или 1 то on если false или 0 то off-->
										<td>{{$news->status ? 'On' : 'Off'}}</td>

										<td>
											<a href="{{route('blog.admin.news.edit', $news->id)}}" title="Редактировать"><i class="fa fa-fw fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											
											@if ($news->status == 0)
												<a class="delete" href="{{route('blog.admin.news.returnstatus', $news->id)}}" title="Перевести status = On"><i class="fa fa-fw fa-refresh">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@else
												<a class="delete" href="{{route('blog.admin.news.deletestatus', $news->id)}}" title="Перевести status = Off"><i class="fa fa-fw fa-close">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@endif

											@if ($news)
												<a class="delete" href="{{route('blog.admin.news.deletenews', $news->id)}}" title="Удалить из БД"><i class="fa fa-fw fa-close text-danger"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-center">
							<p>{{count($getAllNews)}} продуктов из {{$count}}</p>

							@if ($getAllNews->total() > $getAllNews->count())
							<br>
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
											{{$getAllNews->links()}}
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