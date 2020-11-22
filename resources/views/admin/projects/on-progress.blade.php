@extends('layouts.app')

@section('link')
		<link rel="stylesheet" href="{{ asset('css/c-modal.css') }}">
@endsection

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Proyek On-Progress</h4>
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
					<div class="tab-content" x-data="action()">
						<div 
						class="tab-pane fade {{ $kind === 'borongan' ? 'show active' : ''}}" id="borongan" role="tabpanel">
							<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Nilai Proyek</th>
											<th scope="col" class="border-0">Kas Bon</th>
											<th scope="col" class="border-0">Uang Masuk</th>
											<th scope="col" class="border-0">Action</th>
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
												<td>{{ $data->start_date }}</td>
												<td>{{ $data->worker->name }}</td>
												<td>{{ $data->project_value }}</td>
												<td><button class="btn btn-warning btn-sm" @click="setCBillingId({{ $data->id }})">KasBon</button></td>
												<td><button class="btn btn-info btn-sm"  @click="setCTerminId({{ $data->id }})">Termin</button></td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="#"><i class="dw dw-check"></i> Finish</a>
															<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
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

						<div x-show="cBillingId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">KasBon</h4>
											<button @click="cBillingId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body">

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
														<th scope="col" class="border-0">Ket</th>
													</tr>
												</thead>

												<template x-if="cBills">
													<tbody>
															<template x-for="(bill, index) in cBills" :key="bill.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="bill.date"></td>
																	<td x-text="bill.amount"></td>
																	<td x-text="bill.description"></td>
																</tr>
															</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalCBill"></td>
															<td></td>
														</tr>
													</tfoot>
												</template>
											</table>
										</div>
										<div class="modal-footer">
											<button @click="cBillingId = null" class="btn btn-secondary">Close</button>
											<button @click="addCBilling = !(addCBilling)" type="button" class="btn btn-primary">Tambah Kasbon</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCBilling === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="addCBilling = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ cBillingId +'/add-billing/borongan'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addCBilling = !(addCBilling)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal</label>
														<input class="form-control" type="date" name="date" value="\Carbon\Carbon::now()->format('Y-m-d')" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" type="number" name="amount" required>
													</div>
													<div class="form-group">
														<label>Ket</label>
														<input class="form-control" type="text" name="description">
													</div>
											</div>
											<div class="modal-footer">
												<button @click="addCBilling = !(addCBilling)" type="button" class="btn btn-secondary">Close</button>
												<button class="btn btn-info">Beri Harga</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div x-show="cTerminId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content modal-scroll">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Termin</h4>
											<button @click="cTerminId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body modal-body-scroll">

											<div class="mb-3">
												<h5 class="my-2">Nilai Project : 
													<span x-text="cProjectTermin.project_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="totalCTermin"></span>
												</h5>
												<h5 class="my-2">Sisa : 
													<span x-text="remainCTermin"></span>
												</h5>
											</div>

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
													</tr>
												</thead>

												<template x-if="cTermins">
													<tbody>
															<template x-for="(termin, index) in cTermins" :key="termin.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="termin.date"></td>
																	<td x-text="termin.amount"></td>
																</tr>
															</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalCTermin"></td>
														</tr>
													</tfoot>
												</template>
											</table>

										</div>
										<div class="modal-footer">
											<button @click="cTerminId = null" class="btn btn-secondary">Close</button>
											<button @click="addCTermin = !(addCTermin)" type="button" class="btn btn-primary">Tambah Uang Masuk</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCTermin === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="addCTermin = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ cTerminId +'/add-payment-fee/borongan'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addCTermin = !(addCTermin)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<h5 class="my-2">Sisa : 
														<span x-text="remainCTermin"></span>
													</h5>
													<div class="form-group">
														<label>Tanggal</label>
														<input class="form-control" type="date" name="date" value="\Carbon\Carbon::now()->format('Y-m-d')" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" type="number" name="amount" required>
													</div>
											</div>
											<div class="modal-footer">
												<button @click="addCTermin = !(addCTermin)" type="button" class="btn btn-secondary">Close</button>
												<button class="btn btn-info">Beri Harga</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div
						class="tab-pane fade {{ $kind === 'harian' ? 'show active' : ''}}" id="harian" role="tabpanel">
							{{-- <div class="pd-20"> --}}
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">No</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai</th>
											<th scope="col" class="border-0">Nilai Harian</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Gaji Harian</th>
											<th scope="col" class="border-0">KasBon</th>
											<th scope="col" class="border-0">Uang Masuk</th>
											<th scope="col" class="border-0">Bagi Hasil</th>
											<th scope="col" class="border-0">Action</th>
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
												<td>{{ $data->start_date }}</td>
												<td>{{ $data->daily_value }}</td>
												<td>{{ $data->worker->name }}</td>
												<td>{{ $data->daily_salary }}</td>
												<td>
													<button class="btn btn-warning btn-sm" @click="setDBillingId({{ $data->id }})">KasBon</button>
												</td>
												<td>
													<button class="btn btn-info btn-sm" @click="setDTerminId({{ $data->id }})">Termin</button>
												</td>
												<td>
													<button class="btn btn-success btn-sm" @click="setDSharingId({{ $data->id }})">Bagi Hasil</button>
												</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="#"><i class="dw dw-check"></i> Finish</a>
															<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
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
							{{-- </div> --}}
						</div>

						<div x-show="dBillingId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">KasBon</h4>
											<button @click="dBillingId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body">

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
														<th scope="col" class="border-0">Ket</th>
													</tr>
												</thead>

												<template x-if="dBills">
													<tbody>
															<template x-for="(bill, index) in dBills" :key="bill.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="bill.date"></td>
																	<td x-text="bill.amount"></td>
																	<td x-text="bill.description"></td>
																</tr>
															</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalDBill"></td>
															<td></td>
														</tr>
													</tfoot>
												</template>
											</table>
										</div>
										<div class="modal-footer">
											<button @click="dBillingId = null" class="btn btn-secondary">Close</button>
											<button @click="addDBilling = !(addDBilling)" type="button" class="btn btn-primary">Tambah Kasbon</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDBilling === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="addDBilling = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ dBillingId +'/add-billing/harian'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addDBilling = !(addDBilling)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal</label>
														<input class="form-control" type="date" name="date" value="\Carbon\Carbon::now()->format('Y-m-d')" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" type="number" name="amount" required>
													</div>
													<div class="form-group">
														<label>Ket</label>
														<input class="form-control" type="text" name="description">
													</div>
											</div>
											<div class="modal-footer">
												<button @click="addDBilling = !(addDBilling)" type="button" class="btn btn-secondary">Close</button>
												<button class="btn btn-info">Beri Harga</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						<div x-show="dTerminId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content modal-scroll">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Termin</h4>
											<button @click="dTerminId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body modal-body-scroll">

											<div class="mb-3">
												<h5 class="my-2">Nilai Harian : 
													<span x-text="dProjectTermin.daily_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="totalDTermin"></span>
												</h5>
												<h5 class="my-2">Sisa : 
													<span x-text="remainDTermin"></span>
												</h5>
											</div>

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
													</tr>
												</thead>

												<template x-if="dTermins">
													<tbody>
															<template x-for="(termin, index) in dTermins" :key="termin.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="termin.date"></td>
																	<td x-text="termin.amount"></td>
																</tr>
															</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalDTermin"></td>
														</tr>
													</tfoot>
												</template>
											</table>

										</div>
										<div class="modal-footer">
											<button @click="dTerminId = null" class="btn btn-secondary">Close</button>
											<button @click="addDTermin = !(addDTermin)" type="button" class="btn btn-primary">Tambah Uang Masuk</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDTermin === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="addDTermin = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ dTerminId +'/add-payment-fee/harian'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addDTermin = !(addDTermin)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<h5 class="my-2">Sisa : 
														<span x-text="remainDTermin"></span>
													</h5>
													<div class="form-group">
														<label>Tanggal</label>
														<input class="form-control" type="date" name="date" value="\Carbon\Carbon::now()->format('Y-m-d')" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" type="number" name="amount" required>
													</div>
											</div>
											<div class="modal-footer">
												<button @click="addDTermin = !(addDTermin)" type="button" class="btn btn-secondary">Close</button>
												<button class="btn btn-info">Beri Harga</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						<div x-show="dSharingId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-lg modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
											<button @click="dSharingId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body">

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Kas</th>
														<th scope="col" class="border-0">Pekerja</th>
														<th scope="col" class="border-0">Total</th>
													</tr>
												</thead>

													<tbody>
																<tr>
																	<th scope="row">1</th>
																	<td>23 Maret 2020</td>
																	<td>Rp. 500.000</td>
																	<td>Rp. 1.500.000</td>
																	<td>Rp. 2.000.000</td>
																</tr>
																<tr>
																	<th scope="row">1</th>
																	<td>30 Maret 2020</td>
																	<td>Rp. 500.000</td>
																	<td>Rp. 1.500.000</td>
																	<td>Rp. 2.000.000</td>
																</tr>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td>Rp. 1.000.000</td>
															<td>Rp. 3.000.000</td>
															<td>Rp. 4.000.000</td>
														</tr>
													</tfoot>
											</table>
										</div>
										<div class="modal-footer">
											<button @click="dSharingId = null" class="btn btn-secondary">Close</button>
											<button @click="addDSharing = !(addDSharing)" type="button" class="btn btn-primary">Tambah Kasbon</button>
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
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
		<script>
			function action() {
				return {
					cBillingId : null,
					cBills : [],
					addCBilling : false,
					cPaymentId: null,
					totalCBill: 0,

					cProjectTermin:[],
					cTerminId: null,
					cTermins: [],
					addCTermin: null,
					totalCTermin: 0,
					remainCTermin:0,

					dBillingId : null,
					dBills : [],
					addDBilling : false,
					dPaymentId: null,
					totalDBill: 0,

					dProjectTermin:[],
					dTerminId: null,
					dTermins: [],
					addDTermin: null,
					totalDTermin: 0,
					remainDTermin:0,

					dSharingId: null,

					setCBillingId(id) {
						this.cBillingId = id;
						this.getDataCBilling();
						// console.log(this.cBillingId);
					},
					setCTotalBill() {
						var cBill = this.cBills.reduce(function(total, num) {
							// console.log(num.amount);
							return (total + num.amount);
						}, 0);
						// console.log(cBill);
						this.totalCBill = cBill;
					},
					getDataCBilling() {
						var self = this;
						axios.get('{{ url("/api/get-billing")}}/' + this.cBillingId + '/borongan')
						.then(function(response) {
							self.cBills = response.data;
							self.setCTotalBill();
						}) 
					},


					setCTerminId(id) {
						this.cTerminId = id;
						this.getDataCTermin();
						this.getDataCProject();
						this.setCTotalTermin();
					},
					setCTotalTermin() {
						var cTermin = this.cTermins.reduce(function(total, num) {
							// console.log(num.amount);
							return (total + num.amount);
						}, 0);
						console.log(cTermin);
						this.totalCTermin = cTermin;
					},
					setRemainCTermin() {
						var self = this;
						var remain = self.cProjectTermin.project_value - self.totalCTermin;
						this.remainCTermin = remain;
						console.log(self.cProjectTermin);
					},
					getDataCProject() {
						var self = this;
						axios.get('{{ url("/api/get-project-termin")}}/' + this.cTerminId + '/borongan')
						.then(function(response) {
							self.cProjectTermin = response.data;
							self.setRemainCTermin();
						});
						// console.log(this.cProjectTermin);
					},
					getDataCTermin() {
						var self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.cTerminId + '/borongan')
						.then(function(response) {
							self.cTermins = response.data;
							self.setCTotalTermin();
						}) 
					},



					setDBillingId(id) {
						this.dBillingId = id;
						this.getDataDBilling();
						// console.log(this.cBillingId);
					},
					setDTotalBill() {
						var dBill = this.dBills.reduce(function(total, num) {
							// console.log(num.amount);
							return (total + num.amount);
						}, 0);
						// console.log(cBill);
						this.totalDBill = dBill;
					},
					getDataDBilling() {
						var self = this;
						axios.get('{{ url("/api/get-billing")}}/' + this.dBillingId + '/harian')
						.then(function(response) {
							self.dBills = response.data;
							self.setDTotalBill();
							console.log(self.dBills);
						}) 
					},


					setDTerminId(id) {
						this.dTerminId = id;
						this.getDataDTermin();
						this.getDataDProject();
						this.setDTotalTermin();
					},
					setDTotalTermin() {
						var dTermin = this.dTermins.reduce(function(total, num) {
							// console.log(num.amount);
							return (total + num.amount);
						}, 0);
						console.log(dTermin);
						this.totalDTermin = dTermin;
					},
					setRemainDTermin() {
						var self = this;
						var remain = self.dProjectTermin.project_value - self.totalDTermin;
						this.remainDTermin = remain;
						console.log(self.dProjectTermin);
					},
					getDataDProject() {
						var self = this;
						axios.get('{{ url("/api/get-project-termin")}}/' + this.dTerminId + '/harian')
						.then(function(response) {
							self.dProjectTermin = response.data;
							self.setRemainDTermin();
						});
						// console.log(this.cProjectTermin);
					},
					getDataDTermin() {
						var self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.dTerminId + '/harian')
						.then(function(response) {
							self.dTermins = response.data;
							self.setDTotalTermin();
						}) 
					},

					setDSharingId(id) {
						this.dSharingId = id;
						return true;
					},

					watch: {
						// cBillingId : function (val, oldVal) {
						// 	this.getDataBilling();
						// }
					}
						
				}
			}
		</script>
@endsection