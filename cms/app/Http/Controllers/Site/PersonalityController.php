<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Personality;
use App\Models\Setting;
use Illuminate\View\View;

class PersonalityController extends Controller
{
    public function __invoke(): View
    {
        $personalities = Personality::query()
            ->with('branch')
            ->where('published', true)
            ->orderBy('sort_order')
            ->paginate(24);

        return view('site.personalities', [
            'activeNav' => 'personalities',
            'title' => Setting::getValue('personalities_meta_title', 'شخصيات إعتبارية - العبادلة'),
            'metaDescription' => Setting::getValue('personalities_meta_description', 'شخصيات بارزة من عائلة العبادلة.'),
            'introHtml' => Setting::getValue('personalities_intro_html', ''),
            'personalities' => $personalities,
        ]);
    }
}
