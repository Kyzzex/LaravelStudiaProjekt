<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function __construct() {
        $this->middleware('role:admin', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('subjects.list', ['subjects' => Subject::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $subject = Subject::create($request->only(['name']));

        return response()->redirectToRoute('subjects.show', ['subject' => $subject->id])->with(['status' => 'created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return response()->view('subjects.show', [
            'subject' => $subject,
            'addable_groups' => Group::whereDoesntHave('subjects', function($q) use($subject) {
                $q->where('subject_id', $subject->id);
            })->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return response()->view('subjects.create', ['subject' => $subject]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $subject->update($request->only(['name']));

        return response()->redirectToRoute('subjects.show', ['subject' => $subject->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        DB::transaction(function () use ($subject) {
            $subject->delete();
        });

        return response()->redirectToRoute('subjects.index')->with('status', 'subject-deleted');
    }
}
