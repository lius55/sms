$(function(){

	$("#addGoods").on("click", function() {

		console.log("addGoods");

		var requestParam = {
			id 						: $("#goods-id").val(),
			name					: $("#goods-name").val(),
			capacity				: $("#capacity").val(),
			price					: $("#price").val(),
			long_term_price 		: $("#long_term_price").val(),
			publisher				: $("#publisher").val(),
			catch					: $("#catch").val(),
			one_day_price			: $("#one_day_price").val(),
			expect_degree			: $("#expect_degree").find("[name=score]").val(),
			popularity				: $("#popularity").find("[name=score]").val(),
			cost_performence		: $("#cost_performence").find("[name=score]").val(),
			hormone_suppress		: $("#hormone_suppress").find("[name=score]").val(),
			circulation_prompt		: $("#circulation_prompt").find("[name=score]").val(),
			cell_activation 		: $("#cell_activation").find("[name=score]").val(),
			bulge_activation		: $("#bulge_activation").find("[name=score]").val(),
			growth_prompt			: $("#growth_prompt").find("[name=score]").val(),
			hair_growth_effect_1	: $("#hair_growth_effect_1").val(),
			hair_growth_effect_1_title: $("#hair_growth_effect_1_title").val(),
			hair_growth_effect_1_detail: $("#hair_growth_effect_1_detail").val(),
			hair_growth_effect_2	: $("#hair_growth_effect_2").val(),
			hair_growth_effect_2_title: $("#hair_growth_effect_2_title").val(),
			hair_growth_effect_2_detail: $("#hair_growth_effect_2_detail").val(),
			recommend_1				: $("#recommend_1").val(),
			recommend_1_detail		: $("#recommend_1_detail").val(),
			recommend_2				: $("#recommend_2").val(),
			recommend_2_detail		: $("#recommend_2_detail").val(),
			recommend_3				: $("#recommend_3").val(),
			recommend_3_detail		: $("#recommend_3_detail").val(),
		};

		var addSuccess = function(response) {
			alert("success");
		}

		ajax({
			url : apiList.goodsAdd,
			data : requestParam,
			success : addSuccess
		});
	});
});