<?php

namespace App\Http\Controllers;

use App\Models\Job_Posts;
use Illuminate\Mail\Markdown;

class EmailsController extends Controller
{
    public function adminAccountDelete()
    {
        $content['mailMessage'] = "Individual Account of user John is Deleted";
        $content['firstName'] = "John";
        $content['lastName'] = "Doe";
        $content['type'] = "Private";
        $content['email'] = "john@gmail.com";
        $markdown = new Markdown(view(), config('mail.markdown'));
        return $markdown->render('emails.admin-account-delete', compact('content'));
    }

    public function userAccountDelete()
    {
        $content['firstName'] = "John";
        $content['type'] = "Soft";
        $markdown = new Markdown(view(), config('mail.markdown'));
        return $markdown->render('emails.user-account-delete', compact('content'));
    }

    public function sendJobOffers()
    {
        $content = Job_Posts::whereIn('id', [44, 45])->get();
        $markdown = new Markdown(view(), config('mail.markdown'));
        return $markdown->render('emails.job-offers', compact('content'));
    }
}
