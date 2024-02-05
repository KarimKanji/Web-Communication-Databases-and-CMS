<?php
// session_start();

// Remove whitespaces, remove extra slashes, and convert to safe html characters
// USE FOR ALL USER INPUT
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Sets up connection to database - use $conn = create_conn(); to open connection and $conn->close();
function create_conn()
{
    // byt error reporting läge
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    //Databaskonfiguration
    $servername = "localhost";
    $username = "kanjikar";
    $password = "sQv99j3HKx";
    $dbname = "kanjikar";

    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $mysqli->set_charset("utf8");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        return $mysqli;
    }
}
