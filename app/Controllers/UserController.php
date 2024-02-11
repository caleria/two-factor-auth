<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;

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

        //validar segundo factor
        if($userData['two_factor_key'] != null){
            $this->createSesion(null, $userData['email'], false);
            return ['result' => true, 'secondFactor' => true];  
        }        

        $this->createSesion($userData['id'], $userData['email']);

        return ['result' => true, 'secondFactor' => false];        
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




    public function getUser()
    {
        $email = $_SESSION['email'];
        return (new User())->getUser($email);
    }




    public function activateSecondFactor($secret, $code)
    {
        try {
            if ($this->checkGoogleAuthenticatorCode($secret, $code)) {
                $id = $_SESSION['userId'];
                $user = new User();
                $user->createSecret($secret, $id);
                return true;
            }
        } catch (PDOException $e) {
            // Manejar la excepción aquí si es necesario
            // Por ejemplo, puedes registrar el error en un archivo de registro
            // o devolver un mensaje de error más detallado
            error_log("Error al activar el segundo factor: " . $e->getMessage(), 3, 'log/archivo.log');
        }
        return false;
    }




    public function deactivateSecondFactor()
    {
        $id = $_SESSION['userId'];
        $user = new User();
        try {
            $user->deleteSecret($id);
            return true;
        } catch (PDOException $e) {
            error_log("Error al desactivar el segundo factor: " . $e->getMessage(), 3, 'log/archivo.log');
        }
        return false;

    }




    public function checkGoogleAuthenticatorCode($secret, $code)
    {
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

        if($g->checkCode($secret, $code)){
            return true;
        }
        return false;
    }




    public function validateCode($code)
    {
        $user = $this->getUser();
        if($this->checkGoogleAuthenticatorCode($user['two_factor_key'], $code)){
            $this->createSesion($user['id'], $user['email']);
            return true;
        }
        return false;
    }


}
