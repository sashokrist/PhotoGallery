<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsFormRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsFormController extends Controller
{
    public function createForm(Request $request)
    {
        return view('contact');
    }

    /**
     * @param ContactUsFormRequest $request
     * @return RedirectResponse
     */
    public function ContactUsForm(ContactUsFormRequest $request)
    {
        Contact::create($request->all());
        //  Send mail to admin
        Mail::send('mail', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'subject' => $request->get('subject'),
            'user_query' => $request->get('message'),
        ), function ($message) use ($request) {
            $message->from($request->email);
            $message->to('test@gmail.com', 'Admin')->subject($request->get('subject'));
        });

        return back()->with('success', 'Твоето съобщене беше изпратено успешно.');
    }
}
