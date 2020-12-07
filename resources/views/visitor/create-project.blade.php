<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('deskapp/vendors/images/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('deskapp/vendors/images/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('deskapp/vendors/images/favicon-16x16.png') }}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/style.css') }}">

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
  
	<div class="p-5"> 

			<!-- Striped table start -->
			<div class="p-5 w-75 m-auto mb-5 pd-20 card-box">

        <div class="text-center">
          <h4 class="text-blue h1">Form Request Project</h4>
          <p class="mb-30">Lengkapilah form dibawah ini</p>
        </div>
        
        <form action="{{ route('createProjectProcess') }}" method="POST">
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
<!-- js -->
	<script src="{{ asset('deskapp/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/layout-settings.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('deskapp/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script> 
  
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

</body>
</html>