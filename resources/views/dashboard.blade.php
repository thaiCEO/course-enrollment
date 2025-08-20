@extends('components.master')
@section('content')


@if(Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Success!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif


@if(Session::has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Error!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif


<div class="page-body">
    <div class="row">

 <!-- Order Cards Start -->

<!-- Teacher Card -->
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-blue order-card">
        <div class="card-block">
            <h4 class="m-b-20">{{ __('messages.totalTeachers') }}</h4>
            <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $teacher }}</span></h2>
        </div>
    </div>
</div>

<!-- Student Card -->
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-pink order-card">
        <div class="card-block">
            <h4 class="m-b-20">{{ __('messages.totalStudents') }}</h4>
            <h2 class="text-right"><i class="ti-id-badge f-left"></i><span>{{ $studentTotal }}</span></h2>
        </div>
    </div>
</div>

<!-- Course Card -->
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-green order-card">
        <div class="card-block">
            <h4 class="m-b-20">{{ __('messages.totalCourses') }}</h4>
            <h2 class="text-right"><i class="ti-book f-left"></i><span>{{ $course }}</span></h2>
        </div>
    </div>
</div>

<!-- Revenue Card -->
<div class="col-md-6 col-xl-3">
    <div class="card bg-c-yellow order-card">
        <div class="card-block">
            <h4 class="m-b-20">{{ __('messages.totalRevenue') }}</h4>
            <h2 class="text-right"><i class="ti-wallet f-left"></i><span>${{ number_format($revenue, 2) }}</span></h2>
        </div>
    </div>
</div>


<!-- Order Cards End -->


          <!-- statustic and process start -->
          <div class="col-lg-8 col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h5>{{ __('messages.statistics') }}</h5>
                      <div class="card-header-right">
                          <ul class="list-unstyled card-option">
                              <li><i class="fa fa-chevron-left"></i></li>
                              <li><i class="fa fa-window-maximize full-card"></i></li>
                              <li><i class="fa fa-minus minimize-card"></i></li>
                              <li><i class="fa fa-refresh reload-card"></i></li>
                              <li><i class="fa fa-times close-card"></i></li>
                          </ul>
                      </div>
                  </div>
                  <div class="card-block">
                      <canvas id="Statistics-chart" height="450"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-4 col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h5>{{ __('messages.feedback') }}</h5>
                  </div>
                  <div class="card-block">
                      <span class="d-block text-c-blue f-24 f-w-600 text-center">2000</span>
                      <canvas id="feedback-chart" height="247"></canvas>
                      <div class="row justify-content-center m-t-15">
                          <div class="col-auto b-r-default m-t-5 m-b-5">
                              <h4>83%</h4>
                              <p class="text-success m-b-0"><i class="ti-hand-point-up m-r-5"></i>{{ __('messages.positive') }}</p>
                          </div>
                          <div class="col-auto m-t-5 m-b-5">
                              <h4>17%</h4>
                              <p class="text-danger m-b-0"><i class="ti-hand-point-down m-r-5"></i>{{ __('messages.negative') }}</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- statustic and process end -->

     

      </div>
  </div>

  <div id="styleSelector">

  </div>
@endsection


