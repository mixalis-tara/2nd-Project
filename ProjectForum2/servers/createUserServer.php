<?php 
require('../functions/userFunctions.php'); 
require('../functions/genericFunctions.php'); 
require('../functions/databaseFunctions.php'); 

startSession();

if(isRequestMethodPost()) {
    $userData = [
        'Username' => $_POST['username'],
        'email'     => $_POST['email'],
        'password'  => $_POST['password']
    ];

    $username = $userData['Username'];

    $sql = "SELECT UserID
            FROM users
            WHERE Username = '{$username}'";

    $data = selectFromDbSimple($sql);

    if(!empty($data)) {
        $message = "User with username '$username' already exists. Choose a different username.";
        redirectTo("../users_Create.php?message=" . urlencode($message));
        exit;
    }
    

    $fields = "";
    $values = "";

    foreach($userData as $field => $value) {
        if(!empty($value)) {
            $fields .= "$field, ";
            $values .= "'$value', ";
        }
    }

    
    $fields = rtrim($fields, ', ');
    $values = rtrim($values, ', ');

    $sql = "INSERT INTO users ({$fields}) 
            VALUES ({$values})";

    executeQuery($sql);

    $welcomeMessage = "Welcome, $username! Your account has been created successfully.";
    redirectTo("../login.php?message=$welcomeMessage");
} else {
    setError("Tried to send data without 'Post' Method!");
    redirectTo("../errorPage.php");
}
?>