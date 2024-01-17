<?php
require('../functions/userFunctions.php');
require('../functions/genericFunctions.php');
require('../functions/databaseFunctions.php');

startSession();

if (isRequestMethodPost()) {
    $userData = [
        'Username' => $_POST['username'],
        'email'    => $_POST['email'],
        'password' => $_POST['password'],
        'role'     => ($_POST['role'] == 1) ? 'admin' : 'user', // Set role based on the value received
    ];

    $username = $userData['Username'];

    // Check if the username already exists
    $sql = "SELECT UserID
            FROM users
            WHERE Username = ?";
    $data = selectFromDbPrepared($sql, [$username]);

    if (!empty($data)) {
        $message = "User with username '$username' already exists. Choose a different username.";
        redirectTo("../addUserAsAdmin.php?message=" . urlencode($message));
        exit;
    }

    // Prepare fields and values for the SQL query
    $fields = implode(", ", array_keys($userData));
    $placeholders = implode(", ", array_fill(0, count($userData), '?'));

    // Construct the SQL query with prepared statements
    $sql = "INSERT INTO users ($fields) 
            VALUES ($placeholders)";

    // Execute the query with prepared statements
    executeQueryPrepared($sql, array_values($userData));

    $welcomeMessage = "Welcome, $username! Your account has been created successfully.";
    redirectTo("../index.php?message=" . urlencode($welcomeMessage));
} else {
    setError("Tried to send data without 'Post' Method!");
    redirectTo("../errorPage.php");
}
?>
