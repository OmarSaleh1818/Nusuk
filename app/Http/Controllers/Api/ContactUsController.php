<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Validator;

class ContactUsController extends Controller
{
    
    public function submit(Request $request)
    {

        // Prepare data for the email
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
        ];

        // Send email
        Mail::to('o.abdullah@ryadh.com.sa')->send(new ContactUsMail($data));

        return response()->json([
            'status' => true,
            'message' => 'Your message has been sent successfully!',
            'data' => $data
        ], 200);
    }



}
