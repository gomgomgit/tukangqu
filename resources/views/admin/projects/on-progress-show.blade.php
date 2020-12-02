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
								
							</div>
							<div class="col-1">
								
							</div>
							<div class="col-6">
								{{ $data->city }}
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
								Tanggal Mulai
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ date('l, d-M-Y', strtotime($data->start_date)) }}
							</div>
						</div>

						@if ($kind === 'borongan')
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Tanggal Selesai
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->finish_date ? date('l, d-M-Y', strtotime($data->finish_date)) : '---' }}
							</div>
						</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Pekerja
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->worker->name }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									No Hp Pekerja
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									{{ $data->worker->phone_number }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Nilai Project
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									Rp. {{ number_format($data->project_value, 0, '.', '.') }}
								</div>
							</div>

							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Total Uang Masuk
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
										Rp. {{ number_format($data->totalpayment, 0, '.', '.') }}
								</div>
							</div>

							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Sisa Pembayaran
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
										Rp. {{ number_format($data->project_value - $data->totalpayment, 0, '.', '.') }}
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
									Rp. {{ number_format($data->daily_value, 0, '.', '.') }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Gaji Harian
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									Rp. {{ number_format($data->daily_salary, 0, '.', '.') }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Selisih
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
									Rp. {{ number_format($data->difference, 0, '.', '.') }}
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-4 font-weight-bold">
									Total Uang Masuk
								</div>
								<div class="col-1">
									:
								</div>
								<div class="col-6">
										Rp. {{ number_format($data->totalpayment, 0, '.', '.') }}
								</div>
							</div>
						@endif

						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Total Kasbon
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
									Rp. {{ number_format($data->totalcharge, 0, '.', '.') }}
							</div>
						</div>
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