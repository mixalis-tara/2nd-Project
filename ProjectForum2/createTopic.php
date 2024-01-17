<?php
require('functions/userFunctions.php');
require('functions/genericFunctions.php');
require('functions/databaseFunctions.php');

startSession();
// showLoggedUser();

if (!existsLoggedUser()) {
    // Redirect to the login page or handle the case as needed
    redirectTo("login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Topic - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/styleMain.css">
    <link rel="stylesheet" type="text/css" href="style/styleCreateTopic.css">

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
        <?php if (existsLoggedUser()) : ?>
            <section class="create-topic">
            <h3>Create a New Topic</h3>
            <form id="createTopicForm" action="servers/createTopicServer.php" method="post">
                <!-- Add your form fields here (e.g., Title, Content) -->
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                <br>
                <label for="content">Content:</label>
                <textarea id="mytextarea" name="content" rows="4" required></textarea>
                <br>
                <button type="button" onclick="submitForm()">Create New Topic</button>
            </form>
        </section>

            <!-- Initialize TinyMCE after the form -->
            <script>
                tinymce.init({
                    selector: '#mytextarea'
                });

                function submitForm() {
                // Update the original textarea with TinyMCE content
                var content = tinymce.get('mytextarea').getContent();
                document.getElementById('mytextarea').value = content;

                // Submit the form
                document.getElementById('createTopicForm').submit();
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
