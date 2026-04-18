@php
    $kids = $byParent->get($member->id, collect());
    $branchSlug = $member->branch?->slug ?? 'all';
    $iconClass = $member->icon_key ?: 'fas fa-user';
    $displayName = $member->short_name ?: \Illuminate\Support\Str::limit($member->full_name, 28);
    if ($isRoot ?? false) {
        $nodeClass = 'ftree-root';
    } elseif ($kids->isEmpty()) {
        $nodeClass = 'ftree-leaf';
    } elseif (($depth ?? 0) === 1) {
        $nodeClass = 'ftree-branch-head';
    } else {
        $nodeClass = '';
    }
@endphp
<li @if(($depth ?? 0) === 1) data-branch="{{ $branchSlug }}" @endif>
    <div
        class="ftree-node {{ $nodeClass }}"
        data-name="{{ $member->full_name }}"
        data-role="{{ $member->role ?? '' }}"
        data-year="{{ $member->year_range ?? '' }}"
        data-bio="{{ $member->bio ?? '' }}"
        data-branch="{{ $branchSlug }}"
    >
        <div class="ftree-avatar {{ ($isRoot ?? false) ? 'ftree-avatar-root' : '' }}"><i class="{{ $iconClass }}"></i></div>
        <span class="ftree-name">{{ $displayName }}</span>
        @if ($member->role)
            <span class="ftree-role">{{ $member->role }}</span>
        @endif
        @if ($kids->isNotEmpty())
            <button type="button" class="ftree-toggle" aria-label="توسيع"><i class="fas fa-chevron-down"></i></button>
        @endif
    </div>
    @if ($kids->isNotEmpty())
        <ul class="ftree-collapsed">
            @foreach ($kids as $child)
                @include('site.partials.family-tree-node', ['member' => $child, 'byParent' => $byParent, 'depth' => ($depth ?? 0) + 1, 'isRoot' => false])
            @endforeach
        </ul>
    @endif
</li>
