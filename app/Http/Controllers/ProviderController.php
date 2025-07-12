<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Mail\GetVerified as MailGetVerified;
use App\Mail\ProviderConnect;

use App\Models\User;
use App\Models\countries;
use App\Models\Specialities;
use App\Models\Experiences;
use App\Models\Job_Types;
use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\User_Language;
use App\Models\Getverified;
use App\Models\Videointros;
use App\Models\User_Connections;
use App\Models\Document;
use App\Models\DocumentUser;
use App\Models\Profile_Categories;
Use App\Models\AccessRequest;

use App\Services\Slug;

use Chatify\Http\Models\Message;
use Carbon\Carbon;
use Chatify\Http\Models\Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;

use Response;
use Session;
use Helper;
use Config;

class ProviderController extends Controller
{
    protected $slug;

    public function __construct(Slug $slug)
    {
        $this->basic_detail['countries'] = countries::all();
        $this->basic_detail['londoncity'] = config('kinderway.londoncity');
        $this->basic_detail['londonpostal'] = config('kinderway.londonpostal');
        $this->basic_detail['language_supported'] = config('kinderway.language_supported');
        $this->basic_detail['language_count'] = count($this->basic_detail['language_supported']);
        $this->profile_categories = Profile_Categories::all();
        $this->slug = $slug;
    }

    public function dashboard()
    {
        $suspendedProfiles = Profile_Posts::with('profilecat')
            ->where('provider_id', Auth::user()->id)
            ->where('status', 0)
            ->get();
        $allUsersJobs = User_Connections::select(
            'user_connections.provider_id',
            'user_connections.id as conid',
            'user_connections.job_userid',
            'user_connections.jobappliedid',
            'user_connections.providerprofileid',
            'user_connections.profilecategoryid',
            'user_connections.requested_by',
            'user_connections.fullconnect',
            'users.id',
            'users.name',
            'users.last_name',
            'users.profile_picture',
            'job_posts.id as jobid',
            'job_posts.created_at',
            'job_posts.jobtitle',
            'job_posts.profile_category_id',
            'job_posts.deleted_at',
            'job_posts.adstatus',
            'profile_posts.id',
            'profile_posts.status',
        )
            // ->leftJoin('users', 'user_connections.provider_id', '=', 'users.id')
            ->leftJoin('users', 'user_connections.job_userid', '=', 'users.id')
            ->leftJoin('job_posts', 'user_connections.jobappliedid', '=', 'job_posts.id')
            ->leftJoin('profile_posts', 'user_connections.providerprofileid', '=', 'profile_posts.id')
            ->where('user_connections.provider_id', Auth::user()->id)
            ->where('user_connections.jobconnect', 1)
            ->where('user_connections.report', 0)
            ->whereNull('job_posts.deleted_at')
            ->whereDate('job_posts.expirydt', '>=', Carbon::now())
            ->orderBy('user_connections.updated_at', 'desc')
            ->paginate(10);
        $total_dashbrd_jobs = count($allUsersJobs);

        return view('user.provider.dashboard', compact('allUsersJobs', 'total_dashbrd_jobs', 'suspendedProfiles'));
    }

    public function getNewJobNotification(Request $request)
    {
        if ($request->ajax()) {
            $suspendedProfiles = Profile_Posts::with('profilecat')
                ->where('provider_id', Auth::user()->id)
                ->where('status', 0)
                ->get();
            $allUsersJobs = User_Connections::select(
                'user_connections.provider_id',
                'user_connections.id as conid',
                'user_connections.job_userid',
                'user_connections.jobappliedid',
                'user_connections.providerprofileid',
                'user_connections.profilecategoryid',
                'user_connections.requested_by',
                'user_connections.fullconnect',
                'users.id',
                'users.name',
                'users.last_name',
                'users.profile_picture',
                'job_posts.id as jobid',
                'job_posts.created_at',
                'job_posts.jobtitle',
                'job_posts.profile_category_id',
                'job_posts.deleted_at',
                'job_posts.adstatus',
                'profile_posts.id',
                'profile_posts.status',
            )
                // ->leftJoin('users', 'user_connections.provider_id', '=', 'users.id')
                ->leftJoin('users', 'user_connections.job_userid', '=', 'users.id')
                ->leftJoin('job_posts', 'user_connections.jobappliedid', '=', 'job_posts.id')
                ->leftJoin('profile_posts', 'user_connections.providerprofileid', '=', 'profile_posts.id')
                ->where('user_connections.provider_id', Auth::user()->id)
                ->where('user_connections.jobconnect', 1)
                ->where('user_connections.report', 0)
                ->whereNull('job_posts.deleted_at')
                ->whereDate('job_posts.expirydt', '>=', Carbon::now())
                ->orderBy('user_connections.updated_at', 'desc')
                ->paginate(10);
            $total_dashbrd_jobs = count($allUsersJobs);

            $html = view('partials.job_notification_provider', compact('allUsersJobs', 'total_dashbrd_jobs', 'suspendedProfiles'))->render();

            return response()->json(['html' => $html]);

        }
    }

    public function manageProfile()
    {
        $this->basic_detail['profile_picture'] = Storage::url(Auth::user()->profile_picture);

        $user_language = User_Language::where('user_id', Auth::user()->id)->get()->toArray();
        //dd($user_language[0]['language_name']);exit;
        $getLanguageArr = $getLevelArr = $getIdsArr = [];
        $totSelectedLanguage = count($user_language);

        $compactDataLang = $compactDataLevel = $compactDataIds = '0';
        if ($totSelectedLanguage > 0) {
            for ($y = 0; $y < $totSelectedLanguage; $y++) {
                $getIdsArr[] = $user_language[$y]['id'];
                $getLanguageArr[] = $user_language[$y]['language_name'];
                $getLevelArr[] = $user_language[$y]['language_level'];
            }

            $compactDataLang = (isset($getLanguageArr)) ? implode(',', $getLanguageArr) : '';
            $compactDataLevel = (isset($getLevelArr)) ? implode(',', $getLevelArr) : '';
            $compactDataIds = (isset($getLevelArr)) ? implode(',', $getIdsArr) : '';
        }

        $pass_languages = $this->basic_detail['language_supported'];
        // Check if the user has just submitted the form
        $showIntroJS = session('submittedProfileForm', false);

        // Clear the session variable so the IntroJS doesn't show again on refresh
        session()->forget('submittedProfileForm');

        return view('user.provider.manage-profile', $this->basic_detail, compact('compactDataLang', 'compactDataLevel', 'compactDataIds', 'pass_languages', 'showIntroJS'));
    }

