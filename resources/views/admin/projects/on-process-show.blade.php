@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Detail Project</h4>
					</div>
				</div>
				<div class="row mx-2">
					<div class="col-md-12">
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Nama Klien
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->client->name }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Alamat
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->address }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								No HP
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->client->phone_number }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Jenis Proyek
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->kind_project }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Tanggal Order
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ date('l, d-M-Y', strtotime($data->created_at)) }}
							</div>
						</div>

						@if ($kind === 'borongan')
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Tanggal Survei
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->survey_date ? date('l, d-M-Y', strtotime($data->survey_date)) : '---' }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Waktu Survei
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->survey_time ?? '---' }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Surveyer
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->surveyer->name ?? '---' }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									No Hp Surveyer
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->surveyer->phone_number ?? '---' }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Nilai RAB
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->approximate_value ?? '---' }}
								</div>
							</div>
						@elseif ($kind === 'harian')
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Nilai Harian
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->daily_value ?? '---' }}
								</div>
							</div>
						@endif

						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Status
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ Str::ucfirst($data->process) }}
							</div>
						</div>
						<div class="mt-4">
							<a href="{{ route('admin.projects.onProcess', $kind) }}" class="btn btn-primary">Back</a>
						</div>
				</div>
				
			</div>
			<!-- Striped table End -->
	</div>
@endsection