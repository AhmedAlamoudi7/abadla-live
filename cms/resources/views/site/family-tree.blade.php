@extends('layouts.site')

@push('styles')
    <link rel="stylesheet" href="{{ asset('legacy/tree.css') }}" />
@endpush

@section('content')
    @php($totalMembers = \App\Models\FamilyMember::query()->where('is_public', true)->count())
    <div class="tree-app" data-animate="fade-up">
        <div class="tree-hero">
            <div class="tree-hero-bg"></div>
            <div class="tree-hero-content">
                <div class="tree-hero-icon"><i class="fas fa-tree"></i></div>
                <h1>{{ $treeHeroTitle }}</h1>
                <p>{{ $treeHeroSubtitle }}</p>
                <div class="tree-hero-stats">
                    <div class="tree-stat-pill">
                        <span class="tree-stat-num" data-target="{{ (int) preg_replace('/\D/', '', $treeStatMembers) }}">—</span>
                        <span class="tree-stat-lbl">فرد</span>
                    </div>
                    <div class="tree-stat-pill">
                        <span class="tree-stat-num" data-target="{{ (int) preg_replace('/\D/', '', $treeStatBranches) }}">—</span>
                        <span class="tree-stat-lbl">فرع</span>
                    </div>
                    <div class="tree-stat-pill">
                        <i class="fas fa-flag" style="margin-left:6px"></i>
                        <span class="tree-stat-lbl">{{ $treeStatRegion }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tree-tabs">
            <button type="button" class="tree-tab active" data-tab="tree"><i class="fas fa-sitemap"></i> مشجرة العائلة</button>
            <button type="button" class="tree-tab" data-tab="members"><i class="fas fa-users"></i> أفراد العائلة</button>
            <button type="button" class="tree-tab" data-tab="stats"><i class="fas fa-chart-bar"></i> إحصائيات</button>
            <button type="button" class="tree-tab" data-tab="about"><i class="fas fa-book-open"></i> عن العائلة</button>
        </div>

        <div class="tree-layout">
            <aside class="tree-sidebar" id="treeSidebar">
                <div class="sidebar-section">
                    <h3><i class="fas fa-search"></i> اختر الفرع / بحث عن شخص</h3>
                </div>
                <div class="sidebar-section">
                    <h4><i class="fas fa-code-branch"></i> اختر الفرع</h4>
                    <div class="branch-list" id="branchList">
                        <button type="button" class="branch-item active" data-branch="all">
                            <i class="fas fa-tree"></i>
                            <span>كل الفروع</span>
                            <span class="branch-badge">{{ $totalMembers }}</span>
                        </button>
                        @foreach ($branches as $b)
                            <button type="button" class="branch-item" data-branch="{{ $b->slug }}">
                                <i class="fas fa-code-branch"></i>
                                <span>{{ $b->name }}</span>
                                <span class="branch-badge">{{ $b->member_count ?? 0 }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="sidebar-section">
                    <h4><i class="fas fa-search"></i> بحث عن شخص</h4>
                    <div class="tree-search-box">
                        <input type="text" id="treeSearchInput" placeholder="اكتب الاسم..." />
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="search-results" id="searchResults"></div>
                    <button type="button" class="advanced-toggle" id="advancedToggle">
                        <i class="fas fa-chevron-down"></i> بحث متقدم (الأب + الجد)
                    </button>
                    <div class="advanced-fields" id="advancedFields">
                        <input type="text" id="fatherSearch" placeholder="اسم الأب" />
                        <input type="text" id="grandSearch" placeholder="اسم الجد" />
                    </div>
                </div>
            </aside>

            <main class="tree-main">
                <div class="tree-tab-content active" id="tabTree">
                    <div class="tree-toolbar">
                        <div class="toolbar-right">
                            <button type="button" class="tb-btn" id="tbZoomIn" title="تكبير"><i class="fas fa-plus"></i></button>
                            <button type="button" class="tb-btn" id="tbZoomOut" title="تصغير"><i class="fas fa-minus"></i></button>
                            <button type="button" class="tb-btn" id="tbReset" title="إعادة ضبط"><i class="fas fa-crosshairs"></i></button>
                            <span class="tb-zoom" id="tbZoomLabel">100%</span>
                        </div>
                        <div class="toolbar-left">
                            <button type="button" class="tb-btn" id="tbExpandAll" title="توسيع الكل"><i class="fas fa-expand-alt"></i> توسيع</button>
                            <button type="button" class="tb-btn" id="tbCollapseAll" title="طي الكل"><i class="fas fa-compress-alt"></i> طي</button>
                            <button type="button" class="tb-btn tb-sidebar-toggle" id="tbSidebarToggle"><i class="fas fa-bars"></i></button>
                        </div>
                    </div>
                    <div class="tree-viewport" id="treeViewport">
                        <div class="tree-canvas" id="treeCanvas">
                            @include('site.partials.family-tree-forest', [
                                'roots' => $roots,
                                'byParent' => $byParent,
                                'syntheticRootName' => $syntheticRootName,
                                'syntheticRootBio' => $syntheticRootBio,
                            ])
                        </div>
                    </div>
                </div>

                <div class="tree-tab-content" id="tabMembers">
                    <div class="members-grid" id="membersGrid"></div>
                </div>

                <div class="tree-tab-content" id="tabStats">
                    <div class="tree-stats-grid">
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-users"></i></div><h3>{{ $treeStatMembers }}</h3><p>إجمالي الأفراد</p></div>
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-code-branch"></i></div><h3>{{ $treeStatBranches }}</h3><p>فروع رئيسية</p></div>
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-layer-group"></i></div><h3>—</h3><p>أجيال موثّقة</p></div>
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-male"></i></div><h3>—</h3><p>ذكور</p></div>
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-female"></i></div><h3>—</h3><p>إناث</p></div>
                        <div class="ts-card"><div class="ts-icon"><i class="fas fa-globe-americas"></i></div><h3>—</h3><p>دول الانتشار</p></div>
                    </div>
                </div>

                <div class="tree-tab-content" id="tabAbout">
                    <div class="tab-about-content">
                        @if ($treeAboutHtml)
                            {!! $treeAboutHtml !!}
                        @else
                            <h2>عن شجرة عائلة العبادلة</h2>
                            <p>يتم عرض بيانات الشجرة من قاعدة البيانات ويمكن تحديثها من لوحة التحكم.</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>

        <div class="ftree-detail" id="ftreeDetail">
            <button type="button" class="ftree-detail-close" id="ftreeDetailClose"><i class="fas fa-times"></i></button>
            <div class="ftree-detail-avatar"><i class="fas fa-user" id="ftreeDetailIcon"></i></div>
            <h3 id="ftreeDetailName"></h3>
            <span class="ftree-detail-role" id="ftreeDetailRole"></span>
            <span class="ftree-detail-year"><i class="fas fa-calendar-alt"></i> <span id="ftreeDetailYear"></span></span>
            <p id="ftreeDetailBio"></p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('legacy/tree-app.js') }}"></script>
@endpush
