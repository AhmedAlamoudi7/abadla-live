<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'message' => $data['message'],
        ]);

        return back()->with('contact_ok', true);
    }
}
