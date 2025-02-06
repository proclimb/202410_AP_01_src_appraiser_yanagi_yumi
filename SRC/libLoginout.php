<?php
//
//ログイン画面
//
function subLogin()
{
?>


	<div class="login_ttl">
		<img src="./images/logo.png">
	</div>


	<form name="form" action="index.php" method="post">
		<input type="hidden" name="act" value="loginCheck" />

		<div class="login_table">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>ユーザーID</th>
					<td><input type="text" name="id" style="ime-mode:disabled;" /></td>
				</tr>
				<tr>
					<th>パスワード</th>
					<td><input type="password" name="pw" /></td>
				</tr>
			</table>
		</div>

		<div class="login_btn">
			<a href="javascript:form.submit();"><img src="./images/btn_login.png"></a>
		</div>
	</form>
<?php
}




//
//ログイン確認
//
function subLoginCheck()
{
	$id = addslashes($_REQUEST['id']);
	$pw = addslashes($_REQUEST['pw']);

	$conn = fnDbConnect();

	// 2025.02.06 新規登録時に、パスワードをハッシュ化して登録している不具合を修正
	// $sql = fnSqlLogin($id, $pw);
	$sql = fnSqlLogin($id);
	//呼び出した後で値を表示(2024.01.08 add) SQLを作っただけ
	var_dump($sql);

	$res = mysqli_query($conn, $sql);
	// 実行
	$row = mysqli_fetch_array($res);
	// 実行した結果を配列$rowに入れる

	// 2025.02.06 新規登録時に、パスワードをハッシュ化して登録している不具合を修正
	// if ($row[0]) {
	if ($row[0] && password_verify($pw, $row['PASSWORD'])) {
		// ０：ユーザ番号　検索結果に存在する？
		$_COOKIE['cUserNo']   = $row[0];
		$_COOKIE['authority'] = $row[1];
		$_REQUEST['act']      = 'menu';
	} else {
		$_REQUEST['act']    = 'reLogin';
	}
}
?>