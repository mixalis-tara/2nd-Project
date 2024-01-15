<?php 
require('../functions/userFunctions.php'); 
require('../functions/genericFunctions.php'); 
require('../functions/databaseFunctions.php'); 

startSession();

if (isRequestMethodPost()) {
    $userName = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    if (isset($userName) && isset($password)) {
        // Retrieve the user ID from the database
        $userID = fetchUserIDFromDatabase($userName, $password);

        if ($userID !== null) {
            // Log in the user
            $userRole = getUserRoleFromDatabase($userName);  // Assuming you have a function to get the user role
            $logUserInResult = logUserIn($userID, $userName, $userRole);

            if ($logUserInResult) {
                // Redirect to index.php with welcome message
                $loginMessage = "Welcome, " . $userName . "!";
                redirectTo("../index.php?message=" . urlencode($loginMessage));
                exit; // Stop script execution after redirection
            } else {
                echo "Another user is already logged in!";
            }
        } else {
            // User not found or incorrect credentials
            $errorMessage = "Incorrect username or password. Please try again.";
            redirectTo("../login.php?message=" . urlencode($errorMessage) . "&username=" . urlencode($userName));
            exit; // Stop script execution after redirection
        }
    }
} else {
    setError("Tried to send data without 'Post' Method!");
    redirectTo("../errorPage.php");
}
?>
