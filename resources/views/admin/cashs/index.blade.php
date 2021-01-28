@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Kas</h4>
				</div>

				<div class="clearfix mb-5">
					<div class="pull-left">
						<p class="font-weight-bold">Saldo: Rp {{ number_format($total) }}</p>
					</div>
				</div>
				<div class="row mb-20">
					<div class="col-12">
						<div class="clearfix mb-5">
							<div class="flex w-50 pull-left">
								<a class="btn btn-outline-primary btn-sm" href="#" role="button" data-toggle="modal" data-target="#modal-export">
									Export
								</a>
								<a class="btn btn-outline-primary btn-sm" href="#" role="button" data-toggle="modal" data-target="#modal-import">
									Import
								</a>
								{{-- <a class="btn btn-outline-primary" href="{{ route('admin.cashes.import') }}">
									Import
								</a> --}}
							</div>
							<div class="pull-right">
								<a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
							</div>
						</div>

						<div  x-data="modal()" x-init="init()">
							<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content w-auto">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Export</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="d-flex justify-content-between">
												<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-print-in">
													Pemasukan
												</a>
												<a class="btn btn-outline-primary mx-2" href="#" role="button" data-toggle="modal" data-target="#modal-print-out">
													Pengeluaran
												</a>
												<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-print-debt">
													Hutang
												</a>
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Import</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-import-in">
												Pemasukan
											</a>
											<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-import-out">
												Pengeluaran
											</a>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-import-in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Import Pemasukan</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<p>Template</p>
												<a href="{{route('admin.cashes.exportTemplateIn')}}" class="btn btn-sm btn-primary w-100"><i class="icon-copy dw dw-download text-white"></i> Download Template </a>
											</div>
											<form id="import-in" action="{{ route('admin.cashes.importIn') }}" method="POST" enctype="multipart/form-data">
											@csrf
												<div class="form-group">
													<label>Pilih File</label>
													<input class="form-control p-0 h-auto" type="file" name="import-in">
												</div>
											</form>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button form="import-in" type="submit" class="btn btn-primary">Cetak</button>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-import-out" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Import Pengeluaran</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">	
											<div class="form-group">
												<p>Template</p>
												<a href="{{route('admin.cashes.exportTemplateOut')}}" class="btn btn-sm btn-primary w-100"><i class="icon-copy dw dw-download text-white"></i> Download Template </a>
											</div>
												<form id="import-out" action="{{ route('admin.cashes.importOut') }}" method="POST" enctype="multipart/form-data">
												@csrf
													<div class="form-group">
														<label>Pilih File</label>
														<input class="form-control p-0 h-auto" type="file" name="import-out">
													</div>
												</form>
											</div>
											
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button form="import-out" type="submit" class="btn btn-primary">Cetak</button>
												{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
											</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-print-in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<form :action="'/admin/cashes/export/in/' + month">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Export Pemasukan</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Pilih Bulan</label>
												<input v-model="month" id="month-picker-in" class="form-control" placeholder="Select Month" type="text" required>
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button class="btn btn-primary">Cetak</button>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
								</form>
							</div>
							<div class="modal fade" id="modal-print-out" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<form :action="'/admin/cashes/export/out/' + month">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Export Pengeluaran</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Pilih Bulan</label>
												<input v-model="month" id="month-picker-out" class="form-control" placeholder="Select Month" type="text" required>
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button class="btn btn-primary">Cetak</button>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
								</form>
							</div>
							<div class="modal fade" id="modal-print-debt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<form :action="'/admin/cashes/export/debt/' + month">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Export Hutang</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Pilih Bulan</label>
												<input v-model="month" id="month-picker-debt" class="form-control" placeholder="Select Month" type="text" required>
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button class="btn btn-primary">Cetak</button>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="tab">
					<ul class="nav nav-tabs customtab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#masuk" role="tab" aria-selected="true">Masuk</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#keluar" role="tab" aria-selected="false">Keluar</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="pt-4 tab-pane fade show active" id="masuk" role="tabpanel">
							<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Nama</th>
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">Nilai Project</th>
											<th scope="col" class="border-0">Masuk</th>
											<th scope="col" class="border-0">Action</th>
										</tr>
									</thead>
									<tbody>
										@php
												$no = 1;
										@endphp
										@foreach ($datas_in as $data)
											<tr>
												<th scope="row">{{ $no++ }}</th>
												<td>
													{{ $data->name }}
													@if($data->project_id)
														<a href="{{ Route('admin.cashes.projectShow', [$data->project_id, Str::lower($data->project_type)]) }}"><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
													@endif
												</td>
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>
													@if($data->projectvalue)
														Rp {{ $data->projectvalue }}
													@else
														---
													@endif
												</td>
												<td>Rp {{ $data->money_in }}</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															{{-- <a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a> --}}
															<a class="dropdown-item" href="{{ Route('admin.cashes.editin', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
															{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
															<x-form-button 
																	:action="route('admin.cashes.destroy', $data->id)"
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
						</div>
						<div class="pt-4 tab-pane fade" id="keluar" role="tabpanel">
							<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Nama</th>
											<th scope="col" class="border-0">Kategori</th>
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">User</th>
											<th scope="col" class="border-0">Keluar</th>
											<th scope="col" class="border-0">Action</th>
										</tr>
									</thead>
									<tbody>
										@php
												$no = 1;
										@endphp
										@foreach ($datas_out as $data)
											<tr>
												<th scope="row">{{ $no++ }}</th>
												<td>{{ $data->name }}</td>
												<td>
													{{ $data->category == 'out' ? 'Pengeluaran' : '' }}
													{{ $data->category == 'owe' ? 'Hutang' : '' }}
													{{ $data->category == 'pay' ? 'Cicil' : '' }}
													{{ $data->category == 'refund' ? 'Refund' : '' }}
												</td>
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>
													{{ $data->user->name ?? '---' }}
												</td>
												<td>Rp {{ $data->money_out }}</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															{{-- <a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a> --}}
															<a class="dropdown-item" href="{{ Route('admin.cashes.editout', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
															{{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
															<x-form-button 
																	:action="route('admin.cashes.destroy', $data->id)"
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

		<script>
			function modal() {
				return {
					month: null,
					init() {
						const self = this
						window.addEventListener('selectmonth', function (e) {
							self.month = e.detail
							self.cetak()
						})
					},
					cetak() {
						console.log(this.month)
					},
				}
			}
			var monthPickerIn = $('#month-picker-in').datepicker({
					language: 'en',
					minView: 'months',
					view: 'months',
					autoClose: true,
					dateFormat: 'MM yyyy',
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectmonth', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})
			var monthPickerOut = $('#month-picker-out').datepicker({
					language: 'en',
					minView: 'months',
					view: 'months',
					autoClose: true,
					dateFormat: 'MM yyyy',
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectmonth', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})
			var monthPickerDebt = $('#month-picker-debt').datepicker({
					language: 'en',
					minView: 'months',
					view: 'months',
					autoClose: true,
					dateFormat: 'MM yyyy',
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectmonth', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})
			var monthPickerIn = $('#month-picker-in').datepicker().data('datepicker');
			monthPickerIn.clear();
			var monthPickerOut = $('#month-picker-out').datepicker().data('datepicker');
			monthPickerOut.clear();
			var monthPickerDebt = $('#month-picker-debt').datepicker().data('datepicker');
			monthPickerDebt.clear();
		</script>

@endsection