    public function manageDocuments()
    {
        $user_language = User_Language::where('user_id', Auth::user()->id)->get()->toArray();
        $getLanguageArr = $getLevelArr = $getIdsArr = [];
        $totSelectedLanguage = count($user_language);

        $compactDataLang = $compactDataLevel = $compactDataIds = '0';
        if ($totSelectedLanguage > 0) {
            for ($y = 0; $y < $totSelectedLanguage; $y++) {
                $getIdsArr[] = $user_language[$y]['id'];
                $getLanguageArr[] = $user_language[$y]['language_name'];
                $getLevelArr[] = $user_language[$y]['language_level'];
            }

            $compactDataLang = (isset($getLanguageArr)) ? implode(',', $getLanguageArr) : '';
            $compactDataLevel = (isset($getLevelArr)) ? implode(',', $getLevelArr) : '';
            $compactDataIds = (isset($getLevelArr)) ? implode(',', $getIdsArr) : '';
        }

        $pass_languages = $this->basic_detail['language_supported'];

        $documents = Document::where('provider_id', Auth::user()->id)->get();

        return view('user.provider.manage-documents', $this->basic_detail, compact('documents', 'compactDataLang', 'compactDataLevel', 'compactDataIds', 'pass_languages'));
    }

    public function addDocument(Request $request)
    {
        $request->validate([
            'document_name' => 'required',
            'document' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:5120',
        ]);

        if ($request->hasFile('document')) {
            $path_document = $request->file('document')->store('provider_document', 'public');
        }

        Document::create([
            'provider_id' => Auth::user()->id,
            'document_name' => $request->document_name,
            'document_url' => $path_document,
        ]);

        return redirect('/provider/manage-documents')->with('success', 'Document Added Successfully!');
    }

    public function manageAccount()
    {
        return view('user.provider.manage-account');
    }

