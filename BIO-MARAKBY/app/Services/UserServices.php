<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UserServices
{
    public function HonorDashboard()
    {
        $topUsers = DB::table('exam_attempts')
            ->join('users', 'exam_attempts.user_id', '=', 'users.id')
            ->leftJoin('levels', 'users.level_id', '=', 'levels.id')
            ->leftJoin('stages', 'users.stage_id', '=', 'stages.id')
            ->select(
                'users.id',
                'users.name',
                'levels.name as level_name',
                'stages.name as stage_name',
                DB::raw('AVG(exam_attempts.score) as average')
            )
            ->groupBy('users.id', 'users.name', 'levels.name', 'stages.name')
            ->orderByDesc('average')
            ->limit(3)
            ->get();

        return $topUsers;
    }
}
