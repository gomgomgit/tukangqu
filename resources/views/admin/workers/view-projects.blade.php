@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Data Proyek Tukang</h4>
          </div>
          <div class="pull-right pr-3">
            <a href="{{ Route('admin.workers.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Tukang</a>
          </div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Proyek</th>
							<th scope="col">Jenis</th>
							<th scope="col">Tgl Order</th>
							<th scope="col" width="300px">Alamat</th>
							<th scope="col" class="text-center">Nilai Proyek</th>
							<th scope="col" class="text-center">Keuntungan</th>
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
								<td>{{ $data->kind_project }}</td>
								<td>{{ $data->kind }}</td>
								<td>{{ $data->order_date }}</td>
								<td>
									<p>{{ $data->address }} </p> 
									<span class="">{{ $data->city }}</span>
								</td>
								<td class="text-center">{{ $data->project_value ?? '---' }}</td>
								<td class="text-center">{{ $data->profit ?? '---' }}</td>
								<td>
									<a class="btn btn-primary py-1 px-3" href="{{ Route('admin.projects.finishedShow', [$data->id, Str::lower($data->kind)]) }}">View</a>
									{{-- <div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
											<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a> --}}
											{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
											{{-- <x-form-button 
													:action="route('admin.workers.destroy', $data->id)"
													method="DELETE"
													class="dropdown-item border-0"
											>
													<i class="dw dw-delete-3"></i> Delete
											</x-form-button>
										</div> --}}
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