@extends('layouts.app')

@section('main-content')
	<div class="card-box pd-20 height-100-p mb-30">
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
	</div>
	<div class="row">
		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="d-flex flex-wrap align-items-center">
					<div class="progress-data">
						<div id="chart"></div>
					</div>
					<div class="widget-data">
						<div class="h4 mb-0">2020</div>
						<div class="weight-600 font-14">Contact</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="d-flex flex-wrap align-items-center">
					<div class="progress-data">
						<div id="chart2"></div>
					</div>
					<div class="widget-data">
						<div class="h4 mb-0">400</div>
						<div class="weight-600 font-14">Deals</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 mb-30">
			<div class="card-box height-100-p widget-style1">
				<div class="d-flex flex-wrap align-items-center">
					<div class="progress-data">
						<div id="chart3"></div>
					</div>
					<div class="widget-data">
						<div class="h4 mb-0">350</div>
						<div class="weight-600 font-14">Campaign</div>
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
					<a href="#" class="btn btn-outline-primary btn-sm">View More</a>
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
										{{ $schedule->survey_time }}
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
					<a href="#" class="btn btn-outline-primary btn-sm">View More</a>
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
						<tr>
							<th scope="row">1</th>
							<td>Gilang</td>
							<td>081232782676</td>
							<td>Bangun Ruko</td>
							<td>Borongan</td>
							<td>14 Maret 2020</td>
							<td>
								<span class="badge badge-primary">Deal</span>
							</td>
						</tr>
						<tr>
							<th scope="row">1</th>
							<td>Gilang</td>
							<td>081232782676</td>
							<td>Bangun Ruko</td>
							<td>Borongan</td>
							<td>14 Maret 2020</td>
							<td>
								<span class="badge badge-primary">Deal</span>
							</td>
						</tr>
						<tr>
							<th scope="row">1</th>
							<td>Gilang</td>
							<td>081232782676</td>
							<td>Bangun Ruko</td>
							<td>Borongan</td>
							<td>14 Maret 2020</td>
							<td>
								<span class="badge badge-primary">Deal</span>
							</td>
						</tr>
						<tr>
							<th scope="row">1</th>
							<td>Gilang</td>
							<td>081232782676</td>
							<td>Bangun Ruko</td>
							<td>Borongan</td>
							<td>14 Maret 2020</td>
							<td>
								<span class="badge badge-primary">Deal</span>
							</td>
						</tr>
						<tr>
							<th scope="row">1</th>
							<td>Gilang</td>
							<td>081232782676</td>
							<td>Bangun Ruko</td>
							<td>Borongan</td>
							<td>14 Maret 2020</td>
							<td>
								<span class="badge badge-primary">Deal</span>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="text-center">
					<a href="#" class="btn btn-outline-primary btn-sm">View More</a>
				</div>
			</div>
			<!-- Striped table End -->
	</div>
@endsection