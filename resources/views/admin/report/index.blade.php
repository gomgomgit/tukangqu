@extends('layouts.app') 

@section('link')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"/>
@endsection

@php
	$month = Carbon\Carbon::now()->format('M yy');

	for ($i=6; $i >= 0; $i--) { 
			$listmonth[] = Carbon\Carbon::now()->subMonths($i)->format('F'); 
			$formatmonth = Carbon\Carbon::now()->subMonths($i)->format('m');
			$formatyear = Carbon\Carbon::now()->subMonths($i)->format('Y');
			$listmonthProjects[] = (App\Models\ContractProject::whereMonth('order_date', $formatmonth)->whereYear('order_date',$formatyear)->count()) + (App\Models\DailyProject::whereMonth('order_date', $formatmonth)->whereYear('order_date',$formatyear)->count());
			$listmonthIncome[] = (App\Models\Cash::where('category', 'in')->whereMonth('date', $formatmonth)->whereYear('date',$formatyear)->sum('money_in'));
	};

@endphp

@section('main-content')
	{{-- <div class="row">
		<div class="col-12 mb-30">
			<div class="card-box pd-20">
				@if ($surveyCount > 0)
					<p class="text-center mb-0"><span class="h3">Ada {{ $surveyCount }} Jadwal Survei Hari Ini! </span> <a class="text-primary text-sm" href="{{ route('admin.reportTodaySurvey') }}">cek jadwal survei</a></p>
				@else			
					<h5 class="text-center">Tidak Ada Jadwal Survei Hari Ini!</h5>
				@endif
			</div>
		</div>
	</div> --}}
	<div class="row">
		<div class="col-4 mb-30">
			<div>
				<div class="card-box height-100-p widget-style1 mb-4">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-inbox1 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Income Bulan Ini</div>
							<div class="h3 mb-2">Rp {{ number_format($month_income, 0,'.','.')}}</div>
							<div class="weight-600 font-14"><a href="/admin/cashes/export/in/{{ $month }}" class="btn btn-sm btn-primary py-1 px-3">Cetak</a></div>
						</div>
					</div>
				</div>
				<div class="card-box height-100-p widget-style1 mb-4">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-outbox1 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Pengeluaran Bulan Ini</div>
							<div class="h3 mb-2">Rp {{ number_format($month_outcome, 0,'.','.') }}</div>
							<div class="weight-600 font-14"><a href="/admin/cashes/export/out/{{ $month }}" class="btn btn-sm btn-primary py-1 px-3">Cetak</a></div>
						</div>
					</div>
				</div>
				<div class="card-box height-100-p widget-style1">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-money-2 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Kas</div>
							<div class="h3 mb-2">Rp {{ number_format($total_cash,0,'.','.') }}</div>
							<div class="weight-600 font-14"><a href="{{ Route('admin.cashes.index') }}" class="btn btn-sm btn-primary py-1 px-3">View More</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-8 mb-30">
			<div class="card-box height-100-p pd-20">
				<h2 class="h4 mb-20">Chart Project per Bulan</h2>
				<div id="incomeChart" style="height: 370px"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-8 mb-30">
			<div class="card-box height-100-p pd-20">
				<h2 class="h4 mb-20">Chart Project per Bulan</h2>
				<div id="projectsChart" style="height: 370px"></div>
			</div>
		</div>
		<div class="col-4 mb-30">
			<div>
				<div class="card-box height-100-p widget-style1 mb-4">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-building1 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Total Project</div>
							<div class="h3 mb-0">{{ $projects }}</div>
							{{-- <div class="weight-600 font-14"><a href="{{ Route('admin.cashes.index') }}">View More ></a></div> --}}
						</div>
					</div>
				</div>
				<div class="card-box height-100-p widget-style1 mb-4">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-map-11 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Total Project On Proccess</div>
							<div class="h3 mb-0">{{ $onprocess }}</div>
							{{-- <div class="weight-600 font-14"><a href="{{ Route('admin.cashes.index') }}">View More ></a></div> --}}
						</div>
					</div>
				</div>
				<div class="card-box height-100-p widget-style1">
					<div class="row d-flex flex-wrap align-items-center">
						<div class="col-auto progress-data pl-4">
							<div class="position-relative" style="min-height: 116.7px;">
								<i class="icon-copy dw dw-cone d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
							</div>
						</div>
						<div class="col widget-data pl-5">
							<div class="weight-600 font-16">Total Project On Progress</div>
							<div class="h3 mb-0">{{ $onprogress }}</div>
							{{-- <div class="weight-600 font-14"><a href="{{ Route('admin.cashes.index') }}">View More ></a></div> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="pd-20 card-box mb-30">
				<div class="mb-20">
					<div>
						<h4 class="text-black h4">Project per Kota</h4>
					</div>
				</div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col">Banyak Project</th>
							<th scope="col">Project Selesai</th>
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
									<span class="badge badge-info" style="font-size: 14px">{{ Str::ucfirst($city->countprojects) }}</span>
								</td>
								<td>
									<span class="badge badge-primary" style="font-size: 14px">
										{{ Str::ucfirst($city->contractprojects()->where('status', 'Finished')->count() + $city->dailyprojects()->where('status', 'Finished')->count()) }}
									</span>
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
			const dataincome = {
				chart: { labels: @json($listmonth) },
				datasets: [
					{ name: 'Income', values: @json($listmonthIncome) },
				],
			}

			const chart = new Chartisan({
				el: '#projectsChart',
				data: dataprojects,
				hooks: new ChartisanHooks()
					.colors(['#1B00FF	', '#ffffff'])
					.responsive()
					.beginAtZero()
					.legend({ position: 'bottom' })
					.title('Projects 6 bulan terakhir')
					.datasets(['bar']),
			})
			const chart2 = new Chartisan({
				el: '#incomeChart',
				data: dataincome,
				hooks: new ChartisanHooks()
					.colors(['#1B00FF	', '#ffffff'])
					.responsive()
					.beginAtZero()
					.legend({ position: 'bottom' })
    			.borderColors()
					.title('Income 6 bulan terakhir')
					.datasets([{ type: 'line', fill: false }]),
			})
		</script>

@endsection