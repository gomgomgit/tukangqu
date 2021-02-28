@extends('layouts.app')

@section('link')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
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
					<div class="tab-content" x-data="action()" x-init="init()">
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
												<td>
													@if ($data->worker)
														{{ $data->worker->name }} <a href={{ Route('admin.projects.workerShow', $data->worker_id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
													@endif
												</td>
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
													<div class="form-group">
														<label>Keterangan Tambahan</label>
														<textarea class="form-control" rows="5" name="description" value=""> </textarea>
													</div>
											</div>
											<div class="modal-footer">
												<span @click="cDoneId = !(cDoneId)" type="button" class="btn btn-secondary">Close</span>
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
												<span @click="cSharingId = null" class="btn btn-secondary">Close</span>
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
												<div class="row">
													<div class="col-6">
														<h5 class="my-2">Nilai Project : 
															<span x-text="cProject.project_value"></span>
														</h5>
														<h5 class="my-2">Uang Masuk : 
															<span x-text="cProject.totalpayment"></span>
														</h5>
													</div>
													<div class="col-6">
														<h5 class="my-2">Telah DiBagikan : 
															<span x-text="totalCSharing"></span>
														</h5>
														<h5 class="my-2">Sisa : 
															<span x-text="cProject.unshared"></span>
														</h5>
													</div>
												</div>
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

											<template x-if="cProject.project_value <= totalCSharing">
												<p class="h2 text-center">Telah Dibagikan</p>
											</template>
										</div>
										<div class="modal-footer">
											<span @click="cSharingId = null" class="btn btn-secondary">Close</span>

											<template x-if="cProject.project_value > totalCSharing">
												<button @click="addCSharing = !(addCSharing)" type="button" class="btn btn-primary">Bagi Hasil</button>
											</template>

											<template x-if="cProject.project_value <= totalCSharing">
													<a class="btn btn-primary" x-bind:href="'/admin/projects/on-progress/' + cProject.id + '/finish/borongan'"> Finish</a>
											</template>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCSharing" style="display: none">
							<div class="modal-background">
								<div class="modal-lg modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-on:submit.prevent="storeCSharing">
										{{-- <form  x-bind:action="'/admin/projects/on-progress/'+ cSharingId +'/add-profit/borongan'"  method="post"> --}}
											@csrf

											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
												<button @click="addCSharing = !(addCSharing)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">

												<div class="mb-3">
													<div class="row">
														<div class="col-6">
															<h5 class="my-2">Nilai Project : 
																<span x-text="cProject.project_value"></span>
															</h5>
															<h5 class="my-2">Uang Masuk : 
																<span x-text="cProject.totalpayment"></span>
															</h5>
														</div>
														<div class="col-6">
															<h5 class="my-2">Sisa : 
																<span x-text="cProject.unshared"></span>
															</h5>
														</div>
													</div>
												</div>


												<div class="form-group">
													<label>Tanggal</label>
													<input id="cSharingDate" class="form-control " x-model="dateCSharing" type="text" name="date"  data-date-format="yyyy-m-d" required>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>Kas</label>
															<input class="form-control" type="number" name="amount_cash" :max="maxCSharingCash" x-on:keyup="setMaxCSharingCash()" x-model="cSharingCash" required>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja</label>
															<input class="form-control" type="number" name="amount_worker" :max="maxCSharingWorker" x-on:keyup="setMaxCSharingWorker()" x-model="cSharingWorker" required>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>KasBon</label>
															<input class="form-control" x-model="cProject.totalcharge" type="number" readonly />
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja - KasBon</label>
															<input class="form-control" x-model="cSharingWorker - cProject.totalcharge" type="number" readonly />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Total</label>
													<input class="form-control" x-model="cSharingTotal" type="number" readonly />
												</div>


											</div>
											<div class="modal-footer">
												<span @click="addCSharing = !(addCSharing)" class="btn btn-secondary">Close</span>
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

											<div class="row mb-3">
												<div class="col-6">
													<h5 class="my-2">Nilai Project : 
														<span x-text="cProject.project_value"></span>
													</h5>
												</div>
												<div class="col-6">
													<h5 class="my-2">Total Kasbon : 
														<span x-text="cProject.totalcharge"></span>
													</h5>
												</div>
											</div>

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
											<span @click="cBillingId = null" class="btn btn-secondary">Close</span>
											<button @click="addCBilling = !(addCBilling)" type="button" class="btn btn-primary">Tambah Kasbon</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCBilling === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										{{-- <form x-bind:action="'/admin/projects/on-progress/'+ cBillingId +'/add-billing/borongan'" method="POST"> --}}
										<form x-on:submit.prevent="storeCBilling">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addCBilling = !(addCBilling)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal</label>
														<input id="cBillingDate" class="form-control" x-model="dateCBilling" type="text" name="date" data-date-format="yyyy-m-d" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" x-model="amountCBilling" type="number" name="amount" required>
													</div>
													<div class="form-group">
														<label>Ket</label>
														<input class="form-control" x-model="descriptionCBilling" type="text" name="description">
													</div>
											</div>
											<div class="modal-footer">
												<span @click="addCBilling = !(addCBilling)" type="button" class="btn btn-secondary">Close</span>
												<button class="btn btn-info" >Tambah</button>
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
											<div class="row mb-3">
												<div class="col-6">
													<h5 class="my-2">Nilai Project : 
														<span x-text="cProject.project_value"></span>
													</h5>
													<h5 class="my-2">Uang Masuk : 
														<span x-text="cProject.totalpayment"></span>
													</h5>
												</div>
												<div class="col-6">
													<h5 class="my-2">Sisa : 
														<span x-text="remainCTermin"></span>
													</h5>
												</div>
											</div>

											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col" class="border-0">#</th>
														<th scope="col" class="border-0">Tanggal</th>
														<th scope="col" class="border-0">Jumlah</th>
														<th scope="col" class="border-0">Bukti Transfer</th>
													</tr>
												</thead>

												{{-- <template x-if="cTermins"> --}}
													<tbody>
															<template x-for="(termin, index) in cTermins" :key="termin.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="termin.date"></td>
																	<td x-text="termin.amount"></td>
																	<td>
																		<a :href="'/storage/' + termin.evidence" data-fancybox="gallery" data-caption="Caption for single image">
																			{{-- <img width="80" height="80" src="https://media.karousell.com/media/photos/products/2018/05/03/ni_tipu_tipu_bukti_transfer_1525313387_eb9b1701.jpg" alt="" /> --}}
																			<img width="80" height="80" :src="'/storage/' + termin.evidence" alt="Not Found" />
																		</a>
																	</td>
																</tr>
															</template>
													</tbody>
													<tfoot>
														<tr>
															<td></td>
															<td>Total</td>
															<td x-text="cProject.totalpayment"></td>
															<td></td>
														</tr>
													</tfoot>
												{{-- </template> --}}
											</table>
											<template x-if="cProject.project_value == cProject.totalpayment">
												<p class="h2 text-center">Lunas</p>
											</template>

										</div>
										<div class="modal-footer">
											<span @click="cTerminId = null" class="btn btn-secondary">Close</span>
											
											<template x-if="cProject.project_value != cProject.totalpayment">
												<button @click="addCTermin = !(addCTermin)" type="button" class="btn btn-primary">Tambah Uang Masuk</button>
											</template>
											<template x-if="cProject.project_value == cProject.totalpayment">
												<span @click="paidOff()" class="btn btn-primary">Tambah Uang Masuk</span>
											</template>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addCTermin === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form @submit.prevent="storeCTermin" enctype="multipart/form-data">
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
														<input id="cTerminDate" class=" form-control" x-model="dateCTermin" data-date-format="yyyy-m-d" type="text" name="date" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" x-model="amountCTermin" type="number" name="amount" :value="remainCTermin" :max="remainCTermin" required>
													</div>
													<div class="form-group">
														<label>Bukti Transfer</label>
														<input @change="addCTerminImage" class="form-control" type="file" name="evidence" accept="image/*" required>
													</div>
											</div>
											<div class="modal-footer">
												<span @click="addCTermin = !(addCTermin)" type="button" class="btn btn-secondary">Close</span>
												<button class="btn btn-info">Tambah</button>
											</div>
										</form>
										{{-- <form x-bind:action="'/admin/projects/on-progress/'+ cTerminId +'/add-payment-fee/borongan'" method="POST">
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
														<input class="date-picker form-control" data-date-format="yyyy-m-d" type="text" name="date" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" type="number" name="amount" :value="remainCTermin" :max="remainCTermin" required>
													</div>
											</div>
											<div class="modal-footer">
												<span @click="addCTermin = !(addCTermin)" type="button" class="btn btn-secondary">Close</span>
												<button class="btn btn-info">Tambah</button>
											</div>
										</form> --}}
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
												<td>Rp {{ number_format($data->daily_value, 0, '.', '.') }}</td>
												<td>
													@if ($data->worker)
														{{ $data->worker->name }} <a href={{ Route('admin.projects.workerShow', $data->worker_id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a>
													@endif
												</td>
												<td>Rp {{ number_format($data->daily_salary, 0, '.', '.') }}</td>
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
															{{-- <a class="dropdown-item" href="{{ route('admin.projects.finish', [$data->id, 'harian']) }}"><i class="dw dw-check"></i> Finish</a> --}}
															<a class="dropdown-item" x-on:click="dDoneId = {{ $data->id }}"><i class="dw dw-check"></i> Finish</a>
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
						
						<div x-show="dDoneId" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div @click.away="dDoneId = null" class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form x-bind:action="'/admin/projects/on-progress/'+ dDoneId +'/done/harian'" method="POST">
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Selesai</h4>
												<button @click="dDoneId = !(dDoneId)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal Selesai</label>
														<input class="form-control" type="date" name="finish_date" value="" required>
													</div>
													<div class="form-group">
														<label>Keterangan Tambahan</label>
														<textarea class="form-control" rows="5" name="description" value=""> </textarea>
													</div>
											</div>
											<div class="modal-footer">
												<span @click="dDoneId = !(dDoneId)" type="button" class="btn btn-secondary">Close</span>
												<button class="btn btn-info">Selesai</button>
											</div>
										</form>
									</div>
								</div>
							</div>
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


											<div class="row mb-3">
												<div class="col-6">
													<h5 class="my-2">Nilai Harian : 
														Rp <span x-text="dProject.daily_value"></span>
													</h5>
												</div>
												<div class="col-6">
													<h5 class="my-2">Total Kasbon : 
														Rp <span x-text="dProject.totalcharge"></span>
													</h5>
												</div>
											</div>
											<div class="row">
												<div class="col">
													<h5 class="my-2">Total Kasbon Minggu Ini : 
														Rp <span x-text="dProject.chargeweek"></span>
													</h5>
												</div>
											</div>

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
											<span @click="dBillingId = null" class="btn btn-secondary">Close</span>
											<button @click="addDBilling = !(addDBilling)" type="button" class="btn btn-primary">Tambah Kasbon</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDBilling === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form @submit.prevent="storeDBilling">
										{{-- <form x-bind:action="'/admin/projects/on-progress/'+ dBillingId +'/add-billing/harian'" method="POST"> --}}
											@csrf
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">Tambah Kasbon</h4>
												<button @click="addDBilling = !(addDBilling)" type="button" class="close">×</button>
											</div>
											<div class="modal-body">
													<div class="form-group">
														<label>Tanggal</label>
														<input id="dBillingDate" class="form-control" x-model="dateDBilling" type="text" name="date" data-date-format="yyyy-m-d" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" x-model="amountDBilling" type="number" name="amount" required>
													</div>
													<div class="form-group">
														<label>Ket</label>
														<input class="form-control" x-model="descriptionDBilling" type="text" name="description">
													</div>
											</div>
											<div class="modal-footer">
												<span @click="addDBilling = !(addDBilling)" type="button" class="btn btn-secondary">Close</span>
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
												<h5 class="my-2">Uang Masuk : 
													Rp <span x-text="dProject.totalpayment"></span>
												</h5>
												<h5 class="my-2">Nilai Harian : 
													Rp <span x-text="dProject.daily_value"></span>
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
														<th scope="col" class="border-0">Bukti Transfer</th>
													</tr>
												</thead>

												{{-- <template x-if="dTermins"> --}}
													<tbody>
															<template x-for="(termin, index) in dTermins" :key="termin.id">
																<tr>
																	<th scope="row" x-text="index + 1">1</th>
																	<td x-text="termin.date"></td>
																	<td x-text="termin.amount"></td>
																	<td>
																		<a :href="'/storage/' + termin.evidence" data-fancybox="gallery" data-caption="Caption for single image">
																			{{-- <img width="80" height="80" src="https://media.karousell.com/media/photos/products/2018/05/03/ni_tipu_tipu_bukti_transfer_1525313387_eb9b1701.jpg" alt="" /> --}}
																			<img width="80" height="80" :src="'/storage/' + termin.evidence" alt="Not Found" />
																		</a>
																	</td>
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
											<span @click="dTerminId = null" class="btn btn-secondary">Close</span>
											<button @click="addDTermin = !(addDTermin)" type="button" class="btn btn-primary">Tambah Uang Masuk</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDTermin === true" style="display: none; z-index: 99999">	
							<div class="modal-background" tabindex="-1">
								<div class="modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form @submit.prevent="storeDTermin">
										{{-- <form x-bind:action="'/admin/projects/on-progress/'+ dTerminId +'/add-payment-fee/harian'" method="POST"> --}}
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
														<input id="dTerminDate" class="form-control" x-model="dateDTermin" data-date-format="yyyy-m-d" type="text" name="date" required>
													</div>
													<div class="form-group">
														<label>Jumlah</label>
														<input class="form-control" x-model="amountDTermin" type="number" name="amount" required>
													</div>
													<div class="form-group">
														<label>Bukti Transfer</label>
														<input @change="addDTerminImage" class="form-control" type="file" name="evidence" accept="image/*" required>
													</div>
											</div>
											<div class="modal-footer">
												<span @click="addDTermin = !(addDTermin)" type="button" class="btn btn-secondary">Close</span>
												<button class="btn btn-info">Tambah</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						<div x-show="dSharingId" style="display: none">
							<div class="modal-background">
								<div class="modal-lg modal-dialog modal modal-dialog-centered" style="max-width: 700px">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Bagi Hasil</h4>
											<button @click="dSharingId = null" type="button" class="close">×</button>
										</div>
										<div class="modal-body">

											<div class="mb-3">
												<div class="row">
													<div class="col-6">
														<h5 class="my-2">Nilai Harian : 
															<span x-text="dProject.daily_value"></span>
														</h5>
														<h5 class="my-2">Uang Masuk : 
															<span x-text="dProject.totalpayment"></span>
														</h5>
													</div>
													<div class="col-6">
														<h5 class="my-2">Telah DiBagikan : 
															<span x-text="totalDSharing"></span>
														</h5>
														<h5 class="my-2">Sisa : 
															<span x-text="dProject.unshared"></span>
														</h5>
													</div>
												</div>
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

												@php
														$no = 1;
												@endphp
													<tbody>
														<template x-for="(sharing, index) in dSharings" :key="sharing.id">
																<tr>
																	<th x-text="index + 1" scope="row"></th>
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
											<span @click="dSharingId = null" class="btn btn-secondary">Close</span>

											<template x-if="dProject.unshared > 0">
												<button @click="setAddDSharing()" type="button" class="btn btn-primary">Bagi Hasil</button>
											</template>
											<template x-if="dProject.unshared <= 0">
												<span @click="dSharingError()" class="btn btn-primary">Bagi Hasil</span>
											</template>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div x-show="addDSharing" style="display: none">
							<div class="modal-background">
								<div class="modal-lg modal-dialog modal modal-dialog-centered modal">
									<div class="modal-content">
										<form @submit.prevent="storeDSharing">
										{{-- <form  x-bind:action="'/admin/projects/on-progress/'+ dSharingId +'/add-profit/harian'"  method="post"> --}}
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

												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>Tanggal</label>
															<input id="dSharing" class="form-control" type="text" name="date"  data-date-format="yyyy-m-d" required>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Jumlah Hari Masuk</label>
															<input class="form-control" x-model="dDayAmount" @change="setDDayAmount" @keyup="setDDayAmount" type="number" name="day_amount" :max="maxDDayAmount" required>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>Kas</label>
															<input class="form-control" x-model="dSharingCash" @change="setMaxDSharingCash" :max="maxDSharingCash" type="number" name="amount_cash" required readonly>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja</label>
															<input class="form-control" x-model="dSharingWorker" @change="setMaxDSharingWorker" :max="maxDSharingWorker" type="number" name="amount_worker" required readonly>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-6">
														<div class="form-group">
															<label>KasBon Minggu Ini</label>
															<input class="form-control" x-model="dWeeklyBills" type="text" readonly>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label>Pekerja - Kasbon</label>
															<input class="form-control" x-model="dSharingWorker - dWeeklyBills" type="number" readonly>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<label>Total</label>
													<input class="form-control" x-model="dSharingTotal" type="number" required readonly>
												</div>

											</div>
											<div class="modal-footer">
												<span @click="addDSharing = !(addDSharing)" class="btn btn-secondary">Close</span>
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
	
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<!-- add sweet alert js & css in footer -->
	<script src="{{ asset('deskapp/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>

	{{-- fancybox --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

		<script>
			function action() {
				return {
					cBillingId : null,
					cBills : [],
					addCBilling : false,
					cPaymentId: null,

					dateCBilling: null,
					amountCBilling: 0,
					descriptionCBilling: null,

					cProject:[],
					cTerminId: null,
					cTermins: [],
					addCTermin: null,
					remainCTermin:0,
					cTerminImage: ' ',

					dateCTermin: null,
					amountCTermin: 0,

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

					dateCSharing: null,

					dBillingId : null,
					dBills : [],
					addDBilling : false,
					dPaymentId: null,

					dateDBilling: null,
					amountDBilling: 0,
					descriptionDBilling: null,

					dProject:[],
					dTerminId: null,
					dTermins: [],
					addDTermin: null,
					remainDTermin:0,
					cTerminImage: ' ',

					dateDTermin: null,
					amountDTermin: 0,

					dDoneId: 0,

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
					dDayAmount: 0,
					maxDDayAmount: 0,

					dSharingDate: null,
					dWeeklyBills: 0,

					dateDSharing: null,

					// init() {
						
					// 	var disabledDays = [0, 1, 2, 3, 4, 5];

					// 	var self = this;

					// 	$('#dSharing').datepicker({
					// 			language: 'en',
					// 			dateFormat: 'yyyy-m-d',
					// 			onRenderCell: function (date, cellType) {
					// 					if (cellType == 'day') {
					// 							var day = date.getDay(),
					// 									isDisabled = disabledDays.indexOf(day) != -1;

					// 							return {
					// 									disabled: isDisabled
					// 							}
					// 					}
					// 			},
					// 			onSelect(formattedDate, date, inst) {
					// 				self.getDWeeklyBills();
					// 			}
					// 	})
					// },

					init () {
						const self = this
						window.addEventListener('selectDSharingDate', function (e) {
							self.getDWeeklyBills(e.detail)
							self.dateDSharing = e.detail
						})
						window.addEventListener('selectCTerminDate', function (e) {
							self.dateCTermin = e.detail
						})
						window.addEventListener('selectCBillingDate', function (e) {
							self.dateCBilling = e.detail
						})
						window.addEventListener('selectCSharingDate', function (e) {
							self.dateCSharing = e.detail
						})
						window.addEventListener('selectDBillingDate', function (e) {
							self.dateDBilling = e.detail
						})
						window.addEventListener('selectDTerminDate', function (e) {
							self.dateDTermin = e.detail
						})
					},

					numberFormat(number) {
						return number.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
					},

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

					storeCBilling() {
						const self = this;
						let billingData = {
							'project_id' : this.cProject.id,
							'kind_project' : 'contract',
							'date' : this.dateCBilling,
							'amount' : this.amountCBilling,
							'description' : this.descriptionCBilling,
						};

						axios.post('{{ url("/api/store-billing") }}', billingData)
						.then(function(){
							self.setCBillingId(self.cProject.id);
							self.addCBilling = !self.addCBilling;
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
						// console.log(self.cProject);
					},
					getDataCTermin() {
						const self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.cTerminId + '/borongan')
						.then(function(response) {
							self.cTermins = response.data;
						}) 
					},

					addCTerminImage(e) {
        		this.cTerminImage = e.target.files[0]
					},

					storeCTermin() {
						console.log(this.cTerminImage);
						const self = this;

						let formData = new FormData();

						formData.append("project_id", self.cProject.id);
						formData.append("kind_project", 'contract');
						formData.append("date", self.dateCTermin);
						formData.append("amount", self.amountCTermin);
						formData.append("image", self.cTerminImage);

						console.log(formData);

						axios.post('{{ url("/api/store-termin") }}', formData, {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
            })
						.then(function(){
							self.setCTerminId(self.cProject.id);
							self.addCTermin = !self.addCTermin;
						})
						.catch(err => {
								console.log(err.message)
						});
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
						let maxCash = this.cProject.unshared - this.cSharingWorker;
						this.maxCSharingCash = maxCash;
						let maxworker = this.cProject.unshared - this.cSharingCash;
						this.maxCSharingWorker = maxworker;
						this.cSharingTotal = parseInt(this.cSharingCash) + parseInt(this.cSharingWorker);
					},
					setMaxCSharingWorker() {
						let maxWorker = this.cProject.unshared - this.cSharingCash;
						this.maxCSharingWorker = maxWorker;
						let maxCash = this.cProject.unshared - this.cSharingWorker;
						this.maxCSharingCash = maxCash;
						this.cSharingTotal = parseInt(this.cSharingCash) + parseInt(this.cSharingWorker);
					},

					storeCSharing() {
						const self = this;
						let sharingData = {
							'project_id' : this.cProject.id,
							'kind_project' : 'contract',
							'date' : this.dateCSharing,
							'amount_cash' : this.cSharingCash,
							'amount_worker' : this.cSharingWorker,
							'amount_total' : this.cSharingTotal, 
						};
						console.log(sharingData)
						
						axios.post('{{ url("/api/store-sharing") }}', sharingData)
						.then(function(){
							self.addCSharing = false;
							console.log('berhasil bagi hasil')
							self.setCSharingId(self.cProject.id);
						})
					},



					getDataDProject(id) {
						var self = this;
						axios.get('{{ url("/api/get-project")}}/' + id + '/harian')
						.then(function(response) {
							self.dProject = response.data.data;
							self.setRemainDTermin();
							// console.log(response.data.data);
						});
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
							// console.log(self.dBills);
						}) 
					},

					storeDBilling() {
						const self = this;
						let billingData = {
							'project_id' : this.dProject.id,
							'kind_project' : 'daily',
							'date' : this.dateDBilling,
							'amount' : this.amountDBilling,
							'description' : this.descriptionDBilling,
						};

						axios.post('{{ url("/api/store-billing") }}', billingData)
						.then(function(){
							self.setDBillingId(self.dProject.id);
							self.addDBilling = !self.addDBilling;
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
						// console.log(self.dProject);
					},
					getDataDTermin() {
						var self = this;
						axios.get('{{ url("/api/get-termin")}}/' + this.dTerminId + '/harian')
						.then(function(response) {
							self.dTermins = response.data;
						}) 
					},

					addDTerminImage(e) {
        		this.dTerminImage = e.target.files[0]
					},

					storeDTermin() {
						const self = this;

						let formData = new FormData();

						formData.append("project_id", self.dProject.id);
						formData.append("kind_project", 'daily');
						formData.append("date", self.dateDTermin);
						formData.append("amount", self.amountDTermin);
						formData.append("image", self.dTerminImage);

						console.log(formData);

						axios.post('{{ url("/api/store-termin") }}', formData, {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
            })
						.then(function(){
							self.setDTerminId(self.dProject.id);
							self.addDTermin = !self.addDTermin;
						})
						.catch(err => {
								console.log(err.message)
						});

						// let terminData = {
						// 	'project_id' : this.dProject.id,
						// 	'kind_project' : 'daily',
						// 	'date' : this.dateDTermin,
						// 	'amount' : this.amountDTermin,
						// };

						// axios.post('{{ url("/api/store-termin") }}', terminData)
						// .then(function(){
						// 	self.setDTerminId(self.dProject.id);
						// 	self.addDTermin = !self.addDTermin;
						// })
					},

					setDSharingId(id) {
						this.dSharingId = id;
						this.getDataDProject(id);
						this.getDataDSharing();
						this.setDTotalSharing();
						var myDatepicker = $('#dSharing').datepicker({
							autoClose: true
						}).data('datepicker');
						myDatepicker.clear();
						this.dWeeklyBills = 0;
					},
					getDataDSharing() {
						var self = this;
						axios.get('{{ url("/api/get-sharing")}}/' + this.dSharingId + '/harian')
						.then(function(response) {
							self.dSharings = response.data;
							// console.log(self.dSharings);
							self.setDTotalSharing();
						}) 
						this.init();
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
					setAddDSharing() {
						this.addDSharing = !this.addDSharing;
						this.dDayAmount = 0;
						this.maxDDayAmount = this.dProject.unshared / this.dProject.daily_value;
						console.log(this.maxDDayAmount + ' ' + this.dProject.unshared + ' ' + this.dProject.daily_value)
					},
					setDDayAmount(){
						this.dSharingCash = this.dDayAmount * (this.dProject.daily_value - this.dProject.daily_salary);
						this.dSharingWorker = this.dDayAmount * this.dProject.daily_salary;
						this.dSharingTotal = parseInt(this.dSharingCash) + parseInt(this.dSharingWorker);

						console.log(this.dProject.id);
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
					storeDSharing() {
						const self = this;
						let sharingData = {
							'project_id' : this.dProject.id,
							'kind_project' : 'daily',
							'date' : this.dateDSharing,
							'amount_cash' : this.dSharingCash,
							'amount_worker' : this.dSharingWorker,
							'amount_total' : this.dSharingTotal, 
							'total_all' : this.totalDSharing,
						};

						axios.post('{{ url("/api/store-sharing") }}', sharingData)
						.then(function(){
							self.addDSharing = !self.addDSharing;
							console.log('berhasil bagi hasil')
							self.setDSharingId(self.dProject.id);
						})
					},

					getDWeeklyBills(date) {
						var self = this;
						axios.get('{{ url("/api/get-weekly-bills")}}/' + this.dProject.id + '/' + date)
						.then(function(response) {
							console.log(response.data)
							self.dWeeklyBills = response.data;
						});
						// console.log(self.dProject.id);
					},

					dSharingError() {
						swal({
							title: 'Uang Habis',
							text: 'Tidak ada uang tersisa',
							icon: 'error',
							confirmButtonText: 'Kembali'
						})
					},

					paidOff() {
						swal({
							title: 'Lunas!',
							text: 'Silahkan membagi hasil!',
							type: 'success',
							confirmButtonClass: 'btn btn-success',
						})
					},
						
				}
			}
			var disabledDays = [0, 1, 2, 3, 4, 5];

			$('#dSharing').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onRenderCell: function (date, cellType) {
							if (cellType == 'day') {
									var day = date.getDay(),
											isDisabled = disabledDays.indexOf(day) != -1;

									return {
											disabled: isDisabled
									}
							}
					},
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectDSharingDate', { detail: formattedDate })
						window.dispatchEvent(ev)
						// clear()
					},
			});

			$('#cTerminDate').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectCTerminDate', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			});

			$('#cBillingDate').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectCBillingDate', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})

			$('#cSharingDate').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectCSharingDate', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})

			$('#dBillingDate').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectDBillingDate', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})

			$('#dTerminDate').datepicker({
					language: 'en',
					dateFormat: 'yyyy-m-d',
					autoClose: true,
					onSelect(formattedDate, date, inst) {
						const ev = new CustomEvent('selectDTerminDate', { detail: formattedDate })
						window.dispatchEvent(ev)
					},
			})
		</script>
@endsection