@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Data Jadwal Survey</h4>
          </div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Surveyer</th>
							<th scope="col">No HP</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Waktu</th>
							<th scope="col">Lokasi</th>
							{{-- <th scope="col">Action</th> --}}
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($datas as $data)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $data->surveyer->name }}</td>
								<td>{{ $data->surveyer->phone_number }}</td>
								<td>{{ date('l, d-M-Y', strtotime($data->survey_date)) }}</td>
								<td>{{ \Carbon\Carbon::createFromFormat('H:i:s',$data->survey_time)->format('H:i') }}</td>
								<td>{{ $data->address .' '. $data->city }}</td>
								{{-- <td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
											<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
											<x-form-button 
													:action="route('admin.workers.destroy', $data->id)"
													method="DELETE"
													class="dropdown-item border-0"
											>
													<i class="dw dw-delete-3"></i> Delete
											</x-form-button>
										</div>
									</div>
								</td> --}}
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