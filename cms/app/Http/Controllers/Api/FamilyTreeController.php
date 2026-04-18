<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\JsonResponse;

class FamilyTreeController extends Controller
{
    public function index(): JsonResponse
    {
        $all = FamilyMember::query()
            ->where('is_public', true)
            ->orderBy('sort_order')
            ->get();

        /** @var array<int, list<FamilyMember>> $childrenMap */
        $childrenMap = [];
        foreach ($all as $member) {
            $pid = $member->parent_id ?? 0;
            $childrenMap[$pid][] = $member;
        }

        $build = function (int $parentId) use (&$build, $childrenMap): array {
            $nodes = $childrenMap[$parentId] ?? [];
            $out = [];
            foreach ($nodes as $m) {
                $out[] = [
                    'id' => $m->id,
                    'full_name' => $m->full_name,
                    'short_name' => $m->short_name,
                    'role' => $m->role,
                    'year_range' => $m->year_range,
                    'bio' => $m->bio,
                    'branch_id' => $m->family_branch_id,
                    'children' => $build($m->id),
                ];
            }

            return $out;
        };

        return response()->json([
            'data' => $build(0),
        ]);
    }
}
