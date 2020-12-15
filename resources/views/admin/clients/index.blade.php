@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Data Klien</h4>
          </div>
          <div class="pull-right pr-3">
            <a href="{{ Route('admin.clients.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Klien</a>
          </div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col" width="150px">No HP</th>
							<th scope="col" width="380px">Alamat</th>
							<th scope="col">Proyek</th>
							<th scope="col" class="datatable-nosort">Action</th>
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
								<td>{{ $data->phone_number }}</td>
								<td>
									<p>{{ $data->address }} </p> 
									<span class="">{{ $data->city }}</span>
								</td>
								<td>
									{{ $data->projectscount }} 
									@if ($data->projectscount)
										<a href={{ Route('admin.clients.viewProjects', $data->id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a></td>	
									@endif
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="{{ Route('admin.clients.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
											<a class="dropdown-item" href="{{ Route('admin.clients.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
											{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
											<x-form-button 
													:action="route('admin.clients.destroy', $data->id)"
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
			</div>
			<!-- Striped table End -->
	</div>
@endsection

@section('script')
		
		<!-- buttons for Export datatable -->
		<script src="{{ asset('deskapp/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
		<script src="{{ asset('deskapp/src/plugins/datatables/js/vfs_fonts.js') }}"></script>
		<!-- Datatable Setting js -->
		<script src="{{ asset('deskapp/vendors/scripts/datatable-setting.js') }}"></script>

@endsection