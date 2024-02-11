<?php

namespace App\Models;

use PDO;
use PDOException;

class User extends Database
{
    public function createUser($name, $email, $password)
    {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $query = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
            $query->bindParam(1, $name);
            $query->bindParam(2, $email);
            $query->bindParam(3, $hash);
            $query->execute();
            $insertedId = $this->db->lastInsertId();
            $query->closeCursor();
            return $insertedId;
        } catch (PDOException $e) {
            // Manejar la excepción aquí
            // Por ejemplo, puedes imprimir un mensaje de error o realizar alguna acción específica
            //echo "Error al crear el usuario: " . $e->getMessage();
            // O puedes lanzar nuevamente la excepción para que sea manejada en un nivel superior
            //throw $e;
            $insertedId = 0;
            return $insertedId;
        }
    }




    public function getUser($email)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $query->bindParam(1, $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $query->closeCursor();

            if ($result === false) {
                return null;
            }

            return $result;
        } catch (\Throwable $th) {
            error_log('Error al obtener usuario: ' . $th->getMessage());
            return null;
        }
    }




    public function createSecret($secret, $id)
    {
        try {
            $query = $this->db->prepare("UPDATE users SET two_factor_key = ? WHERE id = ?");
            $query->bindValue(1, $secret);
            $query->bindValue(2, $id);
            $query->execute();
            $query->closeCursor();
        } catch (PDOException $e) {
            // Manejar la excepción aquí si es necesario
            throw $e; // Lanzar la excepción para que sea manejada en un nivel superior
        }
    }

    
    

    public function deleteSecret($id)
    {
        try {
            $query = $this->db->prepare("UPDATE users SET two_factor_key = null WHERE id = ? ");
            $query->bindValue(1, $id);
            $query->execute();
            $query->closeCursor();
        } catch (PDOException $e) {
            // Manejar la excepción aquí
            // Por ejemplo, puedes imprimir un mensaje de error o realizar alguna acción específica
            //echo "Error al crear el usuario: " . $e->getMessage();
            // O puedes lanzar nuevamente la excepción para que sea manejada en un nivel superior
            throw $e;
        }
    }



}
