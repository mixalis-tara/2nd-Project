<?php
require('../functions/userFunctions.php');
require('../functions/genericFunctions.php');
require('../functions/databaseFunctions.php');

startSession();

if (isRequestMethodPost()) {
    // Check if the user is logged in
    if (existsLoggedUser()) {
        $userID = $_SESSION['loggedUserID'];
        $title = addslashes($_POST['title']);
        $content = addslashes($_POST['content']);
    
        // Insert the new topic into the database
        $sql = "INSERT INTO topics (UserID, Title, Content, DateCreated)
                VALUES ('$userID', '$title', '$content', NOW())";
    
        executeQuery($sql);
    
        // Redirect to index.php after creating the topic
        redirectTo("../index.php");
    } else {
        setError("No logged in user!");
        redirectTo("errorPage.php");
    }
}
?>
