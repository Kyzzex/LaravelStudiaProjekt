<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class UserCreationService
{
    public function getUserRequestValidationRules(User $user = null): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.($user ? ',email,'.$user->id : '')],
            'type' => ['required', 'in:student,teacher']
        ];
    }
    public function getUserableRequestValidationRules(string $type): array {
        return match ($type) {
            'student' => ['group_id' => ['required', 'exists:' . Group::class . ',id']],
            default => [],
        };
    }

    public function getUserableModelData(Request $request): array {
        return match ($request->get('type')) {
            'student' => $request->only(['group_id']),
            default => [],
        };
    }

    public function createUserable(Request $request): Student | Teacher | Admin {
        return Relation::getMorphedModel($request->get('type'))::create($this->getUserableModelData($request));
    }

    public function updateUserable(User $user, Request $request): User {
        $userableData = $this->getUserableModelData($request);

        if(!$user->hasRole($request->get('type'))) {
            $user->userable()->delete();
            $user->userable()->associate(Relation::getMorphedModel($request->get('type'))::create($userableData))->save();
        } else {
            $user->userable()->update($userableData);
        }

        return $user;
    }
}
