<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class UserServices
{
    public function HonorDashboard()
    {
        $topUsers = DB::table('exam_attempts')
            ->join('users', 'exam_attempts.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.level',
                'users.stage',
                DB::raw('AVG(exam_attempts.score) as average')
            )
            ->groupBy('users.id', 'users.name', 'users.level', 'users.stage')
            ->orderByDesc('average')
            ->limit(3)
            ->get();

        return $topUsers;
    }
}