    public function getVerified()
    {
        $currentVerified = GetVerified::where('provider_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        $totalVerified = 1;
        if (!$currentVerified) {
            $totalVerified = 0;
        }

        return view('user.provider.get-verified', compact('currentVerified', 'totalVerified'));
    }

    public function verified()
    {
        return back()->with('success', 'Documents sent to Admin for verification.');
    }

    public function searchJobs(Request $request)
    {
        if (Auth::check() && Auth::user()->type == 'admin') {
            abort(404);
        }
        $totalJobPost = 0;
        if (Auth::check() && Auth::user()->type == 'service_seeker') {
            $user_type = (Auth::user()->client_type == 'Business') ? '/user/client' : '/user/client';
            abort(404);
            // return redirect($user_type.'/dashboard')->with('warning', 'You do not have access');
        }

        if (Auth::check() && Auth::user()->type == 'service_provider') {
            $jobPosts = Job_Posts::with('profilecategory', 'userdetails')
            ->with(['applied'=> function ($query) {
                $query->where('provider_id', Auth::user()->id);
            }])
            ->whereDate('expirydt', '>=', Carbon::now()->toDateString())
            ->where('adstatus', '1')
            ->where('profile_category_id', '1')
            ->orderBy('id', 'desc')
            ->paginate(10);
        } else {
            $jobPosts = Job_Posts::with('profilecategory', 'userdetails')
            ->whereDate('expirydt', '>=', Carbon::now()->toDateString())
            ->where('adstatus', '1')
            ->where('selected', '1')

            //->where('profile_category_id', '1')
            ->orderBy('id', 'desc')
                ->take(10)
            ->paginate(10);
        }

        $totalJobPost = count($jobPosts);

        return View('website.search-jobs', $this->basic_detail, compact('jobPosts', 'totalJobPost'));
    }

    public function searchjobsbyajax(Request $request)
    {
        $page = $request->get('page');
        $profileId = $request->get('profile');
        $userType = $request->get('usertype');
        $duration = $request->get('duration');
        $jobType = $request->get('jobtypes');
        $jobPosition = $request->get('job_position');
        $country = $request->get('country');
        $city = $request->get('city');
        $postalCode = $request->get('postalCode');
        if (is_string($jobType)) {
            $jobType = explode(',', $jobType);
        }
        $jobTypeArr = (isset($jobType) && (count($jobType) > 0)) ? $jobType : '';

        if (Auth::check()) {
            $jobQuery = Job_Posts::with(['applied'=> function ($query) {
                $query->where('provider_id', Auth::user()->id);
            }])
            ->where('adstatus', '1')
            ->where('publish', '1')
            ->whereDate('expirydt', '>=', Carbon::now()->toDateString());
        } else {
            $jobQuery = Job_Posts::where('adstatus', '1')
            ->where('publish', '1')
            ->whereDate('expirydt', '>=', Carbon::now()->toDateString());
        }


        $jobPosts = $jobQuery->where(function ($query) use ($profileId, $userType, $duration, $jobTypeArr, $jobPosition, $country, $city, $postalCode) {

            if (!Auth::check()) {
                $query->where('selected', 1);
            }
            if ($profileId != '') {
                $query->where('profile_category_id', $profileId);
            }



            if ($userType == '1') {
                $query->Where('usertype', '=', 'Private');
            }
            if ($userType == '2') {
                $query->Where('usertype', '=', 'Business');
            }
            if ($duration == '1') {
                $query->Where('jobduration', '=', 'Permanent');
            }
            if ($duration == '2') {
                $query->Where('jobduration', '=', 'Temporary');
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
                $query->WhereRaw("( ".$rawQuery." ) ", $jobTypeArr);
            }

            if ($jobPosition != '') {
                $query->where('job_position', $jobPosition);
            }

            if ($country != '') {
                $query->where('country', $country);
            }

            if ($city != '') {
                $query->where('city', 'like', '%' . $city . '%');
            }

            if ($postalCode != '') {
                $query->where('postalcode', $postalCode);
            }
        })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalJobPost = count($jobPosts);
        return view('website.ajaxsearchjobs', compact('jobPosts', 'totalJobPost'));
    }

    public function getjobdetails(Request $request)
    {
        if ($request->ajax()) {
            $jobid = $request->jobid;
            $conid = $request->conid;
            $fullconnect = $request->fullconnect;

            $jposts = job_posts::where('id', $jobid)->with('userdetails')->first();
            $jposts->view_count++;
            $jposts->save();

            //jobtype
            $all_jobtypes = [];
            $all_jtypes = $this->getValuesForIds('jobtypes', $jposts->jobtypes);

            //work with
            $all_workwith = [];
            $all_workwith = $this->getValuesForIds('workwith', $jposts->workwith);

            //experience - work skills
            $all_work_skills = [];
            $all_work_skills = $this->getValuesForIds('position', $jposts->position);

            //req_language
            $rlang = $jposts->req_language;
            $reqlang = explode(',', $rlang);

            $provider_id = Auth::user()->id;
            $seeker_id = $jposts->user_id;

            //Additional Languages
            $preferredLanguages = ($jposts->pref_language != '') ? explode(',', $jposts->pref_language) : '';
            $preferredLanguages = explode(',', $jposts->pref_language);

            $documents = Document::where('provider_id', Auth::user()->id)->get();
            $user_docs = DocumentUser::where('provider_id', Auth::user()->id)->where('seeker_id', $seeker_id)->get();


            $documents_count = Document::where('provider_id', $provider_id)->count();

            $doc_access_data = DocumentUser::where('provider_id', $provider_id)
                ->where('provider_id', Auth::user()->id)
                ->where('seeker_id', $seeker_id)
                ->where('is_requested', 1)
                ->get();

            $doc_access_ids = $doc_access_data->pluck('document_id');

            foreach ($documents as $document) {
                foreach ($user_docs as $ud) {
                    if ($ud->document_id == $document->id) {
                        $document['granted'] = 1;
                    }
                }
            }

            $html = view('user.provider.viewjob', compact('provider_id','seeker_id','doc_access_data','user_docs','conid', 'jposts', 'all_workwith', 'all_work_skills', 'all_jtypes', 'reqlang', 'preferredLanguages', 'fullconnect', 'documents'))->render();

            return Response::json(['success' => '1', 'html' => $html]);
        }
    }

    public function getSearchSidebar(Request $request)
    {
        if ($request->currpopup) {
            $currpopup = $request->currpopup;
            $jposts = job_posts::where('id', $currpopup)->with('userdetails')->first();
            $jposts->view_count++;
            $jposts->save();
            //jobtype
            $all_jobtypes = [];
            $all_jtypes = $this->getValuesForIds('jobtypes', $jposts->jobtypes);

            //work with
            $all_workwith = [];
            $all_workwith = $this->getValuesForIds('workwith', $jposts->workwith);

            //experience - work skills
            $all_work_skills = [];
            $all_work_skills = $this->getValuesForIds('position', $jposts->position);

            //req_language
            $rlang = $jposts->req_language;
            $reqlang = explode(',', $rlang);


            //Check for matching jobs by cateogry:-
            $alluserjobpost =  Auth::user() ? $this->getAllUser_ProfilePost() : ['totaljobpost' => 0];
            $totaljobpost =  $alluserjobpost['totaljobpost'];
            if ($totaljobpost != 0) {
                $postedcategory = $alluserjobpost['postedcategory'];
                $categoryname = $alluserjobpost['categoryname'];
                $jobmainids = $alluserjobpost['jobmainids'];
            }



            $datajobs['totmatch'] = 0;
            $showconnect['buttonData'] = strtolower(str_replace(' ', '-', $jposts['profilecategory']['categoryname']));
            if ($totaljobpost > 0) {
                if (in_array($jposts['profile_category_id'], $postedcategory)) {
                    $datajobs['totmatch'] = 1;
                    $keytest = array_search($jposts['profile_category_id'], $postedcategory);

                    $providerid =  Auth::user() ? Auth::user()->id : 0;
                    $profilecategoryid = $postedcategory;
                    $datajobs['jobuserid'] = $jposts['user_id'];
                    $datajobs['jobappliedid'] = $jposts['id'];
                    $datajobs['providerprofileid'] = $jobmainids[$keytest];
                    $datajobs['categoryid'] = $postedcategory[$keytest];

                    //Check if the user has already applied:
                    $chk_user_connect = User_Connections::withTrashed()
                    ->where([
                        'jobappliedid' => $jposts['id'],
                        'profilecategoryid' => $jposts['profile_category_id'],
                        'providerprofileid' => $jobmainids[$keytest]
                    ])->get();

                    if ((isset($chk_user_connect)) && (count($chk_user_connect)) > 0) {
                        $showconnect['buttonID'] = "messageTab";
                        // $showconnect['Message'] = "MESSAGE NOW";
                        $showconnect['Message'] = "ALREADY APPLIED";
                    } else {
                        $showconnect['buttonID'] = "jobapplybtn";
                        $showconnect['Message'] = "APPLY NOW";
                    }
                } else {
                    $showconnect['buttonID'] = "goToProfile";
                    $showconnect['Message'] = "CREATE ". strtoupper($jposts['profilecategory']['categoryname']) ." PROFILE TO APPLY";
                }
            } else {
                $showconnect['buttonID'] = "goToProfile";
                $showconnect['Message'] = "CREATE ". strtoupper($jposts['profilecategory']['categoryname']) ." PROFILE TO APPLY";
            }

            if (Auth::user() == null) {
                $showconnect['buttonID'] = "goLogin";
                $showconnect['Message'] = "LOGIN TO APPLY";
            }

            $html = view('user.provider.searchsidebar', compact('jposts', 'all_workwith', 'all_work_skills', 'all_jtypes', 'reqlang', 'showconnect', 'datajobs'))->render();

            return Response::json(['success' => '1', 'html' => $html]);
        }
    }

    public function update_user_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'nationality' => 'required',
            'native_language' => 'required',
            /*'birth_date' => 'required',*/
            'phone_code' => 'required',
            'phone' => 'required',
            'country' => 'required',
            /*'city' => 'required',*/
            'landmark' => 'required',
        ]);
        $data = $request->All();

        $name = (isset($data['name'])) ? $data['name'] : '';
        $last_name = (isset($data['last_name'])) ? $data['last_name'] : '';
        $phone_code = (isset($data['phone_code'])) ? $data['phone_code'] : '';
        $phone = (isset($data['phone'])) ? $data['phone'] : '';
        $secondary_notifications = (isset($data['secondary_notifications'])) ? 1 : 0;
        $privacy = (isset($data['privacy'])) ? 1 : 0;
        $marketing = (isset($data['marketing'])) ? 1 : 0;
        $country = (isset($data['country'])) ? $data['country'] : '';
        $city = (isset($data['city'])) ? $data['city'] : '';
        $ukcity = (isset($data['ukcity'])) ? $data['ukcity'] : '';
        $postal_code = (isset($data['postal_code'])) ? $data['postal_code'] : '';

        if ($country != "United Kingdom") {
            $city = $city;
            $postal_code = '';
        } else {
            $city = $ukcity;
        }

        $landmark = (isset($data['landmark'])) ? $data['landmark'] : '';
        $nationality = (isset($data['nationality'])) ? $data['nationality'] : '';
        $native_language = (isset($data['native_language'])) ? $data['native_language'] : '';

        $dobday = (isset($data['dobday'])) ? $data['dobday'] : '';
        $dobmonth = (isset($data['dobmonth'])) ? $data['dobmonth'] : '';
        $dobyear = (isset($data['dobyear'])) ? $data['dobyear'] : '';
        $fullbday = $dobyear . "-" . $dobmonth . "-" . $dobday;

        $address = (isset($data['address'])) ? $data['address'] : '';
        $other_language = (isset($data['other_language'])) ? $data['other_language'] : '';
        $langlevel = (isset($data['langlevel'])) ? $data['langlevel'] : '';

        $totlang = 0;
        if ($other_language != '') {
            $totlang = count($other_language);
        }

        $setlang = $setlevel = '';
        if ($totlang > 0) {
            User_Language::where('user_id', Auth::user()->id)->delete();

            for ($i = 0; $i < $totlang; $i++) {
                if ($other_language[$i] != '' && $langlevel[$i] != '') {
                    //Insert:
                    $insertProfile = User_Language::create([
                        'user_id' => Auth::user()->id,
                        'language_name' => $other_language[$i],
                        'language_level' => $langlevel[$i],
                    ]);
                }
            }
        }

        User::where('id', Auth::user()->id)->update([
            'name' => $name,
            'last_name' => $last_name,
            'phone_code' => $phone_code,
            'phone' => $phone,
            'secondary_notifications' => $secondary_notifications,
            'privacy' => $privacy,
            'marketing' => $marketing,
            'nationality' => $nationality,
            'native_language' => $native_language,
            'birth_date' => $fullbday,
            'country' => $country,
            'city' => $city,
            'postal_code' => $postal_code,
            'landmark' => $landmark,
            'address' => $address,
        ]);
        session(['submittedProfileForm' => true]);
        return back()->with('success', 'Profile has been saved.');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required',
        ]);
        $data = $request->All();

        if (Hash::check($data['old_password'], Auth::user()->password)) {
            if ($data['confirm_password'] == $data['new_password']) {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($data['new_password'])]);
                return back()->with('success', 'Password has been updated.');
            }
        }
        return back()->with('warning', 'something went wrong.');
    }

    public function update_profile_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'mimes:jpeg,jpg,png,gif,svg|required' //|max:10000 = max 10000kb
        ]);
        $data = $request->All();

        $path = $request->file('profile_picture')->store('profile_picture', 'public');
        User::where('id', Auth::user()->id)->update(['profile_picture' => $path]);
        return back()->with('success', 'Picture has been uploaded.');
    }

    public function videoIntro()
    {
        $currentVideoId = Videointros::where('provider_id', Auth::user()->id)->get();
        $totVideoUploaded = 1;
        if (!$currentVideoId) {
            $totVideoUploaded = 0;
        }

        return view('user.provider.video-intro', compact('currentVideoId', 'totVideoUploaded'));
    }

    public function serviceProfiles()
    {
        $user_profiles = Profile_Posts::with('profilecat')->where('provider_id', Auth::user()->id)->get();
        $profile_ids = [];

        foreach ($user_profiles as $profile) {
            array_push($profile_ids, $profile->profilecat->id);
        }

        return view('user.provider.service-profiles', $this->profile_categories, compact('profile_ids', 'user_profiles'));
    }

    public function deleteProfile(Request $request, $id)
    {
        $profile_post = Profile_Posts::find($id);
        $profile_post->delete();
        return redirect('/provider/service-profiles')->with('success', 'Profile deleted Successfully!');
    }

    public function deleteDocument(Request $request, $id)
{
    $document = Document::find($id);

    if ($document) {
        DocumentUser::where('document_id', $id)->delete();

        if (file_exists(storage_path('app/public/' . $document->document_url))) {
            unlink(storage_path('app/public/' . $document->document_url));
        }

        $document->delete();

        return redirect('/provider/manage-documents')->with('success', 'Document deleted Successfully!');
    }

    return redirect('/provider/manage-documents')->with('error', 'Document not found!');
}
    public function giveAccess(Request $request)
    {
        $job_id = $request->job_id;
        $doc_id = $request->doc_id;
        $referenceId = $request->connId;

        //Check if document has already permission
        $documentUser = DocumentUser::where('provider_id', Auth::user()->id)
                    ->where('seeker_id', $job_id)
                    ->where('document_id', $doc_id)->first();

        if (!$documentUser) {
            $documentUser = DocumentUser::create([
                'provider_id' => Auth::user()->id,
                'seeker_id' => $job_id,
                'document_id' => $doc_id,
                'is_access_granted' => true,
                'is_access_blocked' => false
            ]);

            return Response::json(['success' => '1', 'message' => 'Permission granted']);
        }

        $messageData = $this->renderDocumentRequestCard($documentUser,$referenceId);

        Chatify::push('private-chatify', 'messaging', [
            'from_id' => Auth::user()->id,
            'to_id' => $documentUser->job_id,
            'reference_id' => $referenceId,
            'message' => Chatify::messageCard($messageData, 'request')
        ]);

        return Response::json(['success' => '1', 'message' => 'Permission already granted']);
    }

    public function getProfile($profileCategoryId)
    {
        if ($profileCategoryId != '') {
            $currarray = $data['curr_profile'] = Profile_Posts::select(
                'provider_id',
                'profile_category_id',
                'job_duration',
                'currency',
                'payamount',
                'payfrequency',
                'jobtypes',
                'experience1',
                'experience2',
                'workwith',
                'worksector',
                'carvalue',
                'licensevalue',
                'qualificationsvalue',
                'recordvalue',
                'aidvalue',
                'refvalue',
                'edu_description',
                'status',
                'suspendBy'
            )
                ->where('provider_id', Auth::user()->id)
                ->where('profile_category_id', $profileCategoryId)
                ->first();

            $work = (isset($currarray['workwith'])) ? $currarray['workwith'] : '';
            if ($work != '') {
                $setWorkwith = explode(",", $work);
                $data['work_with'] = $setWorkwith;
            }

            $jobType = (isset($currarray['jobtypes'])) ? $currarray['jobtypes'] : '';
            if ($jobType != '') {
                $setJobType = explode(",", $jobType);
                $data['job_type'] = $setJobType;
            }

            $experiences = (isset($currarray['experience1'])) ? $currarray['experience1'] : '';
            if ($experiences != '') {
                $set_exp = explode(",", $experiences);
                $data['exp'] = $set_exp;
            }

            $jobDurations = (isset($currarray['job_duration'])) ? $currarray['job_duration'] : '';
            if ($jobDurations != '') {
                $setJobDuration = explode(",", $jobDurations);
                $data['job_duration'] = $setJobDuration;
            }

            return $data;
        }
    }

    public function profilepost($profile_cat_id, $request)
    {
        if ($profile_cat_id != '') {
            $data = $request->All();

            $currency = (isset($data['currency'])) ? $data['currency'] : '';
            $payamount = (isset($data['payamount'])) ? $data['payamount'] : '';
            $experience2 = (isset($data['experience2'])) ? $data['experience2'] : '';
            $frequency = (isset($data['frequency'])) ? $data['frequency'] : '';
            $carvalue = (isset($data['carRadio'])) ? $data['carRadio'] : '';
            $licensevalue = (isset($data['licenseRadio'])) ? $data['licenseRadio'] : '';

            $qualificationsvalue = (isset($data['qualiRadio'])) ? $data['qualiRadio'] : '';

            $recordvalue = (isset($data['recordRadio'])) ? $data['recordRadio'] : '';

            $aidvalue = (isset($data['aidRadio'])) ? $data['aidRadio'] : '';

            $refvalue = (isset($data['refRadio'])) ? $data['refRadio'] : '';

            $edu_details = (isset($data['edu_details'])) ? $data['edu_details'] : '';

            $workwith = $jobtype_opt = $exp_opt = $sector_opt = '';

            //Work with
            $options_outlined = (isset($data['options_outlined'])) ? $data['options_outlined'] : '';
            if ($options_outlined != '') {
                $workwith = implode(',', $options_outlined);
            }

            //Job type
            $options_jobtype = (isset($data['options_jobtype'])) ? $data['options_jobtype'] : '';
            if ($options_jobtype != '') {
                $jobtype_opt = implode(',', $options_jobtype);
            }

            //Experiece
            $options_exp = (isset($data['options_exp'])) ? $data['options_exp'] : '';
            if ($options_exp != '') {
                $exp_opt = implode(',', $options_exp);
            }

            //Work Sector
            $options_sector = (isset($data['duration'])) ? $data['duration'] : '';

            if ($options_sector != '') {
                $duration = implode(',', $options_sector);
            }

            $cnt = 0;
            $queryProfile = Profile_Posts::where('provider_id', Auth::user()->id)
                ->where('profile_category_id', $profile_cat_id)->get();
            $cnt = $queryProfile->count();


            if ($cnt > 0) { //If record found then update:
                //update record :
                Profile_Posts::where('provider_id', Auth::user()->id)
                    ->where('profile_category_id', $profile_cat_id)
                    ->update([
                        'provider_id' => Auth::user()->id,
                        'slug' => $this->slug->createSlug('profile', Auth::user()->name),
                        'profile_category_id' => $profile_cat_id,
                        'job_duration' => $duration,
                        'currency' => $currency,
                        'payamount' => $payamount,
                        'payfrequency' => $frequency,
                        'jobtypes' => $jobtype_opt,
                        'experience1' => $exp_opt,
                        'experience2' => $experience2,
                        'workwith' => $workwith,
                        'worksector' => $sector_opt,
                        'carvalue' => $carvalue,
                        'licensevalue' => $licensevalue,
                        'qualificationsvalue' => $qualificationsvalue,
                        'recordvalue' => $recordvalue,
                        'aidvalue' => $aidvalue,
                        'refvalue' => $refvalue,
                        'edu_description' => $edu_details,
                    ]);
            } else { //Insert record & get last inserted ID:
                $insertProfile = Profile_Posts::create([
                    'provider_id' => Auth::user()->id,
                    'slug' => $this->slug->createSlug('profile', Auth::user()->name),
                    'profile_category_id' => $profile_cat_id,
                    'job_duration' => $duration,
                    'currency' => $currency,
                    'payamount' => $payamount,
                    'payfrequency' => $frequency,
                    'jobtypes' => $jobtype_opt,
                    'experience1' => $exp_opt,
                    'experience2' => $experience2,
                    'workwith' => $workwith,
                    'worksector' => $sector_opt,
                    'carvalue' => $carvalue,
                    'licensevalue' => $licensevalue,
                    'qualificationsvalue' => $qualificationsvalue,
                    'recordvalue' => $recordvalue,
                    'aidvalue' => $aidvalue,
                    'refvalue' => $refvalue,
                    'edu_description' => $edu_details,
                ]);
            }
        }
    }

    public function nanny()
    {
        $currprofile = $this->getProfile('1');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '1')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '1')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '1')->get();

        return view('user.provider.service-profiles.nanny', $this->basic_detail, compact('currprofile'));
    }

    public function maternityNurse()
    {
        $currprofile = $this->getProfile('2');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '2')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '2')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '2')->get();
        //       dd($currprofile['curr_profile']['payfrequency']);exit;

        return view('user.provider.service-profiles.maternity-nurse', $this->basic_detail, compact('currprofile'));
    }

    public function carer()
    {
        $currprofile = $this->getProfile('3');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '3')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '3')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '3')->get();
        return view('user.provider.service-profiles.carer', $this->basic_detail, compact('currprofile'));
    }

    public function petCarer()
    {
        $currprofile = $this->getProfile('4');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '4')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '4')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '4')->get();

        return view('user.provider.service-profiles.pet-carer', $this->basic_detail, compact('currprofile'));
    }

    public function cleaner()
    {
        $currprofile = $this->getProfile('5');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '5')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '5')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '5')->get();

        return view('user.provider.service-profiles.cleaner', $this->basic_detail, compact('currprofile'));
    }

    public function housekeeper()
    {
        $currprofile = $this->getProfile('6');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '6')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '6')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '6')->get();


        return view('user.provider.service-profiles.housekeeper', $this->basic_detail, compact('currprofile'));
    }

    public function tutor()
    {
        $currprofile = $this->getProfile('7');
        $this->basic_detail['specialities'] = specialities::where('profile_category_id', '7')->get();
        $this->basic_detail['jtypes'] = job_types::where('profile_id', '7')->get();
        $this->basic_detail['experiences'] = experiences::where('profile_category_id', '7')->get();

        return view('user.provider.service-profiles.tutor', $this->basic_detail, compact('currprofile'));
    }

    public function addProfiles(Request $request)
    {
        $request->validate(
            [
            'duration' => 'required',
            'currency' => 'required',
            'payamount' => 'required',
            'frequency' => 'required',
            'experience2' => 'required',
            'options_outlined' => 'required',
            'options_jobtype' => 'required',
            /* 'options_exp'  => 'required',*/
            /* 'options_sector'  => 'required', */
            /*'carvalue' => 'required',*/
            /*'licensevalue' => 'required|in:0,1',
            'qualificationsvalue' => 'required',
            'recordvalue' => 'required',
            'aidvalue' => 'required',
            'refvalue' => 'required',*/
            'edu_details' => 'required',
        ],
            [
                'duration.required' => 'Job duration field is required',
                'experience2.required' => 'Experience field is required',
                'options_outlined.required' => 'Select atleast one With work',
                'options_jobtype.required' => 'Select atleast one Job type',
                /*'options_exp.required'=> 'Select atleast one Experience',   */
                //   'options_sector.required'=> 'Select atleast one Work sector',
                /*'carvalue.required'=> 'Please select have you own car',
                'licensevalue.required'=> 'Please select you have drivers license',
                'qualificationsvalue.required'=> 'Please select a certified qualifications for this position',
                'recordvalue.required'=> 'Please select have you a criminal record check',
                'aidvalue.required'=> 'Please select you have First Aid',
                'refvalue.required'=> 'Please select you have references',  */
                'edu_details.required' => 'Education and work experience field is required',
            ]
        );

        $profileid = $request->hid_profileval;
        $this->profilepost($profileid, $request);

        if ($profileid == 1) {
            return back()->with(['success' => 'Nanny Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 2) {
            return back()->with(['success' => 'Maternity Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 3) {
            return back()->with(['success' => 'Carer Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 4) {
            return back()->with(['success' => 'Pet Carer Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 5) {
            return back()->with(['success' => 'Cleaner Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 6) {
            return back()->with(['success' => 'Housekeeper Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        } elseif ($profileid == 7) {
            return back()->with(['success' => 'Tutor Profile has been saved.', 'profileid' => $profileid,'saved'=>true]);
        }
    }

    public function addGetVerified(Request $request)
    {
        $request->validate([
            'identification_type' => 'required',
            'proof' => 'required|mimes:png,jpg,jpeg,gif,pdf',
            //'reference' => 'required|mimes:png,jpg,jpeg,gif,pdf'
        ]);

        $proof_file = $ref_file = '';
        $identification_type = (isset($request->identification_type)) ? $request->identification_type : '';
        $reference_text = (isset($request->reference_text)) ? $request->reference_text : '';
        $advchk = (isset($request->advchk)) ? 1 : 0;
        $reference_detail = (isset($request->reference_detail)) ? $request->reference_detail : '';

        if ($request->hasFile('proof')) {
            $path_proof = $request->file('proof')->store('proof_verify', 'public');
        }

        $path_reference = '';
        if ($request->hasFile('reference')) {
            $path_reference = $request->file('reference')->store('reference_verify', 'public');
        }

        $insertProfile = GetVerified::create(
            [
                'provider_id' => Auth::user()->id,
                'identification_type' => $identification_type,
                'identification_doc' => $path_proof,
                'adv_check' => $advchk,
                'reference_doc' => $path_reference,
                'reference_text' => $reference_text,
            ]
        );


        //Send mail to provider regarding verification request:
        EmailHelper::verificationRequestMailToProvider();

        //Send mail to admin regarding verificaiton:---------------------------
        //*****************************************************************************
        //Admin email:
        $sendMailTo =  Config::get('kinderway.emailOptions.adminEmail');


        //Message
        $data = ['mailMessage'=>"You have New Provider requesting Verification Check"];

        Mail::to($sendMailTo)->send(new MailGetVerified($data));

        //-------------------------------------------Email End-----------------------------------

        return redirect('/provider/get-verified')->with('success', 'Verification Document sent to Admin Successfully!');
    }

    public function deleteOtherLanguage(Request $request)
    {
        $deleteid = $request->deleteid;
        if ($deleteid != '') {
            $getlangname = User_Language::where('id', $deleteid)->first();
            $langname = $getlangname['language_name'];

            User_Language::where('id', $deleteid)->delete();

            $allDataCount = User_Language::where('user_id', Auth::user()->id)->count();
            $remainingTot = 6 - $allDataCount;
            //$remainingTot = 5;

            return Response::json(['success' => '1', 'remainingTot' => $remainingTot, 'pushlanguage' => $langname, 'message' => "Other language deleted"]);
        } else {
            return Response::json(['success' => '0', 'message' => "Other language not deleted"]);
        }
    }

    public function getValuesForIds($modelvalue, $dbvalue)
    {
        $arr = [];
        $all_exp = explode(',', $dbvalue);
        for ($i = 0; $i < count($all_exp); $i++) {
            if ($modelvalue == 'workwith') {
                $temp = Specialities::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['name'];
            } elseif ($modelvalue == 'position') {
                $temp = Experiences::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['exp_name'];
            } elseif ($modelvalue == 'jobtypes') {
                $temp = Job_Types::where('id', $all_exp[$i])->first();
                $temparr = $temp->toArray();
                $arr[] = $temparr['jobtype'];
            }
        }

        return $arr;
    }

    public function getAllUser_ProfilePost()
    {
        $allposts = Profile_Posts::with('profilecat', 'userdetails')
            ->where('provider_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $totaljobpost = $allposts->count();

        if ($totaljobpost > 0) {
            $postedjobs = $allposts->toArray();

            for ($i = 0; $i < $totaljobpost; $i++) {
                $postedcategory[] = $postedjobs[$i]['profile_category_id'];
                $categoryname[] = $postedjobs[$i]['profilecat']['categoryname'];
                $jobmainids[] = $postedjobs[$i]['id'];
            }
            $data['totaljobpost'] = $totaljobpost;
            $data['postedcategory'] = $postedcategory;
            $data['categoryname'] = $categoryname;
            $data['jobmainids'] = $jobmainids;
        } else {
            $data['totaljobpost'] = 0;
        }

        return $data;
    }

    public function getAllJobtype(Request $request)
    {
        $profileid = $request->profileid;
        $jtypes = job_types::where('profile_id', $profileid)->get();
        $html = view('user.provider.jobtypeslist', compact('jtypes'))->render();

        return Response::json(['success' => '1', 'html' => $html]);
    }

    public function addvideointro(Request $request)
    {
        $request->validate([
            'video_file' => 'required|mimes:ogg,ogv,avi,mpeg,mov,wmv,flv,mp4'
        ]);

        // $video_file = '';
        if ($request->hasFile('video_file')) {
            $fileMimeType = $request->file('video_file')->getMimeType();
            $path_video = $request->file('video_file')->store('providervideo', 'public');
        }

        $video_exists = Videointros::where('provider_id', Auth::user()->id)->first();

        if ($video_exists) {
            Videointros::where('provider_id', Auth::user()->id)->update(
                [
                    'filetype' => $fileMimeType,
                    'videofile' => $path_video,
                ]
            );
        } else {
            Videointros::create(
                [
                    'provider_id' => Auth::user()->id,
                    'filetype' => $fileMimeType,
                    'videofile' => $path_video,
                ]
            );
        }

        return redirect('/provider/video-intro')->with('success', 'Video Introduction Added Successfully!');
    }

    public function set_provider_connection(Request $request)
    {
        $jobappliedid = $request->jobid;
        $profilecat = $request->profilecat;
        $jobuserid = $request->jobuserid;
        $profileid = $request->profileid;

        $insertProfile = User_Connections::create([
            'job_userid' => $jobuserid,
            'provider_id' => Auth::user()->id,
            'jobappliedid' => $jobappliedid,
            'providerprofileid' => $profileid,
            'profilecategoryid' => $profilecat,
            'clienttype' => Auth::user()->client_type,
            'requested_by' => 'service_provider',
            'providerconnect' => '1',
            'jobconnect' => 0,
            'fullconnect' => 0
        ]);

        //Send mail to job poster regarding connection request:---------------------------
        //*****************************************************************************

        //Get job poster details:
        if ($jobappliedid != '') {
            $getJobPosterDetails = Job_Posts::with('userdetails')->where('id', $jobappliedid)->first();
            $getJobPosterDetails->touch();
            $sendMailTo = $getJobPosterDetails->userdetails['email'];
            $secondaryNotification = $getJobPosterDetails->userdetails['secondary_notifications'];
            // $jobPosterFullname = $getJobPosterDetails->userdetails['name']." ".$getJobPosterDetails->userdetails['last_name'];
            $jobPosterFullname = $getJobPosterDetails->userdetails['name'];
            $clientType = $getJobPosterDetails->userdetails['client_type'];
            $dashboardUrl = ($clientType == 'Business') ? 'user/client/dashboard' : 'user/client/dashboard';
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
        }

        //Message
        //Send mail if notification on:
        if ($secondaryNotification == 1) {
            $senddetails = [
                'jobPosterFullname' => $jobPosterFullname,
                // 'providerFullname' => Auth::user()->name.' '.Auth::user()->last_name,
                'providerFullname' => Auth::user()->name,
                'dashboardUrl' => $dashboardUrl,
                ];
            //TODO: remove it on staging
            Mail::to($sendMailTo)->send(new ProviderConnect($senddetails));

            // Mail::send('emails.provider-connect', $senddetails, function ($message) use ($sendMailTo)
            // {
            //     $message->to($sendMailTo)->subject('You have a new Job Application');
            // });
        }

        //-------------------------------------------Email End-----------------------------------


        return Response::json(['success' => '1', 'message' => 'You have applied! <br/>
        The job poster will contact you if they think you are suitable for this position. Messages regarding this job application will appear on your dashboard.']);
    }

    public function deleteconnection(Request $request)
    {
        if ($request->ajax()) {
            $connectid = $request->connectid;
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
            Message::where('reference_id', $connectid)->delete();
            User_Connections::Where('id', $connectid)->delete();

            return Response::json(['success' => '1', 'message' => 'Connection deleted successfully']);
        }
    }

    public function approveConnection(Request $request)
    {
        if ($request->ajax()) {

            $connectid = $request->connectid;

            $userConnection = User_Connections::find($connectid);
            $userConnection->providerconnect = 1;
            $userConnection->fullconnect = 1;
            $userConnection->save();

            $userConnection->job()->touch();

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

            $providerId = Auth::user()->id;
            $seekerId = $result->job_userid;

            $documents = Document::where('provider_id', $providerId)->get();
            $existingDocumentIds = DocumentUser::where('provider_id', $providerId)
                ->where('seeker_id', $seekerId)
                ->pluck('document_id')
                ->toArray();

            foreach ($documents as $document) {
                if (!in_array($document->id, $existingDocumentIds)) {
                    $documentuser = DocumentUser::create([
                        'provider_id' => $providerId,
                        'seeker_id' => $seekerId,
                        'document_id' => $document->id,
                        'is_access_granted' => false,
                        'is_access_blocked' => false,
                    ]);
                    dump($documentuser);

                }
            }

            //Send mail on approval:
            EmailHelper::approveConnectionMailFromProvider($connectid);

            return Response::json(['success' => '1', 'message' => 'Connection approved successfully']);
        }
    }

    public function reportConnection(Request $request)
    {
        $connection = User_Connections::Where('id', $request->userconnectionid)->first();
        if ($connection) {
            $connection->report = 1;
            $connection->report_reason = $request->reason;
            $connection->save();

            $jposts = job_posts::where('id', $connection->jobappliedid)->first();
            $jposts->report_count++;
            $jposts->save();
        } else {
            return back()->with('warning', 'Something goes wrong. Please try again.');
        }
        return back()->with('success', 'Connection reported successfully.');
    }

    public function grantAccess(Request $request)
    {
        $referenceId = $request->reference_id;

        $documentUser = DocumentUser::where('document_id', $request->document_id)
        ->where('provider_id', Auth::id())
        ->where('seeker_id', $request->seeker_id)
        ->firstOrFail();

        if ($documentUser->provider_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $documentUser->is_access_granted = true;
        $documentUser->is_access_blocked = false;
        $documentUser->is_requested = false;
        $documentUser->save();

        $messageData = $this->renderDocumentRequestCard($documentUser,$referenceId);

        $messageID = mt_rand(9, 999999999) + time();

        Chatify::newMessage([
            'id' => $messageID,
            'type' => 'service_seeker',
            'from_id' => Auth::user()->id,
            'to_id' => $request->seeker_id,
            'reference_id' => $referenceId,
            'body' => trim(htmlentities($request['message'])),
            'attachment' =>  null,
        ]);


        Chatify::push('private-chatify', 'messaging', [
            'from_id' => Auth::user()->id,
            'to_id' => $request->seeker_id,
            'reference_id' => $referenceId,
            'message' => Chatify::messageCard($messageData, 'request')
        ]);


        return response()->json(['success' => true, 'message' => 'Access granted successfully.']);
    }

    public function blockAccess(Request $request)
    {
        $documentUser = DocumentUser::where('document_id', $request->document_id)
        ->where('provider_id', Auth::id())
        ->where('seeker_id', $request->seeker_id)
        ->firstOrFail();

        if ($documentUser->provider_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $documentUser->is_access_blocked = true;
        $documentUser->is_access_granted = false;
        $documentUser->is_requested = false;
        $documentUser->save();

        return response()->json(['success' => true, 'message' => 'Access blocked successfully.']);
    }

    protected function renderDocumentRequestCard($request,$referenceId)
    {
        $messageID = mt_rand(9, 999999999) + time();
        $clientName = $request->provider->name;
        $documentName = $request->document->document_name;
        $seekerId = $request->seeker_id;
        $providerId = $request->provider_id;

        $phrase = $clientName . ' has given you access to <span>' . $documentName . ' .</span>';

        $htmlContent = '<div class="boxSentRequestClient">
                            <div class="textRequestClkient">' . $phrase . '</div>
                        </div>';

        return [
            'id' => $messageID,
            'referenceId' => $referenceId,
            'from_id' => $seekerId,
            'to_id' => $providerId,
            'message' => $htmlContent,
            'attachment' => [null, null, null],
            'time' => now()->diffForHumans(),
            'fullTime' => now(),
            'viewType' => 'sender',
            'seen' => 0,
        ];
    }
}
