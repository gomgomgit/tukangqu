@extends('layouts.app') 

@section('main-content')
	{{-- <div class="card-box pd-20 height-100-p mb-30">
		<div class="row align-items-center">
			<div class="col-md-4">
				<img src="http://127.0.0.1:8000/deskapp/vendors/images/banner-img.png" alt="">
			</div>
			<div class="col-md-8">
				<h4 class="font-20 weight-500 mb-10 text-capitalize">
					Welcome back <div class="weight-600 font-30 text-blue">Johnny Brown!</div>
				</h4>
				<p class="font-18 max-width-600">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde hic non repellendus debitis iure, doloremque assumenda. Autem modi, corrupti, nobis ea iure fugiat, veniam non quaerat mollitia animi error corporis.</p>
			</div>
		</div>
	</div> --}}
	<div class="row">
		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="row d-flex flex-wrap align-items-center">
					{{-- <div class="progress-data">
						<div id="chart"></div>
					</div> --}}
					<div class="col-auto progress-data pl-4">
						<div class="position-relative" style="min-height: 116.7px;">
							<i class="icon-copy dw dw-building1 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
						</div>
					</div>
					<div class="col widget-data pl-5">
						<div class="weight-600 font-16">Total Proyek Bulan Ini</div>
						<div class="h4 mb-0">{{ $month_project }}</div>
						<div class="weight-600 font-14"><a href="{{ Route('admin.projects.onProcess') }}">View More ></a></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="row d-flex flex-wrap align-items-center">
					<div class="col-auto progress-data pl-4">
						<div class="position-relative" style="min-height: 116.7px;">
							<i class="icon-copy dw dw-group d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
						</div>
					</div>
					<div class="col widget-data pl-5">
						<div class="weight-600 font-16">Total Tukang</div>
						<div class="h4 mb-0">{{ $workers->count() }}</div>
						<div class="weight-600 font-14"><a href="{{ Route('admin.workers.index') }}">View More ></a></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="row d-flex flex-wrap align-items-center">
					<div class="col-auto progress-data pl-4">
						<div class="position-relative" style="min-height: 116.7px;">
							<i class="icon-copy dw dw-wallet1 d-block my-auto position-absolute text-info" style="font-size: 70px; top:50%; transform :translateY(-50%)"></i>
						</div>
					</div>
					<div class="col widget-data pl-5">
						<div class="weight-600 font-16">Total Income Bulan Ini</div>
						<div class="h3 mb-0">Rp. {{ number_format($month_income, 0,'.','.') }}</div>
						<div class="weight-600 font-14"><a href="{{ Route('admin.cashes.index') }}">View More ></a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-4 mb-30">
			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="mb-20">
						<h4 class="h4 text-black">Tukang Terbaru</h4>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col">Alamat</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($recent_workers as $worker)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $worker->name }}</td>
								<td>{{ $worker->domicile }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					<a href="{{ route('admin.workers.index') }}" class="btn btn-outline-primary btn-sm">View More</a>
				</div>
			</div>
			<!-- Striped table End -->
		</div>
		<div class="col-xl-8 mb-30">
			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="mb-20">
					<div class="">
						<h4 class="text-black h4">Survey Schedule</h4>
					</div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Waktu</th>
							<th scope="col">Surveyer</th>
							<th scope="col">Kontak</th>
							<th scope="col">Lokasi</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($schedules as $schedule)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>
									<div>
										{{ date('l, d-M-Y', strtotime($schedule->survey_date)) }}
									</div>
									<div>
										{{ \Carbon\Carbon::createFromFormat('H:i:s',$schedule->survey_time)->format('H:i') }}
									</div>
								</td>
								<td>{{ $schedule->surveyer->name }}</td>
								<td>{{ $schedule->surveyer->phone_number }}</td>
								<td>{{ $schedule->address }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					<a href="{{ Route('admin.dashboardSchedules') }}" class="btn btn-outline-primary btn-sm">View More</a>
				</div>
			</div>
			<!-- Striped table End -->
		</div>
	</div>
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="mb-20">
					<div>
						<h4 class="text-black h4">Project Terbaru</h4> 
					</div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Klien</th>
							<th scope="col">No Hp</th>
							<th scope="col">Proyek</th>
							<th scope="col">Pengerjaan</th>
							<th scope="col">Tgl Order</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($recent_projects as $project)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $project->client->name }}</td>
								<td>{{ $project->client->phone_number }}</td>
								<td>{{ $project->kind_project }}</td>
								<td>{{ $project->kind }}</td>
								<td>{{ $project->order_date }}</td>
								<td>
									@if ($project->status == 'OnProcess')
										<span class="badge badge-info">{{ Str::ucfirst($project->status) }}</span>
									@elseif ($project->status == 'OnProgress')
										<span class="badge badge-primary">{{ Str::ucfirst($project->status) }}</span>
									@elseif ($project->status == 'Finished')
										<span class="badge badge-success">{{ Str::ucfirst($project->status) }}</span>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="text-center">
					<a href="{{ route('admin.projects.onProcess') }}" class="btn btn-outline-primary btn-sm">View More</a>
				</div>
			</div>
			<!-- Striped table End -->
	</div>
@endsection

@section('script')
	<script src="{{ asset('deskapp/vendors/scripts/dashboard.js') }}"></script>
@endsection