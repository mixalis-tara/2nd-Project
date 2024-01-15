<?php
require('functions/userFunctions.php'); 
require('functions/genericFunctions.php'); 
require('functions/databaseFunctions.php'); 

    // Check for a message in the URL
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo '<div class="message">' . htmlspecialchars($message) . '</div>';
    }

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create User - My Forum</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style/styleMain.css">
        <link rel="stylesheet" type="text/css" href="style/styleCreateUser.css">
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
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </nav>
            </div>
            </header>

            <main class="container">
                <form action="servers/createUserServer.php" method="POST"> 

                <label>User Name
                    <input type="text" id="username" name="username" placeholder="User Name" required>
                </label>
                <br/>

                <label>Email
                    <input type="text" id="email" name="email" placeholder="Email">
                </label>
                <br/>

                <label>Password
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </label>

                <button type="submit">Create Account</button>
                </form>
            </main>

            <footer>
            <div class="container">
                <!-- Add footer content -->
            </div>
            </footer>

        </body>
</html>