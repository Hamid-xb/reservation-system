<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class RestaurantMemberController extends Controller
{
    public function index(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $members = $restaurant->userRoles()
            ->with(['user', 'role'])
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->orderByRaw("
        CASE LOWER(roles.name)
            WHEN 'restaurant_owner' THEN 3
            WHEN 'restaurant_manager' THEN 2
            WHEN 'restaurant_staff' THEN 1
            ELSE 0
        END DESC
    ")
            ->select('user_roles.*')
            ->get();

        $editableRoles = Role::where('scope', 'restaurant')
            ->where('name', '!=', 'restaurant_owner')
            ->get();

        return view('restaurant.members.index', compact(
            'restaurant',
            'members',
            'editableRoles'
        ));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();

        $alreadyMember = $restaurant->userRoles()
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyMember) {
            return back()->withErrors([
                'email' => 'Deze gebruiker is al lid van dit restaurant.',
            ]);
        }

        $restaurant->userRoles()->create([
            'user_id' => $user->id,
            'role_id' => $validated['role_id'],
        ]);

        return back()->with('success', 'Lid toegevoegd.');
    }

    public function update(Request $request, Restaurant $restaurant, UserRole $userRole)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureMemberBelongsToRestaurant($restaurant, $userRole);
        if (! $this->canManageUserRole($request, $restaurant, $userRole)) {
            abort(403);
        }
        $this->protectOwner($userRole);

        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $newRole = Role::findOrFail($validated['role_id']);

        if ($newRole->name === 'restaurant_owner') {
            abort(403);
        }

        $userRole->update([
            'role_id' => $newRole->id,
        ]);

        return back()->with('success', 'Lid aangepast.');
    }

    public function destroy(Request $request, Restaurant $restaurant, UserRole $userRole)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureMemberBelongsToRestaurant($restaurant, $userRole);
        if (! $this->canManageUserRole($request, $restaurant, $userRole)) {
            abort(403);
        }
        $this->protectOwner($userRole);

        $userRole->delete();

        return back()->with('success', 'Lid verwijderd.');
    }

    private function checkAccess(Request $request, Restaurant $restaurant): void
    {
        if (! $request->user()->hasRestaurantRole($restaurant->id, [
            'Restaurant_owner',
            'Restaurant_manager',
        ])) {
            abort(403);
        }
    }

    private function ensureMemberBelongsToRestaurant(Restaurant $restaurant, UserRole $userRole): void
    {
        if ($userRole->restaurant_id !== $restaurant->id) {
            abort(404);
        }
    }

    private function protectOwner(UserRole $userRole): void
    {
        if ($userRole->role->name === 'restaurant_owner') {
            abort(403);
        }
    }

    private function roleLevel(string $roleName): int
    {
        return match ($roleName) {
            'Restaurant_owner' => 3,
            'Restaurant_manager' => 2,
            'Restaurant_staff' => 1,
            default => 0,
        };
    }

    private function canManageUserRole(Request $request, Restaurant $restaurant, UserRole $targetUserRole): bool
    {
        $currentUserRole = $request->user()
            ->userRoles()
            ->with('role')
            ->where('restaurant_id', $restaurant->id)
            ->get()
            ->sortByDesc(function ($userRole) {
                return match ($userRole->role->name) {
                    'Restaurant_owner' => 3,
                    'Restaurant_manager' => 2,
                    'Restaurant_staff' => 1,
                    default => 0,
                };
            })
            ->first();

        if (! $currentUserRole) {
            return false;
        }

        if ($targetUserRole->user_id === $request->user()->id) {
            return false;
        }

        return $this->roleLevel($currentUserRole->role->name)
            > $this->roleLevel($targetUserRole->role->name);
    }
}
