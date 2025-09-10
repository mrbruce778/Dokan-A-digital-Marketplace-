<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupport;

class CustomerServiceController extends Controller
{
    // This method must be INSIDE the class
    public function submitTicket(Request $request)
    {
        $request->validate([
            'issue_subject' => 'required|string|max:255',
            'issue_description' => 'required|string',
        ]);

        CustomerSupport::create([
            'issue_subject' => $request->issue_subject,
            'issue_description' => $request->issue_description,
            'status' => 'open',
            'customer_id' => Auth::user()->customer_id,
            'created_at' => now()
        ]);

        return redirect()->route('customer.service.form')
                         ->with('success', 'Your ticket has been submitted. Our support team will contact you soon.');
    }

    // Optional: method to show the form
    public function showForm()
    {
        return view('customer.service_form');
    }
}
