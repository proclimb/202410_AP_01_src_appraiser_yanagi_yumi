<?php
//
//仕入管理画面
//
function subStockView($param) // 仕入管理の実際の画面表示
{
?>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "sInsDTFrom");
		var cal2 = new JKL.Calendar("cal2", "form", "sInsDTTo");
		var cal3 = new JKL.Calendar("cal3", "form", "sVisitDTFrom");
		var cal4 = new JKL.Calendar("cal4", "form", "sVisitDTTo");
	</script>

	<h1>仕入管理一覧</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="stockSearch" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<!-- "hidden"今は見えない状態 -->
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="stockNo" />
		<!--送る時は空で送る -->
		<input type="hidden" name="delStockList" />

		<a href="javascript:form.act.value='stockEdit';form.submit();"><img src="./images/btn_enter.png"></a>
		<!--ボタンを押した時こういう動作をします -->
		<!--submitする時はindex.phpに飛ぶ 　indexで共通情報を作り、bodyで個別ページの情報を作る-->
		<!--新規登録ボタンを作る -->
		<div class="search">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>除外</th>
					<td><input type="checkbox" name="sDel" value="0" <?php if ($param["sDel"] == 0) print ' checked="checked"' ?> /></td>
					<th>最寄駅</th>
					<td><input type="text" name="sStation" value="<?php print $param["sStation"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>日付</th>
					<td><input type="text" name="sInsDTFrom" value="<?php print $param["sInsDTFrom"] ?>" size="15" /> <a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span>～
						<input type="text" name="sInsDTTo" value="<?php print $param["sInsDTTo"] ?>" size="15" /> <a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();"><img src="./images/b_calendar.png"></a><span id="cal2"></span>
					</td>
					<th>距離</th>
					<td>
						<?php
						//						for ($i = 0; $i < 27; $i++) {   距離のチェックボックスの数が多いのを修正
						for ($i = 0; $i < 4; $i++) {
						?>
							<input type="checkbox" name="sDistance[]" value="<?php print $i + 1; ?>" <?php for ($j = 0; $j < 4; $j++) {
																											if ($param["sDistance"][$j] == $i + 1) print ' checked="checked"';
																										} ?> /> <?php print fnRankName($i) ?>
						<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th>担当</th>
					<td><input type="text" name="sCharge" value="<?php print $param["sCharge"] ?>" size="30" /></td>
					<th>業者名</th>
					<td><input type="text" name="sAgent" value="<?php print $param["sAgent"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>ランク</th>
					<td>
						<?php
						for ($i = 0; $i < 5; $i++) {
						?>
							<input type="checkbox" name="sRank[]" value="<?php print $i + 1; ?>" <?php for ($j = 0; $j < 5; $j++) {
																										if ($param["sRank"][$j] == $i + 1) print ' checked="checked"';
																									} ?> /> <?php print fnRankName($i) ?>
						<?php
						}
						?>
					</td>
					<th>店舗名</th>
					<td><input type="text" name="sStore" value="<?php print $param["sStore"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>物件名</th>
					<td><input type="text" name="sArticle" value="<?php print $param["sArticle"] ?>" size="50" /></td>
					<th>担当者名</th>
					<td><input type="text" name="sCover" value="<?php print $param["sCover"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>物件名（よみ）</th>
					<td><input type="text" name="sArticleFuri" value="<?php print $param["sArticleFuri"] ?>" size="50" /></td>
					<th>内見</th>
					<td><input type="text" name="sVisitDTFrom" value="<?php print $param["sVisitDTFrom"] ?>" size="15" /> <a href="javascript:cal3.write();" onChange="cal3.getFormValue(); cal3.hide();"><img src="./images/b_calendar.png"></a><span id="cal3"></span>～
						<input type="text" name="sVisitDTTo" value="<?php print $param["sVisitDTTo"] ?>" size="15" /> <a href="javascript:cal4.write();" onChange="cal4.getFormValue(); cal4.hide();"><img src="./images/b_calendar.png"></a><span id="cal4"></span>
					</td>
				</tr>
				<tr>
					<th>面積</th>
					<td><input type="text" name="sAreaFrom" value="<?php print $param["sAreaFrom"] ?>" size="10" /> ～
						<input type="text" name="sAreaTo" value="<?php print $param["sAreaTo"] ?>" size="10" />
					</td>
					<th>仕入経緯</th>
					<td>
						<?php
						for ($i = 0; $i < 6; $i++) {
						?>
							<input type="checkbox" name="sHow[]" value="<?php print $i + 1; ?>" <?php for ($j = 0; $j < 6; $j++) {
																									if ($param["sHow"][$j] == $i + 1) print ' checked="checked"';
																								} ?> /> <?php print fnHowName($i); ?>
						<?php
							if ($i == 2) {
								print "<br />\n";
							}
						}
						?>
					</td>
				</tr>
			</table>
		</div>
		<!-- 2025.01.23 仕入管理一覧画面で検索ボタンを押すと検索されず空のレコードがDBに登録される不具合を修正 -->
		<!-- 検索ボタンは'stockEditComplete' -> 'stockSearch'で良い-->
		<input type="image" src="./images/btn_search.png" onclick="form.act.value='stockSearch';form.submit();" />
		<!-- ボタンサーチで検索のボタンを作る-->
		<hr />

		<?php
		if ($_REQUEST['act'] == 'stock') {
			return;
		}

		// 2025.01.23 検索結果の総数が「1件」で固定表示されている不具合を修正
		// ２ページ目以降、ページャーの表示がおかしくなるを修正
		//$sql = fnSqlStockList(1, $param); 「1」は、検索結果の 一覧を表示する為の各項目の値を取得する 為のSQLを作成
		$sql = fnSqlStockList(0, $param);
		// 「0」は、検索結果の 検索結果数を取得する為のSQLを作成
		$res = mysqli_query($param["conn"], $sql);
		$row = mysqli_fetch_array($res);

		$count = $row[0]; //$count に検索結果の総数を設定

		$sPage = fnPage($count, $param["sPage"], 'stockSearch');
		?>

		<div class="list">
			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th class="list_head">担当<?php fnOrder('CHARGE', 'stockSearch') ?></th>
					<th class="list_head">ランク<?php fnOrder('RANK', 'stockSearch') ?></th>
					<th class="list_head">日付<?php fnOrder('INSDT', 'stockSearch') ?></th>
					<th class="list_head">物件名<?php fnOrder('ARTICLE', 'stockSearch') ?></th>
					<th class="list_head">部屋<?php fnOrder('ROOM', 'stockSearch') ?></th>
					<th class="list_head">面積<?php fnOrder('AREA', 'stockSearch') ?></th>
					<th class="list_head">最寄駅<?php fnOrder('STATION', 'stockSearch') ?></th>
					<th class="list_head">距離<?php fnOrder('DISTANCE', 'stockSearch') ?></th>
					<th class="list_head">業者名<?php fnOrder('AGENT', 'stockSearch') ?></th>
					<th class="list_head">店舗名<?php fnOrder('STORE', 'stockSearch') ?></th>
					<th class="list_head">担当者名<?php fnOrder('COVER', 'stockSearch') ?></th>
					<th class="list_head">内見<?php fnOrder('VISITDT', 'stockSearch') ?></th>
					<th class="list_head">机上金額<?php fnOrder('DESKPRICE', 'stockSearch') ?></th>
					<th class="list_head">売主希望金額<?php fnOrder('VENDORPRICE', 'stockSearch') ?></th>
					<th class="list_head">備考<?php fnOrder('NOTE', 'stockSearch') ?></th>
				</tr>
				<?php
				$sql  = fnSqlStockList(1, $param);
				$res  = mysqli_query($param["conn"], $sql);
				$i = 0;
				while ($row = mysqli_fetch_array($res)) {
					// 2025.01.23 検索結果一覧の項目と登録されているデータの項目が１個ずつズレている不具合を修正
					$stockNo     = htmlspecialchars($row[0]);
					$charge      = htmlspecialchars($row[1]);
					$rank        = fnRankName(htmlspecialchars($row[2] - 1));
					$insDT       = htmlspecialchars($row[3]);
					$article     = htmlspecialchars($row[4]);
					$articleFuri = htmlspecialchars($row[5]);
					$room        = htmlspecialchars($row[6]);
					$area        = htmlspecialchars($row[7]);
					$station     = htmlspecialchars($row[8]);
					$distance    = fnRankName(htmlspecialchars($row[9] - 1));
					$agent       = htmlspecialchars($row[10]);
					$store       = htmlspecialchars($row[11]);
					$cover       = htmlspecialchars($row[12]);
					$visitDT     = htmlspecialchars($row[13]);
					$deskPrice   = htmlspecialchars(fnNumFormat($row[14]));
					$vendorPrice = htmlspecialchars(fnNumFormat($row[15]));
					$note        = htmlspecialchars($row[16]);
				?>
					<tr>
						<td class="list_td<?php print $i; ?>"><?php print $charge; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $rank; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $insDT; ?></td>
						<td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='stockEdit';form.stockNo.value=<?php print $stockNo; ?>;form.submit();"><?php print $article; ?></a></td>
						<td class="list_td<?php print $i; ?>"><?php print $room; ?></td>
						<td class="list_td<?php print $i; ?>" align="right"><?php print $area; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $station; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $distance; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $agent; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $store; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $cover; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $visitDT; ?></td>
						<td class="list_td<?php print $i; ?>" align="right"><?php print $deskPrice; ?></td>
						<td class="list_td<?php print $i; ?>" align="right"><?php print $vendorPrice; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $note; ?></td>
					</tr>
				<?php
					$i = ($i + 1) % 2;
				}
				?>
			</table>
		</div>
	</form>
<?php
}




