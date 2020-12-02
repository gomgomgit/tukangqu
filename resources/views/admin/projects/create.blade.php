@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30"> 

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Buat Project</h4>
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
            {{-- <input class="form-control" type="date" name="order_date" value="{{ old('order_date') }}"> --}}
            <input class="form-control date-picker" placeholder="Select Date" type="text" name="order_date" data-date-format="yyyy-m-d">
          </div>
          <div class="form-group">
            <label>No Hp / WhatsApp</label>
            <input class="form-control" type="number" name="phone_number" value="{{ old('phone_number') }}">
          </div>
          <div class="form-group">
            <label>Address</label>
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

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: '#locations',
        mounted() {
          this.getProvincesData();
          this.province_id = @json(old('province_id'));
          this.city_id = @json(old('city_id'));
        },
        data: {
          provinces: null,
          cities: null,
          province_id: null,
          city_id: null,
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
        },
        watch: {
          province_id: function(val, oldVal) {
            this.city_id = null;
            this.getCitiesData();
          },
        },
      })
    </script>
    {{-- <script>
      $('.date-picker').datepicker({
        format: {
          toDisplay: function (date, format, language) {
            var d = new Date(date);
            d.setDate(d.getDate() - 7);
            return d.toISOString();
          },
          toValue: function (date, format, language) {
            var d = new Date(date);
            d.setDate(d.getDate() + 7);
            return new Date(d);
          }
        }
      })
    </script> --}}
@endsection