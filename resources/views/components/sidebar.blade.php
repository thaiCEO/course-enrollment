<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="{{ route('dashboard.index') }}">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.dashboard') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.system_school') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.table') }}</div>

        {{-- Student Table start --}}
        <ul class="pcoded-item pcoded-left-item">

            <!-- teacher start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.teacher_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('teacher.list') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.teacher_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('teacher.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.teacher_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- teacher end -->

            
            <!-- student start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.student_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('student.list') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.student_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.student_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- student end -->

            <!-- course start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.course_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('courses.List') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.course_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('course.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.course_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- course end -->

          
            <!-- enrollment start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.enrollment_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('enrollments.List') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.enrollment_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('enrollments.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.enrollment_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- enrollment end -->
        </ul>
        {{-- Student Table end --}}

         <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.payment') }}</div>



        {{-- Student Table start --}}
        <ul class="pcoded-item pcoded-left-item">

           <!-- payment start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.payment_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('payment.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.payment_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('payment.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.payment_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
              <!-- payment end -->








      <!-- payment method start -->
       <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.paymentmethod.bank') }}</div>


        <ul class="pcoded-item pcoded-left-item">

 
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.paymentmethod.table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('payment-method.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.paymentmethod.list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('payment-method.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.paymentmethod.create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
              <!-- payment method end -->



        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.address') }}</div>

           <!-- adddress start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.studentaddress_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>

                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('addresses.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.studentaddress_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('addresses.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" style="font-weight: bold;">{{ __('messages.sidebar.studentaddress_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
              <!-- address end -->
        <ul>
          
         
        </div>
</nav>
