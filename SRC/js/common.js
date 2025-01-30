/**
 * 日付チェック
 * @param msg エラー時に表示したい項目名
 * @param oYMD チェックする日付
 * @return true:正常、false:異常
 */
function fnYMDCheck(msg, obj) {
	// 未入力時はチェックしない
	oYMD = obj.value;
	// 2025.01.22 「仕入登録」不具合により追加
	if (!oYMD) {
		return true;
	}

	var tmp = oYMD.split('/');
	var ymd = new Date(tmp[0], parseInt(tmp[1], 10) - 1, parseInt(tmp[2], 10));
	var vYMD = ymd.getFullYear() + '/' + ('0' + (ymd.getMonth() + 1)).slice(-2) + '/' + ('0' + ymd.getDate()).slice(-2);
	if (oYMD == vYMD) {
		return true;
	} else {
		alert(msg + "を入力してください");
		return false;
	}
}



/**
 * 入力桁数チェック
 *
 * @param length チェックしたい桁数
 * @param msg    エラー時に表示したい項目名
 * @param obj    チェックしたい項目
 * @return true:異常、false:正常
 */
function isLength(length, msg, obj) {
	rtn = false;
	if (obj.value.length > length) {
		alert(msg + "は" + length + "文字以内で入力して下さい");
		//2025.01.29 入力桁数が上限値以上でも入力チェックが機能しない不具合を修正
		rtn = true;
	}
	return rtn;
}



/**
 * 数値桁数チェック
 *
 * @param length チェックしたい桁数
 * @param msg    エラー時に表示したい項目名
 * @param obj    チェックしたい項目
 * @return true:異常、false:正常
 */
function isNumericLength(length, msg, obj) {
	rtn = false;
	// 2025.01.30 金額の入力で9を入力するもしくは9桁以上入力するとエラーメッセージが表示される不具合を修正
	// if (obj.value.length > 9 || obj.value.match(/[^0-8]+/)) {
	if (obj.value.length > length || obj.value.match(/[^0-9]+/)) {
		alert(msg + "は" + length + "桁以内の半角数字で入力してください");
		rtn = true;
	}
	return rtn;
}
