<nav class="navbar header-navbar pcoded-header">

    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <div class="mobile-search">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="index.html">
                <div style="width: 200px; height: 14px;">
                    SYSTEM SCHOOL
                </div>

               {{-- <img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="Theme-Logo" />  --}}
            </a>
            <a class="mobile-options">php
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                        <form>

                            <div class="input-group">
                                <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                <input type="search" name="search" class="form-control">
                                <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                            </div>

                        </form>
                    </div>
                </li>
                
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
            <!-- Language Selector start-->
                <li class=" mt-1">
                    @php
                        $locale = session('locale', 'en');
                        $flags = [
                            'en' => 'us.png',
                            'km' => 'kh.png',
                        ];

                        $names = [
                            'en' => 'English',
                            'km' => 'ភាសាខ្មែរ',
                        ];

                        // Toggle to the other language
                        $nextLocale = $locale === 'en' ? 'km' : 'en';
                    @endphp

                    <a href="{{ route('lang.change') }}?lang={{ $nextLocale }}"
                    class="d-flex align-items-center rounded text-decoration-none mt-1"
                    style="color: black; width:100px; height:40px; background:white">
                        <img src="{{ asset('flag/' . $flags[$locale]) }}" width="20" class="mr-1" alt="flag">
                        <span>{{ $names[$locale] }}</span>
                    </a>
                </li>
              <!-- Language Selector end-->




              <li class="header-notification">
                    <a href="#!">
                        <i class="ti-bell"></i>
                        <span class="badge bg-c-pink"></span>
                    </a>
                    <ul class="show-notification">
                        <li>
                            <h6>Notifications</h6>
                            <label class="label label-danger">New</label>
                        </li>
                        <!-- Notifications will be dynamically appended here -->
                      
                    </ul>
                </li>

                  
            

                
                <li class="user-profile header-notification">



                   <a href="#!" style="width: 50px; height:50px">
                        <img style="border-radius: 50%; width:50px; height:50px" src="{{ asset('assets/images/64969.png') }}" alt="User Image" >
                        <i class="ti-angle-down ms-2"></i>
                    </a>




                    <ul class="show-notification profile-notification">
                        <li>
                            <a href="#!">
                                <i class="ti-settings"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="user-profile.html">
                                <i class="ti-user"></i> Profile
                            </a>
                        </li>

                        <li>
                            <a href="auth-lock-screen.html">
                                <i class="ti-lock"></i> Lock Screen
                            </a>
                        </li>
                        <li>
                          
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: red">
                                <i class="ti-layout-sidebar-left text-danger"></i> Logout
                            </a>

                        </li>
                    </ul>

                    <!-- Right: Language Switcher -->
                
                </li>
                
            </ul>

            
        </div>
    </div>
 </nav>
