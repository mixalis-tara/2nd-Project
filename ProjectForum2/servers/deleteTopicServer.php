<?php
require('../functions/userFunctions.php');
require('../functions/genericFunctions.php');
require('../functions/databaseFunctions.php');

startSession();

if (existsLoggedUser() && isUserAdmin() && isRequestMethodPost()) {
    $topicID = $_POST['topic_id'];

    // Check if the topic exists
    $topicDetails = getTopicDetails($topicID);

    if ($topicDetails) {
        // Delete the topic
        $sql = "DELETE FROM topics WHERE TopicID = ?";
        executeQueryPrepared($sql, [$topicID]);

        $message = "Topic '{$topicDetails['Title']}' deleted successfully.";
        redirectTo("../index.php?message=" . urlencode($message));
    } else {
        $message = "Topic not found.";
        redirectTo("../index.php?message=" . urlencode($message));
    }
} else {
    setError("Unauthorized access or invalid request method.");
    redirectTo("../errorPage.php");
}
?>
