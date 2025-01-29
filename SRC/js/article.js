//
//物件管理チェック
//
function fnArticleEditCheck() {
	tmp = form.article.value;
	// 2025.01.28 物件名を入力するとエラーメッセージが表示される不具合を修正
	// if (tmp) {
	if (tmp.length == 0) {
		alert('物件名を入力してください');
		return;
	}

	if (isLength(100, "物件名", form.article)) { return; }

	// 2025.01.29 入力桁数が上限値以上でも入力チェックが機能しない不具合を修正
	if (isLength(100, "部屋番号", form.room)) { return; }
	if (isLength(200, "鍵場所", form.keyPlace)) { return; }
	if (isLength(100, "住所", form.address)) { return; }
	if (isLength(200, "備考", form.articleNote)) { return; }
	if (isLength(100, "キーBox番号", form.keyBox)) { return; }
	if (isLength(100, "3Dパース", form.drawing)) { return; }
	if (isLength(100, "営業担当者", form.sellCharge)) { return; }

	// 2025.01.28　新規登録、更新時に確認メッセージが表示されずに登録される不具合を修正
	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'articleEditComplete';
		form.submit();
	}
}



function fnArticleDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.articleNo.value = no;
		form.act.value = 'articleDelete';
		form.submit();
	}
}
