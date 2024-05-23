<?php

class database{

    function opencon(){
        return new PDO('mysql:host=localhost; dbname=loginmethod', 'root', '');
    }
    function check($username, $password ) {
        // Open database connection
        $con = $this->opencon();
    
        // Prepare the SQL query
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
    
        // Fetch the user data as an associative array
        $username = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If a user is found, verify the password
        if ($username && password_verify($password, $username['passwords'])) {
            return $username;
        }

    
        // If no user is found or password is incorrect, return false
        return false;
    }
    // function check($username, $password){
    //     $con = $this->opencon();
    //     $query = "SELECT * from users WHERE username='".$username."'&& passwords='".$password."'";
    //     return  $con->query($query)->fetch();
    // }
    function signup($username, $password, $firstName, $lastName, $birthday, $sex){
        $con = $this->opencon();
    
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser){
            return false; // Username already exists
        }
    
        $query = $con->prepare("INSERT INTO users (username, passwords, first_name, last_name, birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
        return $query->execute([$username, $password, $firstName, $lastName, $birthday,$sex]);
    }
    function signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture)
    {
        $con = $this->opencon();
        // Save user data along with profile picture path to the database
        $con->prepare("INSERT INTO users (first_name, last_name, birthday, sex, user_email, username, passwords, user_profile) VALUES (?,?,?,?,?,?,?,?)")->execute([$firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture]);
        return $con->lastInsertId();
        }
    

    
    function insertAddress($user_id, $street, $barangay, $city, $province)
    {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO users_address (user_id, Users_add_street, Users_add_barangay, Users_add_city,User_add_province) VALUES (?,?,?,?,?)")->execute([$user_id, $street, $barangay,  $city, $province]);
          
    }

    // function signupUser($username, $password, $firstName, $lastName, $birthday, $sex) {
    //     $con = $this->opencon();
    
    //     $query = $con->prepare("SELECT username FROM users WHERE username = ?");
    //     $query->execute([$username]);
    //     $existingUser = $query->fetch();
    //     if ($existingUser){
    //         return false; 
    //     }
    //     $query = $con->prepare("INSERT INTO users (username, passwords, first_name, last_name, birthday, sex) VALUES (?, ?, ?, ?, ?,?)");
    //     $query->execute([$username, $password, $firstName, $lastName, $birthday,$sex]);
    //     return $con->lastInsertId();
    // }function insertAddress($user_id, $city, $province, $street, $barangay) {
    //     $con = $this->opencon();
    //     return $con->prepare("INSERT INTO users_address (user_id, Users_add_city, User_add_province, Users_add_street, Users_add_barangay) VALUES (?, ?, ?, ?, ?)")
    //         ->execute([$user_id, $city, $province, $street, $barangay]);
    // }
    function view(){
        $con = $this->opencon();
        return $con->query("SELECT users.user_id, users.user_profile, users.first_name, users.last_name,users.passwords, users.birthday, users.sex, users.username, CONCAT(users_address.Users_add_street,' ', users_address.Users_add_barangay,' ', users_address.Users_add_city,' ', users_address.User_add_province) AS address FROM users JOIN users_address ON users.user_id=users_address.user_id")->fetchAll();
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
    function viewdata($id){
        try {
            $con = $this->opencon();    
            $query = $con->prepare("SELECT users.user_id, users.username, users.passwords, users.first_name, users.last_name, users.birthday, users.sex, users_address.Users_add_street, users_address.Users_add_barangay, users_address.Users_add_city, users_address.User_add_province FROM users JOIN users_address ON users.user_id=users_address.user_id WHERE users.user_id = ?");
            $query->execute([$id]);
            return $query->fetch();
        } catch (PDOException $e) {
            return [];
            
        }
    }
    function updateUser($user_id, $firstname, $lastname, $birthday, $sex, $username, $password){
        try {
            $con = $this->opencon();    
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET username=?,passwords=?,first_name=?,last_name=?,birthday=?,sex=? WHERE user_id=?");
            $query->execute([$username, $password, $firstname, $lastname, $birthday, $sex, $user_id]);
            $con->commit();
            return true;
        }
        catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
    function updateUserAddress($user_id, $city, $province, $street, $barangay){
        try {
            $con = $this->opencon();    
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users_address SET Users_add_city=?, User_add_province=?,Users_add_street=?,Users_add_barangay=? WHERE user_id=?");
            $query->execute([$city, $province, $street, $barangay, $user_id]);
            $con->commit();
            return true;
        }
        catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

}