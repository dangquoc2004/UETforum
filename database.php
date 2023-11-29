<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "csdl";
$conn = "";
try{
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
}
catch(mysqli_sql_exception) {
    echo "You are not connected<br>";
}
if($conn) {
  echo "You are connnected<br>";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csdl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sqlUpdateUsers = "INSERT INTO users (userID, firstName, lastName, userName, password, userPermission, followers, dateRegistration)
VALUES
('3', 'Alice', 'Smith', 'alice_smith', 'hashed_password_3', 'user', 75, '2023-01-01 00:00:00')";

if ($conn->query($sqlUpdateUsers) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sqlUpdateUsers . "<br>" . $conn->error;
}

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Create database
$sql = "CREATE DATABASE csdl";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}
$conn->close();


$sql_users = "CREATE TABLE `csdl`.`users` (
  `userID` varchar(10) NOT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT 'Anonymous',
  `userName` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `userPermission` varchar(45) DEFAULT 'user',
  `followers` int DEFAULT '0',
  `dateRegistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userName_UNIQUE` (`userName`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_groups = "CREATE TABLE `csdl`.`groups` (
  `groupID` varchar(10) NOT NULL,
  `categoryGroup` text,
  PRIMARY KEY (`groupID`),
  UNIQUE KEY `groupID_UNIQUE` (`groupID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_posts = "CREATE TABLE `csdl`.`posts` (
  `postID` varchar(10) NOT NULL,
  `userIDPost` varchar(10) NOT NULL,
  `groupIDPost` varchar(10) DEFAULT NULL,
  `tittlePost` text,
  `descriptionPost` text,
  `numberComments` int DEFAULT '0',
  `numberReactions` int DEFAULT '0',
  `dateOfPost` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`postID`),
  UNIQUE KEY `postID_UNIQUE` (`postID`),
  KEY `userIDPost_idx` (`userIDPost`),
  KEY `groupIDPost_idx` (`groupIDPost`),
  CONSTRAINT `groupIDPost` FOREIGN KEY (`groupIDPost`) REFERENCES `groups` (`groupID`),
  CONSTRAINT `userIDPost` FOREIGN KEY (`userIDPost`) REFERENCES `users` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";  

$sql_reports = "CREATE TABLE `csdl`.`reports` (
  `reportID` varchar(10) NOT NULL,
  `userIDReporting` varchar(10) NOT NULL,
  `userIDReported` varchar(10) NOT NULL,
  `postIDReported` varchar(10) DEFAULT NULL,
  `reasonReport` text NOT NULL,
  `dateOfReport` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reportID`),
  UNIQUE KEY `reportID_UNIQUE` (`reportID`),
  KEY `_idx` (`userIDReporting`),
  KEY `userIDReported_idx` (`userIDReported`),
  KEY `postIDReported_idx` (`postIDReported`),
  CONSTRAINT `postIDReported` FOREIGN KEY (`postIDReported`) REFERENCES `posts` (`postID`),
  CONSTRAINT `userIDReported` FOREIGN KEY (`userIDReported`) REFERENCES `users` (`userID`),
  CONSTRAINT `userIDReporting` FOREIGN KEY (`userIDReporting`) REFERENCES `users` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_comments = "CREATE TABLE `csdl`.`comments` (
  `commentID` varchar(10) NOT NULL,
  `userIDComment` varchar(10) NOT NULL,
  `postIDComment` varchar(10) NOT NULL,
  `repCommentID` varchar(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `numberLikes` int DEFAULT '0',
  `dateOfComment` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`),
  UNIQUE KEY `commentID_UNIQUE` (`commentID`),
  KEY `userIDComment_idx` (`userIDComment`),
  KEY `postIDComment_idx` (`postIDComment`),
  CONSTRAINT `postIDComment` FOREIGN KEY (`postIDComment`) REFERENCES `posts` (`postID`),
  CONSTRAINT `userIDComment` FOREIGN KEY (`userIDComment`) REFERENCES `users` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


$sql_notices = "CREATE TABLE `csdl`.`notices` (
  `noticeID` varchar(10) NOT NULL,
  `userIDNotice` varchar(10) NOT NULL,
  `message` text,
  `statusReadNotice` BOOLEAN NOT NULL DEFAULT FALSE,
  `dateOfNotice` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`noticeID`),
  UNIQUE KEY `noticeID_UNIQUE` (`noticeID`),
  KEY `userIDNotice_idx` (`userIDNotice`),
  CONSTRAINT `userIDNotice` FOREIGN KEY (`userIDNotice`) REFERENCES `users` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_activities = "CREATE TABLE `csdl`.`activities` (
  `activityID` varchar(10) NOT NULL,
  `userIDInteracting` varchar(10) NOT NULL,
  `userIDInteracted` varchar(10) DEFAULT NULL,
  `postIDInteracted` varchar(10) DEFAULT NULL,
  `commentIDInteracted` varchar(10) DEFAULT NULL,
  `login` BOOLEAN DEFAULT FALSE,
  `logout` BOOLEAN DEFAULT FALSE,
  `statusFollow` BOOLEAN DEFAULT FALSE,
  `statusLike`BOOLEAN DEFAULT FALSE,
  `statusEditProfile` BOOLEAN DEFAULT FALSE,
  `dateOfInteract` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activityID`),
  KEY `userIDInteracting_idx` (`userIDInteracting`),
  KEY `userIDInteracted_idx` (`userIDInteracted`),
  KEY `postIDInteracted_idx` (`postIDInteracted`),
  KEY `commentIDInteacted_idx` (`commentIDInteracted`),
  CONSTRAINT `commentIDInteacted` FOREIGN KEY (`commentIDInteracted`) REFERENCES `comments` (`commentID`),
  CONSTRAINT `postIDInteracted` FOREIGN KEY (`postIDInteracted`) REFERENCES `posts` (`postID`),
  CONSTRAINT `userIDInteracted` FOREIGN KEY (`userIDInteracted`) REFERENCES `users` (`userID`),
  CONSTRAINT `userIDInteracting` FOREIGN KEY (`userIDInteracting`) REFERENCES `users` (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql_users) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_groups) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_posts) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_reports) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_comments) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_notices) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}
