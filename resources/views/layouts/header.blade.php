<div class="header">
  <div class="header-left">
    {{-- <div class="menu-icon dw dw-menu"></div>
    <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
    <div class="header-search">
      <form>
        <div class="form-group mb-0">
          <i class="dw dw-search2 search-icon"></i>
          <input type="text" class="form-control search-input" placeholder="Search Here">
          <div class="dropdown">
            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
              <i class="ion-arrow-down-c"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">From</label>
                <div class="col-sm-12 col-md-10">
                  <input class="form-control form-control-sm form-control-line" type="text">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">To</label>
                <div class="col-sm-12 col-md-10">
                  <input class="form-control form-control-sm form-control-line" type="text">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                <div class="col-sm-12 col-md-10">
                  <input class="form-control form-control-sm form-control-line" type="text">
                </div>
              </div>
              <div class="text-right">
                <button class="btn btn-primary">Search</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div> --}}
  </div>
  <div class="header-right">
    <div class="dashboard-setting user-notification">
      <div class="dropdown">
        <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
          <i class="dw dw-settings2"></i>
        </a>
      </div>
    </div>
    <div class="user-notification" x-data="notif()" x-init="init()">
      <div class="dropdown">
        <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
          <i class="icon-copy dw dw-notification"></i>
          <template x-if="notifications.length > 0">
            <span class="badge notification-active"></span>
          </template>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="notification-list mx-h-350 customscroll">
            <ul>
              
              <template x-if="notifications.length < 1">
                <li>
                  Tidak Ada Notifikasi
                </li>
              </template>

              {{-- <template x-for="(n,i) in notifs" :key="i">
                <li>
                  <a href="#">
                    <img src="{{ asset('deskapp/vendors/images/img.jpg') }}" alt="">
                    <h3>Vicki M. Coleman</h3>
                    <p x-text="n"></p>
                  </a>
                </li>
              </template> --}}
                <template x-for="ns in notifications" :key="ns.id">
                  <li>
                    <div class="d-flex pr-3">
                      <div>
                        <a href="">
                          <img src="{{ asset('image/tukangqu-logo.jpg') }}" alt="">
                          <h3 x-text="ns.title"></h3>
                          <p x-text="ns.message"></p>
                        </a>
                      </div>
                      <div>
                        <a href="#" @click.prevent="deleteNotification(ns.id)"><i class="icon-copy fa fa-close font-16" aria-hidden="true"></i></a>
                      </div>
                    </div>
                  </li>
                </template>
                <template x-if="notifications.length > 0">
                  <li class="text-center pt-3">
                    <h6 @click.prevent="deleteAllNotifications()" class="btn">Hapus semua notifikasi</h6>
                  </li>
                </template>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="user-info-dropdown mr-5">
      <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
          <span class="user-icon">
            <img src="{{ asset('deskapp/vendors/images/photo1.jpg') }}" alt="">
          </span>
          <span class="user-name">{{ auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
          {{-- <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Profile</a> --}}
          {{-- <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a> --}}
          {{-- <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> --}}
          {{-- <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="dw dw-logout"></i> Log Out</a> --}}
          <form action="{{ route('admin.logout') }}" method="post" class="d-block ">
              @csrf
              <button class="dropdown-item btn w-100" >
                <i class="dw dw-logout"></i> Log Out</a>
              </button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function notif() {
    return {
      notifs: [],
      notifications: [],

      init() {
        const self = this
        window.addEventListener('notif', function (e) {
          console.log('event success')

          let notificationData = {
            'title' : e.detail.title,
            'message' : e.detail.message,
          }

            self.getNotification();

          // axios.post('{{ url("/api/store-notification") }}', notificationData)
          // .then(function(){
          //   self.getNotification();
          //   console.log('post data success');
          // });

          // self.notifs.push(e.detail.title)
          
          let notification = new Notification('TukangQu', {
            body: e.detail.title, // content for the alert
            icon: "{{ asset('image/tukangqu-logo.jpg') }}" // optional image url
          });

          // link to page on clicking the notification
          notification.onclick = () => {
            window.open(window.location.href);
          };
        })

        self.getNotification();
      },

      getNotification() {
        var self = this
        axios.get("/api/get-notification")
        .then(function(response) {
          self.notifications = response.data;
        });
        console.log('get data success');
      },

      deleteNotification(id) {
        var self = this
        axios.get('{{ url("/api/delete-notification") }}/'+id)
        .then(function(response) {
          self.getNotification();
        });
      },

      deleteAllNotifications() {
        var self = this
        axios.get("/api/delete-all-notification")
        .then(function(response) {
          self.getNotification();
        });
      },

    }
  }

</script>