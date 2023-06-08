<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subject;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __invoke()
    {
        switch (auth()->user()->userable_type) {
            case 'student':
                return $this->renderStudentDashboard();
            case 'teacher':
                return $this->renderTeacherDashboard();
            case 'admin':
                return $this->renderAdminDashboard();
            default:
                abort(403);
        }
    }

    private function renderStudentDashboard(): Response
    {
        $subjects = auth()->user()->userable->group->subjects()->with(['grades' => function ($q) {
            $q->where('student_id', auth()->user()->userable_id);
        }])->get();
        return response()->view('dashboards.student', ['subjects' => $subjects]);
    }

    private function renderTeacherDashboard(): Response
    {
        return response()->view('dashboards.teacher', ['subjects' => Subject::all()]);
    }

    private function renderAdminDashboard(): Response
    {
        return response()->view('dashboards.admin', ['groups' => Group::all()]);
    }
}
