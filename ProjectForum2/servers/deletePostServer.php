<?php
require('../functions/userFunctions.php');
require('../functions/genericFunctions.php');
require('../functions/databaseFunctions.php');

startSession();

// Check if the user is logged in, is an admin, and the request method is POST
if (existsLoggedUser() && isUserAdmin() && isRequestMethodPost()) {
    // Check if the POST data is present
    if (isset($_POST['post_id'])) {
        $postID = $_POST['post_id'];

        // Fetch details of the selected post
        $postDetails = getPostDetails($postID);

        if ($postDetails) {
            // Delete the post
            deletePost($postID);

            // Redirect to the topic page
            redirectTo("../topics.php?topic_id=" . $postDetails['TopicID']);
        } else {
            setError("Post not found!");
            redirectTo("../index.php");
        }
    } else {
        setError("Post ID not provided!");
        redirectTo("../index.php");
    }
} else {
    setError("Unauthorized access or invalid request method.");
    redirectTo("../errorPage.php");
}
?>
