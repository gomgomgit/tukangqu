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

						<div class="mt-5">
							<a href="{{ route('admin.projects.onProcess', $kind) }}" class="btn btn-primary"><i class="icon-copy dw dw-left-arrow1"></i> Back</a>
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