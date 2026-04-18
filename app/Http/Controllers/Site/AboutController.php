<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\FamilyBranch;
use App\Models\FamousMember;
use App\Models\Setting;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('site.about', [
            'activeNav' => 'about',
            'title' => Setting::getValue('about_meta_title', 'عن العائلة - العبادلة'),
            'metaDescription' => Setting::getValue('about_meta_description', 'تعرّف على تاريخ عائلة العبادلة وفروعها.'),
            'aboutTitle' => Setting::getValue('about_title', 'عن عائلة العبادلة'),
            'aboutLead' => Setting::getValue('about_lead', ''),
            'aboutBodyHtml' => Setting::getValue('about_body_html', ''),
            'branches' => FamilyBranch::query()->orderBy('sort_order')->get(),
            'famous' => FamousMember::query()->orderBy('sort_order')->get(),
        ]);
    }
}
