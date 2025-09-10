<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSupport;

class SupportController extends Controller
{
    public function index()
    {
        $issues = CustomerSupport::with(['customer'])->get();
        return view('admin.support.issues', compact('issues'));
    }
        public function updateStatus(Request $request, CustomerSupport $review)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $review->status = $request->status;
        $review->save();

        return redirect()->back()->with('success', 'Issue status updated successfully.');
    }
}
