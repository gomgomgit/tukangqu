@extends('layouts.app')

@section('link')
	<link rel="stylesheet" href="{{ asset('css/c-modal.css') }}">
@endsection

@section('main-content')
	<div class="card-box mb-30">

		<!-- Striped table start -->
		<div class="pd-20 card-box">
			<div class="clearfix mb-20">
				<div class="pull-left">
					<h4 class="text-black h4">Data Hutang</h4>
				</div>
				<div class="pull-right pr-3">
					<a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
				</div>
			</div>
			<div x-data="pay()">
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nama</th>
							<th scope="col">Jumlah</th>
							<th scope="col" class="datatable-nosort">Action</th>
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($users as $user)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ $user->name }}</td>
								<td>Rp {{ number_format($user->debt, 0, '.', '.') }}</td>
								<td>
									<a href="#" @click.prevent="showModal({{$user->id}})" class="btn btn-sm btn-success py-1"><i class="icon-copy fa fa-money" aria-hidden="true"></i>&nbsp;Cicil</a>
									<a href="{{ route('admin.cashes.debtDetail', $user->id) }}" class="btn btn-sm btn-primary py-1">Detail</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div x-show="payModal === true" style="display: none; z-index: 99999">	
					<div class="modal-background" tabindex="-1">
						<div class="modal-dialog modal modal-dialog-centered modal">
							<div class="modal-content">
								<form action="{{ route('admin.cashes.debtPay') }}" method="POST">
									@csrf
									<input type="hidden" :value="userIdPay" name="user_id">
									<div class="modal-header">
										<h4 class="modal-title" id="myLargeModalLabel">Cicil Hutang</h4>
										<button @click="payModal = !(payModal)" type="button" class="close">×</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Tanggal</label>
											<input id="cBillingDate" class="form-control" type="date" name="date" data-date-format="yyyy-m-d" required>
										</div>
										<div class="form-group">
											<label>Jumlah</label>
											<input class="form-control" type="number" name="amount" required>
										</div>
									</div>
									<div class="modal-footer">
										<span @click="payModal = !(payModal)" type="button" class="btn btn-secondary">Close</span>
										<button class="btn btn-info" >Cicil</button>
									</div>
								</form>
							</div>
						</div>
					</div>
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
		function pay() {
			return {
				payModal: false,
				userIdPay: null,
				showModal (id) {
					this.payModal = !this.payModal
					this.userIdPay = id
				}
			}
		}
	</script>

@endsection