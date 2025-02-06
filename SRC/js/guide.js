//
//案内管理チェック
//
function fnGuideEditCheck() {

	var cnt = document.form.cnt.value;
	// 2025.02.06 入力チェックが2件目から実行され、1件目の入力チェックが行われない不具合を修正
	// for (i = 1; i < cnt; i++) {
	for (i = 0; i < cnt; i++) {

		var msg = "";
		if (cnt > 1) { msg = (i + 1) + "件目の"; }
		// 2025.02.06 案内日(From)の値を取得する変数名が違う不具合を修正
		// tmp = getEditObject(i, "guideStart");
		tmp = getEditObject(i, "guideStartDT");

		if (tmp.value == '') { alert(msg + "案内日(開始日付)を入力してください"); return; }
		if (!fnYMDCheck(msg + "開始日付には正しい日付", tmp)) { return; }
		// 2025.02.06 案内日(From)の入力チェックが２つある不具合を修正
		// if (!fnYMDCheck(msg + "開始日付には正しい日付", getEditObject(i, "guideStartDT"))) { return; }
		if (!fnYMDCheck(msg + "終了日付には正しい日付", getEditObject(i, "guideEndDT"))) { return; }
		if (isLength(100, msg + "担当", getEditObject(i, "charge"))) { return; }

		// 2025.02.06 業者名と営業店のエラーメッセージと表示される項目名が逆になっている不具合を修正(営業店と業者名の順番を逆に)
		if (isLength(100, msg + "業者名", getEditObject(i, "branch"))) { return; }
		if (isLength(100, msg + "営業店", getEditObject(i, "name"))) { return; }

		if (isLength(100, msg + "TEL", getEditObject(i, "tel"))) { return; }
		if (isLength(100, msg + "FAX", getEditObject(i, "fax"))) { return; }

		// 2025.02.06 10文字以上、結果に入力するとエラーメッセージが表示される不具合を修正
		// if (isLength(10, msg + "結果", getEditObject(i, "result"))) { return; }
		if (isLength(1000, msg + "結果", getEditObject(i, "result"))) { return; }

		if (!fnYMDCheck(msg + "受付日には正しい日付", getEditObject(i, "acceptDT"))) { return; }
		if (isLength(100, msg + "受付", getEditObject(i, "accept"))) { return; }
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'guideEditComplete';
		form.submit();
	}
}



function fnGuideDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.guideNo.value = no;
		form.act.value = 'guideDelete';
		form.submit();
	}
}



/**
 * 案内登録の入力値取得用の関数
 *
 * @param cnt      ループ回数
 * @param itemName 項目名
 * @return
 */
function getEditObject(cnt, itemName) {
	var name = "edit[" + cnt + "][" + itemName + "]";
	return document.form.elements[name];
}



/**
 * 物件の検索一覧と登録一覧への相互移動処理
 */
function fnGuideMove(muki, articleNo) {

	if (muki == "toRight") {
		var obj = $("#s" + articleNo);

		// 名称の取得
		var articleName = $(obj.children()[0]).text();
		var articleRoom = $(obj.children()[1]).text();

		// 2025.02.06 物件検索で「＞」を押下すると、右側（案件情報登録候補）で鍵詳細がリンクにならない不具合を修正
		// var articleKey = $(obj.children()[2]).text();
		var articleKey = $(obj.children()[2]).html();

		// 登録リストに保存(右側に移動)
		tags = "<tr id=\"r" + articleNo + "\">";

		// 削除ボタンの作成
		tags += "<td>";
		tags += "<input type=\"button\" value=\"&lt;\" onClick=\"fnGuideMove( 'toLeft', " + articleNo + " );\" />";
		tags += "<input type=\"hidden\" name=\"articleList[" + articleNo + "][articleNo]\" value=\"" + articleNo + "\" />";
		tags += "<input type=\"hidden\" name=\"articleList[" + articleNo + "][article]\" value=\"" + articleName + "\" />";
		tags += "<input type=\"hidden\" name=\"articleList[" + articleNo + "][room]\" value=\"" + articleRoom + "\" />";
		tags += "</td>";

		// 物件名の作成
		tags += "<td>" + articleName + "</td>";

		// 部屋番号の作成
		tags += "<td>" + articleRoom + "</td>";

		// 鍵情報の作成
		// 2025.02.06 「＜」に移動すると、trの閉じるタグがない不具合を修正
		// tags += "<td>" + articleKey;
		tags += "<td>" + articleKey + "</td>";

		tags += "</tr>";

		// 登録側に追加
		$("#regist").append(tags);

		// 検索側の削除
		obj.remove();

	} else {
		var obj = $("#r" + articleNo);

		// 登録リストから削除(左側に移動)
		tags = "<tr id=\"s" + articleNo + "\">";

		// 物件名の作成
		// 2025.02.06 物件検索で「＜」を押下すると、物件名が太字で表示される不具合を修正
		// tags += "<th>" + $(obj.children()[1]).text() + "</th>";
		tags += "<td>" + $(obj.children()[1]).html() + "</td>";

		// 部屋番号の作成
		// 2025.02.06 物件検索で「＜」を押下すると、部屋の値が２つ表示される不具合を修正
		// tags += "<td>" + $(obj.children()[2]).text() + "</td>";　←不要なので削除
		tags += "<td>" + $(obj.children()[2]).html() + "</td>";

		// 鍵情報の作成
		tags += "<td>" + $(obj.children()[3]).html() + "</td>";

		// 登録ボタンの作成
		// 2025.02.06 物件検索で「＜」を押下した後、もう一度「＞」を押しても移動しない不具合を修正
		// tags += "<td><input type=\"button\" value=\"&gt;\" /></td>";
		tags += "<td><input type=\"button\" value=\"&gt;\" onClick=\"fnGuideMove( 'toRight', '" + articleNo + "' );\" /></td>";
		tags += "</tr>";

		// 検索側に追加
		$("#search").append(tags);

		// 登録側の削除
		obj.remove();
	}

	// 色の再設定
	// 2025.02.06 物件検索で複数の「＞」を押下すると、左側(検索結果)の背景色が全てグレーになる不具合を修正
	// $("#search tr").filter(":odd").find("td").attr("class", "list_td1");
	$("#search tr").filter(":odd").find("td").attr("class", "list_td0");

	$("#search tr").filter(":even").find("td").attr("class", "list_td1");

	// 2025.02.06 物件検索で複数の「＞」を押下すると、右側(案件情報登録候補)の背景色が全て白になる不具合を修正
	// $("#regist tr").filter("odd").find(".td").attr("class", "list_td0");
	// $("#regist tr").filter("even").find(".td").attr("class", "list_td1");
	$("#regist tr").filter(":odd").find("td").attr("class", "list_td0");
	$("#regist tr").filter(":even").find("td").attr("class", "list_td1");
}



/**
 * 物件検索の新規登録チェック
 */
function fnGuideRegistCheck() {
	var count = $("#regist tr").length;
	if (count < 2) {
		alert("物件が選択されていません");
		return;
	}
	form.act.value = 'guideEdit';
	form.submit();
}
