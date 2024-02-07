<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function register($name, $email, $password)
    {
        $id = (new User())->createUser($name, $email, $password);
        return $id;
    }

    public function login($email, $password)
    {
        //$user = (new User())->getUser($email);
        $user = new User();
        $userData = $user->getUser($email);

        if($userData === null){
            return ['result' => false];
        }

        if(!password_verify($password, $userData['password'])){
            return ['result' => false];
        }

        //segundo factor

        $this->createSesion($userData['id'], $userData['email']);

        return ['result' => true];        
    }

    protected function createSesion($id, $email, $isLoggedIn = true)
    {
        $_SESSION['isLoggedIn'] = $isLoggedIn;
        $_SESSION['userId'] = $id;
        $_SESSION['email'] = $email;

    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'];
    }

    public function logout()
    {
        try {
            // Destruye todas las variables de sesión
            $_SESSION = array();

            // Borra la cookie de sesión
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            session_destroy();
        } catch (\Exception $e) {
            //throw $th;
        }

    }
}
