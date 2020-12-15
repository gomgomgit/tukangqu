@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Detail Klien</h4>
					</div>
				</div>
				<div class="row mx-2">
					<div class="col-md-12">
						<div class="row mb-2">
							<div class="col-2 font-weight-bold">
								Nama
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->name }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-2 font-weight-bold">
								No HP
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->phone_number }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-2 font-weight-bold">
								Alamat
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->address }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-2 font-weight-bold">
							</div>
							<div class="col-1">
							</div>
							<div class="col-6">
								{{ $data->city }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-2 font-weight-bold">
								Jumlah Project
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->projects_count }}
								@if ($data->projectscount)
									<a href={{ Route('admin.clients.viewProjects', $data->id) }}><i class="icon-copy fa fa-info-circle" aria-hidden="true"></i></a></td>	
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2 mt-4">
					<div class="col my-3">
						<a class="btn btn-primary px-4" href="{{ Route('admin.workers.edit', $data->id) }}">Edit</a>
					</div>
				</div>
			</div>
			<!-- Striped table End -->
	</div>
@endsection
