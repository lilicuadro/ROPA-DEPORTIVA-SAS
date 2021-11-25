@extends('admin.master')

@section('title', 'Productos')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/products')}}"><i class="fas fa-boxes"></i>Productos</a>
</li>
@endsection


@section('content')
<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-boxes"></i>Productos</h2>
		</div>
		<div class="inside">
			<div class="btns">
				<a href="{{url('/admin/products/add')}}" class="btn btn-primary">
					<i class="fas fa-plus-circle"></i>Agregar producto</a>
			</div>
			<table class="table table-striped mtop16">
				<thead>
					<tr>
						<td>ID</td>
						<td></td>
						<td>Nombre</td>
						<td>Categoria</td>
						<td>Precio</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $p)
					<tr>
						<td>{{$p->id}}</td>
						<td width="64"><a href="{{url('/uploads/'.$p->file_path.'/'.$p->image)}}">
							<img src="{{url('/uploads/'.$p->file_path.'/t_'.$p->image)}}" width="64">
							</a>
						</td>
						<td>{{$p ->name}}</td>
						<td>{{$p->cat->name}}</td>
						<td>{{$p ->price}}</td>
						<td>
							<div class="opts">
								<a href="{{url('/admin/product/'.$p -> id.'/edit')}}" data-toggle="tooltip" data-bs-placement="top" title="Editar">
									<i class="fas fa-edit"></i></a>
								<a href="{{url('/admin/product/'.$p -> id.'/delete')}}" data-toggle="tooltip" data-bs-placement="top" title="Eliminar">	
									<i class="fas fa-trash"></i>
								</a>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection