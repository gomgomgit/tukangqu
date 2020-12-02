@extends('layouts.app')

@section('link')
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="{{ asset('css/c-modal.css') }}">
@endsection

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Proyek On-Process</h4>
				</div>

				<div class="clearfix mb-20">
          <div class="pull-right">
            <a href="{{ Route('admin.projects.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
          </div>
				</div>
				<div class="tab">
					<ul class="nav nav-tabs customtab" role="tablist">
						<li class="nav-item">
							<a class="nav-link {{ $kind === 'borongan' ? 'active' : ''}}"" data-toggle="tab" href="#borongan" role="tab" aria-selected="{{ $kind == 'borongan' ? 'true' : 'false'}}">Borongan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ $kind === 'harian' ? 'active' : ''}}"" data-toggle="tab" href="#harian" role="tab" aria-selected="{{ $kind == 'harian' ? 'true' : 'false'}}">Harian</a>
						</li>
					</ul>
					<div class="tab-content"  x-data="action()" x-init="initSelect()">
						<div 
						class="pt-4 tab-pane fade {{ $kind === 'borongan' ? 'show active' : ''}}" id="borongan" role="tabpanel">
							<table class="data-table table table-striped">
								<thead>
									<tr>
										<th scope="col" class="border-0">#</th>
										<th scope="col" class="border-0">Klien</th>
										<th scope="col" class="border-0">No HP</th>
										{{-- <th scope="col" class="border-0">Alamat</th> --}}
										<th scope="col" class="border-0">Proyek</th>
										<th scope="col" class="border-0 text-center">Survei</th>
										{{-- <th scope="col" class="border-0">Tgl Survei</th>
										<th scope="col" class="border-0">Jam</th>
										<th scope="col" class="border-0">Surveyer</th> --}}
										<th scope="col" class="border-0">Nilai RAB</th>
										<th scope="col" class="border-0">Status</th>
										<th scope="col" class="border-0 datatable-nosort">Processing</th>
										<th scope="col" class="border-0 datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
									@php
											$no = 1;
									@endphp
									@foreach ($contract_datas as $data)
										<tr>
											<th scope="row">{{ $no++ }}</th>
											<td>{{ $data->client->name }}</td>
											<td>{{ $data->client->phone_number }}</td>
											{{-- <td>{{ $data->address }}</td> --}}
											<td>{{ $data->kind_project }}</td>
											<td class="{{ $data->survey_date ?? 'text-center' }}">
												<div>{{ $data->survey_date ? date('l d-M-Y', strtotime($data->survey_date)) : '---' }}</div>
												<div>{{ $data->survey_time ?? '---' }}</div>
												<div>{{ $data->surveyer->name ?? '---' }}</div>
											</td>
											{{-- <td class="{{ $data->survey_date ?? 'text-center' }}">{{ $data->survey_date ?? '---' }}</td>
											<td class="{{ $data->survey_time ?? 'text-center'}}">{{ $data->survey_time ?? '---'}}</td>
											<td class="{{ $data->surveyer ?? 'text-center' }}">{{ $data->surveyer->name ?? '---' }}</td> --}}
											<td class="{{ $data->approximate_value ?? 'text-center' }}">{{ $data->approximate_value ?? '---' }}</td>
											<td><span class="badge badge-warning">{{ Str::ucfirst($data->process ) }}</span></td>
											<td>
												@if ($data->action === 'dealing')
													<a href="{{ route('admin.projects.dealing', [$data->id ,'borongan']) }}" class="btn btn-sm btn-success">Dealing&nbsp;<i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i></a>														
												@elseif($data->action === 'pricing')
													<button x-on:click="cPricingId = {{ $data->id }}" 
														class="btn btn-primary btn-sm text-white text-weight-bold" type="button">
														Pricing&nbsp;<i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i>
													</button>
												@elseif($data->action === 'scheduling')
													<button x-on:click="cSchedulingId = {{ $data->id }}" type="button"
													class="btn btn-sm btn-info text-white text-weight-bold">
														Scheduling&nbsp;<i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i>
													</button>
												@endif
											</td>
											<td>
												<div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item" href="{{ Route('admin.projects.onProcessShow', [$data->id, 'borongan']) }}"><i class="dw dw-eye"></i> View</a>
														<a class="dropdown-item" href="{{ Route('admin.projects.failed', [$data->id, 'borongan']) }}"><i class="dw dw-ban"></i> Failed</a>
														<a class="dropdown-item" href="{{ Route('admin.projects.edit', [$data->id, 'borongan']) }}"><i class="dw dw-edit2"></i> Edit</a>
														{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
														<x-form-button 
																:action="route('admin.projects.destroy', [$data->id, 'borongan'])"
																method="DELETE"
																class="dropdown-item border-0"
														>
																<i class="dw dw-delete-3"></i> Delete
														</x-form-button>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>


								<div x-show="cPricingId" class="" tabindex="-1"  style="display: none">
									<div class="modal-background">

										<div @click.away="cPricingId = null" class="modal-dialog modal-sm modal-dialog-centered modal">
											<div class="modal-content">
												<form x-bind:action="'/admin/projects/on-process/'+ cPricingId +'/pricing/borongan'" method="POST">
													@csrf
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">Pricing</h4>
														<button @click="cPricingId = null" type="button" type="button" class="close">×</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label>Nilai RAB</label>
															<input class="form-control" type="number" name="approximate_value" required>
														</div>
													</div>
													<div class="modal-footer">
														<button @click="cPricingId = null" type="button" class="btn btn-secondary">Close</button>
														<button class="btn btn-info">Beri Harga</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>

								<div x-show="cSchedulingId" style="display: none">
									<div class="modal-background">
										<div class="modal-dialog modal-dialog-centered modal" style="max-width: 700px">
											<div class="modal-content">
												<form x-bind:action="'/admin/projects/on-process/'+ cSchedulingId +'/scheduling/borongan'" method="POST">
												@csrf
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">Scheduling</h4>
														<button @click="cSchedulingId = null" type="button" class="close">×</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label>Tanggal Survei</label>
															<input class="form-control date-picker" type="text" name="survey_date" data-date-format="yyyy-m-d" required>
														</div>
														<div class="form-group">
															<label>Jam</label>
															<input class="form-control" type="time" name="survey_time" required>
														</div>
														<div class="form-group">
															<label>Surveyer</label>
															<select class="custom-select2 form-control" id="select-worker" name="surveyer_id" style="width: 100%; height: 38px;">
																<optgroup label="Alaskan/Hawaiian Time Zone">
																	{{-- <template x-for="size in row.sizes" :key="size.id">
																		<option x-text="size.name" x-model="size.id"></option>
																	</template> --}}
																	{{-- <template x-for="worker in workers" :key="worker.id">
																		<option x-text="worker.name" x-model="workerId"></option>
																	</template> --}}
																	@foreach ($workers as $worker)
																		<option value="{{ $worker->id }}">
																			{{ $worker->name }} | {{ Indonesia::findCity($worker->city_id)->name }}
																		</option>	
																	@endforeach
																</optgroup>
															</select>
														</div>
													</div>
													<div class="modal-footer">
														<button @click="cSchedulingId = null" class="btn btn-secondary">Close</button>
														<button type="submit" class="btn btn-primary">Buat Schedule</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>

						</div>

						<div
						class="pt-4 tab-pane fade {{ $kind === 'harian' ? 'show active' : ''}}" id="harian" role="tabpanel">
								<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">No HP</th>
											{{-- <th scope="col" class="border-0">Alamat</th> --}}
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Nilai Harian</th>
											<th scope="col" class="border-0">Status</th>
											<th scope="col" class="border-0 datatable-nosort">Processing</th>
											<th scope="col" class="border-0 datatable-nosort">Action</th>
										</tr>
									</thead>
									<tbody>
										@php
												$no = 1;
										@endphp
										@foreach ($daily_datas as $data)
											<tr>
												<th scope="row">{{ $no++ }}</th>
												<td>{{ $data->client->name }}</td>
												<td>{{ $data->client->phone_number }}</td>
												{{-- <td>{{ $data->address }}</td> --}}
												<td>{{ $data->kind_project }}</td>
												<td>{{ $data->daily_value ?? '---' }}</td>
												<td><span class="badge badge-warning">{{ Str::ucfirst($data->process ) }}</span></td>
												<td>
													@if ($data->action === 'dealing')
														<a href="{{ route('admin.projects.dealing', [$data->id ,'harian']) }}" 
															class="btn btn-sm btn-success">Dealing&nbsp;<i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i></a>														
													@else
														<button @click="dPricingId = {{ $data->id }}" type="button"
														class="btn btn-sm btn-info text-white text-weight-bold">
															Pricing&nbsp;<i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i>
														</button>
													@endif
												</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="{{ Route('admin.projects.onProcessShow', [$data->id, 'harian']) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.projects.failed', [$data->id, 'harian']) }}"><i class="dw dw-ban"></i> Failed</a>
															<a class="dropdown-item" href="{{ Route('admin.projects.edit', [$data->id, 'harian'] ) }}"><i class="dw dw-edit2"></i> Edit</a>
															{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
															<x-form-button 
																	:action="route('admin.projects.destroy', [$data->id, 'harian'])"
																	method="DELETE"
																	class="dropdown-item border-0"
															>
																	<i class="dw dw-delete-3"></i> Delete
															</x-form-button>
														</div>
													</div>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
								
								<div x-show="dPricingId" style="display: none">	
									<div class="modal-background" tabindex="-1">
										<div @click.away="dPricingId = null" class="modal-dialog modal-sm modal-dialog-centered modal">
											<div class="modal-content">
												<form x-bind:action="'/admin/projects/on-process/'+ dPricingId +'/pricing/harian'" method="POST">
													@csrf
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">Pricing</h4>
														<button @click="dPricingId = null" type="button" class="close">×</button>
													</div>
													<div class="modal-body">
															<div class="form-group">
																<label>Nilai Harian</label>
																<input class="form-control" type="number" name="daily_value" required>
															</div>
													</div>
													<div class="modal-footer">
														<button @click="dPricingId = null" type="button" class="btn btn-secondary">Close</button>
														<button class="btn btn-info">Beri Harga</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
				
				<div class="clearfix">
					<div class="pull-right">
						{{-- {{ $datas->links() }} --}}
					</div>
				</div>
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

		{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script> --}}

		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
		<script>
			function action() {
				return {
					cSchedulingId : null,
					cPricingId : null,
					dPricingId : null,

					initSelect() {
						$('#select-worker').select2();
					}
				}
			}
		</script>
		<script>
			// $('#Datbel').dataTable( {
			// 		paging: false
			// } );
			
			
			// $('#Datbel').dataTable( {
			// 		searching: false
			// } );
		</script>
@endsection