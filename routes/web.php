<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckINController;
use App\Http\Controllers\RH;
use App\Http\Controllers\Employe;
use App\Http\Controllers\Manager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login and Logout Routes --------------------------------------------------------------------------

Route::get('/login',function(){
    return view('auth.login');
})->name('login');

Route::post('/LoginHandler',[CheckINController::class,"login"])->name('loginhandler');

Route::match(['get', 'post'], '/logout', [CheckINController::class, 'logout'])->name('logout');

Route::get('/forgotpass',[CheckINController::class,'forgotpass'])->name('matricule');

Route::post('/handlerforgotmatricule', [CheckINController::class, 'handlerforgotmatricule'])->name('handler.forgot.matricule');

Route::post('/handlerforgotpass/{id}', [CheckINController::class, 'handlerforgotpass'])->name('forgotpass.handler');

Route::get('/handlerforgotpass/{id}', [CheckINController::class, 'showUpdatePassForm'])->name('forgotpass.form');

// RH Routes ----------------------------------------------------

Route::middleware(['rh.auth'])->group(function () {

    Route::get('/RHdashboard',[RH::class,'dashboard']);

    Route::get('/RHallemp',[RH::class,'allemployees'])->name('RHallemp');

    Route::get('/RHsearchEmployees', [RH::class, 'searchEmployees'])->name('RHsearchEmployees');

    Route::get('/RHprofile',[RH::class,'profile']);

    Route::get('/viewprofile/{id}',[RH::class,'viewprofile'])->name('viewprofile');

    Route::get('/profile',[RH::class,'profilesection']);

    Route::delete('/handledelete/{id}',[RH::class,'deleteemployee'])->name('deleteemployee');

    Route::get('/editemployee/{id}',[RH::class,'editemployee'])->name('editemployee');

    Route::get('/editemployeesection',[RH::class,'editemployeesection'])->name('editemployeesection');

    Route::put('/handleupdate/{id}',[RH::class,'updateemployee'])->name('employeeupdate');

    Route::put('/handleupdatesection',[RH::class,'updateemployeesection'])->name('employeeupdatesection');

    Route::post('/handleadd',[RH::class,'addemp'])->name('addemployee');

    Route::get('/RHaddemp',function(){
        return view('RH.layouts.addemployees');
    });

    Route::get('/RHdocumentRequests',[RH::class,'documentsreqs'])->name('documentsreqs');
 
    Route::patch('/updatedocs/{documentId}',[RH::class,'updatedocsstatus']);

    Route::patch('/updatecompletedocs/{documentId}',[RH::class,'updatecompletedocsstatus']);

    Route::get('/completeddocs',[RH::class,'completeddocs'])->name('completeddocsreqs');

    Route::post('/pubnews',[RH::class,'pubnews'])->name('publishnews');

    Route::get('/allnews',[RH::class,'allnews']);

    Route::get('/inactiveemp',[RH::class,'inactiveemp']);

    Route::get('/activeemp',[RH::class,'activeemp']);

    Route::delete('/handledeletenews/{id}',[RH::class,'deletenews'])->name('news.delete');

    Route::put('/handleupdatenews/{id}',[RH::class,'updatenews'])->name('news.update');

    Route::get('/editnews/{id}',[RH::class,'editnewsview'])->name('news.edit');

    Route::get('/RHleavesRequests',[RH::class,'leavesreqs'])->name('leavesreqs');

    Route::patch('/leaves/{id}/update',[RH::class,'updateleaves'])->name('leaves.update');

    Route::patch('/approvedleaves/{id}/update',[RH::class,'updateapprovedleaves'])->name('approvedleaves.update');


    Route::get('/approvedleaves',[RH::class,'approvedleaves'])->name('approvedleavesreqs');

    Route::get('/attendance', [RH::class, 'index'])->name('attendance.index');

    Route::post('/checkattendance', [RH::class, 'attendancestore'])->name('attendance.store');

    Route::get('/attendances', [RH::class, 'showaattendences'])->name('attendancess');

    Route::get('/RHpublishNews',function(){
        return view('RH.layouts.publishnews');
    });

    Route::get('/RHlogs',[RH::class, 'logs'])->name('logs');

});

    // Employe Routes ---------------------------------------------------------------------------------

    Route::middleware(['employe.auth'])->group(function () {
        Route::get('/EMdashboard',[Employe::class,'dashboard']);

        Route::get('/EMlogs',[Employe::class, 'logs'])->name('logs');

        Route::get('/allnewsemp',[Employe::class,'allnews']);

        Route::get('/EMprofile',[Employe::class,'profile']);

        Route::get('/profileview',[Employe::class,'profileview']);

        Route::get('/editprofilesection',[Employe::class,'editprofilesection'])->name('editprofilesection');

        Route::put('/handleupdateempsection',[Employe::class,'updateemployeesection'])->name('updatesection');

        Route::get('/EMattendance', [Employe::class, 'index'])->name('EMattendance.index');

        Route::post('/EMcheckattendance', [Employe::class, 'attendancestore'])->name('EMattendance.store');

        Route::get('/employee/submit-leave', [Employe::class, 'create'])->name('employee.submit-leave.create');
        Route::post('/employee/submit-leave', [Employe::class, 'store'])->name('employee.submit-leave');
        Route::get('/employee/leave-requests', [Employe::class, 'leaves'])->name('employee.leave-requests');
        Route::delete('/employee/leave/{leave}/cancel', [Employe::class, 'cancel'])->name('employee.leave.cancel');

        Route::get('/employee/submit-document', [Employe::class, 'createdoc'])->name('employee.submit-document.create');
        Route::post('/employee/submit-document', [Employe::class, 'storedoc'])->name('employee.submit-document');
        Route::get('/employee/document-requests', [Employe::class, 'docs'])->name('employee.document-requests');
        Route::delete('/employee/document/{document}/cancel', [Employe::class, 'canceldoc'])->name('employee.document.cancel');

        Route::get('/team-members',[Employe::class, 'teammembers']);
        Route::get('/incompleteddocs',[Employe::class, 'incomdocs']);

        Route::get('/pendingleaves',[Employe::class, 'pendingleaves']);


    });

    Route::middleware(['manager.auth'])->group(function () {

        Route::get('/MAdashboard',[Manager::class,'dashboard']);

        Route::get('/MAallemp',[Manager::class,'allemployees'])->name('MAallemp');

        Route::get('/viewprofile/{id}',[Manager::class,'viewprofile'])->name('MAviewprofile');

        Route::get('/MAsearchEmployees', [Manager::class, 'searchEmployees'])->name('MAsearchEmployees');

        Route::get('/MAdocumentRequests',[Manager::class,'documentsreqs'])->name('MAdocumentsreqs');

        Route::get('/MAleavesRequests',[Manager::class,'leavesreqs'])->name('MAleavesreqs');

        Route::get('/mylogs',[Manager::class, 'mylogs'])->name('mylogs');

        Route::get('/alllogs',[Manager::class, 'alllogs'])->name('alllogs');

        Route::get('/MAattendance', [Manager::class, 'index'])->name('MAattendance.index');

        Route::post('/MAcheckattendance', [Manager::class, 'attendancestore'])->name('MAattendance.store');

        Route::get('/MAattendances', [Manager::class, 'showaattendences'])->name('MAattendancess');

        Route::get('/MApublishNews',function(){
            return view('Manager.layouts.publishnews');
        });

        Route::post('/MApubnews',[Manager::class,'pubnews'])->name('MApublishnews');

        Route::get('/MAallnews',[Manager::class,'allnews']);

        Route::delete('/handledeletenews/{id}',[Manager::class,'deletenews'])->name('MAnews.delete');

        Route::put('/handleupdatenews/{id}',[Manager::class,'updatenews'])->name('MAnews.update');

        Route::get('/editnews/{id}',[Manager::class,'editnewsview'])->name('MAnews.edit');

        Route::get('/MAprofile',[Manager::class,'profile']);

        Route::get('/MAprofileview',[Manager::class,'profilesection']);

        Route::get('/MAeditemployeesection',[Manager::class,'editemployeesection'])->name('MAeditemployeesection');

        Route::put('/handleupdatesection',[Manager::class,'updateemployeesection'])->name('MAemployeeupdatesection');

    });




