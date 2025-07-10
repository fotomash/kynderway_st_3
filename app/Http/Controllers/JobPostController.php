<?php

namespace App\Http\Controllers;

use App\Interfaces\JobPostInterface;
use App\Mail\JobOfferNewsletter;
use App\Models\Job_Offer;
use App\Models\MailingJob;
use App\Models\MailingJobs;
use Faker\Core\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Job_Posts;
use App\Models\Profile_Categories;
use App\Models\Profile_Posts;
use App\Services\ProfilePostService;
use Carbon\Carbon;
use Mockery\Exception;
use Response;
use Helper;
use Illuminate\Support\Facades\Mail;

class JobPostController extends Controller
{
    public function __construct(private ProfilePostService $profilePostService, private JobPostInterface $jobPostRepository)
    {
    }

    public function index(Request $request)
    {
        $filterMapping = [
            'filter-category' => 'profile_category_id',
            'filter-type' => 'usertype',
            'filter-country' => 'country',
            'filter-city' => 'city',
            'filter-status' => 'adstatus'
        ];


        $categories = $this->profilePostService->getCountByCategorty();
        $providerWithouWorkProfileCount = $this->profilePostService->getCountProviderWithoutWorkProfile();

        $qb = Job_Posts::with('userdetails', 'profilecategory')
            ->whereHas('userdetails')
            ->whereHas('profilecategory');

        foreach ($filterMapping as $key => $column) {
            $filter = $request->get($key, []);
            if (count($filter) > 0) {
                $qb->whereIn($column, $filter);
            }
        }

        $jobPostLists = $qb->orderBy('id', 'desc')->get();
        $jobPostListsCount = Job_Posts::with('userdetails', 'profilecategory')
        ->whereHas('userdetails')
        ->whereHas('profilecategory')
            ->count();

        $jobPostActiveListsCount = Job_Posts::with('userdetails', 'profilecategory')
            ->whereHas('userdetails')
            ->whereHas('profilecategory')
            ->where('expirydt', '>=', Carbon::now()->toDateString())
            ->count();

        $jobPostExpiredListsCount = Job_Posts::with('userdetails', 'profilecategory')
            ->whereHas('userdetails')
            ->whereHas('profilecategory')
            ->where('expirydt', '<', Carbon::now()->toDateString())
            ->count();

        $countries = $this->jobPostRepository->getCountries();

        $categoriesList = Profile_Categories::get();

        return view('admin.job-list', compact('providerWithouWorkProfileCount', 'categoriesList', 'countries', 'jobPostLists', 'jobPostListsCount', 'jobPostActiveListsCount', 'jobPostExpiredListsCount', 'categories'));
    }

    public function sendNewsletter(Request $request)
    {
        $errorMessage = "";
        $usersCount = 0;

        $customEmails = array_filter(array_map(function (string $rawData) {
            $data = explode('|', $rawData);
            $email = trim($data[0]??'');
            $name = trim($data[1]??'');
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? compact('name', 'email') : null;
        }, explode(PHP_EOL, $request->get('jobs_custom_email', ''))));

        $emails = [];

        foreach ($customEmails as $data) {
            $emails[$data['email']] = [
                'name' => $data['name'],
                'email' => $data['email']
            ];
        }

        $categories = $request->get('categories', []);

        $users = [];

        if (in_array(0, $categories)) {
            $users = $this->profilePostService->getEmailsProviderWithoutWorkProfile();
        }

        $categories = array_filter($categories);

        $users = array_merge($users, $this->profilePostService->getEmailByCategorty($categories));

        foreach ($users as $user) {
            if (($user->email??null) != null) {
                $emails[$user->email] = [
                    'name' => $user->username,
                    'email' => $user->email
                ];
            }
        }

        $job = new MailingJob();
        $job->jobs = json_encode($request->get('jobs', []));
        ;
        $job->emails = json_encode($emails);
        $job->total = count($emails);
        $job->progress = 0;
        $job->finished = false;
        $job->createdAt = new \DateTime();
        $job->save();
        $usersCount = count($emails);

        return Response::json(compact('errorMessage', 'usersCount'));
    }

    public function previewNewsletter(Request $request)
    {
        $jobs = array_filter(explode(',', $request->get('jobs', '')));
        if (!count($jobs)) {
            abort(404);
        }

        $jobPosts = Job_Posts::with('userdetails', 'profilecategory')
            ->whereHas('userdetails')
            ->whereHas('profilecategory')
            ->whereIn('id', $jobs)
            ->get();

        return view('emails.job-offers-newsletter', [
            'content' => [
                    'name' => 'User Name',
                    'email' => null,
                    'jobs' => $jobPosts
                ]
        ]);
    }

    public function show($jobId, $type)
    {
        if ($jobId != '') {
            $jobPost = Job_Posts::withTrashed()->where('id', $jobId)->with('userdetails', 'profilecategory')->first();

            //jobtype
            $allJobTypes = implode(',', Helper::getValuesForIds('jobtypes', $jobPost->jobtypes));

            //work with
            $allWorkwith = implode(',', Helper::getValuesForIds('workwith', $jobPost->workwith));

            //experience - work skills
            $allJobPositions = implode(',', Helper::getValuesForIds('position', $jobPost->position));

            //req_language
            $requiredLanguages =  $jobPost->req_language;

            //Additional Languages
            $preferredLanguages = $jobPost->pref_language;

            $returnHTML = view('admin.job-detail', compact('jobPost', 'allWorkwith', 'allJobPositions', 'allJobTypes', 'requiredLanguages', 'preferredLanguages', 'type'))->render();
            return Response::json(['html' => $returnHTML]);
        }
    }

