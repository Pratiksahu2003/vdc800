<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->get('date')) {
            $query->whereDate('created_at', $date);
        }

        return view('admin.contact-submissions.index', [
            'submissions' => $query->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function show(ContactSubmission $contactSubmission)
    {
        return view('admin.contact-submissions.show', [
            'submission' => $contactSubmission,
        ]);
    }

    public function updateStatus(Request $request, ContactSubmission $contactSubmission)
    {
        $request->validate(['status' => 'required|in:new,contacted,closed']);
        $contactSubmission->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }
}
