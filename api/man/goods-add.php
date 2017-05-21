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

// ---------------------
//       処理開始
// ---------------------
$request = json_decode(file_get_contents('php://input'), true);

$imageFile = $_FILES['image']['tmp_name'];
$ext = end(explode('.', $_FILES['image']['name']));
$imageFileName = $_POST["goods_id"] . '.' . $ext;
// 画像保存
move_uploaded_file($imageFile, '../../img/goods/' . $imageFileName);

// 商品テーブルに情報追加
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

$stmt->bindParam(':id', $_POST["goods_id"]);
$stmt->bindParam(':name', $_POST["goods_name"]);
$stmt->bindParam(':capacity', $_POST["capacity"]);
$stmt->bindParam(':price', $_POST["price"]);
$stmt->bindParam(':long_term_price', $_POST["long_term_price"]);
$stmt->bindParam(':publisher', $_POST["publisher"]);
$stmt->bindParam(':catch', $_POST["catch"]);
$stmt->bindParam(':image', $imageFileName);
$url = IMG_BASE_PATH . $_POST["id"];
$stmt->bindParam(':url', $url);
$stmt->bindParam(':one_day_price', $_POST["one_day_price"]);
$stmt->bindParam(':expect_degree', $_POST["expect_degree"]);
$stmt->bindParam(':popularity', $_POST["popularity"]);
$stmt->bindParam(':cost_performence', $_POST["cost_performence"]);
$stmt->bindParam(':hormone_suppress', $_POST["hormone_suppress"]);
$stmt->bindParam(':circulation_prompt', $_POST["circulation_prompt"]);
$stmt->bindParam(':cell_activation', $_POST["cell_activation"]);
$stmt->bindParam(':bulge_activation', $_POST["bulge_activation"]);
$stmt->bindParam(':growth_prompt', $_POST["growth_prompt"]);
$stmt->bindParam(':hair_growth_effect_1', $_POST["hair_growth_effect_1"]);
$stmt->bindParam(':hair_growth_effect_1_title', $_POST["hair_growth_effect_1_title"]);
$stmt->bindParam(':hair_growth_effect_1_detail', $_POST["hair_growth_effect_1_detail"]);
$stmt->bindParam(':hair_growth_effect_2', $_POST["hair_growth_effect_2"]);
$stmt->bindParam(':hair_growth_effect_2_title', $_POST["hair_growth_effect_2_title"]);
$stmt->bindParam(':hair_growth_effect_2_detail', $_POST["hair_growth_effect_2_detail"]);
$stmt->bindParam(':recommend_1', $_POST["recommend_1"]);
$stmt->bindParam(':recommend_1_detail', $_POST["recommend_1_detail"]);
$stmt->bindParam(':recommend_2', $_POST["recommend_2"]);
$stmt->bindParam(':recommend_2_detail', $_POST["recommend_2_detail"]);
$stmt->bindParam(':recommend_3', $_POST["recommend_3"]);
$stmt->bindParam(':recommend_3_detail', $_POST["recommend_3_detail"]);

$stmt->execute();

// 口コミテーブルに情報追加
for($i = 1; $i <= 5; $i++) {
	$assess = $_POST["assess".$i];
	if (isset($assess) && (strlen($assess) > 1)) {
		$stmt = $dbh->prepare("insert into trn_assess(goods_id, assess) values(:goods_id, :assess)");
		$stmt->bindParam(":goods_id", $_POST["goods_id"]);
		$stmt->bindParam(":assess", $_POST["assess".$i]);
		$stmt->execute();
	}
}

// 成分テーブルに情報追加
if (isset($_POST["comp"])) {
	foreach( $_POST["comp"] as $comp) {
		$stmt = $dbh->prepare("insert into trn_goods_comp(goods_id, comp_id) values(:goods_id, :comp_id)");
		$stmt->bindParam(":goods_id", $_POST["goods_id"]);
		$stmt->bindParam(":comp_id", $comp);
		$stmt->execute();
	}
}

$response->responseCode = RESPONSE_SUCCESS;

// 検索結果返却
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>