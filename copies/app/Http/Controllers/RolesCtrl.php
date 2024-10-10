<?php
namespace App\Http\Controllers;

use App\Models\Roles;

class RolesCtrl extends Controller {
    public function index() {
        $roles = Roles::getRequest();
        return view('roles',['requests' => $roles]);
    }

    public function accept() {
        $username = $_POST['username'];
        Roles::acceptRequest($username);
        return redirect('/roles/edit');
    }

    public function decline() {
        $username = $_POST['username'];

        Roles::deleteRequest($username);
        return redirect('/roles/edit');
    }
}