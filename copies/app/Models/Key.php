<?php
namespace App\Models;

use \Illuminate\Support\Facades\DB;

class Key {
    public static function getPublicKey($id) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("SELECT public_key FROM users WHERE id =:id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();
        return $result;
    }

    public function storeSessionKey($id,$sessKey) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("insert into users (session_key) values (:sesskey) WHERE id =:id");
        $statement->execute(['id' => $id,'sesskey'=>$sessKey]);
    }
}