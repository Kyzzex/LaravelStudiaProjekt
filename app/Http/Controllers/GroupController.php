<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function __construct() {
        $this->middleware('role:admin', ['only' => ['create', 'store', 'edit', 'update', 'addStudent', 'removeStudent']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('groups.list', ['groups' => Group::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $group = Group::create($request->only(['name']));

        return response()->redirectToRoute('groups.show', ['group' => $group->id])->with(['status' => 'group-created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return response()->view('groups.show', [
            'group' => $group,
            'addable_students' => Student::where('group_id', null)->get(),
            'addable_subjects' => Subject::whereDoesntHave('groups', function($q) use($group) {
                $q->where('group_id', $group->id);
            })->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return response()->view('groups.create', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $group->update($request->only(['name']));

        return response()->redirectToRoute('groups.show', ['group' => $group->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        DB::transaction(function () use ($group) {
            $group->students()->update(['group_id' => null]);
            $group->delete();
        });

        return response()->redirectToRoute('groups.index')->with('status', 'group-deleted');
    }

    public function addStudent(Request $request) {
        $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
            'student_id' => ['required', 'exists:students,id']
        ]);

        $student = Student::find($request->get('student_id'));
        $student->update([
            'group_id' => $request->get('group_id')
        ]);

        return response()->redirectToRoute('groups.show', ['group' => $student->group_id])->with('status', 'user-added');
    }

    public function removeStudent(Student $student) {
        $group_id = $student->group_id;
        $student->update(['group_id' => null]);

        return response()->redirectToRoute('groups.show', ['group' => $group_id])->with('status', 'user-removed');
    }

    public function addSubject(Request $request) {
        $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
            'subject_id' => ['required', 'exists:subjects,id']
        ]);

        $group = Group::find($request->get('group_id'));
        $group->subjects()->attach($request->get('subject_id'));

        return back()->with('status', 'subject-added');
    }

    public function removeSubject(Request $request) {
        $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
            'subject_id' => ['required', 'exists:subjects,id']
        ]);

        $group = Group::find($request->get('group_id'));
        $group->subjects()->detach($request->get('subject_id'));

        return back()->with('status', 'subject-removed');
    }
}
