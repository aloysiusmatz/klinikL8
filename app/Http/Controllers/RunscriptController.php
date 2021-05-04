<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RunscriptController extends Controller
{
    //

    public function index(){
        // $user = User::find(1);

        // $user->assignRole('level4');
        // $user->givePermissionTo('show general setting', 'show user setting');

        // $role = Role::find(1);
        // $role->givePermissionTo(['show medrec','show checkup']);

        // $role = Role::find(2);
        // $role->givePermissionTo(['show medrec','show checkup','create medrec','create checkup']);

        // $role = Role::find(3);
        // $role->givePermissionTo(['show medrec','show checkup','create medrec','create checkup','edit medrec','edit checkup']);

        return 'done';
    }
}
