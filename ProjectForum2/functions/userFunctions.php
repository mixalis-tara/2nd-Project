<?php

function existsActiveUserSession() 
{
    return session_status() === 2;
}

function existsLoggedUser()
{
    return isset($_SESSION['loggedUserID']) && isset($_SESSION['loggedUserName']) && isset($_SESSION['loggedUserRole']);
}


function isUserAdmin() 
{    
    if (existsLoggedUser()) {
        return $_SESSION['loggedUserRole'] === 'admin';
    }
    
    return false;
}

function showLoggedUser() 
{    
    if(existsLoggedUser()) {
        echo "Logged in user" . "<br>"
            . "UserName: " . $_SESSION['loggedUserName']
            . " Role: " . $_SESSION['loggedUserRole']  . "<br>" . "<br>";
    } else {
        echo "No logged in user!"  . "<br>" . "<br>";
    }
}

function logUserIn($userID, $userName, $userRole)
{
    if (!existsLoggedUser()) {
        $_SESSION['loggedUserID'] = $userID;
        $_SESSION['loggedUserName'] = $userName;
        $_SESSION['loggedUserRole'] = $userRole;

        return true;
    }

    return false;
}


function logUserOut()
{
    if (existsLoggedUser()) {
        $userName = $_SESSION['loggedUserName'];

        unset($_SESSION['loggedUserID']);
        unset($_SESSION['loggedUserName']);
        unset($_SESSION['loggedUserRole']);

        if (existsLoggedUser()) {
            echo "Failed to log out user: $userName";
        } else {
            echo "Successfully logged out user" . "<br>" . $userName;
            redirectTo("index.php");
        }
    } else {
        echo "No user to log out!"  . "<br>";
    }
}
function getUsernameById($userID) {
    $sql = "SELECT Username FROM Users WHERE UserID = ?";
    $result = selectFromDbPrepared($sql, [$userID]);
    
    return $result[0]['Username'] ?? '';
}

?>