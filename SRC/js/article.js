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
