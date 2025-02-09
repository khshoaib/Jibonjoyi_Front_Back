<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\FooterController;

use App\Http\Controllers\BaniController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\SurveyController;

Route::get('/survey', [SurveyController::class, 'showSurvey'])->name('survey.show');
Route::post('/survey/vote', [SurveyController::class, 'submitVote'])->name('survey.vote');



// Display the latest ad details
Route::get('/upload-ads', [AdController::class, 'uploadForm'])->name('ads.upload');

// Route to handle ad uploads
Route::post('/ads', [AdController::class, 'store'])->name('ads.store');

// Route to display ads (optional, if you want to see uploaded ads)
// Route::get('/jibonjoyi_details', [AdController::class, 'showAds'])->name('jibonjoyi.details');




Route::post('stories/bani/{id}/toggle-status', [BaniController::class, 'toggleStatus'])->name('bani.toggleStatus');

// Display all bani and form to add new bani
Route::get('stories/bani', [BaniController::class, 'index'])->name('stories.bani.index');

// Store new bani
Route::post('stories/bani', [BaniController::class, 'store'])->name('stories.bani.store');

// Show form to edit bani
Route::get('stories/bani/{id}/edit', [BaniController::class, 'edit'])->name('stories.bani.edit');

// Update bani
Route::put('stories/bani/{id}', [BaniController::class, 'update'])->name('stories.bani.update');

// Delete bani
Route::delete('stories/bani/{id}', [BaniController::class, 'destroy'])->name('stories.bani.destroy');

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index');
})->name('index');
// Home page route (this will be the first page loaded)
// Route::get('/index', function () {
//     return view('index');
// })->name('index');

// Individual routes for each page
Route::get('/economy', function () {
    return view('economy');
})->name('economy');

Route::get('/history', function () {
    return view('history');
})->name('history');

// Route::get('/liberation', function () {
//     return view('liberation');
// })->name('liberation');

Route::get('/literature', function () {
    return view('literature');
})->name('literature');

Route::get('/philosophy', function () {
    return view('philosophy');
})->name('philosophy');

Route::get('/religion', function () {
    return view('religion');
})->name('religion');

Route::get('/science', function () {
    return view('science');
})->name('science');

Route::get('/sports', function () {
    return view('sports');
})->name('sports');

Route::get('/travel', function () {
    return view('travel');
})->name('travel');

Route::get('/politics', function () {
    return view('politics');
})->name('politics');

Route::get('/world', function () {
    return view('world');
})->name('world');

// Route::get('/jibonjoyi_details', function () {
//     return view('jibonjoyi_details');
// })->name('jibonjoyi_details');


Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Authentication Routes
Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin'); // Display sign-in form
Route::post('/signin', [AuthController::class, 'handleSignin'])->name('signin.submit'); // Handle form submission


Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'handleSignup'])->name('signup.store');


// // shahed

// Story creation routes
Route::middleware(['admin'])->group(function () {
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');

    Route::get('stories/add-footer', [FooterController::class, 'create'])->name('stories.footer.create');

    // Route to handle form submission
    Route::post('stories/add-footer', [FooterController::class, 'store'])->name('stories.footer.store');
    Route::get('stories/edit-footer/{id}', [FooterController::class, 'edit'])->name('stories.footer.edit');
    Route::post('stories/update-footer/{id}', [FooterController::class, 'update'])->name('stories.footer.update');
    Route::delete('stories/delete-footer/{id}', [FooterController::class, 'destroy'])->name('stories.footer.destroy');
    Route::post('stories/toggle-footer-status/{id}', [FooterController::class, 'toggleStatus'])->name('stories.footer.toggleStatus');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
//story search routes
// Route to show the search form
Route::get('/stories/search', [StoryController::class, 'searchForm'])->name('stories.searchForm');

// Route to handle the search logic
//Route::get('/stories/result', [StoryController::class, 'searchResults'])->name('stories.searchResults');
// Route to show the edit form
Route::get('/stories/{id}/edit', [StoryController::class, 'edit'])->name('stories.edit');

// Route to handle the update request
Route::put('/stories/{id}', [StoryController::class, 'update'])->name('stories.update');

//delete story 
Route::delete('/stories/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');




// Liberation page (showing both "ইতিহাস" and "ধর্ম" stories)
Route::get('/liberation', [StoryController::class, 'showLiberationStories'])->name('liberation');
Route::get('/history', [StoryController::class, 'showHistoryStories'])->name('history');
Route::get('/travel', [StoryController::class, 'showTravelStories'])->name('travel');
Route::get('/politics', [StoryController::class, 'showPoliticsStories'])->name('politics');
Route::get('/world', [StoryController::class, 'showWorldStories'])->name('world');
Route::get('/economy', [StoryController::class, 'showEconomyStories'])->name('economy');
Route::get('/religion', [StoryController::class, 'showReligionStories'])->name('religion');
Route::get('/sports', [StoryController::class, 'showSportsStories'])->name('sports');
Route::get('/science', [StoryController::class, 'showScienceStories'])->name('science');
Route::get('/philosophy', [StoryController::class, 'showPhilosophyStories'])->name('philosophy');
Route::get('/literature', [StoryController::class, 'showLiteratureStories'])->name('literature');
// Route::get('/jibonjoyi_details/{id}', [StoryController::class, 'showDetailsStories'])->name('jibonjoyi_details');
Route::post('/rate-story/{id}', [StoryController::class, 'rateStory'])->name('rate.story');








// Route::get('/jibonjoyi-details/{id}', [StoryController::class, 'showDetails'])->name('jibonjoyi_details');
Route::get('/increment-click-count/{id}', [StoryController::class, 'incrementClickCount'])->name('incrementClickCount');



Route::get('/jibonjoyi_details/{id}', [StoryController::class, 'showDetailsStories'])->name('jibonjoyi_details');
Route::get('/jibonjoyi_details', function () {
    return view('jibonjoyi_details');
})->name('jibonjoyi_details');
Route::get('/jibonjoyi_details', [AdController::class, 'showAds'])->name('jibonjoyi.details');



Route::get('/admin/signup', [AuthController::class, 'showAdminSignupForm'])->name('admin.signup');
Route::post('/admin/signup', [AuthController::class, 'handleAdminSignup'])->name('admin.signup.store');

// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signin', 'signin')->name('signin');
        Route::get('/signup', 'signup')->name('signup');
    });
});
