@extends('layouts.app')

@section('link')
		<link rel="stylesheet" href="{{ asset('css/c-modal.css') }}">
@endsection

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Proyek Finished</h4>
				</div>

				<div class="clearfix mb-20">
          <div class="pull-right">
            <a href="{{ Route('admin.projects.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Proyek</a>
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
					<div class="tab-content" x-data="action()">
						<div 
						class="pt-4 tab-pane fade {{ $kind === 'borongan' ? 'show active' : ''}}" id="borongan" role="tabpanel">
							<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai - Tgl&nbsp;Selesai</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Nilai Proyek</th>
											<th scope="col" class="border-0">Keuntungan</th>
											<th scope="col" class="border-0">Refund</th>
											<th scope="col" class="border-0">Status</th>
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
												<td>{{ $data->address }}</td>
												<td>{{ $data->kind_project }}</td>
												<td>{{ $data->start_date }} - {{ $data->finish_date }}</td>
												<td>
													@if ($data->worker)
														{{ $data->worker->name }} <a href={{ Route('admin.projects.workerShow', $data->worker_id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
													@else
														<span>---</span> 
													@endif 
												</td>
												<td>{{ $data->project_value }}</td>
												<td>{{ $data->profit }}</td>
												<td>{{ $data->refund ?? ' --- ' }}</td>
												<td><span class="badge badge-{{ $data->process === 'finish' ? 'success' : 'danger' }}">
													{{ Str::ucfirst($data->process) }}
												</span></td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<button class="dropdown-item" @click="cRefundId = {{$data->id}}"><i class="dw dw-money-2"></i> Refund</button>
															<a class="dropdown-item" href="{{ Route('admin.projects.finishedShow', [$data->id, 'borongan']) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.projects.edit', [$data->id, 'borongan']) }}"><i class="dw dw-edit2"></i> Edit</a>
															{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
															<x-form-button 
																	:action="route('admin.projects.destroy', $data->id)"
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

								<div x-show="cRefundId" class="" tabindex="-1"  style="display: none">
									<div class="modal-background">

										<div @click.away="cRefundId = null" class="modal-dialog modal-dialog-centered modal">
											<div class="modal-content">
												<form :action="'/admin/projects/finished/'+ cRefundId +'/refund/borongan'" method="POST">
													@csrf
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">Refund</h4>
														<button @click="cRefundId = null" type="button" type="button" class="close">×</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label>Jumlah </label>
															<input class="form-control" type="number" name="refund" required>
														</div>
														<div class="form-group">
															<label>Ket </label>
															<textarea class="form-control" type="number" name="description" height=150 ></textarea>
														</div>
													</div>
													<div class="modal-footer">
														<span @click="cRefundId = null" type="button" class="btn btn-secondary">Close</span>
														<button class="btn btn-info">Refund</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
						</div>

						<div
						class="pt-4 tab-pane fade {{ $kind === 'harian' ? 'show active' : ''}}" id="harian" role="tabpanel">
							{{-- <div class="pd-20"> --}}
								<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai - Tgl Selesai</th>
											<th scope="col" class="border-0">Nilai Harian</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Nilai Proyek</th>
											<th scope="col" class="border-0">Keuntungan</th>
											<th scope="col" class="border-0">Refund</th>
											<th scope="col" class="border-0">Status</th>
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
												<td>{{ $data->address }}</td>
												<td>{{ $data->kind_project }}</td>
												<td>
													<p>{{ $data->start_date }} -</p>
													<p>{{ $data->finish_date }}</p>
												</td>
												<td>{{ $data->daily_value }}</td>
												<td>
													@if ($data->worker)
														{{ $data->worker->name }} <a href={{ Route('admin.projects.workerShow', $data->worker_id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
													@else
														<span>---</span> 
													@endif 
												</td>
												<td>{{ $data->project_value }}</td>
												<td>{{ $data->profit }}</td>
												<td>{{ $data->refund ?? ' --- ' }}</td>
												<td><span class="badge badge-{{ $data->process === 'finish' ? 'success' : 'danger' }}">
													{{ $data->process === 'finish' ? 'Finish' : 'Failed' }}
												</span></td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<button class="dropdown-item" @click="dRefundId = {{$data->id}}"><i class="dw dw-money-2"></i> Refund</button>
															<a class="dropdown-item" href="{{ Route('admin.projects.finishedShow', [$data->id, 'harian']) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.projects.edit', [$data->id, 'harian']) }}"><i class="dw dw-edit2"></i> Edit</a>
															{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
															<x-form-button 
																	:action="route('admin.projects.destroy', $data->id)"
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

								<div x-show="dRefundId" class="" tabindex="-1"  style="display: none">
									<div class="modal-background">

										<div @click.away="dRefundId = null" class="modal-dialog modal-dialog-centered modal">
											<div class="modal-content">
												<form x-bind:action="'/admin/projects/on-process/'+ dRefundId +'/pricing/borongan'" method="POST">
													@csrf
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">Refund</h4>
														<button @click="dRefundId = null" type="button" type="button" class="close">×</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label>Jumlah </label>
															<input class="form-control" type="number" name="refund" required>
														</div>
														<div class="form-group">
															<label>Ket </label>
															<textarea class="form-control" type="number" name="description" height=150 ></textarea>
														</div>
													</div>
													<div class="modal-footer">
														<span @click="dRefundId = null" type="button" class="btn btn-secondary">Close</span>
														<button class="btn btn-info">Refund</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							{{-- </div> --}}
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

		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

		<script>
			function action() {
				return {
					cRefundId : null,
					dRefundId : null,
				}
			}
		</script>

@endsection