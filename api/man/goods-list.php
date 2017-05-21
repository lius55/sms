<?php
header('Content-type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once '../config.php';

// 認証チェック
$response = new stdClass();
session_start();
if($_SESSION["auth"] != true) {
	$response->responseCode = RESPONSE_ERROR;
	$response->responseMsg = '認証失敗。';
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

$request = json_decode(file_get_contents('php://input'), true);
$pagenum = $request['pagenum'];
$limit = $request['limit'];
$offset = $pagenum * $limit;

// 一覧取得
$stmt = $dbh->prepare("select id,name,price,insert_date from TRN_GOODS limit :offset, :limit");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$response->goodsList[] = $row;
}

$response->pagenum = $pagenum;

// 件数取得
$stmt = $dbh->prepare("select count(*) as count from TRN_GOODS");
$stmt->execute();
$row = $stmt->fetch();
$response->count = $row['count'];
$response->pageCount = ceil($row['count'] / $limit);


$response->responseCode = RESPONSE_SUCCESS;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>