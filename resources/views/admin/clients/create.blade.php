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
          <h4 class="text-blue h4">Form Tambah Klien</h4>
        </div>
      </div>
      <form action="{{ Route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
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
          <input class="form-control" type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
          <label>No Hp/WhatsApp</label>
          <input class="form-control" type="number" name="phone_number" value="{{ old('phone_number') }}">
        </div>

        <div class="form-group">
          <label>Alamat</label>
          <input class="form-control" type="text" name="address" value="{{ old('address') }}">
        </div>
        <div id="locations">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Provinsi</label>
                <select class="ex-custom-select2 form-control" id="province-id" name="province_id" v-model="province_id" style="width: 100%; height: 38px;">
                  <optgroup label="Provinsi">
                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kota / Kabupaten</label>
                <select class="ex-custom-select2 form-control" id="city-id" name="city_id" v-model="city_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kota / Kabupaten">
                    <option v-for="city in cities" :value="city.id">@{{ city.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-primary w-100">Tambah Data</button>
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
          this.getProvincesData();
          this.province_id = @json(old('province_id'));
          this.city_id = @json(old('city_id'));
          this.district_id = @json(old('district_id'));
          this.village_id = @json(old('village_id'));
        },
        data: {
          provinces: null,
          cities: null,
          districts: null,
          villages: null,
          province_id: null,
          city_id: null,
          district_id: null,
          village_id: null,
        },
        methods: {
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
            // console.log(this.province_id);
            // $('#province-id').on('select2:select', e => {
            //   row.city_id = e.target.value;
            // });
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