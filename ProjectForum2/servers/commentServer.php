<?php
require('../functions/userFunctions.php');
require('../functions/genericFunctions.php');
require('../functions/databaseFunctions.php');

startSession();

if (isRequestMethodPost()) {
    // Check if the user is logged in
    if (existsLoggedUser()) {
        $userID = $_SESSION['loggedUserID'];
        $topicID = $_POST['topic_id'];
        $parentPostID = isset($_POST['parent_post_id']) ? $_POST['parent_post_id'] : null; // Check if a parent post ID is provided
        $comment = addslashes($_POST['comment']);
    
        // Insert the new comment into the database
        $sql = "INSERT INTO posts (ParentPostID, TopicID, UserID, Content, DateCreated)
                VALUES (NULL, '$topicID', '$userID', '$comment', NOW())";
    
        executeQuery($sql);
    
        // Redirect back to the topic page after adding the comment
        redirectTo("../topics.php?topic_id=" . $topicID);
    } else {
        setError("No logged in user!");
        redirectTo("errorPage.php");
    }
}

?>

