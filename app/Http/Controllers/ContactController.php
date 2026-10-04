<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Services\ContactNotificationService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'project_type' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        $submission = ContactSubmission::create($validated);

        app(ContactNotificationService::class)->notifyAdmin($submission);

        return back()->with('success', 'Thank you for your message. We will be in touch shortly.');
    }
}
