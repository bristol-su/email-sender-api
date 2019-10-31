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
        Mail::to(array_filter($users, function($user){return $user === null;}))
            ->cc(array_filter($ccUsers, function($user){return $user === null;}))
            ->bcc(array_filter($bccUsers, function($user){return $user === null;}))
            ->send(new DefaultMailable($emailAddress, $content, $subject, $attachments));
    }

}