if ($conn->query($sql_activities) === TRUE) {
  echo "Table MyGuests created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}



$sqlUsers = "
INSERT INTO users (userID, firstName, lastName, userName, password, userPermission, followers, dateRegistration)
VALUES
('1', 'John', 'Doe', 'john_doe', 'hashed_password', 'admin', 100, '2023-01-01 00:00:00'),
('2', 'Jane', 'Smith', 'jane_smith', 'hashed_password', 'user', 50, '2023-01-02 12:30:00'),
('3', 'Alice', 'Smith', 'alice_smith', 'hashed_password_3', 'user', 75, '2023-01-01 00:00:00'),
('4', 'Bob', 'Johnson', 'bob_johnson', 'hashed_password_4', 'user', 30, '2023-01-01 00:00:00'),
('5', 'Eva', 'Williams', 'eva_williams', 'hashed_password_5', 'user', 20, '2023-01-01 00:00:00'),
('6', 'Michael', 'Brown', 'michael_brown', 'hashed_password_6', 'user', 45, '2023-01-01 00:00:00'),
('7', 'Olivia', 'Jones', 'olivia_jones', 'hashed_password_7', 'user', 60, '2023-01-01 00:00:00'),
('8', 'Daniel', 'Miller', 'daniel_miller', 'hashed_password_8', 'user', 80, '2023-01-01 00:00:00'),
('9', 'Sophia', 'Davis', 'sophia_davis', 'hashed_password_9', 'user', 65, '2023-01-01 00:00:00'),
('10', 'Matthew', 'Martinez', 'matthew_martinez', 'hashed_password_10', 'user', 55, '2023-01-01 00:00:00'),
('11', 'Emma', 'Anderson', 'emma_anderson', 'hashed_password_11', 'user', 25, '2023-01-01 00:00:00'),
('12', 'Christopher', 'Taylor', 'christopher_taylor', 'hashed_password_12', 'user', 40, '2023-01-01 00:00:00'),
('13', 'Grace', 'Moore', 'grace_moore', 'hashed_password_13', 'user', 90, '2023-01-01 00:00:00'),
('14', 'James', 'Harris', 'james_harris', 'hashed_password_14', 'user', 70, '2023-01-01 00:00:00'),
('15', 'Lily', 'Clark', 'lily_clark', 'hashed_password_15', 'user', 15, '2023-01-01 00:00:00'),
('16', 'William', 'White', 'william_white', 'hashed_password_16', 'user', 85, '2023-01-01 00:00:00'),
('17', 'Ava', 'Wright', 'ava_wright', 'hashed_password_17', 'user', 35, '2023-01-01 00:00:00'),
('18', 'Ryan', 'Walker', 'ryan_walker', 'hashed_password_18', 'user', 50, '2023-01-01 00:00:00'),
('19', 'Mia', 'Turner', 'mia_turner', 'hashed_password_19', 'user', 10, '2023-01-01 00:00:00'),
('20', 'David', 'Carter', 'david_carter', 'hashed_password_20', 'user', 95, '2023-01-01 00:00:00')
";



$sqlGroups = "
INSERT INTO `groups` (groupID, categoryGroup)
VALUES
('101', 'Technology'),
('102', 'Travel'),
('103', 'Food'),
('104', 'Sports'),
('105', 'Health'),
('106', 'Music'),
('107', 'Fashion'),
('108', 'Education'),
('109', 'Finance'),
('110', 'Art'),
('111', 'Science'),
('112', 'Gaming'),
('113', 'Pets'),
('114', 'Books'),
('115', 'Movies'),
('116', 'Fitness'),
('117', 'Photography'),
('118', 'Business'),
('119', 'Nature'),
('120', 'Cooking')
";

$sqlPosts = "
INSERT INTO posts (postID, userIDPost, groupIDPost, tittlePost, descriptionPost, numberComments, numberReactions, dateOfPost)
VALUES
('201', '1', '101', 'Tech News', 'Exciting developments in the tech world!', 10, 50, '2023-01-03 15:45:00'),
('202', '2', '102', 'Game Highlights', 'Check out the best moments from the game!', 5, 30, '2023-01-04 10:00:00'),
('203', '3', 103, 'First Post', 'This is the first post description.', 10, 50, '2023-01-01 08:00:00'),
('204', '4', 104, 'Hello World', 'Just saying hello to the world!', 5, 30, '2023-01-02 10:30:00'),
('205', '5', 105, 'Coding Journey', 'Sharing my coding journey with everyone.', 15, 70, '2023-01-03 12:45:00'),
('206', '6', 106, 'Beautiful Sunset', 'Captured a breathtaking sunset today.', 8, 40, '2023-01-04 15:15:00'),
('207', '7', 107, 'Travel Adventure', 'Exploring new places and making memories.', 12, 60, '2023-01-05 17:30:00'),
('208', '8', 108, 'Book Recommendation', 'Just finished reading an amazing book!', 7, 35, '2023-01-06 19:45:00'),
('209', '9', 109, 'Fitness Update', 'Reached a new personal best in my workout.', 20, 80, '2023-01-07 22:00:00'),
('210', '10', 110, 'Recipe of the Day', 'Sharing a delicious recipe with everyone.', 11, 55, '2023-01-08 00:15:00'),
('211', '11', 111, 'Tech News', 'Latest updates in the world of technology.', 18, 90, '2023-01-09 02:30:00'),
('212', '12', 112, 'Movie Night', 'Recommendations for a great movie night.', 9, 45, '2023-01-10 04:45:00'),
('213', '13', 113, 'Nature Photography', 'Capturing the beauty of nature through my lens.', 14, 70, '2023-01-11 07:00:00'),
('214', '14', 114, 'Mindfulness Meditation', 'Exploring the benefits of mindfulness.', 6, 30, '2023-01-12 09:15:00'),
('215', '15', 115, 'DIY Project', 'Turning ordinary items into something extraordinary.', 16, 80, '2023-01-13 11:30:00'),
('216', '16', 116, 'Motivational Quotes', 'Inspiring quotes to kickstart your day.', 10, 50, '2023-01-14 13:45:00'),
('217', '17', 117, 'Gaming Highlights', 'Sharing memorable moments from my gaming sessions.', 13, 65, '2023-01-15 16:00:00'),
('218', '18', 118, 'Artistic Expression', 'Expressing emotions through art.', 8, 40, '2023-01-16 18:15:00'),
('219', '19', 119, 'Product Review', 'Reviewing the latest gadgets in the market.', 17, 85, '2023-01-17 20:30:00'),
('220', '20', 120, 'Fashion Inspiration', 'Exploring unique fashion trends.', 9, 45, '2023-01-18 22:45:00')
";

$sqlReports = "
INSERT INTO reports (reportID, userIDReporting, userIDReported, postIDReported, reasonReport, dateOfReport)
VALUES
('301', '1', '2', '201', 'Inappropriate content', '2023-01-05 18:20:00'),
('302', '2', '1', '202', 'Spam', '2023-01-06 09:45:00'),
('303', '3', '1', '203', 'Inappropriate content', '2023-01-01 08:30:00'),
('304', '4', '3', '204', 'Spamming', '2023-01-02 11:00:00'),
('305', '6', '5', '206', 'False information', '2023-01-04 15:45:00'),
('306', '7', '7', '207', 'Violence', '2023-01-05 18:00:00'),
('307', '8', '9', '208', 'Hate speech', '2023-01-06 20:15:00'),
('308', '9', '11', '209', 'Bullying', '2023-01-07 22:30:00'),
('309', '10', '13', '210', 'Privacy violation', '2023-01-08 00:45:00'),
('310', '11', '15', '212', 'Impersonation', '2023-01-09 03:00:00'),
('311', '12', '17', '214', 'Graphic content', '2023-01-10 05:15:00'),
('312', '13', '19', '216', 'Solicitation', '2023-01-11 07:30:00'),
('313', '14', '14', '218', 'Misinformation', '2023-01-12 09:45:00'),
('314', '15', '16', '220', 'Abuse', '2023-01-13 12:00:00'),
('315', '16', '18', '215', 'Offensive language', '2023-01-14 14:15:00'),
('316', '17', '20', '217', 'Copyright infringement', '2023-01-15 16:30:00'),
('317', '17', '12', '219', 'Invasion of privacy', '2023-01-16 18:45:00'),
('318', '18', '4', '211', 'Cyberbullying', '2023-01-17 21:00:00'),
('319', '19', '6', '213', 'Fake news', '2023-01-18 23:15:00'),
('320', '20', '8', '207', 'Spreading hate', '2023-01-19 01:30:00')
";



$sqlComments = "
INSERT INTO comments (commentID, userIDComment, postIDComment, repCommentID, comment, numberLikes, dateOfComment)
VALUES
('401', '1', '201', NULL, 'Great news! Excited for the future.', 15, '2023-01-07 12:10:00'),
('402', '2', '202', '401', 'Agreed! Those highlights were amazing.', 8, '2023-01-08 08:30:00'),
('403', '2', '203', NULL, 'Great post!', 15, '2023-01-01 09:00:00'),
('404', '4', '204', NULL, 'Hello there!', 8, '2023-01-02 11:30:00'),
('405', '6', '205', NULL, 'I love coding too!', 20, '2023-01-03 13:45:00'),
('406', '8', '206', NULL, 'The sunset looks amazing!', 12, '2023-01-04 16:15:00'),
('407', '10', '207', NULL, 'Where did you travel?', 18, '2023-01-05 18:30:00'),
('408', '12', '208', NULL, 'What book did you read?', 10, '2023-01-06 20:45:00'),
('409', '14', '209', NULL, 'Impressive workout!', 25, '2023-01-07 23:00:00'),
('410', '16', '210', NULL, 'Yummy recipe! Cant wait to try it.', 14, '2023-01-09 01:15:00'),
('411', '18', '211', NULL, 'Exciting tech news!', 22, '2023-01-10 03:30:00'),
('412', '20', '212', NULL, 'Movie night sounds fun!', 11, '2023-01-11 05:45:00'),
('413', '3', '213', NULL, 'Amazing photography!', 17, '2023-01-12 08:00:00'),
('414', '5', '214', NULL, 'Mindfulness is so important.', 9, '2023-01-13 10:15:00'),
('415', '7', '215', NULL, 'Creative DIY project!', 21, '2023-01-14 12:30:00'),
('416', '9', '216', NULL, 'Motivational quotes are the best!', 13, '2023-01-15 14:45:00'),
('417', '13', '218', NULL, 'Artistic expression is a beautiful thing.', 12, '2023-01-17 19:15:00'),
('418', '15', '219', NULL, 'Great product review!', 23, '2023-01-18 21:30:00'),
('419', '17', '220', NULL, 'Love the fashion inspiration!', 10, '2023-01-19 23:45:00'),
('420', '19', '219', NULL, 'Awesome music playlist!', 16, '2023-01-20 02:00:00')
";


$sqlNotices = "
INSERT INTO notices (noticeID, userIDNotice, message, statusReadNotice, dateOfNotice)
VALUES
('501', '1', 'You have a new follower!', '0', '2023-01-09 14:00:00'),
('502', '2', 'Your post has been reported.', '0', '2023-01-10 11:20:00'),
('503', '2', 'You have a new follower!', '0', '2023-01-01 09:30:00'),
('504', '4', 'Your post received 10 likes!', '0', '2023-01-02 12:00:00'),
('505', '6', 'Congratulations! Youve reached 100 followers!', '0', '2023-01-03 14:15:00'),
('506', '8', 'Someone commented on your post.', '0', '2023-01-04 16:45:00'),
('507', '10', 'Your comment got a reply.', '0', '2023-01-05 19:00:00'),
('508', '12', 'Youve been mentioned in a post!', '0', '2023-01-06 21:15:00'),
('509', '14', 'Your post has been shared.', '0', '2023-01-07 23:30:00'),
('510', '16', 'New messages in your inbox.', '0', '2023-01-09 01:45:00'),
('511', '18', 'Your report has been reviewed.', '0', '2023-01-10 04:00:00'),
('512', '20', 'Youve earned a badge!', '0', '2023-01-11 06:15:00'),
('513', '3', 'Important system update.', '0', '2023-01-12 08:30:00'),
('514', '5', 'Reminder: Event tomorrow!', '0', '2023-01-13 10:45:00'),
('515', '7', 'Your subscription is expiring soon.', '0', '2023-01-14 13:00:00'),
('516', '9', 'New job opportunities available.', '0', '2023-01-15 15:15:00'),
('517', '11', 'Youve been invited to a group.', '0', '2023-01-16 17:30:00'),
('518', '13', 'Congratulations on your anniversary!', '0', '2023-01-17 19:45:00'),
('519', '15', 'Security alert: Unusual activity detected.', '0', '2023-01-18 22:00:00'),
('520', '17', 'New features added to the platform.', '0', '2023-01-19 00:15:00')
";


$sqlActivities = "
INSERT INTO activities (activityID, userIDInteracting, userIDInteracted, postIDInteracted, commentIDInteracted, login, logout, statusFollow, statusLike, statusEditProfile, dateOfInteract)
VALUES
('601', '2', '1', NULL, NULL, 1, 0, 1, 0, 0, '2023-01-11 16:40:00'),
('602', '1', '2', '201', NULL, 0, 1, 0, 1, 0, '2023-01-12 22:15:00'),
('603', '3', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-13 10:30:00'),
('604', '2', '3', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-14 18:20:00'),
('605', '1', '3', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-15 12:45:00'),
('606', '3', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-16 08:55:00'),
('607', '2', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-17 14:10:00'),
('608', '1', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-18 20:05:00'),
('609', '3', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-19 16:30:00'),
('610', '2', '3', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-20 22:45:00'),
('611', '1', '3', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-21 11:25:00'),
('612', '3', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-22 17:15:00'),
('613', '2', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-23 13:40:00'),
('614', '1', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-24 19:55:00'),
('615', '3', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-25 15:20:00'),
('616', '2', '3', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-26 21:35:00'),
('617', '1', '3', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-27 10:10:00'),
('618', '3', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-28 16:25:00'),
('619', '2', '1', NULL, NULL, 1, 0, 0, 1, 0, '2023-01-29 12:50:00'),
('620', '1', '2', NULL, NULL, 0, 1, 1, 0, 0, '2023-01-30 19:05:00');
";

$sqlUsers = "
INSERT INTO users (userID, firstName, lastName, userName, password, userPermission, followers, dateRegistration)
VALUES
('1', 'John', 'Doe', 'john_doe', 'hashed_password', 'admin', 100, '2023-01-01 00:00:00'),
('2', 'Jane', 'Smith', 'jane_smith', 'hashed_password', 'user', 50, '2023-01-02 12:30:00')
";

$sqlGroups = "
INSERT INTO groups (groupID, categoryGroup)
VALUES
('101', 'Technology'),
('102', 'Sports')
";


$sqlPosts = "
INSERT INTO posts (postID, userIDPost, groupIDPost, tittlePost, descriptionPost, numberComments, numberReactions, dateOfPost)
VALUES
('201', '1', '101', 'Tech News', 'Exciting developments in the tech world!', 10, 50, '2023-01-03 15:45:00'),
('202', '2', '102', 'Game Highlights', 'Check out the best moments from the game!', 5, 30, '2023-01-04 10:00:00')
";

$sqlReports = "
INSERT INTO reports (reportID, userIDReporting, userIDReported, postIDReported, reasonReport, dateOfReport)
VALUES
('301', '1', '2', '201', 'Inappropriate content', '2023-01-05 18:20:00'),
('302', '2', '1', '202', 'Spam', '2023-01-06 09:45:00')
";

$sqlComments = "
INSERT INTO comments (commentID, userIDComment, postIDComment, repCommentID, comment, numberLikes, dateOfComment)
VALUES
('401', '1', '201', NULL, 'Great news! Excited for the future.', 15, '2023-01-07 12:10:00'),
('402', '2', '202', '401', 'Agreed! Those highlights were amazing.', 8, '2023-01-08 08:30:00')
";

$sqlNotices = "
INSERT INTO notices (noticeID, userIDNotice, message, statusReadNotice, dateOfNotice)
VALUES
('501', '1', 'You have a new follower!', 0, '2023-01-09 14:00:00'),
('502', '2', 'Your post has been reported.', 0, '2023-01-10 11:20:00')
";

$sqlActivities = "
INSERT INTO activities (activityID, userIDInteracting, userIDInteracted, postIDInteracted, commentIDInteracted, login, logout, statusFollow, statusLike, statusEditProfile, dateOfInteract)
VALUES
('601', '2', '1', NULL, NULL, 1, 0, 1, 0, 0, '2023-01-11 16:40:00'),
('602', '1', '2', '201', NULL, 0, 1, 0, 1, 0, '2023-01-12 22:15:00')
";


if ($conn->query($sqlUsers) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlUsers . "<br>" . $conn->error;
}

if ($conn->query($sqlGroups) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlGroups. "<br>" . $conn->error;
}

if ($conn->query($sqlPosts) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlPosts . "<br>" . $conn->error;
}

if ($conn->query($sqlReports) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlReports . "<br>" . $conn->error;
}

if ($conn->query($sqlComments) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlComments . "<br>" . $conn->error;
}

if ($conn->query($sqlNotices) === TRUE) {
  echo "New record created successfull<br>";
} else {
  echo "Error: " . $sqlNotices . "<br>" . $conn->error;
}

if ($conn->query($sqlActivities) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sqlActivities . "<br>" . $conn->error;
}

$conn->close();

?>