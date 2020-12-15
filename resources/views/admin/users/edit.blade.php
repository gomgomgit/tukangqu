@extends('layouts.app')

@section('link')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
@endsection

@section('main-content')
	<div class="card-box mb-30">
    <!-- horizontal Basic Forms Start -->
    <div class="pd-20 card-box mb-30">
      <div class="clearfix">
        <div class="pull-left">
          <h4 class="text-blue h4">Edit User</h4>
        </div>
      </div>
      <form action="{{ Route('admin.users.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @if ($errors->any())
          <div class="mb-3">
            <ul class="p-3 bg-danger">
              @foreach ($errors->all() as $error)
                <li class="">{{ $error }}</li>
              @endforeach
            </ul>
          </div>  
        @endif
        <div class="form-group">
          <label>Nama</label>
          <input class="form-control" type="text" name="name" value="{{ old('name', $data->name) }}" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input class="form-control" type="email" name="email" value="{{ old('email', $data->email) }}" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input class="form-control" type="password" name="password" value="{{ old('password') }}">
        </div>

        <br><br>

        <div class="form-group">
          <button class="btn btn-primary w-100">Edit Data</button>
        </div>
      </form>
      <div class="collapse collapse-box" id="horizontal-basic-form1" >
        <div class="code-box">
          <div class="clearfix">
            <a href="javascript:;" class="btn btn-primary btn-sm code-copy pull-left"  data-clipboard-target="#horizontal-basic"><i class="fa fa-clipboard"></i> Copy Code</a>
            <a href="#horizontal-basic-form1" class="btn btn-primary btn-sm pull-right" rel="content-y"  data-toggle="collapse" role="button"><i class="fa fa-eye-slash"></i> Hide Code</a>
          </div>
        </div>
      </div>
    </div>
    <!-- horizontal Basic Forms End -->
	</div>
@endsection