    public function assignUser($jobId)
    {
        $adminId = Auth::user()->id;
        if ($jobId != '') {
            // Find job post details
            $job_post = Job_Posts::find($jobId);

            if ($job_post === null) {
                return back()->with('alert-warning', 'Invalid job post');
            }
            if ($job_post->assigned_user_id !== null) {
                return back()->with('alert-warning', 'Job post already assign');
            }

            //Assign id:
            Job_Posts::where('id', $jobId)->update([
                'assigned_user_id' => $adminId
            ]);

            return back()->with('alert-success', 'Assigned successfully');
        }
    }

     public function updateJobStatus(Request $request)
     {
         $jobId = $request->statusJobId;
         $setStatus = $request->setStatus;
         $reportCheck = isset($request->reportCheck) ? $request->reportCheck : 0;
         $suspendedBy = ($setStatus) ? '' : 'Admin';
         if ($jobId != '' && $setStatus != '') {
             Job_Posts::where('id', $jobId)->update([
                'adstatus' => $setStatus,
                'suspendBy' => $suspendedBy
             ]);
             if ($reportCheck) {
                 Helper::reportComplete($jobId, 'Job');
             }
             //Send mail to user when job post status changed to suspend/pause (0)
             if ($setStatus == 0) {
                 Helper::changesStatusSuspendMail($jobId, 'Job');
             } else {
                 Helper::changesStatusActivateMail($jobId, 'Job');
             }

             $statusMessage = $setStatus == 1 ? 'Activated' : 'Suspended';

             return back()->with('alert-success', 'Job ' . $statusMessage . ' successfully');
         }
     }

     public function updateJobSelect(Request $request)
     {
         $jobId = $request->jobId;
         $select = $request->select;
         if ($jobId != '' && $select != '') {
             $job = Job_Posts::findOrFail($jobId);
             if ($select) {
                 $countSelected = Job_Posts::where([
                     ['selected', 1],
                     ['profile_category_id', $job->profile_category_id],
                 ])->count();
                 if ($countSelected >= 10) {
                     return back()->with('alert-danger', 'Max 10 jobs per category limit reached');
                 }
             }

             $job->selected = $select;
             $job->save();
             $statusMessage = $select == 1 ? 'Selected' : 'Deselected';

             return back()->with('alert-success', 'Job ' . $statusMessage . ' successfully');
         }
     }

    public function showReport($jobId)
    {
        if ($jobId != '') {
            $jobPost = Job_Posts::where('id', $jobId)->with('userdetails', 'profilecategory', 'userconnection')->first();

            //Provider names
            $jobReporters = '';
            $jobConnection = sizeof($jobPost->userconnection);
            if (sizeof($jobPost->userconnection) > 0) {
                $jobReporters = Helper::getReportedProviderName($jobPost->userconnection->toArray());
            }

            //jobtype
            $allJobTypes = implode(',', Helper::getValuesForIds('jobtypes', $jobPost->jobtypes));

            //work with
            $allWorkwith = implode(',', Helper::getValuesForIds('workwith', $jobPost->workwith));

            //experience - work skills
            $allJobPositions = implode(',', Helper::getValuesForIds('position', $jobPost->position));

            //req_language
            $requiredLanguages =  $jobPost->req_language;

            //Additional Languages
            $preferredLanguages = $jobPost->pref_language;

            $returnHTML = view('admin.report-detail', compact('jobPost', 'allWorkwith', 'allJobPositions', 'allJobTypes', 'requiredLanguages', 'preferredLanguages', 'jobReporters', 'jobConnection'))->render();
            return Response::json(['html' => $returnHTML]);
        }
    }

    public function deleteJob(Request $request)
    {
        $jobId = $request->deleteJobId;
        $reportCheck = isset($request->reportCheck) ? $request->reportCheck : 0;

        if ($jobId != '') {
            Helper::jobOrProfileDeleteMail($jobId, 'Job');
            Helper::softDeleteAllJobs($jobId, Auth::user()->name);
            if ($reportCheck) {
                Helper::reportComplete($jobId, 'Job');
            }
            return back()->with('alert-success', 'Job deleted successfully');
        }
    }

    public function deleteJobOffer(Request $request)
    {
        $jobOfferId = $request->deleteJobOfferId;

        if ($jobOfferId != '') {
            Job_Offer::where('id', $jobOfferId)->delete();
            return back()->with('alert-success', 'Job Offer deleted successfully');
        }

        return back()->with('alert-danger', 'Job Offer not found');
    }

    public function deletedJobs(Request $request)
    {
        $jobPostLists = Job_Posts::onlyTrashed()->with('userdetails', 'profilecategory', 'assigned')
            ->where(function ($query) {
                $query->whereHas('userdetails', function ($query) {
                    $query->where('delete_request', '<', 2);
                });
            })
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.deleted-jobs', compact('jobPostLists'));
    }

    public function adminAddJobNotes(Request $request)
    {
        $jobId = $request->jobId;
        $notes = $request->comment;
        if ($jobId != '') {
            //Update notes:
            Job_Posts::where('id', $jobId)->update([
                'user_notes' => $notes
            ]);

            return back()->with('alert-success', 'Notes added successfully');
        }
    }
}
