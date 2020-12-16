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
          <div class="pull-right">
            <a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
          </div>
				</div>
				<div class="row mb-20">
					<div class="col-12">
						<div class="flex">
							<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-print-in">
								Cetak Laporan Pemasukan
							</a>
							<a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#modal-print-out">
								Cetak Laporan Pengeluaran
							</a>
						</div>

						<div  x-data="modal()" x-init="init()">
							<div class="modal fade" id="modal-print-in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Pilih Bulan</label>
												<input v-model="month" id="month-picker-in" class="form-control" placeholder="Select Month" type="text">
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<a :href="'/admin/cashes/export/in/' + month" type="button" class="btn btn-primary">Cetak</a>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-print-out" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label>Pilih Bulan</label>
												<input v-model="month" id="month-picker-out" class="form-control" placeholder="Select Month" type="text">
											</div>
										</div>
	
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<a :href="'/admin/cashes/export/out/' + month" type="button" class="btn btn-primary">Cetak</a>
											{{-- <button type="button" class="btn btn-primary" @click="cetak()">Cetak</button> --}}
										</div>
									</div>
								</div>
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
													<a href="{{ Route('admin.projects.finishedShow', [$data->project_id, Str::lower($data->description)]) }}"><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
												</td>
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>Rp {{ $data->projectvalue }}</td>
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
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">User</th>
											<th scope="col" class="border-0">Keluar</th>
											<th scope="col" class="border-0">Deskripsi</th>
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
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>
													{{ $data->user->name ?? '---' }}
												</td>
												<td>Rp {{ $data->money_out }}</td>
												<td>{{ $data->description }}</td>
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
			var monthPickerIn = $('#month-picker-in').datepicker().data('datepicker');
			monthPickerIn.clear();
			var monthPickerOut = $('#month-picker-out').datepicker().data('datepicker');
			monthPickerOut.clear();
		</script>

@endsection