<?php 
require('functions/userFunctions.php'); 
require('functions/genericFunctions.php'); 
require('functions/databaseFunctions.php'); 

startSession(); 
// Check for a username in the URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];
}
// Check for a welcome message in the URL
if (isset($_GET['message'])) {
    $welcomeMessage = $_GET['message'];
    echo '<div class="messageWelcome">' . htmlspecialchars($welcomeMessage) . '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style/styleMain.css">
    <link rel="stylesheet" type="text/css" href="style/styleLogin.css">
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
                    <li><a href="users_Create.php"">Create Account</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <form action="servers/loginServer.php" method="POST">
            <label>Username
            <input type="text" id="username" name="username" placeholder="Insert UserName" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </label>
            <br/>
            <label>Password
                <input type="password" id="password" name="password" placeholder="Insert Password">
            </label>
            <br/>
            <button type="submit">Login</button>
        </form>
    </main>

    <footer>
        <div class="container">
            <!-- Add footer content -->
        </div>
    </footer>

    <!-- Add your JavaScript scripts or link to external scripts here -->

</body>
</html>