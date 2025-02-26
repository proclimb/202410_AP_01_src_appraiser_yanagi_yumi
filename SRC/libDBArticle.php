<?php
//
//物件管理リスト
//
function fnSqlArticleList($flg, $sDel, $sArticle, $sRoom, $sKeyPlace, $sArticleNote, $sKeyBox, $sDrawing, $sSellCharge, $sPage, $orderBy, $orderTo)
{
	switch ($flg) {
		case 0:
			$sql  = "SELECT COUNT(*)";
			break;
		case 1:
			// 2025.01.29 検索ボタンを押下しても検索結果が表示されない不具合を修正
			// $sql  = "SELECT ARTICLENO, ARTICLE, RO0M, KEYPLACE, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE";
			$sql  = "SELECT ARTICLENO, ARTICLE, ROOM, KEYPLACE, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE";
			break;
	}
	$sql .= " FROM TBLARTICLE";
	$sql .= " WHERE DEL = $sDel";
	// 2025.01.30　入力した値に関わらず全件が検索結果として表示される不具合を修正
	// 2025.01.30 物件名に値を入力して検索ボタンを押しても検索されない不具合を修正
	if ($sArticle) {
		// $sql .= " OR ARTICLE LIKE '%$sArticle$%'";
		$sql .= " AND ARTICLE LIKE '%$sArticle%'";
	}
	if ($sRoom) {
		// $sql .= " OR ROOM LIKE '%$sRoom%'";
		$sql .= " AND ROOM LIKE '%$sRoom%'";
	}
	if ($sKeyPlace) {
		// $sql .= " OR KEYPLACE LIKE '%$sKeyPlace%'";
		$sql .= " AND KEYPLACE LIKE '%$sKeyPlace%'";
	}
	if ($sArticleNote) {
		// $sql .= " OR ARTICLENOTE LIKE '%$sArticleNote%'";
		$sql .= " AND ARTICLENOTE LIKE '%$sArticleNote%'";
	}
	if ($sKeyBox) {
		// 2025.01.30 キーBOXに値を入力して検索ボタンを押しても検索されない不具合を修正
		// $sql .= " OR KEYBOX LIKE '%l$sKeyBox%'";
		$sql .= " AND KEYBOX LIKE '%$sKeyBox%'";
	}
	if ($sDrawing) {
		// $sql .= " OR DRAWING LIKE '%$sDrawing%'";
		$sql .= " AND DRAWING LIKE '%$sDrawing%'";
	}
	if ($sSellCharge) {
		// $sql .= " OR SELLCHARGE LIKE '%$sSellCharge%'";
		$sql .= " AND SELLCHARGE LIKE '%$sSellCharge%'";
	}
	if ($orderBy) {
		$sql .= " ORDER BY $orderBy $orderTo";
	}
	// 2025.01.09 検索ボタンを押下しても検索結果が表示されない不具合を修正
	if ($flg) {
		// $sql .= " LIMIT " . (($sPage + 1) * PAGE_MAX) . ", " . PAGE_MAX;
		$sql .= " LIMIT " . (($sPage - 1) * PAGE_MAX) . ", " . PAGE_MAX;
	}

	return ($sql);
}



//
//物件管理情報
//
function fnSqlArticleEdit($articleNo)
{
	$sql  = "SELECT ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE, DEL";
	$sql .= " FROM TBLARTICLE";
	// 2025.01.30 どの物件名のリンクを押下しても同じ物件の内容が表示される不具合を修正
	// $sql .= " WHERE ARTICLENO = 1";
	$sql .= " WHERE ARTICLENO = $articleNo";

	return ($sql);
}



//
//物件管理情報更新
//
function fnSqlArticleUpdate($articleNo, $article, $room, $keyPlace, $address, $articleNote, $keyBox, $drawing, $sellCharge, $del)
{
	$sql  = "UPDATE TBLARTICLE";
	$sql .= " SET ARTICLE = '$article'";
	$sql .= ",ROOM = '$room'";
	$sql .= ",KEYPLACE = '$keyPlace'";
	// 2025.01.30 物件更新時、更新した内容がDBに反映されない不具合を修正
	// $sql .= ",ADDRESS = '$address";
	$sql .= ",ADDRESS = '$address'";
	$sql .= ",ARTICLENOTE = '$articleNote'";
	$sql .= ",KEYBOX = '$keyBox'";
	$sql .= ",DRAWING = '$drawing'";
	$sql .= ",SELLCHARGE = '$sellCharge'";

	// 2025.01.30 	データ更新時、更新日時(UPDT)が更新されない不具合を修正
	$sql .= ",UPDT = CURRENT_TIMESTAMP";

	$sql .= ",DEL = '$del'";
	$sql .= " WHERE ARTICLENO = $articleNo";

	return ($sql);
}



