<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
// Import your controller to access the helper function
use App\Http\Controllers\ResumeController; 

class ResumeViewServiceProvider extends ServiceProvider
{
    // ... (rest of the class) ...

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // We only want this to run for authenticated users
        if (Auth::check()) {
            
            // Get an instance of your controller to call the private helper function
            // (Note: In a larger app, you'd move this logic out of the controller)
            $resumeController = app(ResumeController::class);

            // Fetch the resume data once
            $resume = $resumeController->findOrCreateResume(Auth::user());

            // Share the $resume variable with these two views automatically
            View::composer(['dashboard', 'resume.edit'], function ($view) use ($resume) {
                $view->with('resume', $resume);
            });
        }
    }
}