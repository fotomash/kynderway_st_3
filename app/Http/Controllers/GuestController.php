<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\JobConnect;
use App\Models\countries;
use App\Models\Profile_Posts;
use App\Models\Profile_Categories;
use App\Models\Specialities;
use App\Models\Experiences;
use App\Models\Job_Types;
use App\Models\Job_Posts;
use App\Models\User_Connections;
use App\Models\Document;
use App\Models\User;
use App\Services\Slug;
use Chatify\Http\Models\Message;
use Chatify\Http\Models\Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Carbon\Carbon;

use Response;
use Session;

class GuestController extends Controller
{
    protected $slug;

    public function __construct(Slug $slug)
    {
        $this->basic_detail['countries'] = countries::all();
        $this->basic_detail['londonCity'] = config('kinderway.londoncity');
        $this->basic_detail['londonPostal'] = config('kinderway.londonpostal');
        $this->basic_detail['languages'] = config('kinderway.language_supported');
        $this->basic_detail['languageCount'] = count($this->basic_detail['languages']);
        $this->slug = $slug;
    }


    public function viewPDF(Request $request)
    {
        return view('website.view-pdf');
    }

    public function index()
    {
        if (auth()->check()) {
            return redirect('/login');
        }
        return redirect('/search-jobs');
    }

    public function getJob($slug)
    {
        $jobPosts = Job_Posts::with('profilecategory', 'userdetails')
            ->whereDate('expirydt', '>=', Carbon::now()->toDateString())
            ->where('slug', $slug)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalJobPost = count($jobPosts);

        return view('website.job', $this->basic_detail, compact('jobPosts', 'totalJobPost'));
        // return view('website.job', $this->basic_detail, compact('job'));
    }

    public function getProfile($category_slug, $profile_slug)
    {
        $totalProviders = 0;
        $haveJob = 0;

        $providerPosts = Profile_Posts::with('userdetails', 'userdetails.userlanguages', 'userdetails.videosets', 'userdetails.getVerified')
            ->where(function ($query) use ($category_slug) {
                $query->whereHas('profilecat', function ($query) use ($category_slug) {
                    $query->where('slug', $category_slug);
                });
            })
            ->where('status', 1)
            ->where('slug', $profile_slug)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalProviders = count($providerPosts);
        $languages = $this->basic_detail['languages'];

        return view('website.provider', $this->basic_detail, compact('providerPosts', 'totalProviders', 'languages', 'haveJob'));
        // return view('website.provider', $this->basic_detail, compact('profile'));
    }

    public function searchProviders()
    {
        $totalProviders = 0;
        $haveJob = 0;
        if (Auth::check() && Auth::user()->type == 'admin') {
            abort(404);
        }
        if (Auth::check() && Auth::user()->type == 'service_provider') {
            abort(404);
        // return redirect('/provider/dashboard')->with('success', 'As you are service provider. you can not see other service provider.');
        } elseif (Auth::check() && Auth::user()->type == 'service_seeker') {
            $providerPosts = Profile_Posts::with('profilecat', 'userdetails', 'userdetails.userlanguages', 'userdetails.videosets', 'userdetails.getVerified')
                ->where(function ($query) {
                    $query->whereHas('userdetails', function ($query) {
                        $query->where('privacy', 0);
                    });
                })
                ->where('status', 1)
                ->where('profile_category_id', 1)
                ->orderBy('id', 'desc')
                ->paginate(10);
            $findActiveJobs = Job_Posts::where([
                ['user_id', Auth::user()->id],
                ['profile_category_id', 1],
                ['adstatus', 1],
                ['expirydt', '>=', Carbon::now()->toDateString()],
            ])->count();
            if ($findActiveJobs > 0) {
                $haveJob = 1;
            }
            $totalProviders = $providerPosts->total();

            $languages = $this->basic_detail['languages'];
        } else {
            $providerPosts = Profile_Posts::with('userdetails', 'userdetails.userlanguages', 'userdetails.videosets', 'userdetails.getVerified')
                ->where(function ($query) {
                    $query->whereHas('userdetails', function ($query) {
                        $query->where('privacy', 0);
                    });
                })
                ->where('status', 1)
                ->where('selected', 1)
                ->where('profile_category_id', 1)
                ->orderBy('id', 'desc')
                ->take(10)
                ->paginate(10);

            $totalProviders = $providerPosts->total();
            $languages = $this->basic_detail['languages'];
        }
        return view('website.search-providers', $this->basic_detail, compact('providerPosts', 'totalProviders', 'languages', 'haveJob'));
    }

