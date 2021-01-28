@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h3 text-primary">Detail Proyek</h4>
					</div>
				</div>
				<div class="row mx-2">
					<div class="col-md-12">
						
						<div class="row mb-3">
							<div class="col border-bottom">
								<h4>Data Klien</h4>
							</div>
						</div>
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
								Alamat
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->client->address }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								
							</div>
							<div class="col-1">
								
							</div>
							<div class="col-6">
								{{ $data->client->city }}
							</div>
						</div>
						<div class="row mb-3">
							<div class="col border-bottom">
								<h4>Data Proyek</h4>
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
								{{ date('l, d-M-Y', strtotime($data->order_date)) }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Alamat Proyek
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
									@if ($data->worker)
										{{ $data->worker->name }} <a href={{ Route('admin.projects.workerShow', $data->worker_id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
									@endif
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

						<div class="mt-5 border-bottom">
							<div class="border-bottom mb-3 d-flex justify-content-between">
								<h4>Aktifitas</h4>
								<p>
									<button id="buttonActivities" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
										Tampilkan Aktifitas
									</button>
								</p>
							</div>

							<div class="timeline mb-30 collapse" id="collapseExample">
								<ul>
									@foreach ($activities as $activity)
										<li class="pd-10">
											<div class="timeline-date">
												{{Carbon\Carbon::parse($activity->created_at)->format('d-M-Y')}}
											</div>
											<div class="timeline-desc">
												@if ($activity->description == 'created')
													@if ($activity->causer)
														<h4 class="mb-10 h5">Proyek dibuat oleh {{$activity->causer->name}}</h4>
													@else
														<h4 class="mb-10 h5">Proyek dibuat oleh Klien</h4>
													@endif
												@elseif($activity->description == 'updated')
													<h4 class="mb-10 h5">{{$activity->causer->name}} {{'telah mengupdate data :'}}</h4>

													<div class="ml-4">
														@foreach ($activity->properties->first() as $keyold => $dataold)
															@if ($dataold)
																<p>
																	<span>{{$keyold . ' dari ' . $dataold . " menjadi "}}</span>
																	@foreach ($activity->properties->last() as $key => $data)
																		@if ($keyold == $key)
																				<span>{{$data}}</span>
																		@endif
																	@endforeach
																</p>		
															@else
																<p>
																	<span>{{$keyold . ' diisi dengan ' }}</span>
																	@foreach ($activity->properties->last() as $key => $data)
																		@if ($keyold == $key)
																				<span>{{$data}}</span>
																		@endif
																	@endforeach
																</p>
															@endif
														@endforeach
													</div>
												@endif
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>

						<div class="mt-4">
							<a href="{{ route('admin.projects.onProgress', $kind) }}" class="btn btn-primary"><i class="icon-copy dw dw-left-arrow1"></i> Back</a>
						</div>
				</div>
				
			</div>
			<!-- Striped table End -->
	</div>
@endsection

@section('script')
	<script>
		var buttonActivities = false
		$('#buttonActivities').click(function(){$('buttonActivities')
				$(this).text(function(i,old){
						let result = buttonActivities ?  'Tampilkan Aktifitas' : 'Sembunyikan Aktifitas'
						buttonActivities = !buttonActivities
						return result
				});
		});
	</script>
@endsection