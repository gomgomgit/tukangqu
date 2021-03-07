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

  <style>
    .placeholder-self-photo {
      background-image: url('https://www.kemenkumham.go.id/images/foto/2019/1_Januari_2019/ektp1.JPG') !important;
      background-size: cover;
      background-position: center;
      width: 100%;
      height: 200px;
    }
    .placeholder-id-photo {
      background-image: url('https://i2.wp.com/help.tokotalk.com/wp-content/uploads/2020/08/identity_card_example.b686f703.jpg?resize=643%2C417&ssl=1') !important;
      background-size: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="pd-20 card-box mb-30 m-auto mb-5 p-5">
      <div class="clearfix">
        <div class="text-center">
          <h4 class="text-blue h1">Form Pendaftaran Tukang</h4>
          <p class="mb-30">Lengkapilah form berikut dengan data yang sesuai</p>
        </div>
      </div>
      @if ($errors->any())
        <div class="mb-3">
          <ul class="p-3 bg-danger">
            @foreach ($errors->all() as $error)
              @if ( $error == 'The phone number has already been taken.' )
                @push('custom-script')
                  <script>
                    swal(
                        {
                            type: 'error',
                            title: 'Oops...',
                            text: 'Nomor anda telah terdaftar!',
                        }
                    )
                  </script>
                @endpush
              @endif
              <li class="text-white">{{ $error }}</li>
            @endforeach
          </ul>
        </div>  
      @endif
      <form action="{{ Route('workerRegisterProcess') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="text-center">
          <h2 class="h3 d-inline-block mb-4">Data Diri</h2>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input class="form-control" type="text" name="name" value="{{ old('name') }}">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tempat Tanggal Lahir</label>
              <input class="form-control" placeholder="Tempat Lahir" type="text" name="birth_place" value="{{ old('birth_place') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label></label>
              <input class="form-control ex-date-picker" placeholder="Tanggal Lahir" type="date" name="birth_date" value="{{ old('birth_date') }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Email</label>
              <input class="form-control" value="email@example.com" type="email" name="email" value="{{ old('email') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>No Hp/WhatsApp</label>
              <input class="form-control" type="number" name="phone_number" value="{{ old('phone_number') }}">
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
              <input class="form-control" type="text" name="address" value="{{ old('address') }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>RT</label>
              <input class="form-control" type="number" name="rt" value="{{ old('rt') }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>RW</label>
              <input class="form-control" type="number" name="rw" value="{{ old('rw') }}">
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
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kelurahan</label>
                <select class="ex-custom-select2 form-control" id="district-id" name="district_id" v-model="district_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kelurahan">
                    <option v-for="district in districts" :value="district.id">@{{ district.name }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kecamatan / Desa</label>
                <select class="ex-custom-select2 form-control" id="village-id" name="village_id" v-model="village_id" style="width: 100%; height: 38px;">
                  <optgroup label="Kecamatan / Desa">
                    <option v-for="village in villages" :value="village.id">@{{ village.name }}</option>
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
                      <option value="{{ $kind->id }}" {{ old('worker_kind_id') == $kind->id ? 'selected' : '' }}>{{ $kind->name }}</option>
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
                      <option value="{{ $specialist->id }}" {{ old('specialist_id') == $specialist->id ? 'selected' : '' }}>{{ $specialist->name }}</option>
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
                    @if(is_array(old('skill_id')) && in_array($skill->id, old('skill_id'))) checked @endif>
                  <label class="custom-control-label" for="customCheck{{ $skill->id }}">{{ $skill->name }}</label>
                </div>
              </div> 
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <label>Pengalaman Kerja</label>
          <input type="text" class="form-control" placeholder="contoh: 2 Tahun" name="experience" value="{{ old('experience') }}">
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
                <div class="fileinput fileinput-new w-100" data-provides="fileinput">
                  <div class="row">
                    <div class="fileinput-new img-thumbnail placeholder-self-photo col-xs-12 col-6" style="height: 400px;">
                      <img data-src="holder.js/100%x100%"  alt="Foto selfie dengan KTP" class="font-weight-bold text-white">
                    </div>
                  </div>
                  <div class="fileinput-preview fileinput-exists img-thumbnail"
                    style=" max-width: 200px; max-height: 150px;"></div>
                  <div>
                    <span class="btn btn-outline-secondary btn-file">
                      <span class="fileinput-new">Pilih Foto</span>
                      <span class="fileinput-exists">Ganti Foto</span>
                      <input type="file" name="self_photo" accept="image/*"></span>
                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Upload Foto KTP</label>
              <p class="small">Foto yang menampilkan KTP keseluruhan</p>
              <div>
                <div class="fileinput fileinput-new w-100" data-provides="fileinput">
                  <div class="fileinput-new img-thumbnail placeholder-id-photo" style="width: 100%; height: 300px;">
                    <img data-src="holder.js/100%x100%"  alt="Foto KTP" class="text-white font-weight-bold">
                  </div>
                  <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                  <div>
                    <span class="btn btn-outline-secondary btn-file">
                      <span class="fileinput-new">Pilih Foto</span>
                      <span class="fileinput-exists">Ganti Foto</span>
                      <input type="file" name="id_card_photo" accept="image/*"></span>
                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr>

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
  
  <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <!-- add sweet alert js & css in footer -->
  <script src="{{ asset('deskapp/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
  <script src="{{ asset('deskapp/src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>
  <script>
    $('.fileinput').fileinput()
    </script>
    @stack('custom-script')
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

</body>
</html>