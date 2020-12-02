@extends('layouts.app') 

@section('link')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"/>
@endsection

@php

	for ($i=0; $i <= 4; $i++) { 
			$listmonth[] = Carbon\Carbon::now()->subMonths($i)->format('F'); 
			$formatmonth = Carbon\Carbon::now()->subMonths($i)->format('m');
			$listmonthProjects[] = (App\Models\ContractProject::whereMonth('order_date', $formatmonth)->count()) + (App\Models\DailyProject::whereMonth('order_date', $formatmonth)->count());
	};

@endphp

@section('main-content')
	<div class="row">
		<div class="col-8">
			<div class="pd-20 card-box mb-30">
				<div class="mb-20">
					<div>
						<h4 class="text-black h4">Kota Terbanyak</h4>
					</div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col">Banyak Project</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($most_city as $city)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $city->name }}, {{ $city->province->name }}</td>
								<td>
									<span class="badge badge-primary">{{ Str::ucfirst($city->countprojects) }}</span>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					<a href="{{ route('admin.projects.onProcess') }}" class="btn btn-outline-primary btn-sm">View More</a>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-xl-8 mb-30">
			<div class="card-box height-100-p pd-20">
				<h2 class="h4 mb-20">Activity</h2>
				<div id="projectsChart" style="height: 400px"></div>
			</div>
		</div>
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

		{{-- ChartJS --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

		<!-- Chartisan -->
		<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

		<script>
			const dataprojects = {
				chart: { labels: @json($listmonth) },
				datasets: [
					{ name: 'Project', values: @json($listmonthProjects)},
				],
			}

			const chart = new Chartisan({
				el: '#projectsChart',
				data: dataprojects,
				hooks: new ChartisanHooks()
					.colors(['#1B00FF	', '#4299E1'])
					.responsive()
					.beginAtZero()
					.legend({ position: 'bottom' })
					.title('Projects for the last 5 months')
					.datasets(['bar']),
			})
		</script>

@endsection