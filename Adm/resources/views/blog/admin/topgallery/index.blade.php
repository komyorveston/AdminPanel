@extends('layouts.app_admin')

@section('content')
	<section class="content-header">
		@component('blog.admin.components.breadcrumb')
			@slot('title') Список галерей @endslot
			@slot('parent') Главная @endslot
			@slot('active') Список галерей @endslot
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
									<th>Фото</th>
									<th>Статус</th>
									<th>Действия</th>
								</tr>
								</thead>
								<tbody>
								@foreach($getAllTopgalleries as $topgallery)
									<tr @if($topgallery->status == 0) style="font-weight:bold"; @endif>
										<td>{{$topgallery->id}}</td>
										<td>{{$topgallery->title}} </td>
										<td>
										<div class="box-body" id="image" style="border: 1px solid whitesmoke; text-align: left; position: relative">
											@if ($topgallery->img == null)
												<img width="20%" height="10%" src='{{asset("/images/images/no_image.png")}}' id="preview_image" />
											@else
												<img width="20%" height="10%" src='{{asset("/uploads/single/$topgallery->img")}}' id="preview_image" />
											@endif
										</div>
										</td>
										<!--если статус true или 1 то on если false или 0 то off-->
										<td>{{$topgallery->status ? 'On' : 'Off'}}</td>

										<td>
											<a href="{{route('blog.admin.topgalleries.edit', $topgallery->id)}}" title="Редактировать"><i class="fa fa-fw fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											
											@if ($topgallery->status == 0)
												<a class="delete" href="{{route('blog.admin.topgalleries.returnstatus', $topgallery->id)}}" title="Перевести status = On"><i class="fa fa-fw fa-refresh">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@else
												<a class="delete" href="{{route('blog.admin.topgalleries.deletestatus', $topgallery->id)}}" title="Перевести status = Off"><i class="fa fa-fw fa-close">&nbsp;&nbsp;&nbsp;&nbsp;</i></a>
											@endif

											@if ($topgallery)
												<a class="delete" href="{{route('blog.admin.topgalleries.deletetopgallery', $topgallery->id)}}" title="Удалить из БД"><i class="fa fa-fw fa-close text-danger"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-center">
							<p>{{count($getAllTopgalleries)}} продуктов из {{$count}}</p>

							@if ($getAllTopgalleries->total() > $getAllTopgalleries->count())
							<br>
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
											{{$getAllTopgalleries->links()}}
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