//
//仕入管理編集画面
//
function subStockEditView($param)
{

?><!-- スクリプトを追加します　index共通　拡張する場合はここで選別する-->
	<script type="text/javascript" src="./js/stock.js"></script>
	<script type="text/javascript" src="./js/jquery-1.4.min.js"></script>
	<script type="text/javascript" src="./js/auto_ruby.js"></script>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "visitDT");
	</script>

	<h1>仕入<?php print $param["purpose"] ?></h1>
	<!--purposeに「登録」が入っていると「仕入登録」とタイトル表示される -->

	<!--2025.01.23 get -> post　に修正 仕入登録画面で備考欄に1000文字入れて登録しようとするとサーバーエラーになる不具合修正のため-->
	<form name="form" id="form" action="index.php" method="get">
		<input type="hidden" name="act" />
		<input type="hidden" name="sDel" value="<?php print $param["sDel"] ?>" />
		<input type="hidden" name="sInsDTFrom" value="<?php print $param["sInsDTFrom"] ?>" />
		<input type="hidden" name="sInsDTTo" value="<?php print $param["sInsDTTo"] ?>" />
		<input type="hidden" name="sCharge" value="<?php print $param["sCharge"] ?>" />
		<input type="hidden" name="sRank" value="<?php print $param["sRank"] ?>" />
		<input type="hidden" name="sArticle" value="<?php print $param["sArticle"] ?>" />
		<input type="hidden" name="sArticleFuri" value="<?php print $param["sArticleFuri"] ?>" />
		<input type="hidden" name="sAreaFrom" value="<?php print $param["sAreaFrom"] ?>" />
		<input type="hidden" name="sAreaTo" value="<?php print $param["sAreaTo"] ?>" />
		<input type="hidden" name="sStation" value="<?php print $param["sStation"] ?>" />
		<input type="hidden" name="sDistance" value="<?php print $param["sDistance"] ?>" />
		<input type="hidden" name="sAgent" value="<?php print $param["sAgent"] ?>" />
		<input type="hidden" name="sStore" value="<?php print $param["sStore"] ?>" />
		<input type="hidden" name="sCover" value="<?php print $param["sCover"] ?>" />
		<input type="hidden" name="sVisitDTFrom" value="<?php print $param["sVisitDTFrom"] ?>" />
		<input type="hidden" name="sVisitDTTo" value="<?php print $param["sVisitDTTo"] ?>" />
		<input type="hidden" name="sHow" value="<?php print $param["sHow"] ?>" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="stockNo" value="<?php print $param["stockNo"] ?>" />

		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th>除外</th>
				<td><input type="radio" name="del" value="1" checked /> 非除外
					<input type="radio" name="del" value="0" /> 除外
				</td>
			</tr>
			<tr>
				<th>担当</th>
				<td><input type="text" name="charge" value="<?php print $param["charge"] ?>" /></td>
			</tr>
			<tr>
				<th>ランク</th>
				<td>
					<!-- 2025.01.23 仕入更新画面の「ランク」で登録しているデータと異なる値が表示される不具合を修正-->
					<?php
					if (!$param["stockNo"]) {
						$param["rank"] = 1;
					}

					for ($i = 0; $i < 5; $i++) {
						$check = '';
						if (($param["rank"] - 1) == $i) {
							$check = 'checked = "checked"';
						}
					?>
						<!-- 2025.01.21 初期値の表示 -->
						<!-- <input type="radio" name="rank" value="<?php print $i + 1; ?>" <?php if ($param["rank"] == $i + 1) print ' checked="checked"'; ?> /> <?php print fnRankName($i); ?> -->
						<input type="radio" name="rank" value="<?php print $i + 1; ?>" <?php print $check; ?> /> <?php print fnRankName($i); ?>
					<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<th>物件名<span class="red">（必須）</span></th>
				<td><input type="text" name="article" id="name" value="<?php print $param["article"] ?>" /></td>
			</tr>
			<tr>
				<th>物件名（よみ）</th>
				<td><input type="text" name="articleFuri" id="ruby" value="<?php print $param["articleFuri"] ?>" /></td>
			</tr>
			<tr>
				<th>部屋</th>
				<td><input type="text" name="room" value="<?php print $param["room"] ?>" /></td>
			</tr>
			<tr>
				<th>面積</th>
				<td><input type="text" name="area" value="<?php print $param["area"] ?>" />㎡</td>
			</tr>
			<tr>
				<th>最寄駅</th>
				<td><input type="text" name="station" value="<?php print $param["station"] ?>" /></td>
			</tr>
			<tr>
				<th>距離</th>
				<td>
					<?php
					if (!$param["stockNo"]) {
						$param["distance"] = 1;
					}
					for ($i = 0; $i < 4; $i++) {
						$check = '';
						if (($param["distance"] - 1) == $i) {
							$check = 'checked = "checked"';
						}
					?>
						<!-- 2025.01.21 初期値の表示 -->
						<!--2025.01.23 仕入更新画面の「距離」で登録しているデータと異なる値が表示される不具合を修正 -->
						<!-- 修正前：<input type="radio" name="distance" value="<?php print $i + 1; ?>" <?php if ($param["distance"] == $i) print ' checked="checked"'; ?> /> <?php print fnDistanceName($i); ?> -->
						<!-- for文の変数$iは0から始まり、DBに登録する値は1から始まるため、両変数の値を一致させるには変数$iの値を+1する必要がある。 -->
						<input type="radio" name="distance" value="<?php print $i + 1; ?>" <?php print $check; ?> /> <?php print fnDistanceName($i); ?>
					<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<th>業者名</th>
				<td><input type="text" name="agent" value="<?php print $param["agent"] ?>" /></td>
			</tr>
			<tr>
				<th>店舗名</th>
				<td><input type="text" name="store" value="<?php print $param["store"] ?>" /></td>
			</tr>
			<tr>
				<th>担当者名</th>
				<td><input type="text" name="cover" value="<?php print $param["cover"] ?>" /></td>
			</tr>
			<tr>
				<th>内見</th>
				<td><input type="text" name="visitDT" value="<?php print $param["visitDT"] ?>" /> <a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span></td>
			</tr>
			<tr>
				<th>机上金額</th>
				<td><input type="text" name="deskPrice" value="<?php print $param["deskPrice"] ?>" />万円</td>
			</tr>
			<tr>
				<th>売主希望金額</th>
				<td><input type="text" name="vendorPrice" value="<?php print $param["vendorPrice"] ?>" />万円</td>
			</tr>
			<tr>
				<th>備考</th>
				<td><textarea name="note" cols="50" rows="10"><?php print $param["note"] ?></textarea></td>
			</tr>
			<tr>
				<th>仕入経緯</th>
				<td>
					<?php
					// 2025.01.23「仕入経緯」で登録しているデータと異なる値が表示される不具合を修正
					if (!$param["stockNo"]) {
						$param["how"] = 1;
					}
					for ($i = 0; $i < 6; $i++) {
						// 2025.01.23
						$check = '';
						if (($param["how"] - 1) == $i) {
							$check = 'checked = "checked"';
						}
					?>
						<br />
						<!--2025.01.21 初期値設定 -->
						<!-- <input type="radio" name="how" value="<?php print $i + 1; ?>" <?php if ($param["how"] == $i) print ' checked="checked"'; ?> /> <?php print fnHowName($i); ?> -->
						<input type="radio" name="how" value="<?php print $i + 1; ?>" <?php print $check; ?> /> <?php print fnHowName($i); ?>
					<?php
					}
					?>
				</td>
			</tr>

		</table>

		<a href="javascript:fnStockEditCheck();"><img src="./images/<?php print $param["btnImage"] ?>" /></a>
		<!--btn_entr.pngが入る -->
		<!--ポップアップが出る　よろしいですか？ -->
		<!-- fnStockEditCheck()-->
		<!--2025.01.23 更新画面にて戻るボタンをクリックすると検索一覧から表示されなくなる不具合を修正-->
		<!-- <a href="javascript:form.act.value='stockEditComplete';form.submit();"><img src="./images/btn_return.png" /></a> -->
		<a href="javascript:form.act.value='stockSearch';form.submit();"><img src="./images/btn_return.png" /></a>
		<!-- 'stockSearch'を呼ぶと仕入管理一覧画面へ -->
		<?php
		if ($param["stockNo"]) {
		?>
			<a href="javascript:fnStockDeleteCheck(<?php print $param["stockNo"] ?>);"><img src="./images/btn_del.png" /></a>
		<?php
		}
		?>

	</form>
<?php
}
?>