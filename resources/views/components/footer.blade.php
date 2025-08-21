<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="{{asset('assets/js/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/popper.js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset('assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{asset('assets/js/modernizr/modernizr.js')}}"></script>
<!-- am chart -->
<script src="{{asset('assets/pages/widget/amchart/amcharts.min.js')}}"></script>
<script src="{{asset('assets/pages/widget/amchart/serial.min.js')}}"></script>
<!-- Chart js -->
<script type="text/javascript" src="{{asset('assets/js/chart.js/Chart.js')}}"></script>
<!-- Todo js -->
<script type="text/javascript " src="{{asset('assets/pages/todo/todo.js')}} "></script>
<!-- Custom js -->
<script type="text/javascript" src="{{asset('assets/pages/dashboard/custom-dashboard.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/script.js')}}"></script>
<script type="text/javascript " src="{{asset('assets/js/SmoothScroll.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>
<script src="{{asset('assets/js/vartical-demo.js')}}"></script>
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!-- lin CDN jquery  -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
<!-- link sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- link js CDN Boostrap5.3 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- link icon Boostrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.1/html5-qrcode.min.js"></script>
<!-- link chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


        $('#lang').on('change', function () {
            const selectedLang = $(this).val();
            window.location.href = '{{ route("lang.change") }}?lang=' + selectedLang;
        });
</script>


@yield('script')

</body>

</html>
