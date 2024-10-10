<?php
namespace App\Models;

use \Illuminate\Support\Facades\DB;

class Roles {
    public static function getRole($id) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("SELECT name FROM roles WHERE id =:id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();
        return $result;
    }

    public static function insertRequest($username, $roleId) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("INSERT INTO request_roles (`username`,`requested_role`) values(:username,:roleId)");
        $statement->execute(['username' => $username, 'roleId' => $roleId]);
    }

    public static function getRequest() {
        $result = DB::select("SELECT * FROM request_roles JOIN roles ON id = requested_role");
        $roles = [];
        foreach ($result as $request) {
            $roles[] = $request;
        }
        
        return $roles;
    }

    public static function deleteRequest($username){
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("DELETE FROM request_roles WHERE username = :username");
        $statement->execute(['username' => $username]);
    }

    public static function acceptRequest($username) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("UPDATE users SET `role` = 
                                    (SELECT requested_role FROM request_roles WHERE username = :username)
                                    WHERE username = :user");
        $statement->execute(['username' => $username, 'user' => $username]);                            
        Roles::deleteRequest($username);
    }
}