<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'instagram_clone');

function initDatabase()
{
	//inicio create_table.php
	//Database configuration
	// Connect
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

	if (mysqli_connect_errno()) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Create database if not exists
	$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
	if (mysqli_query($conn, $sql)) {
		if (mysqli_warning_count($conn) == 0) {
			// Select the database
			mysqli_select_db($conn, DB_NAME);

			// Crear tablas

			//Crear tabla usuarios
			$sql = "CREATE TABLE IF NOT EXISTS users (
			id INT AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(255) NOT NULL UNIQUE,
			password VARCHAR(255) NOT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);";
			execQuery($conn, $sql);

			$sql = "INSERT IGNORE INTO users (username, password) VALUES 
			('john_doe', '$2y$10\$zcsqFdqaMa9IDyUTpuPygutBog9kiNz9ecNgMyew.yVtUE7CGPhrC'),  -- Original password: password123
			('jane_doe', '$2y$10\$qsRZ2OuTQSqqfBZfbIAjlew9oJ/jnZDL6AN7tzLpv4cvJHtKzyb4G'), -- Original password: password123
			('alice_smith', '$2y$10$2I.3p6KV5XmIl5ReoqBCr.XHGCZ8jKV3N6.zjOs9pyT9GmWOoVnCi'), -- Original password: alice123
			('bob_jones', '$2y$10\$CMkh35x4pFsx3vCYyd0TSuMwfjHhCdUU3ZIzaT1GMXmG4JAwAruMq'),   -- Original password: bob123
			('charlie_brown', '$2y$10\$AD1I.m0y1Q4Tr.Rztz1pTOWMj.s81CTapfovf7kXc9HWG88iaMAUu'), -- Original password: charlie123
			('diana_white', '$2y$10\$pqL12mU/eDqf0CahydeaT.Y1huJ6YMpF8UNEVNDvRt/a8Amar68Ke'); -- Original password: diana123";
			execQuery($conn, $sql);

			$sql = "CREATE TABLE IF NOT EXISTS photos (
			id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing photo ID
			user_id INT NOT NULL,               -- Foreign key to the `users` table
			file_path VARCHAR(255) NOT NULL,     -- Path to the photo file (e.g., file path in the server)
			caption TEXT,                       -- Caption for the photo
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Photo upload timestamp
			FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key constraint with cascading delete
			);";
			execQuery($conn, $sql);

			$sql = "INSERT IGNORE INTO photos (user_id, file_path, caption, created_at) VALUES 
			(1, 'bd1938b369d87e05d3c6be73d0cbe38b', 'My first photo', '2025-01-01 12:00:00'),
			(1, 'd12d2203225a8e4653fb4461f50785ee', 'Another cool shot', '2025-01-02 14:30:00'),
			(1, 'b894b4b44177306322c801ca8f5517ef', 'Exploring the beach', '2025-01-03 16:45:00'),
			(2, 'c703a7ec0a99b94fdea89ef9e9fdd36e', 'Exploring the city', '2025-01-04 09:15:00'),
			(2, 'a036b29a73d91926f334dd3c7a923c0c', 'Lovely sunset', '2025-01-05 18:30:00'),
			(2, '455a6cff1fac4308f95c02dfa339e295', 'Coffee time!', '2025-01-06 08:00:00'),
			(3, '8d140c7830612d1b7b819fcf16f82416', 'Alice in the park', '2025-01-07 11:20:00'),
			(3, '8acd3142b58bf54b32cc4d7102c9eefc', 'A beautiful hike', '2025-01-08 17:00:00'),
			(4, '5b0ab10dfa89aecdcae340c455ac171e', 'Bob’s vacation', '2025-01-09 13:10:00'),
			(4, '4342e3c5e913db144bb3380fcaee5f7e', 'Bob and his friends', '2025-01-10 20:00:00'),
			(5, 'b77e6b99600c0e46b53a00eb5f1e5f54', 'Charlie at the beach', '2025-01-11 07:30:00'),
			(5, '1ec7505f6b0ad2b9ea568b0579cd3b0c', 'Chilling at the pool', '2025-01-12 19:45:00'),
			(6, '69c07fee7b98c4ca87ffe3c6b0bd707d', 'Diana on a bike ride', '2025-01-13 10:30:00'),
			(6, '455a6cff1fac4308f95c02dfa339e295', 'Diana’s morning run', '2025-01-14 06:15:00');";
			execQuery($conn, $sql);

			$sql = "CREATE TABLE IF NOT EXISTS followers (
			follower_id INT NOT NULL,           -- User ID of the follower
			following_id INT NOT NULL,          -- User ID of the followed user
			PRIMARY KEY (follower_id, following_id), -- Composite primary key (follower and following)
			FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE, -- Cascade delete when user is deleted
			FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE -- Cascade delete when user is deleted
			);";
			execQuery($conn, $sql);

			$sql = "INSERT IGNORE INTO followers (follower_id, following_id) VALUES 
				(1, 2),  -- John follows Jane
				(1, 3),  -- John follows Alice
				(1, 4),  -- John follows Bob
				(2, 1),  -- Jane follows John
				(2, 5),  -- Jane follows Charlie
				(3, 2),  -- Alice follows Jane
				(3, 4),  -- Alice follows Bob
				(3, 6),  -- Alice follows Diana
				(4, 1),  -- Bob follows John
				(4, 5),  -- Bob follows Charlie
				(5, 1),  -- Charlie follows John
				(5, 2),  -- Charlie follows Jane
				(5, 3),  -- Charlie follows Alice
				(5, 6),  -- Charlie follows Diana
				(6, 1),  -- Diana follows John
				(6, 3),  -- Diana follows Alice
				(6, 4),  -- Diana follows Bob
				(6, 5);  -- Diana follows Charlie
				";
			execQuery($conn, $sql);
		}
	} else {
		die("Error creating database: " . mysqli_error($conn));
	}
}

function execQuery($conn, $sql)
{
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		die("Error: " . mysqli_error($conn));
	}
	return $result;
}

function getDbConnection()
{
	// Connect to MySQL
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	// Check for connection errors
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	return $conn;
}

//Example of function usage
//$conn = getDbConnection();
//...


//Place below all database related functions
function getPeopleFollowingMe($following_id) {
	//obtener numero de gente que me sigue
	$sql = "SELECT count(follower_id) AS followers FROM instagram_clone.followers WHERE following_id = ".$following_id."; -- gente que me sigue";
	$result = execQuery(getDbConnection(), $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			return $row["followers"];
		}
	}
}

function getPeopleIFollow($follower_id) {
	$sql = "SELECT count(following_id) AS following FROM instagram_clone.followers WHERE follower_id = ".$follower_id."; -- gente que yo sigo";
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["following"];
            }
        }
}

function deleteUser($logged_user){
	$sql = "DELETE FROM users WHERE username LIKE '".$logged_user."'";
    $result = execQuery(getDbConnection(), $sql);
	return $result;
}

function deletePhoto($photoid){
	$sql = "DELETE FROM photos WHERE id = ".$photoid;
        $result = execQuery(getDbConnection(), $sql);
		return $result;
}
?>