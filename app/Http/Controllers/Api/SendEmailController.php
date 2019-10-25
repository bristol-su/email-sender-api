<?php

namespace App\Http\Controllers\Api;

use App\EmailAddress;
use App\Http\Controllers\Controller;
use App\Mail\DefaultMailable;
use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{

    public function store(Request $request, EmailAddress $emailAddress)
    {

        $content = $request->input('content');
        $subject = $request->input('subject');
        $users = $request->input('to', []);
        $ccUsers = $request->input('cc', []);
        $bccUsers = $request->input('bcc', []);
        $attachments = $request->input('attachments', []);
        Mail::to($users)
            ->cc($ccUsers)
            ->bcc($bccUsers)
            ->send(new DefaultMailable($emailAddress, $content, $subject, $attachments));
    }

}
