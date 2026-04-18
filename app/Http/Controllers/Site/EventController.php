<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->where('is_published', true)
            ->orderByDesc('starts_at')
            ->paginate(12);

        return view('site.events.index', [
            'activeNav' => 'events',
            'title' => Setting::getValue('events_meta_title', 'فعاليات - العبادلة'),
            'metaDescription' => Setting::getValue('events_meta_description', 'فعاليات وأنشطة عائلة العبادلة.'),
            'intro1' => Setting::getValue('events_intro_1', ''),
            'intro2' => Setting::getValue('events_intro_2', ''),
            'events' => $events,
        ]);
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $latest = Event::query()
            ->where('is_published', true)
            ->where('id', '!=', $event->id)
            ->orderByDesc('starts_at')
            ->limit(6)
            ->get();

        return view('site.events.show', [
            'activeNav' => 'events',
            'title' => $event->title.' - العبادلة',
            'metaDescription' => $event->description ?? \Illuminate\Support\Str::limit(strip_tags((string) $event->body), 160),
            'event' => $event,
            'latest' => $latest,
        ]);
    }
}
