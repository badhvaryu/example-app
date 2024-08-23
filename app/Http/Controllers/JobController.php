<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobPosted;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        //dd('Hello from JobController:create');
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
        // Validation
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // Save a job
        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        // Send an email about a new job is posted
//        Mail::to($job->employer->user)->send(
//            new JobPosted($job)
//        );

        // Don't deliver as a part of the current request instead throw it onto the queue
        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

        // Return to Job listings page
        return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        // authorize the data/request
        Gate::authorize('edit-job', $job);

        // validate the data/request
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // update the job and persist
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        // redirect to the job show page
        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        // authorize the data/request
        Gate::authorize('edit-job', $job);

        // delete a job
        $job->delete();

        // redirect to job listings page
        return redirect('/jobs');
    }

}