//
//物件管理情報登録
//
// 2025.01.29 新規登録時に入力した値がDBに正しく登録されない不具合を修正
/*
function fnSqlArticleInsert($articleNo,  $keyPlace, $article, $address,  $keyBox, $articleNote, $drawing, $sellCharge, $room, $del)
{
	$sql  = "INSERT INTO tblarticle (";
	$sql .= " ARTICLENO, ROOM, ARTICLE, KEYPLACE, ARTICLENOTE, KEYBOX, ADDRESS, DUEDT, SELLCHARGE, AREA, YEARS, SELLPRICE, INTERIORPRICE, CONSTTRADER,"
		. " CONSTPRICE, CONSTADD, CONSTNOTE, PURCHASEDT, WORKSTARTDT, WORKENDDT, LINEOPENDT, LINECLOSEDT, RECEIVE, HOTWATER, SITEDT, LEAVINGFORM,"
		. " LEAVINGDT, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, INSDT, UPDT, DEL,"
		. " DRAWING, LINEOPENCONTACTDT, LINECLOSECONTACTDT, LINECONTACTNOTE, ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER";
	$sql .= " ) VALUES ( ";
	$sql .= "'$articleNo', '$article', '$room', '$keyPlace', '$address', '$articleNote', '$keyBox', '', '$sellCharge', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$del',"
		. " '$drawing', '', '', '', '', '', '' )";

	return ($sql);
}
*/

// 新規物件がDBに登録できない不具合の原因3
function fnSqlArticleInsert($articleNo,  $keyPlace, $article, $address,  $keyBox, $articleNote, $drawing, $sellCharge, $room, $del)
{
	$sql  = "INSERT INTO TBLARTICLE (";
	$sql .= "ARTICLENO , ARTICLE , ROOM , KEYPLACE , ADDRESS , ARTICLENOTE , KEYBOX , DUEDT , SELLCHARGE , AREA , YEARS , SELLPRICE , INTERIORPRICE , CONSTTRADER ,"
		. "CONSTPRICE , CONSTADD , CONSTNOTE , PURCHASEDT , WORKSTARTDT , WORKENDDT , LINEOPENDT , LINECLOSEDT , RECEIVE , HOTWATER , SITEDT , LEAVINGFORM ,"
		. "LEAVINGDT , MANAGECOMPANY , FLOORPLAN , FORMEROWNER , BROKERCHARGE , BROKERCONTACT , INTERIORCHARGE , CONSTFLG1 , CONSTFLG2 , CONSTFLG3 , CONSTFLG4 , INSDT , UPDT , DEL ,"
		. "DRAWING , LINEOPENCONTACTDT , LINECLOSECONTACTDT , LINECONTACTNOTE , ELECTRICITYCHARGE , GASCHARGE , LIGHTORDER";
	//$sql .= " ARTICLENO, ROOM, ARTICLE, KEYPLACE, ARTICLENOTE, KEYBOX, ADDRESS, DUEDT, SELLCHARGE, AREA, YEARS, SELLPRICE, INTERIORPRICE, CONSTTRADER,"
	//. " CONSTPRICE, CONSTADD, CONSTNOTE, PURCHASEDT, WORKSTARTDT, WORKENDDT, LINEOPENDT, LINECLOSEDT, RECEIVE, HOTWATER, SITEDT, LEAVINGFORM,"
	//	. " LEAVINGDT, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, INSDT, UPDT, DEL,"
	//	. " DRAWING, LINEOPENCONTACTDT, LINECLOSECONTACTDT, LINECONTACTNOTE, ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER";
	$sql .= " ) VALUES ( ";
	$sql .= "'$articleNo', '$article', '$room', '$keyPlace', '$address', '$articleNote', '$keyBox', '', '$sellCharge', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$del',"
		. " '$drawing', '', '', '', '', '', '' )";
	/*
	$sql .= "'$articleNo', '$article', '$room', '$keyPlace', '$address', '$articleNote', '$keyBox', '8', '$sellCharge', '10', '11', '12', '13', '14',"
		. " '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '25',"
		. " '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$del',"
		. " '$drawing', '42', '43', '44', '45', '46', '47' )";
*/
	return ($sql);
}

//
//物件管理情報削除
//
function fnSqlArticleDelete($articleNo)
{
	$sql  = "UPDATE TBLARTICLE";
	// 2025.01.30 削除しても除外にチェックを入れて検索すると表示される不具合を修正
	// $sql .= " SET DEL = 0";
	$sql .= " SET DEL = -1";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE ARTICLENO = '$articleNo'";

	return ($sql);
}
