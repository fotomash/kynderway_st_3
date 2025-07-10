<?php

namespace App\Http\Controllers;

use App\Events\SendJobOfferEvent;
use App\Models\Job_Offer;
use App\Models\Job_Posts;

class JobOfferController extends Controller
{
    public function offer()
    {
        $job_offers = Job_Offer::with('job_post')->get();
        return view('admin.job-offer', compact('job_offers'));
    }

    public function add($id)
    {
        //Check if less than 10 job offers
        $total_job_offers = Job_Offer::count();
        if ($total_job_offers >= 10) {
            return back()->with('alert-danger', 'Already 10 Job offers in the list (Max 10 Job Offers)');
        }

        //Check if already added
        $job_offer_exist = Job_Offer::where('job_post_id', $id)->count();
        if (!$job_offer_exist) {
            $job_offer = new Job_Offer();
            $job_offer->job_post_id = $id;
            $job_offer->save();

            return back()->with('alert-success', 'Job added to Job Offer successfully');
        }

        return back()->with('alert-success', 'Job already exists in the Job Offers list');
    }

    public function sendJobOffers()
    {
        $job_post_ids = Job_Offer::with('job_post')->pluck('job_post_id')->toArray();

        //Update job posts count by 1
        Job_Posts::whereIn('id', $job_post_ids)->increment('total_sent');

        //Trigger event and pass job post ids
        event(new SendJobOfferEvent($job_post_ids));

        Job_Offer::with('job_post')->delete();

        return redirect('/admin/job-offer')->with('alert-success', 'Job offers are being prepared and will be sent shortly');
    }
}
