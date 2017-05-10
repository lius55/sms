const apiBaseUrl = 'http://localhost:8888/sms/api/';
const apiList = {
    login: apiBaseUrl + 'login.php',
    goodsAdd: apiBaseUrl + 'man/goods-add.php'
};

const ResponseCode = {
    Success:    'success',
    Error:      'error' 
};

/*
 * api呼び出し用ajaxラッピング関数
 * @param option $.ajaxオプション
 */
const ajax = function(option) {
    $.ajax({
        type: 'POST',
        url: option.url,
        data: JSON.stringify(option.data),
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        cache: false,
        success: option.success,
        beforeSend: function(jqXHR, settings) {
            // TODO ajax呼び出し前の処理をここに書けば、各イベント処理の中でいちいち呼び出さなくてもすむ
            // if(validateMstGrp($("[validateMstGrp]"))) { return false; }
            // if(validate($("[validate]"))) { return false; }
            
            // displayLoding();
            return true;
        },
        error: function(xhr){
            if (option.error == undefined) {
                var msg =  (xhr.responseJSON != undefined && xhr.responseJSON.message != undefined) ? 
                        xhr.responseJSON.message : 'システムエラー発生しました。';
                notify(NotifyType.Error, msg);
            } else {
                return option.error;
            }
        },
        complete: function(xhr, status) {
            // removeLoading();
            // validateResponse();
            if ((xhr.responseJSON != undefined) && (xhr.responseJSON.responseCode != ResponseCode.Success)) { 
                notify(NotifyType.Error, xhr.responseJSON.responseMsg); 
            }
        }
    });
};

/*
 * Loadingイメージ表示関数
 */
const displayLoding = function() {
    // ローディング画像が表示されていない場合のみ表示
    if($("#loading").length == 0){
        $("body").append("<div id='loading'></div>");
    } 
}
 
/*
 * Loadingイメージ削除関数
 */
const removeLoading = function() {
    $("#loading").remove();
}

/*
 * お知らせタイプ
 */
const NotifyType = {
    Error:      'error',
    Success:    'success' 
};

/*
 * メッセージ表示クリア
 */
const clearNotify =  function() {
    if ($("#notify").length > 0) {
        $("#notify").hide();
    }
}

/*
 * メッセージ表示(alertの代わりに作りました)
 * @param type メッセージタイプ
 * @param msg  メッセージ内容
 */
const notify = function(type, msg) {

    if ($("#notify").length < 1) {
        $("body").append("<div id='notify' class='alert'>" +
            "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>" +
            msg + "</strong></div>");
    }

    if (type == NotifyType.Error) {
        $("#notify").addClass("alert-danger");
        $("#notify").removeClass("alert-success");
    } else {
        $("#notify").addClass("alert-success");
        $("#notify").removeClass("alert-danger");
    }

    // 5秒後自動的に消します
    setTimeout(clearNotify, 5000);
}