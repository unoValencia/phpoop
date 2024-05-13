<?php

class database{

    function opencon(){
        return new PDO('mysql:host=localhost; dbname=loginmethod', 'root', '');
    }
    function check($username, $password){
        $con = $this->opencon();
        $query = "Select * from users WHERE username='".$username."'&&passwords='".$password."'";
        return $con->query($query)->fetch();
    }
    function signup($username, $password, $firstname, $lastname, $birthday, $sex){
        $con = $this->opencon();
    
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false; // Username already exists
        }
    
        $query = $con->prepare("INSERT INTO users (username, passwords, first_name, last_name, birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        return $query->execute([$username, $password, $firstname, $lastname, $birthday,$sex]);
    }
    function signupUser($username, $password, $firstName, $lastName, $birthday, $sex) {
        $con = $this->opencon();
    
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false; 
        }
        $query = $con->prepare("INSERT INTO users (username, passwords, first_name, last_name, birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        $query->execute([$username, $password, $firstName, $lastName, $birthday,$sex]);
        return $con->lastInsertId();
    }function insertAddress($user_id, $city, $province, $street, $barangay) {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO users_address (user_id, Users_add_city, User_add_province, Users_add_street, Users_add_barangay) VALUES (?, ?, ?, ?, ?)")
            ->execute([$user_id, $city, $province, $street, $barangay]);
    }
    function view(){
        $con = $this->opencon();
        return $con->query("SELECT users.user_id, users.username, users.passwords, users.first_name, users.last_name, users.birthday, users.sex, CONCAT(users_address.Users_add_street,' ', users_address.Users_add_barangay,' ', users_address.Users_add_city,' ', users_address.User_add_province) AS address FROM users JOIN users_address ON users.user_id=users_address.user_id")->fetchAll();
    }
    function delete($id){
        try {
            $con = $this->opencon();    
            $con->beginTransaction();

            $query = $con->prepare("DELETE FROM users_address WHERE user_id = ?");
            $query->execute([$id]);

            $query2 = $con->prepare("DELETE FROM users WHERE user_id = ?");
            $query2->execute([$id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
            
        }
    }
    

}