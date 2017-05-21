$(function(){

	var currentPage = 0;
	var limit = 10;

	var showGoodsList = function(response) {
		$("#goodsList").empty();
		$.tmpl($("#goodsListTemplate"), response).appendTo("#goodsList");
	}

	// 初期処置
	ajax({
		data: { 
			pagenum: currentPage ,
			limit: 10 
		},
		url: apiList.goodsList,
		success: showGoodsList
	})

	$("#goodsList").on('click', '.edit', function() {

		var editGoods = function(response) {
			console.log(response);
			$("#goodsInfo").empty();
			$("#goodsList").hide();
			$("#goodsInfo").show();
			// 口コミデータ設定
			$.tmpl($("#goodsInfoTemplate"), response.goodsInfo).appendTo("#goodsInfo");
			// ⭐️パーツ初期化
			$("#popularity").raty({score: response.goodsInfo.popularity});
		}

		var goodsId = $(this).attr("data");

		ajax({
			url: apiList.goodsInfo,
			data: {
				goodsId: goodsId
			},
			success: editGoods
		})

	});

	$("#goodsList").on('click', '.delete', function() {

	});	
});
