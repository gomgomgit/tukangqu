@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30"> 

			<!-- Striped table start -->
			<div id="locations" class="pd-20 card-box">
				<div class="mb-3">
					<h3 class="text-black text-center mt-3">Edit Proyek</h3>
        </div>
        
        <div class="row mx-2">
          <div class="col-12">
            <form action="{{ route('admin.projects.update', [$data->id, 'borongan']) }}" method="POST">
              @csrf
              {{-- <div class=""><p class="">{{ $data->id }}</p></div> --}}
              <div class="row mb-3">
                <div class="col border-bottom mt-3">
                  <h4>Data Klien</h4>
                </div>
              </div>
              <div class="form-group">
                <label>Nama Klien</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', $data->client->name) }}">
              </div>
              <div class="form-group">
                <label>No Hp / WhatsApp</label>
                <input class="form-control" type="text" name="phone_number" value="{{ old('phone_number', $data->client->phone_number) }}">
              </div>
              <div class="form-group">
                <label>Alamat Klien</label>
                <input class="form-control" type="text" name="client_address" value="{{ old('client_address', $data->client->address) }}">
              </div>
              
              <div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Provinsi</label>
                      <select class="ex-custom-select2 form-control" id="client-province-id" name="client_province_id" v-model="client_province_id" style="width: 100%; height: 38px;">
                        <optgroup label="Provinsi">
                          <option value="{{ $data->client->province_id }}" selected>{{ Indonesia::findProvince($data->client->province_id)->name }}</option>
                          <option v-for="province in clientProvinces" :value="province.id">@{{ province.name }}</option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kota / Kabupaten</label>
                      <select class="ex-custom-select2 form-control" id="client-city-id" name="client_city_id" v-model="client_city_id" style="width: 100%; height: 38px;">
                        <optgroup label="Kota / Kabupaten">
                          <option value="{{ $data->client->city_id }}" selected>{{ Indonesia::findCity($data->client->city_id)->name }}</option>
                          <option v-for="city in clientCities" :value="city.id">@{{ city.name }}</option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col border-bottom mt-3">
                  <h4>Data Proyek</h4>
                </div>
              </div>

              <div class="form-group">
                <label>Tanggal Order</label>
                {{-- <input class="form-control" type="date" name="order_date" value="{{ old('order_date') }}"> --}}
                <input class="form-control date-picker" placeholder="Select Date" type="text" 
                name="order_date" data-date-format="yyyy-m-d" value="{{ old('order_date', $data->order_date) }}">
              </div>

              <div class="form-group">
                <label>Address</label>
                <input class="form-control" type="text" name="address" value="{{ old('address', $data->address) }}">
              </div>

              <div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Provinsi</label>
                      <select class="ex-custom-select2 form-control" id="province-id" name="province_id" v-model="province_id" style="width: 100%; height: 38px;">
                        <optgroup label="Provinsi">
                          <option value="{{ $data->province_id }}" selected>{{ Indonesia::findProvince($data->province_id)->name }}</option>
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
                          <option value="{{ $data->city_id }}" selected>{{ Indonesia::findCity($data->city_id)->name }}</option>
                          <option v-for="city in cities" :value="city.id">@{{ city.name }}</option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              @php 
                $check_waiting = array('waiting', 'scheduled', 'surveyed', 'deal', 'done', 'finish', 'failed');
                $check_scheduled = array('scheduled', 'surveyed', 'deal', 'done', 'finish', 'failed');
                $check_surveyed = array('surveyed', 'deal', 'done', 'finish', 'failed');
                $check_deal = array('deal', 'done', 'finish', 'failed');
                $check_done = array('done', 'finish', 'failed');
                $check_finish = array('finish', 'failed');
                $check_failed = array('failed');
              @endphp
              @if (in_array($data->process, $check_waiting))
                <div class="form-group">
                  <label>Jenis Proyek</label>
                  <input class="form-control" type="text" placeholder="contoh: Renovasi Rumah" name="kind_project" value="{{ $data->kind_project }}">
                </div>
              @endif
              @if (in_array($data->process, $check_scheduled))
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>Tanggal Survei</label>
                      <input class="date-picker form-control" type="text" data-date-format="yyyy-m-d" name="survey_date" value="{{ $data->survey_date }}">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Jam Survei</label>
                      <input class="survey_time form-control" type="text" name="survey_time" value="{{ $data->survey_time }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Surveyer</label>
                  <select class="custom-select2 form-control" id="select-worker" name="surveyer_id" style="width: 100%; height: 38px;">
                    <optgroup label="Alaskan/Hawaiian Time Zone">
                      @foreach ($workers as $worker)
                        <option {{ $data->surveyer_id == $worker->id ? 'selected' : '' }} value="{{ $worker->id }}">
                          {{ $worker->name }} | {{ Indonesia::findCity($worker->city_id)->name }}
                        </option>	
                      @endforeach
                    </optgroup>
                  </select>
                </div>
              @endif
              @if (in_array($data->process, $check_surveyed))
                <div class="form-group">
                  <label>Nilai RAB</label>
                  <input class="form-control" type="number" name="approximate_value" value="{{ $data->approximate_value }}">
                </div>
              @endif
              @if (in_array($data->process, $check_deal))
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input class="date-picker form-control" type="text" name="start_date" data-date-format="yyyy-m-d" value="{{ $data->start_date }}">
                </div>
                <div class="form-group">
                  <label>Nilai Proyek</label>
                  <input class="form-control" type="number" name="project_value" value="{{ $data->project_value }}">
                </div>
                <div class="form-group">
                  <label>Pekerja</label>
                  <select class="custom-select2 form-control" id="select-worker" name="worker_id" style="width: 100%; height: 38px;">
                    <optgroup label="Alaskan/Hawaiian Time Zone">
                      @foreach ($workers as $worker)
                        <option {{ $data->worker_id == $worker->id ? 'selected' : '' }} value="{{ $worker->id }}">
                          {{ $worker->name }} | {{ Indonesia::findCity($worker->city_id)->name }}
                        </option>	
                      @endforeach
                    </optgroup>
                  </select>
                </div>
              @endif
              @if (in_array($data->process, $check_done))
                <div class="form-group">
                  <label>Tanggal Selesai</label>
                  <input class="date-picker form-control" type="text" name="finish_date" data-date-format="yyyy-m-d" value="{{ $data->finish_date }}">
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" name="description" cols="30" rows="10">
                    {{ $data->description }}
                  </textarea>
                </div>
              @endif

              <div>
                <button class="btn btn-primary">
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
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
          this.getClientProvincesData();
        },
        data: {
          clientProvinces: null,
          clientCities: null,
          client_province_id: {{ $data->client->province_id }},
          client_city_id: {{ $data->client->city_id }},
          provinces: null,
          cities: null,
          province_id: {{ $data->province_id }},
          city_id: {{ $data->city_id }},
        },
        methods: {
          getClientProvincesData() {
            var self = this;

            axios.get('{{ url("/api/get-provinces") }}')
              .then(function (response) {
                self.clientProvinces = response.data;
                self.getClientCitiesData();
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
                self.getCitiesData();
              });
          },
          getCitiesData() {
            var self = this;

            axios.get('{{ url("/api/get-cities") }}/' + self.province_id)
              .then(function (response) {
                self.cities = response.data;
              });
          },
          // selectedProvince(province) {
          //   if (this.province_id == province) {
          //     return 'true';
          //   } else {
          //     return 'false';
          //   }
          // },
          // selectedCity(city) {
          //   if (this.city_id == city) {
          //     return 'true';
          //   } else {
          //     return 'false';
          //   }
          // },
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

		<script>
		$( ".survey_time" ).timeDropper({
			format: 'HH:mm',
		});
		</script>
@endsection