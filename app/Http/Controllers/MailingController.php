<?php

namespace App\Http\Controllers;

use App\Models\Job_Posts;
use App\Models\MailingJob;
use App\Models\Profile_Posts;
use App\Models\Report;
use App\Models\ReportUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Response;

class MailingController extends Controller
{
    public function index(Request $request)
    {
        $list = MailingJob::orderBy('id', 'DESC')->get();

        return view('admin.mailing', compact('list'));
    }
}
