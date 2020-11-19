@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Kas</h4>
				</div>

				<div class="clearfix mb-20">
					<div class="pull-left">
						<p class="font-weight-bold">Saldo: Rp {{ number_format($total) }}</p>
          </div>
          <div class="pull-right">
            <a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
          </div>
				</div>
				<div class="tab">
					<ul class="nav nav-tabs customtab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#semua" role="tab" aria-selected="true">Semua</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#masuk" role="tab" aria-selected="false">Masuk</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#keluar" role="tab" aria-selected="false">Keluar</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="semua" role="tabpanel">
							{{-- <div class="pd-20"> --}}
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Nama</th>
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">Kategori</th>
											<th scope="col" class="border-0">Masuk</th>
											<th scope="col" class="border-0">Keluar</th>
											<th scope="col" class="border-0">Deskripsi</th>
											<th scope="col" class="border-0">Action</th>
										</tr>
									</thead>
									<tbody>
										@php
												$no = 1;
										@endphp
										@foreach ($datas as $data)
											<tr>
												<th scope="row">{{ $no++ }}</th>
												<td>{{ $data->name }}</td>
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>{{ $data->category }}</td>
												<td>Rp {{ $data->money_in }}</td>
												<td>Rp {{ $data->money_out }}</td>
												<td>{{ $data->description }}</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
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
						<div class="tab-pane fade" id="masuk" role="tabpanel">
							<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Nama</th>
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">Kategori</th>
											<th scope="col" class="border-0">Masuk</th>
											<th scope="col" class="border-0">Deskripsi</th>
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
												<td>{{ $data->name }}</td>
												<td>{{ date('l, d-M-Y', strtotime($data->date)) }}</td>
												<td>{{ $data->category }}</td>
												<td>Rp {{ $data->money_in }}</td>
												<td>{{ $data->description }}</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
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
						<div class="tab-pane fade" id="keluar" role="tabpanel">
							<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Nama</th>
											<th scope="col" class="border-0">Tanggal</th>
											<th scope="col" class="border-0">Kategori</th>
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
												<td>{{ $data->category }}</td>
												<td>Rp {{ $data->money_out }}</td>
												<td>{{ $data->description }}</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item" href="{{ Route('admin.workers.show', $data->id) }}"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item" href="{{ Route('admin.workers.edit', $data->id) }}"><i class="dw dw-edit2"></i> Edit</a>
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