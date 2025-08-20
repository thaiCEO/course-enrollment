<style>
    /* Sidebar font styles */
    .pcoded-mtext {
        font-weight: bold;       /* Bold text */
        font-size: 15px;         /* Main menu font size bigger */
    }

    .pcoded-submenu .pcoded-mtext {
        font-weight: bold;       /* Bold submenu */
        font-size: 14px;         /* Submenu font slightly smaller */
    }
</style>

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="{{ route('dashboard.index') }}">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.dashboard') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-settings"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.system_school') }}</span>
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
                    <span class="pcoded-micon"><i class="ti-user"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.teacher_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('teacher.list') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.teacher_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('teacher.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.teacher_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- teacher end -->

            <!-- student start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.student_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('student.list') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.student_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.student_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- student end -->

            <!-- course start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-book"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.course_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('courses.List') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.course_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('course.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.course_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- course end -->

            <!-- enrollment start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-agenda"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.enrollment_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('enrollments.List') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.enrollment_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('enrollments.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.enrollment_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- enrollment end -->


            <!-- room start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.room_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('room.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.room_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('room.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.room_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- room end -->


            <!-- study time start -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-timer"></i></span> <!-- Changed main icon -->
                    <span class="pcoded-mtext">{{ __('messages.sidebar.study_time_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('study-time.index') }}">
                            <span class="pcoded-micon"><i class="ti-menu"></i></span> <!-- List icon -->
                            <span class="pcoded-mtext">{{ __('messages.sidebar.study_time_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('study-time.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus-alt"></i></span> <!-- Add icon -->
                            <span class="pcoded-mtext">{{ __('messages.sidebar.study_time_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- study time end -->


        </ul>
        {{-- Student Table end --}}

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.payment') }}</div>

        {{-- payment start --}}
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-wallet"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.payment_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('payment.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.payment_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.payment_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- payment end -->

        <!-- payment method start -->
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.paymentmethod.bank') }}</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-credit-card"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.paymentmethod.table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('payment-method.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.paymentmethod.list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment-method.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.paymentmethod.create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- payment method end -->

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.address') }}</div>
        <!-- address start -->
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-map"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.studentaddress_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('addresses.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.studentaddress_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('addresses.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.studentaddress_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- address end -->

        @role('Admin')
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('messages.sidebar.role_permission_table') }}</div>

        <!-- Admin role -->
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-shield"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.admin_role_table') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('admin-role.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.admin_role_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin-role.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.admin_role_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Role Permission -->
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-lock"></i></span>
                    <span class="pcoded-mtext">{{ __('messages.sidebar.role_permission') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li>
                        <a href="{{ route('roles.index') }}">
                            <span class="pcoded-micon"><i class="ti-list"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.role_permission_list') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles.create') }}">
                            <span class="pcoded-micon"><i class="ti-plus"></i></span>
                            <span class="pcoded-mtext">{{ __('messages.sidebar.role_permission_create') }}</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @endrole

    </div>
</nav>
