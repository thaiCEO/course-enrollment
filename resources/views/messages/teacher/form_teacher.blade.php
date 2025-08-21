@extends('components.master')
@section('content')


    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">{{ __('messages.teacherCreate.mainTitle') }}</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                </li>
               <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.teacherCreate.mainTitleDashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!"></a>
                        </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('teacher.store') }}" method="POST" id="Form_addTeacher" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.teacherCreate.name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="{{ __('messages.teacherCreate.name_placeholder') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.teacherCreate.email') }}</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="{{ __('messages.teacherCreate.email_placeholder') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('messages.teacherCreate.phone') }}</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ __('messages.teacherCreate.phone_placeholder') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="specialization" class="form-label">{{ __('messages.teacherCreate.specialization') }}</label>
                    <input type="text" name="specialization" class="form-control" id="specialization" placeholder="{{ __('messages.teacherCreate.specialization_placeholder') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">{{ __('messages.teacherCreate.profile_image') }}</label>
                    <input type="file" name="profile_image" class="form-control" id="profile_image">
                </div>

                <button type="submit" class="btn btn-primary">{{ __('messages.teacherCreate.submit') }}</button>
               
                 <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.teacherCreate.back') }}</a>
 
            </form>
        </div>
    </div>
</div>

@endsection
