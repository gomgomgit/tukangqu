@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div class="clearfix mb-20">
					<div class="pull-left">
						<h4 class="text-black h4">Detail Tukang</h4>
					</div>
				</div>
				<div class="row mx-2">
					<div class="col-md-7">
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
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
							<div class="col-4 font-weight-bold">
								Tempat Tanggal Lahir
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->birth_info }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
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
							<div class="col-4 font-weight-bold">
								Email
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->email }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Alamat
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->full_address }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Jenis Tukang
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->workerKind->name }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Tenaga Ahli
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->specialist->name }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Keahlian
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								@foreach ($data->skills as $skill)
										{{ $skill->name . ', ' }}
								@endforeach
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Pengalaman Kerja
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->experience }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-4 font-weight-bold">
								Jumlah Project
							</div>
							<div class="col-1">
								:
							</div>
							<div class="col-6">
								{{ $data->project_done() }}
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-12">
								<img src="{{ Storage::url($data->id_card_photo) }}" alt="" style="max-width: 500px">
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="pt-5">
							<img src="{{ Storage::url($data->self_photo) }}" alt="">
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