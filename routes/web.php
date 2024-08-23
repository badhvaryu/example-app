<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $job = Job::first();

    TranslateJob::dispatch($job);

    return 'Done';
});

/*
 * Routes related to Home
 */
Route::view('/', 'home'); // Route to show home page

//Route::get('/', function () {
//    return view('home');
//});

/*
 * Routes related to Contact
 */
Route::view('/contact', 'contact'); // Route to show Contact page

//Route::get('/contact', function () {
//    return view('contact');
//});

/*
 * Routes related to Jobs
 */
//Route::resource('jobs', JobController::class)->only(['index', 'show']);
//Route::resource('jobs', JobController::class)->except(['index', 'show'])->middleware(['auth']);

// OR (same as above)
//Route::controller(JobController::class)->group(function () {                 // This creates a group controller, so we do not have to specify for each related Route
//    Route::get('/jobs', 'index');             // Route to show all jobs - Index
//    Route::get('/jobs/creat','create');       // Route to create a job
//    Route::get('/jobs/{job}','show');         // Route to show specific or single job
//    Route::post('/job','store');              // Route to store/save a job
//    Route::get('/jos{job}/edit', 'edit');     // Route to edit a job
//    Route::patch('/jobs/{job}', 'update');    // Route to update a job (ie Edit -> Apply Changes)
//    Route::delete('/jobs/{job}','destroy');   // Route to Delete/Destroy a job
//});

// OR (same as above 2)
Route::get('/jobs', [JobController::class, 'index']);                           // Route to show all jobs - Index
Route::get('/jobs/create', [JobController::class, 'create']);                   // Route to create a job
Route::get('/jobs/{job}', [JobController::class, 'show']);                      // Route to show specific or single job

Route::post('/jobs', [JobController::class, 'store'])->middleware(['auth']);    // Route to store/save a job
// below middleware checks if you are authorize to edit a job then if you are able to edit this job?
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])                  // Route to edit a job
    ->middleware('auth')
    ->can('edit,job');  // passing the edit method and job model
Route::patch('/jobs/{job}', [JobController::class, 'update']);                  // Route to update a job (ie Edit -> Apply Changes)
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);                // Route to Delete/Destroy a job

/*
 * Routes related to Auth
 */
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
