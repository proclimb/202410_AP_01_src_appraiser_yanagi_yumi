<?php

//
// ログイン
//
// 2025.02.06 新規登録時に、パスワードをハッシュ化して登録している不具合を修正
// function fnSqlLogin($id, $pw)
function fnSqlLogin($id)
{
    $id = addslashes($id);
    // 2025.02.06 新規登録時に、パスワードをハッシュ化して登録している不具合を修正
    // $sql = "SELECT USERNO,AUTHORITY FROM TBLUSER";
    $sql = "SELECT USERNO,AUTHORITY,PASSWORD FROM TBLUSER";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND ID = '$id'";
    // $sql .= " AND PASSWORD = '$pw'";

    return ($sql);
}

//
// ユーザー情報リスト
//
function fnSqlAdminUserList()
{
    $sql = "SELECT USERNO,NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE DEL = 1";
    $sql .= " ORDER BY AUTHORITY ASC,NAME ASC";

    return ($sql);
}

//
// ユーザー情報詳細
//
function fnSqlAdminUserEdit($userNo)
{
    $sql = "SELECT NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE USERNO = $userNo";

    return ($sql);
}

//
// ユーザー情報更新
//
function fnSqlAdminUserUpdate($userNo, $name, $id, $password, $authority)
{
    // 2025.02.06 更新時に、パスワードをハッシュ化して更新している
    if ($password !== "") {
        // $pass = addslashes(hash('adler32', $password));
        $pass = password_hash($password, PASSWORD_DEFAULT);
    }
    $sql = "UPDATE TBLUSER";
    $sql .= " SET NAME = '$name'";
    $sql .= ",ID = '$id'";

    // 2025.02.06 更新時に、パスワードをハッシュ化して更新している
    if ($password !== "") {
        $sql .= ",PASSWORD = '$pass'";
    }

    $sql .= ",AUTHORITY = '$authority'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE USERNO = '$userNo'";

    return ($sql);
}

//
// ユーザー情報登録
//
function fnSqlAdminUserInsert($userNo, $name, $id, $password, $authority)
{
    // 2025.02.06 新規登録時に、パスワードをハッシュ化して登録している不具合を修正
    // $pass = addslashes(hash('adler32', $password));
    $pass = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO TBLUSER(";
    $sql .= "USERNO,NAME,ID,PASSWORD,AUTHORITY,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'$userNo','$name','$id','$pass','$authority',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

    return ($sql);
}

//
// ユーザー情報削除
//
function fnSqlAdminUserDelete($userNo)
{
    $sql = "UPDATE TBLUSER";
    $sql .= " SET DEL = 0";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE USERNO = '$userNo'";

    return ($sql);
}

//
// 次の番号を得る
//
function fnNextNo($t)
{
    $conn = fnDbConnect();

    $sql = "SELECT MAX(" . $t . "NO) FROM TBL" . $t;
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    if ($row[0]) {
        // 2025.01.23 検索結果から詳細を確認する際に同一データしか表示がされない不具合を修正
        // 更新画面で更新ボタンを押下すると、変更が登録データーすべてに更新される不具合を修正
        $max = $row[0] + 1;
    } else {
        $max = 1;
    }

    return ($max);
}
