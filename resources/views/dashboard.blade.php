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


  <!-- Bar Chart -->
    <div class="col-9">
        <div class="card-body">
            <canvas id="enrollmentChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-3">
        <div class="card-body">
            <canvas id="courseChart"></canvas>
        </div>
    </div>
 <!-- statustic and process end -->

      </div>
  </div>

  <div id="styleSelector">

  </div>
@endsection


@section('script')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentLocale = @json($locale);

    // Set font family based on language
    const fontFamily = currentLocale === 'km' ? 'Battambang' : 'system-ui';

    // BAR CHART
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [
                {
                    label: "{{ __('messages.daily') }}",
                    backgroundColor: '#3b82f6',
                    data: {!! json_encode($dailyData) !!}
                },
                {
                    label: "{{ __('messages.monthly') }}",
                    backgroundColor: '#10b981',
                    data: {!! json_encode($monthlyData) !!}
                },
                {
                    label: "{{ __('messages.yearly') }}",
                    backgroundColor: '#f59e0b',
                    data: {!! json_encode($yearlyData) !!}
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: fontFamily,
                            size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: "{{ __('messages.enrollment_statistics') }}",
                    font: {
                        family: fontFamily,
                        size: 18
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: { family: fontFamily }
                    }
                },
                y: {
                    ticks: {
                        font: { family: fontFamily }
                    }
                }
            }
        }
    });

    // PIE CHART
    const ctx2 = document.getElementById('courseChart').getContext('2d');
    const courseChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: {!! json_encode($courseLabels) !!},
            datasets: [{
                data: {!! json_encode($courseData) !!},
                backgroundColor: [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: fontFamily,
                            size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: "{{ __('messages.enrollments_per_course') }}",
                    font: {
                        family: fontFamily,
                        size: 18
                    }
                }
            }
        }
    });
});
</script>
@endsection

