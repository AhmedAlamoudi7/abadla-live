<ul class="ftree" id="familyTree">
    @if ($roots->isEmpty())
        <li>
            <p class="tree-empty-msg" style="padding:24px;text-align:center;">لم تُضف بيانات الشجرة بعد. يمكن إدارتها من لوحة التحكم.</p>
        </li>
    @elseif ($roots->count() === 1)
        @include('site.partials.family-tree-node', [
            'member' => $roots->first(),
            'byParent' => $byParent,
            'depth' => 0,
            'isRoot' => true,
        ])
    @else
        <li>
            <div
                class="ftree-node ftree-root"
                data-name="{{ $syntheticRootName }}"
                data-role=""
                data-year=""
                data-bio="{{ $syntheticRootBio }}"
                data-branch="all"
            >
                <div class="ftree-avatar ftree-avatar-root"><i class="fas fa-tree"></i></div>
                <span class="ftree-name">{{ $syntheticRootName }}</span>
            </div>
            <ul class="ftree-collapsed">
                @foreach ($roots as $child)
                    @include('site.partials.family-tree-node', [
                        'member' => $child,
                        'byParent' => $byParent,
                        'depth' => 1,
                        'isRoot' => false,
                    ])
                @endforeach
            </ul>
        </li>
    @endif
</ul>
