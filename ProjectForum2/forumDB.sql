
CREATE DATABASE ForumDB;

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    RegistrationDate DATETIME NOT NULL,
    Role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE Topics (
    TopicID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Title VARCHAR(255) NOT NULL,
    Content TEXT NOT NULL,
    DateCreated DATETIME NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
);


CREATE TABLE Posts (
    PostID INT PRIMARY KEY AUTO_INCREMENT,
    ParentPostID INT NULL,
    TopicID INT,
    UserID INT,
    Content TEXT NOT NULL,
    DateCreated DATETIME NOT NULL,
    FOREIGN KEY (ParentPostID) REFERENCES Posts(PostID) ON DELETE CASCADE, -- References itself for hierarchical structure
    FOREIGN KEY (TopicID) REFERENCES Topics(TopicID) ON DELETE CASCADE, -- References the TopicID in Topics table
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);


