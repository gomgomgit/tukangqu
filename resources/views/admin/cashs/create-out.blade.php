@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Buat Pengeluaran</h4>
        </div>
        
        <form action="{{ route('admin.cashes.storeOut') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Uraian</label>
            <input class="form-control" type="text" name="name">
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input class="form-control" placeholder="Select Date" type="date" name="date">
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select class="form-control" name="category" id="">
              <option value="Belanja Umum">Belanja Umum</option>
              <option value="Tagihan Internet">Tagihan Internet</option>
              <option value="Transportasi">Transportasi</option>
              <option value="Biaya Website">Biaya Website</option>
              <option value="Iklan">Iklan</option>
              <option value="Gaji">Gaji</option>
              <option value="Alat Penunjang">Alat Penunjang</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input class="form-control" type="number" name="money_out">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" name="description"></textarea>
          </div>
          <div>
            <button class="btn btn-primary">
              Tambah Pengeluaran
            </button>
          </div>
        </form>
				
				<div class="clearfix">
					<div class="pull-right">
						{{-- {{ $datas->links() }} --}}
					</div>
				</div>
			</div>
			<!-- Striped table End -->
	</div>
@endsection