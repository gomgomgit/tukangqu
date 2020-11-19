@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Buat Pengeluaran</h4>
        </div>
        
        <form action="{{ route('admin.projects.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Nama Klien</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
          </div>
          @csrf
          <div class="form-group">
            <label>Tanggal Order</label>
            <input class="form-control" type="date" name="order_date" value="{{ old('order_date') }}">
          </div>
          <div class="form-group">
            <label>No Hp / WhatsApp</label>
            <input class="form-control" type="number" name="phone_number" value="{{ old('phone_number') }}">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input class="form-control" type="text" name="address" value="{{ old('address') }}">
          </div>
          <div class="form-group">
            <label>Jenis Pengerjaan</label>
            <select class="form-control" name="kind_work" id="">
              <option value="borongan" {{ old('kind_work') == 'borongan' ? 'checked' : '' }}>Borongan</option>
              <option value="harian" {{ old('kind_work') == 'harian' ? 'checked' : '' }}>Harian</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jenis Proyek</label>
            <input class="form-control" type="text" placeholder="contoh: Renovasi Rumah" name="kind_project">
          </div>
          <div>
            <button class="btn btn-primary">
              Submit
            </button>
          </div>
        </form>
			</div>
			<!-- Striped table End -->
	</div>
@endsection