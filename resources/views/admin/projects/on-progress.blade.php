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
						class="pt-4 tab-pane fade {{ $kind === 'borongan' ? 'show active' : ''}}" id="borongan" role="tabpanel">
							<table class="data-table table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											{{-- <th scope="col" class="border-0">Alamat</th> --}}
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai - Tgl&nbsp;Selesai</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Nilai Proyek</th>
											<th scope="col" class="border-0">Status</th>
											<th scope="col" class="border-0 datatable-nosort">Kas Bon</th>
											<th scope="col" class="border-0 datatable-nosort">Uang Masuk</th>
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
												{{-- <td>{{ $data->address }}</td> --}}
												<td>{{ $data->kind_project }}</td>
												<td>
													<div>
														{{ $data->start_date ?? '---'}} -
													</div>
													<div>
														{{ $data->finish_date ?? '---'}}
													</div>
												</td>
												<td>{{ $data->worker->name }}</td>
												<td>{{ $data->project_value }}</td>
												<td><span class="badge badge-{{ $data->process == 'deal' ? 'info' : 'success'}}">{{ Str::ucfirst($data->process ) }}</span></td>
												<td><button class="btn btn-warning btn-sm" @click="setCBillingId({{ $data->id }})">KasBon</button></td>
												<td><button class="btn btn-secondary btn-sm"  @click="setCTerminId({{ $data->id }})">Termin</button></td>
												<td>
													@if ($data->action === 'done')
														<button class="btn btn-info btn-sm" x-on:click="cDoneId = {{ $data->id }}">Selesai</button>	
													@endif
													@if ($data->action === 'sharing')
														<button class="btn btn-success btn-sm" x-on:click="setCSharingId({{ $data->id }})">Bagi&nbsp;Hasil</button>	
													@endif
												</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															@if ($data->process == 'done')
																<a class="dropdown-item" href="{{ route('admin.projects.finish', [$data->id, 'borongan']) }}"><i class="dw dw-check"></i> Finish</a>
															@endif
															<a class="dropdown-item" href="{{ route('admin.projects.onProgressShow', [$data->id, 'borongan']) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ route('admin.projects.edit', [$data->id, 'borongan']) }}"><i class="dw dw-edit2"></i> Edit</a>
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
						</div>

						<div x-show="cDoneId" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="cDoneId = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ cDoneId +'/done/borongan'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Selesai</h4>
												<button @click="cDoneId = !(cDoneId)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal Selesai</label>
														<input class="form-control" type="date" name="finish_date" value="" required>
													</div>
											</div>
											<div class="modal-footer">
												<button @click="cDoneId = !(cDoneId)" type="button" class="btn btn-secondary">Close</button>
												<button class="btn btn-info">Selesai</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						{{-- <div x-show="cSharingId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-lg modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content">
										<form action="#" method="POST">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
												<button @click="cSharingId = null" type="button" class="close">×</button>
											</div>
											<div class="modal-body">

												<div class="mb-3">
													<h5 class="my-2">Nilai Harian : 
														<span x-text="dProject.daily_value"></span>
													</h5>
												</div>

											</div>
											<div class="modal-footer">
												<button @click="cSharingId = null" class="btn btn-secondary">Close</button>
												<button type="submit" class="btn btn-primary">Bagi Hasil</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div> --}}

						<div x-show="cSharingId" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal-lg modal-dialog-centered modal" style="max-width: 700px">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
											<button @click="cSharingId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body">

											<div class="mb-3">
												<h5 class="my-2">Nilai Project : 
													<span x-text="cProject.project_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="cProject.totalpayment"></span>
												</h5>
												<h5 class="my-2">Telah DiBagikan : 
													<span x-text="totalCSharing"></span>
												</h5>
												<h5 class="my-2">Sisa : 
													<span x-text="cProject.unshared"></span>
												</h5>
											</div>

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
														<template x-for="sharing in cSharings" :key="sharing.id">
																<tr>
																	<th scope="row">1</th>
																	<td x-text="sharing.date"></td>
																	<td x-text="sharing.amount_cash"></td>
																	<td x-text="sharing.amount_worker"></td>
																	<td x-text="sharing.amount_total"></td>
																</tr>
														</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalCSharingCash">Rp. 1.000.000</td>
															<td x-text="totalCSharingWorker">Rp. 3.000.000</td>
															<td x-text="totalCSharing">Rp. 4.000.000</td>
														</tr>
													</tfoot>
											</table>
										</div>
										<div class="modal-footer">
											<button @click="cSharingId = null" class="btn btn-secondary">Close</button>
											<button @click="addCSharing = !(addCSharing)" type="button" class="btn btn-primary">Bagi Hasil</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCSharing" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form  x-bind:action="'/admin/projects/on-progress/'+ cSharingId +'/add-profit/borongan'"  method="post">
											@csrf

											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
												<button @click="addCSharing = !(addCSharing)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">

												<div class="mb-3">
													<h5 class="my-2">Nilai Project : 
														<span x-text="cProject.project_value"></span>
													</h5>
													<h5 class="my-2">Uang Masuk : 
														<span x-text="cProject.totalpayment"></span>
													</h5>
													<h5 class="my-2">Sisa : 
														<span x-text="cProject.unshared"></span>
													</h5>
												</div>


												<div class="form-group">
													<label>Tanggal</label>
													<input class="form-control date-picker" type="text" name="date"  data-date-format="yyyy-m-d" required>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>Kas</label>
															<input class="form-control" type="number" name="amount_cash" :max="maxCSharingCash" @change="setMaxCSharingCash()" x-model="cSharingCash" required>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja</label>
															<input class="form-control" type="number" name="amount_worker" :max="maxCSharingWorker" @change="setMaxCSharingWorker()" x-model="cSharingWorker" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Total</label>
													<input class="form-control" x-model="cSharingTotal" type="number" readonly />
												</div>


											</div>
											<div class="modal-footer">
												<button @click="addCSharing = !(addCSharing)" class="btn btn-secondary">Close</button>
												<button type="submit" class="btn btn-primary">Bagi Hasil</button>
											</div>

										</form>
									</div>
								</div>
							</div>
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

												{{-- <template x-if="cBills"> --}}
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
															<td x-text="cProject.totalcharge"></td>
															<td></td>
														</tr>
													</tfoot>
												{{-- </template> --}}
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
												<button class="btn btn-info">Tambah</button>
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
													<span x-text="cProject.project_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="cProject.totalpayment"></span>
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

												{{-- <template x-if="cTermins"> --}}
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
															<td x-text="cProject.totalpayment"></td>
														</tr>
													</tfoot>
												{{-- </template> --}}
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
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Termin</h4>
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
												<button class="btn btn-info">Tambah</button>
											</div>
										</form>
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
											<th scope="col" class="border-0">No</th>
											<th scope="col" class="border-0">Klien</th>
											{{-- <th scope="col" class="border-0">Alamat</th> --}}
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai</th>
											<th scope="col" class="border-0">Nilai Harian</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Gaji Harian</th>
											{{-- <th scope="col" class="border-0">Status</th> --}}
											<th scope="col" class="border-0 datatable-nosort">KasBon</th>
											<th scope="col" class="border-0 datatable-nosort">Uang Masuk</th>
											<th scope="col" class="border-0 datatable-nosort">Bagi Hasil</th>
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
												{{-- <td>{{ $data->address }}</td> --}}
												<td>{{ $data->kind_project }}</td>
												<td>{{ $data->start_date }}</td>
												<td>{{ $data->daily_value }}</td>
												<td>{{ $data->worker->name }}</td>
												<td>{{ $data->daily_salary }}</td>
												{{-- <td><span class="badge badge-{{ $data->process == 'deal' ? 'info' : 'success'}}">{{ Str::ucfirst($data->process ) }}</span></td> --}}
												<td>
													<button class="btn btn-warning btn-sm" @click="setDBillingId({{ $data->id }})">KasBon</button>
												</td>
												<td>
													<button class="btn btn-info btn-sm" @click="setDTerminId({{ $data->id }})">Termin</button>
												</td>
												<td>
													<button class="btn btn-success btn-sm" @click="setDSharingId({{ $data->id }})">Bagi&nbsp;Hasil</button>
												</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="{{ route('admin.projects.finish', [$data->id, 'harian']) }}"><i class="dw dw-check"></i> Finish</a>
															<a class="dropdown-item" href="{{ route('admin.projects.onProgressShow', [$data->id, 'harian']) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ route('admin.projects.edit', [$data->id, 'harian']) }}"><i class="dw dw-edit2"></i> Edit</a>
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

												{{-- <template x-if="dBills"> --}}
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
															<td x-text="dProject.totalcharge"></td>
															<td></td>
														</tr>
													</tfoot>
												{{-- </template> --}}
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
												<button class="btn btn-info">Tambah</button>
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
													<span x-text="dProject.daily_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="dProject.totalpayment"></span>
												</h5>
												{{-- <h5 class="my-2">Sisa : 
													<span x-text="remainDTermin"></span>
												</h5> --}}
											</div>

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
													</tr>
												</thead>

												{{-- <template x-if="dTermins"> --}}
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
															<td x-text="dProject.totalpayment"></td>
														</tr>
													</tfoot>
												{{-- </template> --}}
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
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Termin</h4>
												<button @click="addDTermin = !(addDTermin)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													{{-- <h5 class="my-2">Sisa : 
														<span x-text="remainDTermin"></span>
													</h5> --}}
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
												<button class="btn btn-info">Tambah</button>
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

											<div class="mb-3">
												<h5 class="my-2">Nilai Harian : 
													<span x-text="dProject.daily_value"></span>
												</h5>
												<h5 class="my-2">Uang Masuk : 
													<span x-text="dProject.totalpayment"></span>
												</h5>
												<h5 class="my-2">Telah DiBagikan : 
													<span x-text="totalDSharing"></span>
												</h5>
												<h5 class="my-2">Sisa : 
													<span x-text="dProject.unshared"></span>
												</h5>
											</div>

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
														<template x-for="sharing in dSharings" :key="sharing.id">
																<tr>
																	<th scope="row">1</th>
																	<td x-text="sharing.date"></td>
																	<td x-text="sharing.amount_cash"></td>
																	<td x-text="sharing.amount_worker"></td>
																	<td x-text="sharing.amount_total"></td>
																</tr>
														</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="totalDSharingCash">Rp. 1.000.000</td>
															<td x-text="totalDSharingWorker">Rp. 3.000.000</td>
															<td x-text="totalDSharing">Rp. 4.000.000</td>
														</tr>
													</tfoot>
											</table>
										</div>
										<div class="modal-footer">
											<button @click="dSharingId = null" class="btn btn-secondary">Close</button>
											<button @click="addDSharing = !(addDSharing)" type="button" class="btn btn-primary">Bagi Hasil</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDSharing" style="display: none">
							<div class="modal-background">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form  x-bind:action="'/admin/projects/on-progress/'+ dSharingId +'/add-profit/harian'"  method="post">
											@csrf

											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
												<button @click="addDSharing = !(addDSharing)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">

												<div class="mb-3">
													<h5 class="my-2">Nilai Harian : 
														<span x-text="dProject.daily_value"></span>
													</h5>
													<h5 class="my-2">Uang Masuk : 
														<span x-text="dProject.totalpayment"></span>
													</h5>
													<h5 class="my-2">Sisa : 
														<span x-text="dProject.unshared"></span>
													</h5>
												</div>


												<div class="form-group">
													<label>Tanggal</label>
													<input class="form-control date-picker" type="text" name="date"  data-date-format="yyyy-m-d" required>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>Kas</label>
															<input class="form-control" x-model="dSharingCash" @change="setMaxDSharingCash" :max="maxDSharingCash" type="number" name="amount_cash" required>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja</label>
															<input class="form-control" x-model="dSharingWorker" @change="setMaxDSharingWorker" :max="maxDSharingWorker" type="number" name="amount_worker" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Total</label>
													<input class="form-control" x-model="dSharingTotal" type="number" required readonly>
												</div>

											</div>
											<div class="modal-footer">
												<button @click="addDSharing = !(addDSharing)" class="btn btn-secondary">Close</button>
												<button type="submit" class="btn btn-primary">Bagi Hasil</button>
											</div>

										</form>
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
	
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
		<script>
			function action() {
				return {
					cBillingId : null,
					cBills : [],
					addCBilling : false,
					cPaymentId: null,

					cProject:[],
					cTerminId: null,
					cTermins: [],
					addCTermin: null,
					remainCTermin:0,

					cDoneId: 0,

					cSharingId: 0,
					cSharings: [],
					totalCSharingCash : null,
					totalCSharingWorker : null,
					totalCSharing : null,
					addCSharing: false,
					maxCSharingCash: 0,
					maxCSharingWorker: 0,
					cSharingTotal: 0,
					cSharingCash: 0,
					cSharingWorker: 0,

					dBillingId : null,
					dBills : [],
					addDBilling : false,
					dPaymentId: null,

					dProject:[],
					dTerminId: null,
					dTermins: [],
					addDTermin: null,
					remainDTermin:0,

					dSharingId: null,
					dSharings: [],
					totalDSharingCash : null,
					totalDSharingWorker : null,
					totalDSharing : null,
					addDSharing: false,
					maxDSharingCash: 0,
					maxDSharingWorker: 0,
					dSharingTotal: 0,
					dSharingCash: 0,
					dSharingWorker: 0,

					getDataCProject(id) {
						var self = this;
						axios.get('{{ url("/api/get-project")}}/' + id + '/borongan')
						.then(function(response) {
							self.cProject = response.data.data;
							self.setRemainCTermin();
						});
					},

					setCBillingId(id) {
						this.cBillingId = id;
						this.getDataCProject(id);
						this.getDataCBilling();
					},
					getDataCBilling() {
						var self = this;
						axios.get('{{ url("/api/get-billing")}}/' + this.cBillingId + '/borongan')
						.then(function(response) {
							self.cBills = response.data;
						}) 
					},


					setCTerminId(id) {
						this.cTerminId = id;
						this.getDataCTermin();
						this.getDataCProject(id);
					},
					setRemainCTermin() {
						var self = this;
						var remain = self.cProject.project_value - self.cProject.totalpayment;
						this.remainCTermin = remain;
						console.log(self.cProject);
					},
					getDataCTermin() {
						var self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.cTerminId + '/borongan')
						.then(function(response) {
							self.cTermins = response.data;
						}) 
					},

					setCSharingId(id) {
						this.cSharingId = id;
						this.getDataCSharing();
						this.setCTotalSharing();
						this.getDataCProject(id);
					},
					getDataCSharing() {
						var self = this;
						axios.get('{{ url("/api/get-sharing")}}/' + this.cSharingId + '/borongan')
						.then(function(response) {
							self.cSharings = response.data;
							// console.log(self.cSharings);
							self.setCTotalSharing();
						}) 
					},
					setCTotalSharing() {
						var cCash = this.cSharings.reduce(function(total, num) {
							return (total + num.amount_cash);
						}, 0);
						var cWorker = this.cSharings.reduce(function(total, num) {
							return (total + num.amount_worker);
						}, 0);
						var cSharing = this.cSharings.reduce(function(total, num) {
							return (total + num.amount_total);
						}, 0);
						this.totalCSharingCash = cCash;
						this.totalCSharingWorker = cWorker;
						this.totalCSharing = cSharing;

					},
					setMaxCSharingCash() {
						let maxCSharing = this.cProject.unshared - this.cSharingWorker;
						this.maxCSharingCash = maxCSharing;
						this.cSharingTotal = parseInt(this.cSharingCash) + parseInt(this.cSharingWorker);
					},
					setMaxCSharingWorker() {
						let maxCSharing = this.cProject.unshared - this.cSharingCash;
						this.maxCSharingWorker = maxCSharing;
						this.cSharingTotal = parseInt(this.cSharingCash) + parseInt(this.cSharingWorker);
					},



					getDataDProject(id) {
						var self = this;
						axios.get('{{ url("/api/get-project")}}/' + id + '/harian')
						.then(function(response) {
							self.dProject = response.data.data;
							self.setRemainDTermin();
						});
						console.log(this.dProject.unshared);
					},

					setDBillingId(id) {
						this.dBillingId = id;
						this.getDataDProject(id)
						this.getDataDBilling();
					},
					getDataDBilling() {
						var self = this;
						axios.get('{{ url("/api/get-billing")}}/' + this.dBillingId + '/harian')
						.then(function(response) {
							self.dBills = response.data;
							console.log(self.dBills);
						}) 
					},


					setDTerminId(id) {
						this.dTerminId = id;
						this.getDataDTermin();
						this.getDataDProject(id);
					},
					setRemainDTermin() {
						var self = this;
						var remain = self.dProject.project_value - self.dProject.totalpayment;
						this.remainDTermin = remain;
						console.log(self.dProject);
					},
					getDataDTermin() {
						var self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.dTerminId + '/harian')
						.then(function(response) {
							self.dTermins = response.data;
						}) 
					},

					setDSharingId(id) {
						this.dSharingId = id;
						this.getDataDSharing();
						this.setDTotalSharing();
						this.getDataDProject(id);
					},
					getDataDSharing() {
						var self = this;
						axios.get('{{ url("/api/get-sharing")}}/' + this.dSharingId + '/harian')
						.then(function(response) {
							self.dSharings = response.data;
							console.log(self.dSharings);
							self.setDTotalSharing();
						}) 
					},
					setDTotalSharing() {
						var dCash = this.dSharings.reduce(function(total, num) {
							return (total + num.amount_cash);
						}, 0);
						var dWorker = this.dSharings.reduce(function(total, num) {
							return (total + num.amount_worker);
						}, 0);
						var dSharing = this.dSharings.reduce(function(total, num) {
							return (total + num.amount_total);
						}, 0);
						this.totalDSharingCash = dCash;
						this.totalDSharingWorker = dWorker;
						this.totalDSharing = dSharing;

					},
					setMaxDSharingCash() {
						let maxDSharing = this.dProject.unshared - this.dSharingWorker;
						this.maxDSharingCash = maxDSharing;
						this.dSharingTotal = parseInt(this.dSharingCash) + parseInt(this.dSharingWorker);
					},
					setMaxDSharingWorker() {
						let maxDSharing = this.dProject.unshared - this.dSharingCash;
						this.maxDSharingWorker = maxDSharing;
						this.dSharingTotal = parseInt(this.dSharingCash) + parseInt(this.dSharingWorker);
					},

						
				}
			}
		</script>
@endsection