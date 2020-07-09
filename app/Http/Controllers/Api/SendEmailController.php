<?php

namespace App\Http\Controllers\Api;

use App\EmailAddress;
use App\Http\Controllers\Controller;
use App\Mail\DefaultMailable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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


        $type = $request->input('type', 'url');

        $uploadedAttachments = [];
        foreach ($attachments as $attachment) {
            if (is_string($attachment) && $type === 'url') {
                $path = tempnam(sys_get_temp_dir(), 'EmailSender');
                file_put_contents($path, file_get_contents($attachment));
                $uploadedAttachments[] = new UploadedFile($path, basename($attachment), mime_content_type($path));
            } elseif(is_string($attachment) && $type === 'base64') {
                $path = tempnam(sys_get_temp_dir(), 'EmailSender');
                $file = fopen( $path, "wb" );
                fwrite( $file, base64_decode( $attachment ) );
                fclose( $file );
                $uploadedAttachments[] = new UploadedFile($path, basename($path), mime_content_type($path));
            } else {
                $uploadedAttachments[] = $attachment;
            }
        }

        Mail::to(array_filter($users, function ($user) {
            return $user !== null;
        }))
            ->cc(array_filter($ccUsers, function ($user) {
                return $user !== null;
            }))
            ->bcc(array_filter($bccUsers, function ($user) {
                return $user !== null;
            }))
            ->send(new DefaultMailable($emailAddress, $content, $subject, $uploadedAttachments));
    }

}
