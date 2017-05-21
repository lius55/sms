<?php
header('Content-type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once '../config.php';

$response = new stdClass();
session_start();
if($_SESSION["auth"] != true) {
	$response->responseCode = RESPONSE_ERROR;
	$response->responseMsg = '認証失敗。';
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

// 成分テーブル検索
$stmt = $dbh->prepare("select id,name from TRN_COMP");
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$response->compList[] = $row;
}
$response->responseCode = RESPONSE_SUCCESS;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>