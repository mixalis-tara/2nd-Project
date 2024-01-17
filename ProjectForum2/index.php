<?php 
require('functions/userFunctions.php'); 
require('functions/genericFunctions.php'); 
require('functions/databaseFunctions.php'); 

startSession();
// showLoggedUser();
$topics = getLatestTopics();

if (isset($_GET['message'])) {
    $loginMessage = $_GET['message'];
    echo '<div class="loginMessage">' . htmlspecialchars($loginMessage) . '</div>';
    // Clear the welcome message from the URL to avoid displaying it on page reload
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
                    if (isUserAdmin()) {
                    echo '<li><a href="addUserAsAdmin.php">Add User</a></li>';
                    }
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
        <section class="latest-topics">
            <h2>Latest Topics</h2>
            <ul>
                <?php foreach ($topics as $topic) : ?>
                    <li>
                        <a href="topics.php?topic_id=<?= $topic['TopicID']; ?>"><?= htmlspecialchars($topic['Title']); ?></a>
                        <p><?= $topic['Content']; ?> Date Created: <?= htmlspecialchars($topic['DateCreated']); ?></p>
                        <!-- Display the delete button only for admin -->
                            <?php if (isUserAdmin()) : ?>
                                <form action="servers/deleteTopicServer.php" method="post" style="display: inline;">
                                <input type="hidden" name="topic_id" value="<?= $topic['TopicID']; ?>">
                                <button type="submit" style="background-color: #dc3545; color: #ffffff; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 14px;" onclick="return confirm('Are you sure you want to delete this topic?');">Delete</button>
                                </form>
                            <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Display the "Create a New Topic" button only if the user is logged in -->
        <?php if (existsLoggedUser()) : ?>
            <section class="create-topic">
                <h2>Create a New Thread</h2>
                <a href="createTopic.php"><button style="background-color: #007bff; color: #ffffff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">Create New Topic</button></a>
            </section>
        <?php endif; ?>
</main>


    <footer>
        <div class="container">
            <h2>Tara Forums</h2>
        </div>
    </footer>


</body>
</html>
