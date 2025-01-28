//
//業者一覧チェック
//
function fnTradeEditCheck() {
	// 2025.01.27 必須項目である業者名が未入力でもエラーにならない
	tmp = form.name.value;

	// 2025.01.27 必須項目である業者名が未入力でもエラーにならない不具合を修正
	// if (tmp.length < 0) {
	if (tmp.length == 0) {
		alert('業者名を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('業者名は100文字以内で入力してください');
		return;
	}

	// 2025.01.27 業者名（よみ）の入力チェック時に取得する変数名が間違っている不具合を修正
	//tmp = form.nameYomi.value;
	tmp = form.nameFuri.value;
	if (tmp.length > 100) {
		alert('業者名（よみ）は100文字以内で入力してください');
		return;
	}

	tmp = form.branch.value;
	if (tmp.length > 100) {
		alert('支店名は100文字以内で入力してください');
		return;
	}

	tmp = form.branchFuri.value;
	if (tmp.length > 100) {
		alert('支店名（よみ）は100文字以内で入力してください');
		return;
	}

	// 2025.01.27 郵便番号の入力チェックが正しくない
	tmp = form.zip.value;
	//if (tmp.length > 0 && !tmp.match(/^\d{3}(\s*|-)\d{4}$/)) {
	if (tmp.length > 0 && !tmp.match(/^\d{3}-*\d{4}$/)) {
		alert("正しい郵便番号(***-**** 又は ******* )で\n入力してください");
		return;
	}

	tmp = form.prefecture.value;
	// 202.501.27 都道府県の項目に入力した文字数が10文字の時でもエラーになる不具合を修正
	// if (tmp.length >= 10) {
	if (tmp.length > 10) {
		alert('住所（都道府県）は10文字以内で入力してください');
		return;
	}

	tmp = form.address1.value;
	if (tmp.length > 100) {
		alert('住所1（市区町村名）は100文字以内で入力してください');
		return;
	}

	tmp = form.address2.value;
	if (tmp.length > 100) {
		alert('住所2（番地・ビル名）は100文字以内で入力してください');
		return;
	}

	tmp = form.tel.value;
	if (tmp.length > 100) {
		alert('TELは100文字以内で入力してください');
		return;
	}

	tmp = form.fax.value;
	if (tmp.length > 100) {
		alert('FAXは100文字以内で入力してください');
		return;
	}

	tmp = form.mobile.value;
	if (tmp.length > 100) {
		alert('携帯電話は100文字以内で入力してください');
		return;
	}

	// 2025.01.27 新規登録ボタンを押下しても登録処理が行われない不具合を修正
	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'tradeEditComplete';
		form.submit();
	}
}


// 2027.01.27 削除ボタンを押下しても削除処理が行われない不具合を修正
function fnTradeDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		// form.tradeNo.value = no;
		form.act.value = 'tradeDelete';
		form.submit();
	}
}