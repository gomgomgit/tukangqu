@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Data Tukang</h4>
          </div>
          <div class="pull-right">
            <a href="{{ Route('admin.workers.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Tukang</a>
          </div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col" width="380px">Alamat</th>
							<th scope="col" width="150px">No HP</th>
							<th scope="col">Jenis</th>
							<th scope="col">Keahlian</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($datas as $data)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $data->name }}</td>
								<td>{{ $data->full_address }}</td>
								{{-- <td>{{ $data->address . ' Rt.'.$data->rt .' Rw.'.$data->rw . ' '.$data->location }}</td> --}}
								<td>{{ $data->phone_number }}</td>
								<td>{{ $data->workerKind->name }}</td>
								<td>
									@foreach ($data->skills as $skill)
										{{ $skill->name }},		
									@endforeach
								</td>
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
											<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
											{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
											<x-form-button 
													:action="route('admin.workers.destroy', $data->id)"
													method="DELETE"
													class="dropdown-item border-0"
											>
													<i class="dw dw-delete-3"></i> Delete
											</x-form-button>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="clearfix">
					<div class="pull-right">
						{{ $datas->links() }}
					</div>
				</div>
			</div>
			<!-- Striped table End -->
	</div>
@endsection