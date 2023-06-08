<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Services\UserCreationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected UserCreationService $userCreationService;
    public function __construct() {
        $this->middleware('role:admin', ['only' => ['create', 'store', 'edit', 'update']]);

        $this->userCreationService = new UserCreationService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'type' => ['in:student,teacher']
        ]);

        $users = User::whereNot('userable_type', 'admin');
        if($request->get('type')) {
            $users = $users->where('userable_type', $request->get('type'));
        }

        return response()->view('users.list', ['users' => $users->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('users.create', ['groups' => Group::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            ...$this->userCreationService->getUserRequestValidationRules(),
            ...$this->userCreationService->getUserableRequestValidationRules($request->get('type'))
        ]);

        $password = Str::password(8, true, true, false);

        $user = DB::transaction(function () use ($request, $password) {
            $userable = $this->userCreationService->createUserable($request);
            return $userable->user()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'type' => $request->get('type'),
                'password' => Hash::make($password),
            ]);
        });

        event(new Registered($user));

        return response()->redirectToRoute('users.show', ['user' => $user->id])->with(['status' => 'created', 'password' => $password]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if($user->hasRole('admin')) {
            abort(404);
        }
        return response()->view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if($user->hasRole('admin')) {
            abort(404);
        }
        return response()->view('users.create', ['user' => $user, 'groups' => Group::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if($user->hasRole('admin')) {
            abort(404);
        }

        $request->validate([
            ...$this->userCreationService->getUserRequestValidationRules($user),
            ...$this->userCreationService->getUserableRequestValidationRules($request->get('type'))
        ]);
        DB::transaction(function () use ($request, $user) {
            $user->update($request->only(['name', 'email', 'type']));
            $this->userCreationService->updateUserable($user, $request);
        });

        return response()->redirectToRoute('users.show', ['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->userable()->delete();
            $user->delete();
        });

        return response()->redirectToRoute('users.index')->with('status', 'user-deleted');
    }
}
