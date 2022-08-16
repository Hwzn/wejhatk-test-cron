<!--=================================
header start-->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- logo -->
    <div class="text-left navbar-brand-wrapper">
    @if(auth('admin')->check())
      <center>
        <a class="navbar-brand brand-logo" href="{{ url('/admin/dashboard') }}"><img src="{{ URL::asset('assets/images/logo-dark.jpg') }}" width="100%" height="100%" alt=""></a>
        </center>

     @endif
    </div>
    <!-- Top bar left -->
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item">
            <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
        </li>
       
    </ul>
    <!-- top bar right -->
    <ul class="nav navbar-nav ml-auto">

        <div class="btn-group mb-1">
            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if (App::getLocale() == 'ar')
              {{ LaravelLocalization::getCurrentLocaleName() }}
             <img src="{{ URL::asset('assets/images/flags/EG.png') }}" alt="">
              @else
              {{ LaravelLocalization::getCurrentLocaleName() }}
              <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">
              @endif
              </button>
            <div class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                @endforeach
            </div>
        </div>

       
    
        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ URL::asset('assets/images/user_icon.png') }}" alt="avatar">
                

            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            {{Auth::user()->name}}
                            <br/>
                            {{Auth::user()->email}}
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @if(auth('admin')->check())
                <a class="dropdown-item" href="{{route('showprofile')}}"><i class="text-info ti-settings"></i>Settings</a>
                @endif
                @if(auth('web')->check())
                    <form method="GET" action="{{ route('logout','web') }}">
                        @else(auth('admin')->check())
                            <form method="GET" action="{{ route('logout','admin') }}">
                                                @endif

                                                @csrf
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault();this.closest('form').submit();"><i class="bx bx-log-out"></i>تسجيل الخروج</a>
                                            </form>

            </div>
        </li>
    </ul>
</nav>

<!--=================================
header End-->
