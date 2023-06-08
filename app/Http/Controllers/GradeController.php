<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    private array $acceptedGrades = [1, 1.5, 1.75, 2, 2.5, 2.75, 3, 3.5, 3.75, 4, 4.5, 4.75, 5, 5.5, 5.75, 6];
    public function __construct() {
        $this->middleware('role:admin,teacher')->except(['show']);
    }

    public function index(Request $request)
    {
        $request->validate([
            'group' => ['required', 'exists:groups,id'],
            'subject' => ['required', 'exists:subjects,id'],
        ]);

        $group = Group::find($request->get('group'));
        $subject = Subject::find($request->get('subject'));
        $grades = $subject->grades()->where(function ($q) use ($group) {
            $q->whereIn('student_id', $group->students()->pluck('id')->toArray());
        })->get()->groupBy('student_id');

        return response()->view('grades.index', ['group' => $group, 'subject' => $subject, 'grades' => $grades]);
    }

    public function show(Grade $grade)
    {
        return response()->view('grades.show', ['grade' => $grade]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'student' => ['required', 'exists:students,id'],
            'subject' => ['required', 'exists:subjects,id'],
        ]);

        $subject = Subject::find($request->get('subject'));
        $student = Student::find($request->get('student'));

        return response()->view('grades.create', ['subject' => $subject, 'student' => $student, 'acceptedGrades' => $this->acceptedGrades]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grade' => ['required', Rule::in($this->acceptedGrades)],
            'subject_id' => ['required', 'exists:subjects,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $student = Student::find($request->get('student_id'));

        Grade::create([...$request->only(['grade', 'subject_id', 'student_id']), ...['creator_id' => auth()->user()->id, 'creator_type' => auth()->user()->userable_type]]);

        return response()->redirectToRoute('grades.index', ['group' => $student->group_id, 'subject' => $request->get('subject_id')])->with(['status' => 'grade-added']);
    }

    public function edit(Grade $grade, Request $request)
    {
        $request->validate([
            'student' => ['required', 'exists:students,id'],
            'subject' => ['required', 'exists:subjects,id'],
        ]);

        $subject = Subject::find($request->get('subject'));
        $student = Student::find($request->get('student'));

        return response()->view('grades.create', ['grade' => $grade, 'subject' => $subject, 'student' => $student, 'acceptedGrades' => $this->acceptedGrades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade' => ['required', Rule::in($this->acceptedGrades)],
        ]);

        $grade->update([
            ...$request->only(['grade']),
            'creator_id' => auth()->user()->userable_id,
            'creator_type' => auth()->user()->userable_type
        ]);

        return response()->redirectToRoute('grades.show', ['grade' => $grade])->with(['status' => 'grade-edited']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        DB::transaction(function () use ($grade) {
            $grade->delete();
        });

        return back()->with(['status' => 'grade-removed']);
    }
}
