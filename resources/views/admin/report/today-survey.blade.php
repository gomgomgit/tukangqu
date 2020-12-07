@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Data Jadwal Survey Hari Ini</h4>
          </div>
          <div class="pull-right pr-3">
            <a href="{{ Route('admin.workers.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Tukang</a>
          </div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Surveyer</th>
							<th scope="col">No HP</th>
							<th scope="col">Jam</th>
							<th scope="col">Lokasi</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($todaySurveys as $data)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $data->surveyer->name }}</td>
								<td>{{ $data->surveyer->phone_number }}</td>
								<td>{{ \Carbon\Carbon::createFromFormat('H:i:s',$data->survey_time)->format('H:i') }}</td>
								<td>{{ $data->address .' '. $data->city }}</td>
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