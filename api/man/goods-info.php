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
$goodsId = $request['goodsId'];

// 一覧取得
$stmt = $dbh->prepare("select * from TRN_GOODS where id = :id");
$stmt->bindParam(':id', $goodsId, PDO::PARAM_INT);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$response->goodsInfo = $row;
}

// 口コミリスト取得
$stmt = $dbh->prepare("select * from TRN_ASSESS where goods_id = :id");
$stmt->bindParam(':id', $goodsId, PDO::PARAM_INT);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
	$response->goodsInfo->accessList[] = $row;
}

$response->responseCode = RESPONSE_SUCCESS;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>