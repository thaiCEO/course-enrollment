<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RegisterRoleAdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyTimeController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserAddressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login.show');
});



       //login 
        Route::get('/login', [AdminController::class, 'showLogin'])->name('login.show');
        Route::post('/login/proccess', [AdminController::class, 'loginProccess'])->name('login.proccess');


        
Route::prefix('admin')->middleware(['auth:admin' , 'Is_Admin'])->group(function() {

        //dashboard
        Route::get('/dashboard' , [dashboardController::class , 'view_dashboard'])->name('dashboard.index');
        Route::get('lang/change', [dashboardController::class, 'change'])->name('lang.change');

        //student
        Route::get('/students', [StudentController::class, 'index'])->name('student.list');
        Route::get('/create_student', [StudentController::class, 'create'])->name('student.create');
        Route::post('/create_student', [StudentController::class, 'store'])->name('student.store');
        Route::get('/students/show/{id}', [StudentController::class, 'showStudent'])->name('student.show');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('student.delete');
        Route::post('/students/deleteSeleted', [StudentController::class, 'deleteWithSelect'])->name('student.deleteSeletedStudent');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('/students/update/{id}', [StudentController::class, 'update'])->name('student.update');

        //get by relationship
        Route::post('/students/data', [StudentController::class, 'getData'])->name('student.data');


        //course
        Route::get('/course', [CourseController::class, 'List'])->name('courses.List');       // Show all courses
        Route::get('/course/create', [CourseController::class, 'create'])->name('course.create'); // Show form to add course
        Route::post('/course', [CourseController::class, 'store'])->name('course.store');         // Save new course
        Route::get('/course/{course}/show', [CourseController::class, 'show'])->name('course.show');  // Show form to edit course
        Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('course.destroy'); // Delete course
        Route::get('/course/{course}/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::put('/course/{course}', [CourseController::class, 'update'])->name('course.update');
        Route::post('/courses/deleteSelected', [CourseController::class, 'deleteWithSelect'])->name('course.deleteSelectedCourse');


        //enrollments
        Route::get('/enrollment', [EnrollmentsController::class, 'List'])->name('enrollments.List');
        Route::get('/enrollment/create', [EnrollmentsController::class, 'create'])->name('enrollments.create');
        Route::get('/{id}', [EnrollmentsController::class, 'show'])->name('enrollments.show');
        Route::post('/enrollment', [EnrollmentsController::class, 'store'])->name('enrollments.store');
        Route::get('/enrollment/{id}/edit', [EnrollmentsController::class, 'edit'])->name('enrollments.edit');
        Route::put('/enrollment/{id}', [EnrollmentsController::class, 'update'])->name('enrollments.update');
        Route::delete('/enrollment/{id}', [EnrollmentsController::class, 'destroy'])->name('enrollments.destroy');
        Route::post('/enrollments/deleteSelected', [EnrollmentsController::class, 'deleteWithSelect'])->name('enrollments.deleteSelectedEnrollment');

         //teacher
        Route::get('/teachers/test', [TeacherController::class, 'test'])->name('teacher.test');
        Route::get('/teachers/list', [TeacherController::class, 'index'])->name('teacher.list');
        Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
        Route::post('/teacher/create', [TeacherController::class, 'store'])->name('teacher.store');
        // Route::get('/teachers/show/{id}', [TeacherController::class, 'showStudent'])->name('teacher.show');
        Route::get('/teacher/{teacher}/show', [TeacherController::class, 'show'])->name('teacher.show');
        Route::delete('/teacher/{teacher}/delete', [TeacherController::class, 'destroy'])->name('teacher.delete');
        Route::post('/teachers/deleteSelected', [TeacherController::class, 'deleteWithSelect'])->name('teacher.deleteSelectedTeacher');
        Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
        Route::post('/teachers/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');


        // UserAddress 
        Route::prefix('addresses')->group(function () {
        Route::get('/list', [AddressController::class, 'index'])->name('addresses.index');
        Route::get('/address/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/address/store', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/address/{id}', [AddressController::class, 'show'])->name('addresses.show');
        Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::post('/address/{id}/update', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/address/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::post('/address/delete-selected', [AddressController::class, 'deleteSelected'])->name('addresses.deleteSelected');
        });

        // route for payments
        Route::prefix('payment')->group(function () {
        Route::get('/list', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/payment-create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/payment-store', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/payment/{id}/show', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/payment/{id}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/payment/{id}/update', [PaymentController::class, 'update'])->name('payment.update');
        Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');
        });


        // route for payment_method
        Route::prefix('payment-methods')->group(function () {
        Route::get('/list', [PaymentMethodController::class, 'index'])->name('payment-method.index');
        Route::get('/payment-method-create', [PaymentMethodController::class, 'create'])->name('payment-method.create');
        Route::post('/payment-method-store', [PaymentMethodController::class, 'store'])->name('payment-method.store');
        Route::get('/payment-method/{id}', [PaymentMethodController::class, 'show'])->name('payment-method.show');
        Route::get('/payment-method/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment-method.edit');
        Route::post('/payment-method/{id}/update', [PaymentMethodController::class, 'update'])->name('payment-method.update');
        Route::delete('/payment-method/{id}', [PaymentMethodController::class, 'destroy'])->name('payment-method.destroy');
        Route::post('/payment-method/delete-selected', [PaymentMethodController::class, 'deleteSelected'])->name('payment-method.deleteSelected');
        });

        
       // Route group for Role Permission (only admin can access)
      Route::middleware(['auth:admin', 'role:Admin'])->prefix('roles')->group(function () {
        Route::get('/list', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/role-create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/role-store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/role/{id}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/role/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::post('/roles/delete-selected', [RoleController::class, 'deleteSelected'])->name('roles.deleteSelectedRole');

        });


      // Route group for Admin Role (only admin can access)
      Route::middleware(['auth:admin', 'role:Admin'])->prefix('admin-role')->group(function () {
        Route::get('/list', [RegisterRoleAdminController::class, 'index'])->name('admin-role.index');
        Route::get('/admin-role-create', [RegisterRoleAdminController::class, 'create'])->name('admin-role.create');
        Route::post('/admin-role-store', [RegisterRoleAdminController::class, 'store'])->name('admin-role.store');
        Route::get('/admin-role/{id}', [RegisterRoleAdminController::class, 'show'])->name('admin-role.show');
        Route::get('/admin-role/{id}/edit', [RegisterRoleAdminController::class, 'edit'])->name('admin-role.edit');
        Route::put('/admin-role/{id}', [RegisterRoleAdminController::class, 'update'])->name('admin-role.update');
        Route::delete('/admin-role/{id}', [RegisterRoleAdminController::class, 'destroy'])->name('admin-role.destroy');
        Route::post('/admin-role/delete-selected', [RegisterRoleAdminController::class, 'deleteSelected'])->name('admin-role.deleteSelectedRole');
      });


       // route for room
       Route::prefix('room')->group(function () {
        Route::get('/list', [RoomController::class, 'index'])->name('room.index');
        Route::get('/room-create', [RoomController::class, 'create'])->name('room.create');
        Route::post('/room-store', [RoomController::class, 'store'])->name('room.store');
        Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');
        Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
        Route::post('/room/{id}/update', [RoomController::class, 'update'])->name('room.update');
        Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('room.destroy');
        Route::post('/room/delete-selected', [RoomController::class, 'deleteSelected'])->name('room.deleteSelected');
       });

       
        // route for study time
       Route::prefix('study-time')->group(function () {
           Route::get('/list', [StudyTimeController::class, 'index'])->name('study-time.index');
           Route::get('/study-time-create', [StudyTimeController::class, 'create'])->name('study-time.create');
           Route::post('/study-time-store', [StudyTimeController::class, 'store'])->name('study-time.store');
           Route::get('/study-time/{id}', [StudyTimeController::class, 'show'])->name('study-time.show');
           Route::get('/study-time/{id}/edit', [StudyTimeController::class, 'edit'])->name('study-time.edit');
           Route::put('/study-time/{id}/update', [StudyTimeController::class, 'update'])->name('study-time.update');
           Route::delete('/study-time/{id}', [StudyTimeController::class, 'destroy'])->name('study-time.destroy');
           Route::post('/study-time/delete-selected', [StudyTimeController::class, 'deleteSelected'])->name('study-time.deleteSelected');
       });


       
       

        Route::post('/logout', function () {
                Auth::guard('admin')->logout();
                return redirect()->route('login.show')->with('success', 'Logged out successfully');
        })->name('admin.logout');
        
});



require __DIR__.'/auth.php';
