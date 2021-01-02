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
					<h4 class="h3">Data Hutang {{$datas->first()->user->name}}</h4>
				</div>
				<div class="pull-right pr-3">
					{{-- <a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a> --}}
				</div>
			</div>
			<div class="clearfix mb-20" x-data="pay()">
				<div class="pull-left">
					<h4 class="font-weight-bold h6">Total Hutang Rp {{number_format($total, 0, '.', '.')}}</h4>
				</div>
				<div class="pull-right pr-3">
					<a href="#" @click.prevent="showModal({{$datas->first()->user->id}})" class="btn btn-sm btn-success"><i class="icon-copy fa fa-money" aria-hidden="true"></i>&nbsp;Cicil</a>
					<a href="{{ Route('admin.cashes.createOut') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
				</div>

				<div x-show="payModal === true" style="display: none; z-index: 99999">	
					<div class="modal-background" tabindex="-1">
						<div class="modal-dialog modal modal-dialog-centered modal">
							<div class="modal-content">
								{{-- <form x-bind:action="'/admin/projects/on-progress/'+ cBillingId +'/add-billing/borongan'" method="POST"> --}}
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
											<input id="cBillingDate" class="form-control" x-model="datePay" type="date" name="date" data-date-format="yyyy-m-d" required>
										</div>
										<div class="form-group">
											<label>Jumlah</label>
											<input class="form-control" x-model="amountPay" type="number" name="amount" required>
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
			<div>
				<table class="data-table table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Nama</th>
							<th scope="col">Jumlah</th>
							{{-- <th scope="col" class="datatable-nosort">Action</th> --}}
						</tr>
					</thead>
					<tbody>
						@php
								$no = 1;
						@endphp
						@foreach ($datas as $data)
							<tr>
								<th scope="row">{{ $no++ }}</th>
								<td>{{ Carbon\Carbon::parse($data->date)->format('d-M-Y') }}</td>
								<td>{{ $data->name }}</td>
								<td>Rp {{ number_format($data->money_out, 0, '.', '.') }}</td>
								{{-- <td>
								</td> --}}
							</tr>
						@endforeach
					</tbody>
				</table>
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
				datePay: null,
				amountPay: 0,
				showModal (id) {
					this.payModal = !this.payModal
					this.userIdPay = id
				},
				storePay() {
					const self = this;
					let payData = {
						'name': 'Cicil ',
						'date': this.datePay,
						'category': 'pay',
						'money_in': 0,
						'money_out': this.amountPay,
						'description': null,
						'user_id': this.userIdPay,
					};

					axios.post('{{ url("/api/store-pay-debt") }}', payData)
					.then( function () {
						self.payModal = !(self.payModal)
					})
				},
			}
		}
	</script>

@endsection