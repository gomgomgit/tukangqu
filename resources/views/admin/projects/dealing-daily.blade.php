@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30">

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Dealing Project</h4>
        </div>
        
        <form action="{{ route('admin.projects.deal', [$data->id, 'harian']) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Tanggal Mulai</label>
            <input class="form-control date-picker" type="text" name="start_date" data-date-format="yyyy-m-d" required>
          </div>
          <div class="form-group">
            <label>Gaji Pekerja</label>
            <input class="form-control" type="number" name="daily_salary" required>
          </div>
          <div class="form-group">
            <label>Pekerja</label>
            <select class="custom-select2 form-control" name="worker_id" style="width: 100%; height: 38px;">
              @foreach ($workers as $worker)
              <option value="{{ $worker->id }}">{{ $worker->name }} -- {{ $worker->domicile }}</option>  
              @endforeach
            </select>
          </div>
          <div>
            <button class="btn btn-primary">
              Deal
            </button>
          </div>
        </form>
			</div>
			<!-- Striped table End -->
	</div>
@endsection