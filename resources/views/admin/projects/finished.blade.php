@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Data Proyek Finished</h4>
				</div>

				<div class="clearfix mb-20">
          <div class="pull-right">
            <a href="{{ Route('admin.projects.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
          </div>
				</div>
				<div class="tab">
					<ul class="nav nav-tabs customtab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#borongan" role="tab" aria-selected="true">Borongan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#harian" role="tab" aria-selected="false">Harian</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="borongan" role="tabpanel">
							<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">#</th>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai</th>
											<th scope="col" class="border-0">Tgl Selesai</th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Nilai Proyek</th>
											<th scope="col" class="border-0">Keuntungan</th>
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
												<td>{{ $data->finish_date }}</td>
												<td>{{ $data->worker->name ?? '---' }}</td>
												<td>{{ $data->project_value }}</td>
												<td>{{ $data->profit }}</td>
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

						<div class="tab-pane fade show" id="harian" role="tabpanel">
							{{-- <div class="pd-20"> --}}
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col" class="border-0">Klien</th>
											<th scope="col" class="border-0">Alamat</th>
											<th scope="col" class="border-0">Proyek</th>
											<th scope="col" class="border-0">Tgl Mulai</th>
											<th scope="col" class="border-0">Tgl Selesai</th>
											<th scope="col" class="border-0">Nilai Harian<th>
											<th scope="col" class="border-0">Pekerja</th>
											<th scope="col" class="border-0">Gaji Harian</th>
											<th scope="col" class="border-0">Keuntungan</th>
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
												<td>{{ $data->finish_date }}</td>
												<td>{{ $data->daily_value }}</td>
												<td>{{ $data->worker->name ?? '---' }}</td>
												<td>{{ $data->daily_salary }}</td>
												<td>{{ $data->profit }}</td>
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