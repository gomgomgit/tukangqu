@extends('layouts.app')

@section('main-content')
	<div class="card-box mb-30"> 

			<!-- Striped table start -->
			<div class="pd-20 card-box">
				<div>
					<h4 class="text-black h3">Edit Project</h4>
        </div>
        
        <form action="{{ route('admin.projects.update', [$data->id, 'harian']) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Nama Klien</label>
            <input class="form-control" type="text" name="name" value="{{ old('name', $data->client->name) }}">
          </div>
          <div class="form-group">
            <label>Tanggal Order</label>
            {{-- <input class="form-control" type="date" name="order_date" value="{{ old('order_date') }}"> --}}
            <input class="form-control date-picker" placeholder="Select Date" type="text" 
            name="order_date" data-date-format="yyyy-m-d" value="{{ old('order_date', $data->order_date) }}">
          </div>
          <div class="form-group">
            <label>No Hp / WhatsApp</label>
            <input class="form-control" type="text" name="phone_number" value="{{ old('phone_number', $data->client->phone_number) }}">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input class="form-control" type="text" name="address" value="{{ old('address', $data->address) }}">
          </div>

          <div id="locations">
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
            $check_waiting = array('waiting', 'priced', 'deal', 'finish', 'failed');
            $check_priced = array('priced', 'deal', 'finish', 'failed');
            $check_deal = array('deal', 'finish', 'failed');
            $check_finish = array('finish', 'failed');
            $check_failed = array('failed');
          @endphp
          @if (in_array($data->process, $check_waiting))
            <div class="form-group">
              <label>Jenis Proyek</label>
              <input class="form-control" type="text" placeholder="contoh: Renovasi Rumah" name="kind_project" value="{{ $data->kind_project }}">
            </div>
          @endif
          @if (in_array($data->process, $check_priced))
            <div class="form-group">
              <label>Nilai Harian</label>
              <input class="form-control" type="number" name="daily_value" value="{{ $data->daily_value }}">
            </div>
          @endif
          @if (in_array($data->process, $check_deal))
            <div class="form-group">
              <label>Tanggal Mulai</label>
              <input class="form-control" type="date" name="start_date" value="{{ $data->start_date }}">
            </div>
            <div class="form-group">
              <label>Gaji Harian</label>
              <input class="form-control" type="number" name="daily_salary" value="{{ $data->daily_salary }}">
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
          @if (in_array($data->process, $check_finish))
            <div class="form-group">
              <label>Tanggal Selesai</label>
              <input class="form-control" type="date" name="finish_date" value="{{ $data->finish_date }}">
            </div>
          @endif
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
        },
        data: {
          provinces: null,
          cities: null,
          province_id: {{ $data->province_id }},
          city_id: {{ $data->city_id }},
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