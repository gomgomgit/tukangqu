@extends('layouts.app')
@section('link')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endsection

@section('main-content')
	<div class="card-box mb-30"> 

			<!-- Striped table start -->
			<div id="locations" class="pd-20 card-box">
				<div>
					<h2 class="text-black h3">Buat Project</h2>
        </div>
        
        
        <form action="{{ route('admin.projects.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-12">
              <h5 class="mt-4 mb-2 border-bottom pb-2">Data Klien</h5>
            </div>
          </div>
      {{-- <label class="weight-600">Klien </label> --}}
          <div class="custom-control custom-radio mb-5">
            <input type="radio" id="customRadio1" name="client" class="custom-control-input" v-model="client_form" value="1" checked>
            <label class="custom-control-label" for="customRadio1">Klien Baru</label>
          </div>
          <div class="custom-control custom-radio mb-5">
            <input type="radio" id="customRadio2" name="client" class="custom-control-input" v-model="client_form" value="0">
            <label class="custom-control-label" for="customRadio2">Klien Lama</label>
          </div>

          <div v-show="client_form == 0" class="form-group">
            <label>Nama Klien</label>
            <select name="name_old_client" id="select-client" class="form-control " style="width: 100%; height: 38px;">
              @foreach ($clients as $client)
                  <option value="{{ $client->id }}">{{ $client->name }} -- {{$client->domicile}}</option>
              @endforeach
            </select>
          </div>
          <div v-show="client_form == 1" class="form-group">
            <label>Nama Klien</label>
            <input class="form-control" type="text" name="name_new_client" value="{{ old('name') }}">
          </div>

          <div v-if="client_form == 1">
            <div class="form-group">
              <label>No Hp / WhatsApp</label>
              <input class="form-control" type="number" name="phone_number" value="{{ old('phone_number') }}">
            </div>
            <div class="form-group">
              <label>Alamat Klien</label>
              <input class="form-control" type="text" name="client_address" value="{{ old('client_address') }}">
            </div>
  
            <div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select class="ex-custom-select2 form-control" id="client_province-id" name="client_province_id" v-model="client_province_id" style="width: 100%; height: 38px;">
                      <optgroup label="Provinsi">
                        <option v-for="province in clientProvinces" :value="province.id">@{{ province.name }}</option>
                      </optgroup>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kota / Kabupaten</label>
                    <select class="ex-custom-select2 form-control" id="client_city-id" name="client_city_id" v-model="client_city_id" style="width: 100%; height: 38px;">
                      <optgroup label="Kota / Kabupaten">
                        <option v-for="city in clientCities" :value="city.id">@{{ city.name }}</option>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <h5 class="mt-4 mb-2 border-bottom pb-2">Data Proyek</h5>
            </div>
          </div>

          <div class="form-group">
            <label>Tanggal Order</label>
            {{-- <input class="form-control" type="date" name="order_date" value="{{ old('order_date') }}"> --}}
            <input class="form-control date-picker" placeholder="Select Date" type="text" name="order_date" data-date-format="yyyy-m-d">
          </div>

          <div class="form-group">
            <label>Alamat Proyek</label>
            <input class="form-control" type="text" name="address" value="{{ old('address') }}">
          </div>

          <div>
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
            <label>Jenis Pengerjaan</label>
            <select class="form-control" name="kind_work" id="">
              <option value="borongan" {{ old('kind_work') == 'borongan' ? 'checked' : '' }}>Borongan</option>
              <option value="harian" {{ old('kind_work') == 'harian' ? 'checked' : '' }}>Harian</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jenis Proyek</label>
            <input class="form-control" type="text" placeholder="contoh: Renovasi Rumah" name="kind_project" value="{{ old('kind_project') }}">
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

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
      var locations = new Vue({
        el: '#locations',
        mounted() {
          this.getClientProvincesData();
          this.client_province_id = @json(old('client_province_id'));
          this.client_city_id = @json(old('client_city_id'));

          this.getProvincesData();
          this.province_id = @json(old('province_id'));
          this.city_id = @json(old('city_id'));

          $('#select-client').select2();
        },
        data: {
          clientProvinces: null,
          clientCities: null,
          client_province_id: null,
          client_city_id: null,
          provinces: null,
          cities: null,
          province_id: null,
          city_id: null,

          client_id: null,
          client_form: 1,
        },
        methods: {
          getClientProvincesData() {
            var self = this;

            axios.get('{{ url("/api/get-provinces") }}')
              .then(function (response) {
                self.clientProvinces = response.data;
              });
          },
          getClientCitiesData() {
            var self = this;

            axios.get('{{ url("/api/get-cities") }}/' + self.client_province_id)
              .then(function (response) {
                self.clientCities = response.data;
              });
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
        },
        watch: {
          client_province_id: function(val, oldVal) {
            this.client_city_id = null;
            this.getClientCitiesData();
          },
          province_id: function(val, oldVal) {
            this.city_id = null;
            this.getCitiesData();
          },
          client_form: function(val, oldVal) {
            if (this.client_form == 0) {
              $('#select-client').select2();
            };
          },
        },
      })
			
    </script>
@endsection