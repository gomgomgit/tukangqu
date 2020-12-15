@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Edit Kas</h4>
        </div>
        
        <form action="{{ route('admin.cashes.updateout', $data->id) }}" method="POST">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Uraian</label>
            <input class="form-control" type="text" name="name" value="{{ $data->name }}">
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input class="form-control" placeholder="Select Date" type="date" name="date" value="{{ $data->date }}">
          </div>
          <div class="form-group">
            <input class="form-control" type="hidden" name="category" value="out">
          </div>
          <div class="form-group">
            <label>User</label>
            <select class="form-control" name="user_id">
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $data->user_id ? 'selected' : '' }}>{{ $user->name }}</option>  
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah Uang Masuk</label>
            <input class="form-control" type="number" name="money_in" value="{{ $data->money_in }}">
          </div>
          <div class="form-group">
            <label>Jumlah Uang Keluar</label>
            <input class="form-control" type="number" name="money_out" value="{{ $data->money_out }}">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" name="description">{{ $data->description }}</textarea>
          </div>
          <div>
            <button class="btn btn-primary">
              Edit
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