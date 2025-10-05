<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactModel;




class PolicyController extends Controller
{

    public function contact(Request $request)
    {
        return view('policy.contact');
    }

    public function refund(Request $request)
    {
        return view('policy.refund');
    }


    public function cookie(Request $request)
    {
        return view('policy.cookie');
    }

    
    public function privacy(Request $request)
    {
        return view('policy.privacy');
    }

    
    public function terms(Request $request)
    {
        return view('policy.terms');
    }

    
    public function about(Request $request)
    {
        return view('policy.about');
    }

    

    public function storeContact(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        ContactModel::create($request->only('name', 'email', 'subject', 'message'));

        return redirect()->back()->with('success', 'Your message has been sent.');
    }








}
