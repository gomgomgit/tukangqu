@extends('layouts.app')

@section('link')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
@endsection

@php
    // dd($data);
@endphp

@section('main-content')
	<div class="card-box mb-30">
    <!-- horizontal Basic Forms Start -->
    <div class="pd-20 card-box mb-30">
      <div class="clearfix">
        <div class="pull-left">
          <h4 class="text-blue h3">Edit Tukang</h4>
        </div>
      </div>
      <form action="{{ Route('admin.workers.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
          <div class="mb-3">
            <ul class="p-3 bg-danger">
              @foreach ($errors->all() as $error)
                <li class="">{{ $error }}</li>
              @endforeach
            </ul>
          </div>  
        @endif
        <div class="text-center">
          <h2 class="h3 d-inline-block mb-4">Data Diri</h2>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input class="form-control" type="text" name="name" value="{{ old('name', $data->name) }}">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tempat Tanggal Lahir</label>
              <input class="form-control" placeholder="Tempat Lahir" type="text" name="birth_place" value="{{ old('birth_place', $data->birth_place) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label></label>
              <input class="form-control ex-date-picker" placeholder="Tanggal Lahir" type="date" name="birth_date" value="{{ old('birth_date', $data->birth_date) }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Email</label>
              <input class="form-control" value="email@example.com" type="email" name="email" value="{{ old('email', $data->email) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>No Hp/WhatsApp</label>
              <input class="form-control" type="text" name="phone_number" value="{{ old('phone_number', $data->phone_number) }}">
            </div>
          </div>
        </div>

        <hr>

        <div class="text-center">
          <h2 class="h3 d-inline-block mb-4">Alamat</h2>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama Jalan dan Nomor Rumah</label>
              <input class="form-control" type="text" name="address" value="{{ old('address', $data->address) }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>RT</label>
              <input class="form-control" type="number" name="rt" value="{{ old('rt', $data->rt) }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>RW</label>
              <input class="form-control" type="number" name="rw" value="{{ old('rw', $data->rw) }}">
            </div>
          </div>
        </div>
        <div id="locations">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Provinsi</label>
                <select class="ex-custom-select2 form-control" id="province-id" name="province_id" v-model="province_id" style="width: 100%; height: 38px;">
                  <optgroup label="Provinsi">
                    <option v-for="province in provinces" :value="province.id" :selected="province.id == province_id ? 'selected' : ''">@{{ province.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kota / Kabupaten</label>
                <select class="ex-custom-select2 form-control" id="city-id" name="city_id" v-model="city_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kota / Kabupaten">
                    <option v-for="city in cities" :value="city.id" :selected="city.id == city_id ? 'selected' : ''">@{{ city.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kelurahan</label>
                <select class="ex-custom-select2 form-control" id="district-id" name="district_id" v-model="district_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kelurahan">
                    <option v-for="district in districts" :value="district.id" :selected="district.id == district_id ? 'selected' : ''">@{{ district.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kecamatan / Desa</label>
                <select class="ex-custom-select2 form-control" id="village-id" name="village_id" v-model="village_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kecamatan / Desa">
                    <option v-for="village in villages" :value="village.id" :selected="village.id == village_id ? 'selected' : ''">@{{ village.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
          </div>
        </div>

        <hr>

        <div class="text-center">
          <h2 class="h3 d-inline-block mb-4">Data Pekerjaan</h2>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label>Jenis Tukang</label>
                <select class="selectpicker form-control" name="worker_kind_id" style="width: 100%; height: 38px;">
                  @foreach ($kinds as $kind)
                    {{-- <optgroup label=""> --}}
                      <option value="{{ $kind->id }}" {{ old('worker_kind_id', $data->worker_kind_id) == $kind->id ? 'selected' : '' }}>{{ $kind->name }}</option>
                    {{-- </optgroup> --}}
                  @endforeach
                </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label>Tenaga Ahli</label>
                <select class="selectpicker form-control" name="specialist_id" style="width: 100%; height: 38px;">
                  @foreach ($specialists as $specialist)
                      <option value="{{ $specialist->id }}" {{ old('specialist_id', $data->specialist_id) == $specialist->id ? 'selected' : '' }}>{{ $specialist->name }}</option>
                  @endforeach
                </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-12 form-group mb-1">
              <label class="">Keahlian</label>
            </div>
            @foreach ($skills as $skill)
              <div class="col-md-4 col-sm-6 mb-0">
                <div class="custom-control custom-checkbox mb-5">
                  <input type="checkbox" class="custom-control-input" value="{{ $skill->id }}" 
                    name="skill[]" id="customCheck{{ $skill->id }}"
                    @if(
                      is_array(old('skill_id', $selectedSkills)) 
                      && 
                      in_array($skill->id, old('skill_id', $selectedSkills))
                      ) checked @endif>
                  <label class="custom-control-label" for="customCheck{{ $skill->id }}">{{ $skill->name }}</label>
                </div>
              </div> 
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <label>Pengalaman Kerja</label>
          <input type="text" class="form-control" placeholder="contoh: 2 Tahun" name="experience" value="{{ old('experience', $data->experience) }}">
        </div>

        <hr>

        <div class="text-center">
          <h2 class="h3 d-inline-block mb-4">Dokumen</h2>
        </div>
        
        <div class="row">
          {{--  --}}
          <div class="col-md-6">
            <div class="form-group">
              <label>Upload Foto Diri</label>
              <p class="small">Berfoto dengan menampilkan diri anda sambil memperlihatkan KTP</p>
              <div>
                <div class="fileinput fileinput-{{ $data->self_photo ? 'exists' : 'new' }}" data-provides="fileinput">
                  <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
                    <img data-src="holder.js/100%x100%"  alt="Foto Anda">
                  </div>

                  <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 500px; max-height: 600px;">
                      <img class="fileinput-exists" src="{{ Storage::url($data->self_photo) }}" 
                      alt="Foto Anda" style="max-height: 600px; max-width: 500px;">  
                  </div>

                  <div>
                    <span class="btn btn-outline-secondary btn-file">
                      <span class="fileinput-new">Select image</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="self_photo" accept="image/*" value="{{ Storage::url($data->self_photo) }}"></span>
                      <input type="hidden" value="{{ $data->self_photo }}" name="old_self_photo">
                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Upload Foto KTP</label>
              <p class="small">Berfoto dengan menampilkan KTP keseluruhan</p>
              <div>
                <div class="fileinput fileinput-{{ $data->id_card_photo ? 'exists' : 'new' }}" data-provides="fileinput">
                  <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
                    <img data-src="holder.js/100%x100%"  alt="Foto Anda">
                  </div>
                  <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 500px; max-height: 600px;">
                    <img src="{{ Storage::url($data->id_card_photo) }}" style="max-width: 500px; max-height: 600px;" alt="Foto Anda">
                  </div>
                  <div>
                    <span class="btn btn-outline-secondary btn-file">
                      <span class="fileinput-new">Select image</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="id_card_photo" accept="image/*" value="{{ Storage::url($data->id_card_photo) }} required"></span>
                      <input type="hidden" value="{{ $data->id_card_photo }}" name="old_id_card_photo">
                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr>

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

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
      $('.fileinput').fileinput()
    </script>
    <script>
      var locations = new Vue({
        el: '#locations',
        mounted() {
          this.setDataLocation();
        },
        data: {
          provinces: null,
          cities: null,
          districts: null,
          villages: null,
          province_id: {{ $data->province_id }},
          city_id: {{ $data->city_id }},
          district_id: {{ $data->district_id }},
          village_id: {{ $data->village_id }},
        },
        methods: {
          setDataLocation() {
            var self = this;

            axios.get('{{ url("/api/get-provinces") }}')
              .then(function (response) {
                self.provinces = response.data;
              });
            axios.get('{{ url("/api/get-cities") }}/' + @json($data->province_id))
              .then(function (response) {
                self.cities = response.data;
              });
            axios.get('{{ url("/api/get-districts") }}/' + @json($data->city_id))
              .then(function (response) {
                self.districts = response.data;
             });
            axios.get('{{ url("/api/get-villages") }}/' + @json($data->district_id))
              .then(function (response) {
                self.villages = response.data;
              });

            this.setLocation();
          },
          getProvincesData() {
            var self = this;

            axios.get('{{ url("/api/get-provinces") }}')
              .then(function (response) {
                self.provinces = response.data;
              });
          },
          getCitiesData() {
            var self = this;

            axios.get('{{ url("/api/get-cities") }}/' + self.province_id)
              .then(function (response) {
                self.cities = response.data;
              });
          }, 
          getDistrictsData() {
            var self = this;

            axios.get('{{ url("/api/get-districts") }}/' + self.city_id)
              .then(function (response) {
                self.districts = response.data;
              });
          },
          getVillagesData() {
            var self = this;

            axios.get('{{ url("/api/get-villages") }}/' + self.district_id)
              .then(function (response) {
                self.villages = response.data;
              });
          },
          check() {
            console.log('d')
          }
        },
        watch: {
          province_id: function(val, oldVal) {
            this.city_id = null;
            this.getCitiesData();
          },
          city_id: function(val, oldVal) {
            this.district_id = null;
            this.getDistrictsData();
          },
          district_id: function(val, oldVal) {
            this.village_id = null;
            this.getVillagesData();
          },
        },
      })
    </script>
@endsection