    public function getValuesForIds($modelvalue, $dbvalue)
    {
        $arr = [];
        $allExplode = explode(',', $dbvalue);
        for ($i = 0; $i < count($allExplode); $i++) {
            if ($modelvalue == 'workwith') {
                $temp = Specialities::where('id', $allExplode[$i])->first();
                $tempArr = $temp->toArray();
                $arr[] = $tempArr['name'];
            } elseif ($modelvalue == 'position') {
                $temp = Experiences::where('id', $allExplode[$i])->first();
                $tempArr = $temp->toArray();
                $arr[] = $tempArr['exp_name'];
            } elseif ($modelvalue == 'jobtypes') {
                $temp = Job_Types::where('id', $allExplode[$i])->first();
                $tempArr = $temp->toArray();
                $arr[] = $tempArr['jobtype'];
            }
        }
        return $arr;
    }

    public function getAllUserJobPost($profile_category_id, $providerID, $profileID)
    {
        $jobs = Job_Posts::with('profilecategory', 'userdetails')
            ->with(['userconnection' => function ($query) use ($providerID, $profileID) {
                $query->where([
                    ['provider_id', $providerID],
                    ['providerprofileid', $profileID],
                ]);
            }])
            ->where('user_id', Auth::user()->id)
            ->whereDate('expirydt', '>=', Carbon::now())
            ->where('profile_category_id', $profile_category_id)
            ->orderBy('id', 'desc')
            ->get();
        $remainingJob = $totalJob = $jobs->count();
        $matchJob = 0;
        $connectionJobs = [];
        $alreadyInvitedJobs = [];
        if ($totalJob > 0) {
            foreach ($jobs as $job) {
                if ($job->userconnection->count()) {
                    $matchJob++;
                    $remainingJob--;
                    continue;
                }
                array_push($connectionJobs, $job);
            }
            foreach ($jobs as $job) {
                if ($job->userconnection->count() > 0) {
                    array_push($alreadyInvitedJobs, $job);
                }
            }
            $data['totalJob'] = $totalJob;
            $data['remainingJob'] = $remainingJob;
            $data['connectionJobs'] = $connectionJobs;
            $data['alreadyInvitedJobs'] = $alreadyInvitedJobs;
            $data['matchJob'] = $matchJob;
        } else {
            $data['totalJob'] = 0;
        }

        return $data;
    }

    public function getSearchProviderbar(Request $request)
    {
        if ($request->currpopup) {
            $profileIdPopup = $request->currpopup;
            $profileposts = Profile_Posts::where('id', $profileIdPopup)->with('profilecat', 'userdetails', 'userdetails.getVerified')->first();
            $providerPopupId = $profileposts->provider_id;
            $providerDocuments = Document::where('provider_id', $providerPopupId)->first();
            $all_jtypes = $this->getValuesForIds('jobtypes', $profileposts->jobtypes);
            $all_workwith = $this->getValuesForIds('workwith', $profileposts->workwith);

            /*
            Conditions:
            1) If job posted then only can connect
            2) If single job then profile category must match
               else - then message that you have not posted job for this profile
            3) If job posted by business for more then one profile category and there are more then one profile category by service provider then only show radio button that match in both(busi and provider)
            */

            $jobResult = $this->getAllUserJobPost($profileposts->profile_category_id, $providerPopupId, $profileIdPopup);
            $showconnect = [];
            $listJobs = [];
            $invitedJobs = [];
            if ($jobResult['totalJob'] > 0) {
                $listJobs = $jobResult['connectionJobs'];
                $invitedJobs = $jobResult['alreadyInvitedJobs'];
                if ($jobResult['remainingJob'] > 0) {
                    $showconnect['remainingJob'] = $jobResult['remainingJob'];
                    $showconnect['buttonID'] = "connectidbtn";
                    $showconnect['buttonLink'] = "#";
                    $showconnect['Message'] = "INVITE TO JOB";
                } else {
                    $showconnect['remainingJob'] = 0;
                    $showconnect['buttonID'] = "alreadyApplied";
                    $showconnect['buttonLink'] = "#";
                    $showconnect['Message'] = "ALREADY INVITED";
                }
            } else {
                $showconnect['remainingJob'] = 0;
                $showconnect['buttonID'] = "addJob";
                $showconnect['buttonLink'] = "post-vacancy";
                $showconnect['Message'] = "post a job to connect";
            }
            $html = view('website.searchprovidersidebar', compact('profileposts', 'all_jtypes', 'all_workwith', 'showconnect', 'listJobs', 'invitedJobs', 'providerDocuments'))->render();
            return Response::json(['success' => '1', 'html' => $html]);
        }
    }

