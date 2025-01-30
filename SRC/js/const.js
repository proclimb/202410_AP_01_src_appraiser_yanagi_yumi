//
//工事管理チェック
//
function fnConstEditCheck() {
	tmp = form.area.value;
	// 2025.01.30 面積に小数点以下の値を入力することができない不具合を修正
	// if (tmp.length > 6 || tmp.match(/[^0-9]+/)) {
	if (tmp.length > 0 && !tmp.match(/^([0-9]{1,3})(\.[0-9]{1,2})?$/)) {
		alert('面積は3桁以内（小数点以下2桁以内）の半角数字で入力してください');
		return;
	}
	// 2025.01.30 エラーメッセージが表示されても、登録確認のダイアログボックスも表示される不具合を修正

	/*
	// 2025.01.30 「築年」で使用している入力チェックの関数名が間違っている不具合を修正
	// if (isLengce(100, "築年", form.years))
	if (isLength(100, "築年", form.years)) { return; }
	// 2025.01.30 「販売予定額」の入力可能とする桁数が仕様書とエラーメッセージで合っていない不具合を修正
	if (isNumericLength(8, "販売予定額", form.sellPrice))
		// 2025.01.30 「内装見越額」で使用している入力チェックの変数名が間違っている不具合を修正
		// if (isNumericLength(9, "内装見越額", JKL.Calendar.Style.prototype.cursor))
		if (isNumericLength(9, "内装見越額", form.interiorPrice)) { return; }
	if (isLength(100, "施工業者", form.constTrader))
		if (isNumericLength(9, "工事金額", form.constPrice))
			if (isLength(100, "追加工事", form.constAdd))
				if (isLength(200, "備考", form.constNote))
					if (!fnYMDCheck("正しい買取決済日付", form.purchaseDT))
						if (!fnYMDCheck("正しい工期開始日付", form.workStartDT))
							if (!fnYMDCheck("正しい工期終了日付", form.workEndDT))
								if (!fnYMDCheck("正しい電気水道開栓日付", form.lineOpenDT))
									if (!fnYMDCheck("正しい電気水道閉栓日付", form.lineCloseDT))
										if (!fnYMDCheck("正しい電気水道開栓連絡日", form.lineOpenContactDT))
											if (!fnYMDCheck("正しい電気水道閉栓連絡日", form.lineCloseContactDT))
												if (isLength(200, "備考", form.lineContactNote))
													if (isLength(100, "電気連絡者", form.electricityCharge))
														if (isLength(100, "ガス連絡者", form.gasCharge))
															if (isLength(100, "荷＆鍵引取", form.receive))
																if (isLength(100, "給湯", form.hotWater))
																	// 2025.01.30 現調日付の入力チェックの判定結果が逆になる不具合を修正
																	// if (fnYMDCheck("正しい現調日付", form.siteDate))
																	if (!fnYMDCheck("正しい現調日付", form.siteDate)) { return; }
	if (isLength(100, "届出用紙", form.leavingForm))
		// 2025.01.30 届出期日の入力チェックの判定結果が逆になる不具合を修正
		// if (fnYMDCheck("正しい届出期日", form.leavingDT))
		if (!fnYMDCheck("正しい届出期日", form.leavingDT)) { return; }
	if (isLength(100, "管理会社", form.manageCompany))
		if (isLength(100, "管理室", form.floorPlan))
			if (isLength(100, "前所有者", form.formerOwner))
				if (isLength(100, "仲介会社（担当）", form.brokerCharge))
					if (isLength(100, "仲介会社（連絡先）", form.brokerContact))
						if (isLength(100, "内装担当者", form.interiorCharge))

							if (confirm('この内容で登録します。よろしいですか？')) {
								form.act.value = 'constEditComplete';
								form.submit();
							}
}
*/

	if (isLength(100, "築年", form.years)) { return; }
	if (isNumericLength(9, "販売予定額", form.sellPrice)) { return; }
	if (isNumericLength(9, "内装見越額", form.interiorPrice)) { return; }
	if (isLength(100, "施工業者", form.constTrader)) { return; }
	if (isNumericLength(9, "工事金額", form.constPrice)) { return; }
	if (isLength(100, "追加工事", form.constAdd)) { return; }
	if (isLength(200, "備考", form.constNote)) { return; }
	if (!fnYMDCheck("正しい買取決済日付", form.purchaseDT)) { return; }
	if (!fnYMDCheck("正しい工期開始日付", form.workStartDT)) { return; }
	if (!fnYMDCheck("正しい工期終了日付", form.workEndDT)) { return; }
	if (!fnYMDCheck("正しい電気水道開栓日付", form.lineOpenDT)) { return; }
	if (!fnYMDCheck("正しい電気水道閉栓日付", form.lineCloseDT)) { return; }
	if (!fnYMDCheck("正しい電気水道開栓連絡日", form.lineOpenContactDT)) { return; }
	if (!fnYMDCheck("正しい電気水道閉栓連絡日", form.lineCloseContactDT)) { return; }
	if (isLength(200, "備考", form.lineContactNote)) { return; }
	if (isLength(100, "電気連絡者", form.electricityCharge)) { return; }
	if (isLength(100, "ガス連絡者", form.gasCharge)) { return; }
	if (isLength(100, "荷＆鍵引取", form.receive)) { return; }
	if (isLength(100, "給湯", form.hotWater)) { return; }
	if (!fnYMDCheck("正しい現調日付", form.siteDate)) { return; }
	if (isLength(100, "届出用紙", form.leavingForm)) { return; }
	if (!fnYMDCheck("正しい届出期日", form.leavingDT)) { return; }
	if (isLength(100, "管理会社", form.manageCompany)) { return; }
	if (isLength(100, "管理室", form.floorPlan)) { return; }
	if (isLength(100, "前所有者", form.formerOwner)) { return; }
	if (isLength(100, "仲介会社（担当）", form.brokerCharge)) { return; }
	if (isLength(100, "仲介会社（連絡先）", form.brokerContact)) { return; }
	if (isLength(100, "内装担当者", form.interiorCharge)) { return; }

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'constEditComplete';
		form.submit();
	}
}