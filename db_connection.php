<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'instagram_clone');

function initDatabase(){
	//inicio create_table.php
	//Database configuration
	// Connect
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

	if (mysqli_connect_errno()) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Create database if not exists
	$sql = "CREATE DATABASE IF NOT EXISTS ".DB_NAME;
	if (!mysqli_query($conn, $sql)) {
		die("Error creating database: " . mysqli_error($conn));
	}

	// Select the database
	mysqli_select_db($conn, DB_NAME);

	// Crear tablas

    //Crear tabla usuarios
	$sql = "CREATE TABLE IF NOT EXISTS tasks (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	task_title VARCHAR(255) NOT NULL,
	task_description TEXT NOT NULL,
	color VARCHAR(20) NOT NULL,
	due_date DATE NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	)";

	if (!mysqli_query($conn, $sql)) {
		die("Error creating table: " . mysqli_error($conn));
	}
}

function getDbConnection() {    
    // Connect to MySQL
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check for connection errors
    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }
    
    return $conn;
}

	//Example of function usage
    //$conn = getDbConnection();
    //...
    
    
//Place below all database related functions

?>
