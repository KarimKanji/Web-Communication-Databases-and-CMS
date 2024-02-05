<?php 

// include("../../../../../local/mysql_env_real.php");
// $mysqli = new mysqli("mysql.arcada.fi", MYSQLUSER, MYSQLPASS, MYSQLUSER);
// if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error);
 

 $mysqli = new mysqli("mysql.arcada.fi", "kanjikar", "sQv99j3HKx", "kanjikar");
 if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error); 

// include "init.php";

header('content-type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE");

// Spara URL-variablerna ur query string i array $request_vars
parse_str($_SERVER['QUERY_STRING'], $request_vars);
$request_headers = apache_request_headers();

// Hämta data från request body och spara i array $request_body
$request_json = file_get_contents('php://input');
$request_body = json_decode($request_json);

$response = [ 
    "request_method" => $_SERVER['REQUEST_METHOD'],
    "request_body" => $request_body,
    "query_string" => $_SERVER['QUERY_STRING'],
    "request_vars" => $request_vars,
    "request_headers" => $request_headers
];


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($request_headers['api_key'])) {

    $chat_id = $request_headers['api_key'];
    $author_id = "ADMIN" . $request['customer_name'];
    $message = $request_body->message;


    $stmt = $mysqli->prepare("INSERT
    INTO wdbcms_message (
        chat_id,
        author_id,
        message)
    VALUES (
        ?,
        ?,
        ?
        )");


        if (!$stmt) {
                die("SQL ERROR: " . $mysqli->error);
            }
            
            $stmt->bind_param("sss", 
                    $chat_id,
                    $author_id,
                    $message   
                );

                $stmt->execute();

        $response['status'] = "ADMIN message saved in DB";
        $response["api_key"] = $chat_id;
}

 


// if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($request_headers['api_key'])) {
//     // $response["working"] = "yes";
//     // print("hello world");
//     // Använd API Keyn föra att få användarens bokningar
//     $stmt = $mysqli->prepare("SELECT
//     message
//     FROM
//     wdbcms_message
//     WHERE
//     chat_id =  ?");

//     // if (!$stmt) die("SQL ERROR: " . $mysqli->error);

//     $api_key = $request_headers['api_key'];

//     $stmt->bind_param("s", $api_key);

//     $stmt->execute();
//     $result = $stmt->get_result();
//     $rows = [];
//     while ($row = $result->fetch_assoc()) {
//     $rows[] = $row;
//     }    

//     $response["result"] = $rows;

// }

echo json_encode($response);





?>