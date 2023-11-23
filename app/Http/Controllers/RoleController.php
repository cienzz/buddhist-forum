<?php

namespace App\Http\Controllers;

use App\Enums\RoleAbility;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\ViewRoleMenuRequest;
use App\Models\Role;
use App\Models\Temple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::filter($request->all());
        if ($request->temple_name) {
            $query->where('temple.name', 'like', "%{$request->temple_name}%");
        }
        return $this->simplePaginate($query);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $request->validated();
        if ($request->temple_id) {
            $role['temple'] = Temple::find($request->temple_id, ['_id', 'name'])->toArray();
        }
        return ['data' => Role::create($role)];
    }

    public function show(Role $role)
    {
        return ['data' => $role];
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        return ['data' => tap($role)->update($request->validated())];
    }

    public function destroy(Role $role)
    {
        return ['data' => ['success' => $role->delete()]];
    }

    public function menus(ViewRoleMenuRequest $request)
    {
        return [
            'data' => Auth::user()->currentAccessToken()->can(RoleAbility::ROLE_VIEW->value) && ! $request->temple_id
                ? RoleAbility::menus() 
                : RoleAbility::privateMenus()];
    }
}
