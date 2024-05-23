<?php
require_once('classes/database.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['search'])) {
        $searchterm = $_POST['search']; 
        $con = new database();

        try {
            $connection = $con->opencon();
            
            // Check if the connection is successful
            if ($connection) {
                // SQL query with JOIN
                $query = $connection->prepare("SELECT users.user_id, users.first_name, users.last_name, users.birthday, users.sex, users.username, users.user_profile, CONCAT(users_address.Users_add_city,', ', users_address.User_add_province) AS address FROM users INNER JOIN users_address ON users.user_id = users_address.user_id WHERE users.username  LIKE ? OR users.first_name LIKE ? OR users.user_id LIKE ? OR CONCAT(users_address.Users_add_city,', ', users_address.User_add_province) LIKE ? ");
                $query->execute(["%$searchterm%","$searchterm%","%$searchterm%","%$searchterm%"]);
                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                // Generate HTML for table rows
                $html = '';
                foreach ($users as $user) {
                    $html .= '<tr>';
                    $html .= '<td>' . $user['user_id'] . '</td>';
                    $html .= '<td><img src="' . htmlspecialchars($user['user_profile']) . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
                    $html .= '<td>' . $user['first_name'] . '</td>';
                    $html .= '<td>' . $user['last_name'] . '</td>';
                    $html .= '<td>' . $user['birthday'] . '</td>';
                    $html .= '<td>' . $user['sex'] . '</td>';
                    $html .= '<td>' . $user['username'] . '</td>';
                    $html .= '<td>' . $user['address'] . '</td>';
                    $html .= '<td>'; // Action column
                    $html .= '<div class="btn-group" role="group">';
                    $html .= '<form action="update.php" method="post" style="display: inline;">';
                    $html .= '<input type="hidden" name="id" value=".'. $user['user_id'].'">';
                    $html .= '<button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>';
                    $html .= '</button>';
                    $html .= '</form>';
                    $html .= '<form method="POST" class="d-inline">';
                    $html .= '<input type="hidden" name="id" value=".'. $user['user_id'].'">';
                    $html .= '<button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm("Are you sure you want to delete this user?")">';
                    $html .= '<i class="fas fa-trash-alt"></i>';
                    $html .= '</button>';
                    $html .= '</form>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
                echo $html;
            } else {
                echo json_encode(['error' => 'Database connection failed.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'No search query provided.']);
    }
} 