<?php

function defaultConnectToDatabase() {
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "forumdb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function checkEmptyInput($parameter, $message = '') {
    if(empty($parameter)) {
        echo $message . "<br>";
        
        return true;
    }
}

function exitOnEmptyInput($parameter, $message = ''): void {
    if(empty($parameter)) {
        exit($message);
    }
}

function selectFromDbSimple($sql):array 
{
    exitOnEmptyInput($sql, "Empty 'select' query in line: " . __LINE__);

    $conn   = defaultConnectToDatabase();
    $result = $conn->query($sql);
    $data   = [];

    // echo $sql . "<br>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    return $data;
}

function executeQuery($sql) 
{
    exitOnEmptyInput($sql, "Empty query in line: " . __LINE__);

    $conn   = defaultConnectToDatabase();
    $result = $conn->query($sql);

    if(empty($result)) {
        echo "Query execution failure!" . "<br>" . $sql . "<br>";
    } else {
        echo "Query execution success!" . "<br>" . $sql . "<br>";
    }

    $conn->close();
}

function getLatestTopics() {
    // Fetch the latest posts from the database
    $sql = "SELECT TopicID, UserID, Title, Content, DateCreated
            FROM Topics
            ORDER BY DateCreated DESC
            LIMIT 5"; // Assuming you want to retrieve the latest 5 posts

    try {
        $posts = selectFromDbSimple($sql);
        return $posts;
    } catch (PDOException $e) {
        // Handle query error
        die("Query failed: " . $e->getMessage());
    }
}

function getTopicDetails($topicID) {
    exitOnEmptyInput($topicID, "Empty 'topicID' parameter in line: " . __LINE__);

    $conn = defaultConnectToDatabase();

    // Prepare and execute the SQL query to fetch topic details
    $sql = "SELECT TopicID, UserID, Title, Content, DateCreated
            FROM topics
            WHERE TopicID = $topicID";

    $result = $conn->query($sql);

    if (!$result) {
        echo "Error retrieving topic details: " . $conn->error;
        $conn->close();
        return null;
    }

    // Fetch the topic details
    $topicDetails = $result->fetch_assoc();

    $conn->close();

    return $topicDetails;
}
function fetchUserIDFromDatabase($userName, $password)
{
    // Fetch the user ID from the database
    $sql = "SELECT UserID FROM users WHERE Username = ? AND Password = ?";

    try {
        $result = selectFromDbSimpleWithParams($sql, ['ss', $userName, $password]);
        return $result[0]['UserID'] ?? null;
    } catch (Exception $e) {
        // Handle query error
        die("Query failed: " . $e->getMessage());
    }
}

function selectFromDbSimpleWithParams($sql, $params): array 
{
    exitOnEmptyInput($sql, "Empty 'select' query in line: " . __LINE__);

    $conn = defaultConnectToDatabase();
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        if (!empty($params)) {
            $stmt->bind_param(...$params);
        }

        // Execute the statement
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();

    return $data;
}
function getUserRoleFromDatabase($userName) {
    $conn = defaultConnectToDatabase();

    try {
        $stmt = $conn->prepare("SELECT Role FROM users WHERE Username = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->bind_result($userRole);
        $stmt->fetch();

        $conn->close();

        return $userRole;
    } catch (Exception $e) {
        // Handle query error
        die("Query failed: " . $e->getMessage());
    }
}


function getPostsForTopic($topicID) {
    $conn = defaultConnectToDatabase();

    try {
        // Use parameterized query to prevent SQL injection
        $query = "SELECT * FROM posts WHERE TopicID = ? ORDER BY DateCreated DESC";
        $statement = $conn->prepare($query);

        if (!$statement) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $statement->bind_param('i', $topicID);
        $statement->execute();

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception("Error fetching result: " . $conn->error);
        }

        $posts = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $statement->close();

        return $posts;
    } catch (Exception $e) {
        // Log or display the error message
        die("Error fetching posts: " . $e->getMessage());
    } finally {
        // Close the connection
        $conn->close();
    }
}

function executeQueryPrepared($sql, $params) {
    exitOnEmptyInput($sql, "Empty query in line: " . __LINE__);

    $conn = defaultConnectToDatabase();
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i'; // integer
                } elseif (is_double($param)) {
                    $types .= 'd'; // double
                } else {
                    $types .= 's'; // string
                }
            }
            $stmt->bind_param($types, ...$params);
        }

        // Execute the statement
        $stmt->execute();

        if ($stmt->errno) {
            echo "Error executing query: " . $stmt->error;
        } else {
            echo "Query executed successfully!" . "<br>" . $sql . "<br>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}

function selectFromDbPrepared($sql, $params): array {
    exitOnEmptyInput($sql, "Empty 'select' query in line: " . __LINE__);

    $conn = defaultConnectToDatabase();
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i'; // integer
                } elseif (is_double($param)) {
                    $types .= 'd'; // double
                } else {
                    $types .= 's'; // string
                }
            }
            $stmt->bind_param($types, ...$params);
        }

        // Execute the statement
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();

    return $data;
}
function getPostDetails($postID) {
    exitOnEmptyInput($postID, "Empty 'postID' parameter in line: " . __LINE__);

    $conn = defaultConnectToDatabase();

    // Prepare and execute the SQL query to fetch post details
    $sql = "SELECT PostID, TopicID, UserID, Content, DateCreated
            FROM posts
            WHERE PostID = $postID";

    $result = $conn->query($sql);

    if (!$result) {
        echo "Error retrieving post details: " . $conn->error;
        $conn->close();
        return null;
    }

    // Fetch the post details
    $postDetails = $result->fetch_assoc();

    $conn->close();

    return $postDetails;
}

function deletePost($postID) {
    exitOnEmptyInput($postID, "Empty 'postID' parameter in line: " . __LINE__);

    $conn = defaultConnectToDatabase();

    // Prepare and execute the SQL query to delete the post
    $sql = "DELETE FROM posts WHERE PostID = $postID";

    $result = $conn->query($sql);

    if (!$result) {
        echo "Error deleting post: " . $conn->error;
    }

    $conn->close();
}

?>
