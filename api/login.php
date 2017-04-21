<?php
header('Content-type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once 'config.php';

$request = json_decode(file_get_contents('php://input'), true);
$username = $request["username"];
$password = $request["password"];

$stmt = 
	$dbh->prepare("select count(*) as num from mst_admin where username=:username and password=:password");

$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', md5($password));
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_OBJ);

$response = new stdClass();
if($result->num > 0){
	session_start();
	$_SESSION["auth"] = true;
	$response->responseCode = RESPONSE_SUCCESS;
} else {
	$response->responseCode = RESPONSE_ERROR;
	$response->responseMsg = 'ログインユーザ名またはパスワードが間違っています。';
}

// 検索結果返却
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>