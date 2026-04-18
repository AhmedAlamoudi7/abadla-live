<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\FamilyBranch;
use App\Models\FamilyMember;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class FamilyTreePageController extends Controller
{
    public function __invoke(): View
    {
        $members = FamilyMember::query()
            ->where('is_public', true)
            ->with('branch')
            ->orderBy('sort_order')
            ->get();

        /** @var Collection<int, Collection<int, FamilyMember>> $byParent */
        $byParent = $members->groupBy(fn (FamilyMember $m) => $m->parent_id ?? 0);

        $roots = $byParent->get(0, collect());

        $branchRows = FamilyBranch::query()->orderBy('sort_order')->get();

        $totalMembers = $members->count();
        $branchCount = $branchRows->count();

        return view('site.family-tree', [
            'activeNav' => 'family-tree',
            'title' => Setting::getValue('family_tree_meta_title', 'شجرة العائلة - العبادلة'),
            'metaDescription' => Setting::getValue('family_tree_meta_description', 'شجرة عائلة العبادلة.'),
            'byParent' => $byParent,
            'roots' => $roots,
            'branches' => $branchRows,
            'syntheticRootName' => Setting::getValue('tree_synthetic_root_name', 'عائلة العبادلة'),
            'syntheticRootBio' => Setting::getValue('tree_synthetic_root_bio', ''),
            'treeHeroTitle' => Setting::getValue('tree_hero_title', 'عائلة العبادلة'),
            'treeHeroSubtitle' => Setting::getValue('tree_hero_subtitle', 'تصفح شجرة العائلة، ابحث عن أقاربك، واستكشف تاريخ وفروع العائلة'),
            'treeStatMembers' => Setting::getValue('tree_stat_members', (string) max(1, $totalMembers)),
            'treeStatBranches' => Setting::getValue('tree_stat_branches', (string) max(1, $branchCount)),
            'treeStatRegion' => Setting::getValue('tree_stat_region', 'فلسطين والمهجر'),
            'treeAboutHtml' => Setting::getValue('tree_about_html', ''),
        ]);
    }
}
