<?php
require('functions/userFunctions.php');
require('functions/genericFunctions.php');
require('functions/databaseFunctions.php');

startSession();

if (isset($_GET['topic_id'])) {
    $topicID = $_GET['topic_id'];

    // Fetch details of the selected topic
    $topicDetails = getTopicDetails($topicID);

    if (!$topicDetails) {
        die("Topic not found!"); // Handle the case where the topic is not found
    }

    // Fetch posts related to the topic
    $posts = getPostsForTopic($topicID);
} else {
    die("Topic ID not provided!"); // Handle the case where no topic ID is provided in the URL
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/styleMain.css">
    <link rel="stylesheet" type="text/css" href="style/styleTopics.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>    
    <header>
        <div class="container">
            <div class="logo">
                <h1>My Forum</h1>
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php
                    // Check if the user is logged in
                    if (existsLoggedUser()) {
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                        echo '<li><a href="users_Create.php">Create Account</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="topic-details">
            <h2><?php echo htmlspecialchars($topicDetails['Title']); ?></h2>
            <p>Started by User<?php echo $topicDetails['UserID']; ?> | Date: <?php echo $topicDetails['DateCreated']; ?></p>
            <p><?php echo ($topicDetails['Content']); ?></p>
        </section>

        <section class="post-section">
        <h3>Posts</h3>
        <?php foreach ($posts as $post) : ?>
            <div class="post">
                <div class="post-header">
                    <p>Posted by User<?php echo $post['UserID']; ?> | Date: <?php echo $post['DateCreated']; ?></p>
                            <?php if (existsLoggedUser() && isUserAdmin()) : ?>
                            <!-- Display delete button only for admin users -->
                            <form action="servers/deletePostServer.php" method="post">
                                <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                            <?php endif; ?>
                </div>
                <div class="post-content">
                    <p><?php echo $post['Content']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

        <?php if (existsLoggedUser()) : ?>
            <!-- Add a "Comment" button for logged-in users -->
            <section class="comment-section">
            <form id="commentSection" action="servers/commentServer.php" method="post">
            <input type="hidden" name="topic_id" value="<?php echo $topicID; ?>">
            <input type="hidden" name="parent_post_id" value="<?php echo $parentPostID; ?>">
            <label for="comment">Your Comment:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
            <br>
            <button type="submit" onclick="submitForm()">Comment</button>
            </form>

            </section>

            <script>
                tinymce.init({
                    selector: '#comment'
                });

                function submitForm() {
                // Update the original textarea with TinyMCE content
                var content = tinymce.get('comment').getContent();
                document.getElementById('comment').value = content;

                // Submit the form
                document.getElementById('commentSection').submit();
            }
            </script>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
        <h4>Tara Forums</h4>
        </div>
    </footer>

</body>
</html>