    public function getAllJobtype(Request $request)
    {
        $profileId = $request->profileid;
        $jtypes = job_types::where('profile_id', $profileId)->get();
        $html = view('website.jobtypeslist', compact('jtypes'))->render();
        return Response::json(['success' => '1', 'html' => $html]);
    }

    public function searchProviderByAjx(Request $request)
    {
        $page = $request->get('page');
        $profileId = $request->get('profile');
        $exp = $request->get('exp');
        $setLanguage = $request->get('setlanguage');
        $jobType = $request->get('jobtypes');
        $jobPosition = $request->get('job_position');
        $country = $request->get('country');
        $city = $request->get('city');
        $postalCode = $request->get('postalCode');
        $jobTypeArr = (isset($jobType) && (count($jobType) > 0)) ? $jobType : '';

        $setLanguage = (isset($setLanguage)) ? $setLanguage : '0';
        $exp = (isset($exp)) ? $exp : '0';
        $profileId = ($profileId != '') ? $profileId : 1;
        $haveJob = 0;

        if (Auth::check()) {
            $findActiveJobs = Job_Posts::where([
                ['user_id', Auth::user()->id],
                ['profile_category_id', $profileId],
                ['adstatus', 1],
                ['expirydt', '>=', Carbon::now()->toDateString()],
            ])->count();
            if ($findActiveJobs > 0) {
                $haveJob = 1;
            }
        }


        $providerPosts = Profile_Posts::with(['userdetails'])
            ->where(function ($query) use ($profileId, $exp, $setLanguage, $jobTypeArr, $jobPosition, $country, $city, $postalCode) {
                if (!Auth::check()) {
                    $query->where('selected', 1);
                }
                $query->whereHas('userdetails', function ($query) {
                    $query->where('privacy', 0);
                });
                if ($profileId != '') {
                    $query->where('profile_category_id', $profileId);
                }
                if ($exp != '0') {
                    $query->where('experience2', '=', $exp);
                }

                if ($setLanguage != '0') {
                    $query->whereHas('userdetails', function ($query) use ($setLanguage) {
                        $query->where('native_language', $setLanguage);
                    });
                }

                if ($country != '') {
                    $query->whereHas('userdetails', function ($query) use ($country) {
                        $query->where('country', $country);
                    });
                } elseif ($jobPosition == 'Outside UK') {
                    $query->whereHas('userdetails', function ($query) use ($country) {
                        $query->where('country', '<>', 'United Kingdom');
                    });
                }

                if ($city != '') {
                    $query->whereHas('userdetails', function ($query) use ($city) {
                        $query->where('city', 'like', '%' . $city . '%');
                    });
                }

                if ($postalCode != '') {
                    $query->whereHas('userdetails', function ($query) use ($postalCode) {
                        $query->where('postal_code', $postalCode);
                    });
                }
                $rawQuery = '';
                if ($jobTypeArr != '' && is_array($jobTypeArr) && count($jobTypeArr) > 0) {
                    foreach ($jobTypeArr as $key => $jtype) {
                        if ($rawQuery == '') {
                            $rawQuery = 'FIND_IN_SET(? ,jobtypes)';
                        } else {
                            $rawQuery .= ' OR FIND_IN_SET(? ,jobtypes)';
                        }
                    }
                    $query->WhereRaw("( " . $rawQuery . " ) ", $jobTypeArr);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        $totalProviders = $providerPosts->total();

        return view('website.ajaxsearchprovider', compact('providerPosts', 'totalProviders', 'haveJob'));
    }

    public function setJobConnection(Request $request)
    {
        if (request()->ajax()) {
            $jobappliedid = $request->jobid;
            $profilecat = $request->profilecat;
            $providerid = $request->providerid;
            $profileid = $request->profileid;

            //Get provider profileid for which job poster has connected (as per radio button):
            $getProviderDetails = Profile_Posts::with('userdetails')->where([
                'provider_id' => $providerid,
                'profile_category_id' => $profilecat,
            ])->first();
            //----------------------------------------------

            $insertProfile = User_Connections::create([
                'job_userid' => Auth::user()->id,
                'provider_id' => $providerid,
                'jobappliedid' => $jobappliedid,
                'providerprofileid' => $profileid,
                'profilecategoryid' => $profilecat,
                'clienttype' => Auth::user()->client_type,
                'requested_by' => 'service_seeker',
                'jobconnect' => '1',
                'providerconnect' => 0,
                'fullconnect' => 0
            ]);

            $insertProfile->job()->touch();
            //Send mail to job poster regarding connection request:---------------------------
            //*****************************************************************************
            //Provider email:

            if ($getProviderDetails) {
                $sendMailTo = $getProviderDetails->userdetails['email'];
                // $providerFullName = $getProviderDetails->userdetails['name']." ".$getProviderDetails->userdetails['last_name'];
                $providerFullName = $getProviderDetails->userdetails['name'];
                $secondaryNotification = $getProviderDetails->userdetails['secondary_notifications'];
                $dashboardUrl = 'provider/dashboard';
            }



            //Message
            if ($secondaryNotification == 1) {
                $senddetails = [
                    'providerFullName' => $providerFullName,
                    'jobposterFullname' => Auth::user()->name,
                    'dashboardUrl' => $dashboardUrl,
                ];
                $connectid = $insertProfile->id;

                $result = User_Connections::where('id', $connectid)
                ->where(function($query) {
                    $query->where('job_userid', Auth::user()->id)
                          ->orWhere('provider_id', Auth::user()->id);
                })
                ->first(['job_userid', 'provider_id']);

                $relevantId = null;
                if ($result) {
                    if ($result->job_userid != Auth::user()->id) {
                        $relevantId = $result->job_userid;
                    } elseif ($result->provider_id != Auth::user()->id) {
                        $relevantId = $result->provider_id;
                    }
                }
    
                Chatify::push('private-chatify-notification', 'messaging', [
                    'from_id' => Auth::user()->id,
                    'to_id' => $relevantId,
                    'reference_id' => $connectid,
                    'message' => ""
                ]);

                Mail::to($sendMailTo)->send(new JobConnect($senddetails));
                // Mail::send('emails.job-connect', $senddetails, function ($message) use ($sendMailTo) {
                //     $message->to($sendMailTo)->subject('You have a new Job Offer');
                // });
            }
            //-------------------------------------------Email End-----------------------------------

           
            return Response::json(['success' => '1', 'message' => 'Your invite was sent! <br/>
            Provider will contact you if they think they are suitable for this position. Messages regarding this job application will appear on your dashboard.']);
        }
    }

    public function updateJobPostSlugs()
    {
        $job_posts = Job_Posts::where('slug', '')->get();
        foreach ($job_posts as $post) {
            $post->update(['slug' => $this->slug->createSlug('job', $post->jobtitle)]);
        }
        return 'done';
    }

    public function updateProfilePostSlugs()
    {
        $profile_posts = Profile_Posts::where('slug', '')->get();
        foreach ($profile_posts as $post) {
            $post->update(['slug' => $this->slug->createSlug('profile', $post->userdetails->name)]);
        }
        return 'done';
    }

    public function updateProfileCategoriesSlugs()
    {
        $profile_categories = Profile_Categories::all();
        foreach ($profile_categories as $post) {
            $post->slug = $this->slug->createSlug('profile_categories', $post->categoryname);
            $post->save();
        }
        return 'done';
    }

    public function downloadFile(Request $request, $id)
    {
        $doc = Document::find($id);
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path('app/public/' . $doc->document_url), 'new.pdf', $headers);
    }

    public function unsubscribe(String $email)
    {
        $email = base64_decode($email);
        $user = User::where('email', $email)->first();
        if ($user !== null) {
            $user->marketing = 0;
            $user->save();
        }

        return view('website.unsubscribe', compact('email'));
    }
}
