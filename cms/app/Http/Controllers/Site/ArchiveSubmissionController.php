<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ArchiveSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArchiveSubmissionController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone_country' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        ArchiveSubmission::query()->create([
            'type' => $data['type'],
            'full_name' => $data['full_name'],
            'phone_country' => $data['phone_country'] ?? '+970',
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'status' => 'pending',
        ]);

        return back()->with('archive_ok', true);
    }
}
