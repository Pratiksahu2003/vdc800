<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Services\ContactNotificationService;
use App\Services\ContactSpamGuard;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request, ContactSpamGuard $spamGuard)
    {
        $spamGuard->primeSession($request);

        return view('contact.index', [
            'mapLink' => company_map_link(),
            'mapEmbed' => company_map_embed_url(),
            'contactFormToken' => $request->session()->get('contact_form_token'),
        ]);
    }

    public function store(Request $request, ContactSpamGuard $spamGuard)
    {
        if ($spamGuard->rateLimitExceeded($request)) {
            $wait = $spamGuard->secondsUntilAvailable($request);

            return back()
                ->withInput()
                ->withErrors([
                    'message' => 'Too many messages sent from your network. Please wait '.max(1, (int) ceil($wait / 60)).' minute(s) and try again.',
                ]);
        }

        if ($spamGuard->shouldRejectSilently($request)) {
            return $this->fakeSuccessResponse($request, $spamGuard);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'project_type' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
            'contact_form_token' => 'required|string|size:40',
        ]);

        unset($validated['contact_form_token']);

        if ($spamGuard->messageLooksSpammy($validated['message'])) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Your message could not be sent. Please reduce links and try again.']);
        }

        if ($spamGuard->isDuplicateSubmission($validated)) {
            $spamGuard->recordSuccessfulSubmission($request);
            $spamGuard->primeSession($request);

            return back()->with('success', 'Thank you for your message. We will be in touch shortly.');
        }

        $submission = ContactSubmission::create($validated);

        $spamGuard->recordSuccessfulSubmission($request);
        $spamGuard->primeSession($request);

        app(ContactNotificationService::class)->notifyAdmin($submission);

        return back()->with('success', 'Thank you for your message. We will be in touch shortly.');
    }

    private function fakeSuccessResponse(Request $request, ContactSpamGuard $spamGuard)
    {
        $spamGuard->recordSuccessfulSubmission($request);
        $spamGuard->primeSession($request);

        return back()->with('success', 'Thank you for your message. We will be in touch shortly.');
    }
}
