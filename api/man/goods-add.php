<?php
header('Content-type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once '../config.php';

$request = json_decode(file_get_contents('php://input'), true);

$stmt = 
	$dbh->prepare("insert into trn_goods(id, name, capacity, price, long_term_price, publisher," .
		"catch, image, url, one_day_price, expect_degree, popularity, cost_performance," .
		"hormone_suppress, circulation_prompt, cell_activation, bulge_activation, growth_prompt," . 
		"hair_growth_effect_1, hair_growth_effect_1_title, hair_growth_effect_1_detail," . 
		"hair_growth_effect_2, hair_growth_effect_2_title, hair_growth_effect_2_detail," .
		"recommend_1, recommend_1_detail, recommend_2, recommend_2_detail," .
		"recommend_3, recommend_3_detail) values(:id, :name, :capacity, :price, :long_term_price," . 
		":publisher, :catch, :image, :url, :one_day_price, :expect_degree, :popularity," . 
		":cost_performence, :hormone_suppress, :circulation_prompt, :cell_activation," . 
		":bulge_activation, :growth_prompt, :hair_growth_effect_1, :hair_growth_effect_1_title, " . 
		":hair_growth_effect_1_detail, :hair_growth_effect_2, :hair_growth_effect_2_title, " . 
		":hair_growth_effect_2_detail, :recommend_1, :recommend_1_detail, :recommend_2," . 
		":recommend_2_detail, :recommend_3, :recommend_3_detail)");

$stmt->bindParam(':id', $request["id"]);
$stmt->bindParam(':name', $request["name"]);
$stmt->bindParam(':capacity', $request["capacity"]);
$stmt->bindParam(':price', $request["price"]);
$stmt->bindParam(':long_term_price', $request["long_term_price"]);
$stmt->bindParam(':publisher', $request["publisher"]);
$stmt->bindParam(':catch', $request["catch"]);
$stmt->bindParam(':image', $request["image"]);
$url = IMG_BASE_PATH . $request["id"];
$stmt->bindParam(':url', $url);
$stmt->bindParam(':one_day_price', $request["one_day_price"]);
$stmt->bindParam(':expect_degree', $request["expect_degree"]);
$stmt->bindParam(':popularity', $request["popularity"]);
$stmt->bindParam(':cost_performence', $request["cost_performence"]);
$stmt->bindParam(':hormone_suppress', $request["hormone_suppress"]);
$stmt->bindParam(':circulation_prompt', $request["circulation_prompt"]);
$stmt->bindParam(':cell_activation', $request["cell_activation"]);
$stmt->bindParam(':bulge_activation', $request["bulge_activation"]);
$stmt->bindParam(':growth_prompt', $request["growth_prompt"]);
$stmt->bindParam(':hair_growth_effect_1', $request["hair_growth_effect_1"]);
$stmt->bindParam(':hair_growth_effect_1_title', $request["hair_growth_effect_1_title"]);
$stmt->bindParam(':hair_growth_effect_1_detail', $request["hair_growth_effect_1_detail"]);
$stmt->bindParam(':hair_growth_effect_2', $request["hair_growth_effect_2"]);
$stmt->bindParam(':hair_growth_effect_2_title', $request["hair_growth_effect_2_title"]);
$stmt->bindParam(':hair_growth_effect_2_detail', $request["hair_growth_effect_2_detail"]);
$stmt->bindParam(':recommend_1', $request["recommend_1"]);
$stmt->bindParam(':recommend_1_detail', $request["recommend_1_detail"]);
$stmt->bindParam(':recommend_2', $request["recommend_2"]);
$stmt->bindParam(':recommend_2_detail', $request["recommend_2_detail"]);
$stmt->bindParam(':recommend_3', $request["recommend_3"]);
$stmt->bindParam(':recommend_3_detail', $request["recommend_3_detail"]);

$stmt->execute();

$count = $stmt->rowCount();

$response = new stdClass();
if($count > 0){
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