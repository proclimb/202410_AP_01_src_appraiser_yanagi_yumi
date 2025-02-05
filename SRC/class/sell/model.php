<?php

//
// 売主物件リスト
//
function fnSqlSellList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:

            $select = "SELECT SELLNO,IF(SEARCHDT > '0000-00-00',DATE_FORMAT(SEARCHDT,'%Y/%m/%d'),''),ARTICLE,"
                . "ADDRESS,STATION,IF(FOOT > 0,FOOT,''),IF(YEARS > 0,YEARS,''),IF(FLOOR > 0,FLOOR,''),"
                . "IF(AREA > 0,AREA,''),SELLER,IF(PRICE > 0,PRICE,''),NOTE";

            // 2025.01.31 数値項目を0で登録した場合、検索結果の一覧表示では、空白として表示される不具合を修正
            /* Redmineに「数値項目を0で登録した場合、検索結果の一覧表示では、空白として表示される」不具合として掲載があるが、使い方が不明なのでコメントアウトにする
            /*
                IF(SEARCHDT > '0000-00-00',DATE_FORMAT(SEARCHDT,'%Y/%m/%d'),'')
                IF(FOOT > 0,FOOT,'')
                IF(YEARS > 0,YEARS,'')
                IF(FLOOR > 0,FLOOR,'')
                IF(AREA > 0,AREA,'')
                IF(PRICE > 0,PRICE,'')
            */

            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLSELL";
    $where = " WHERE DEL = 1";

    // 検索条件
    if ($param["sSearchFrom"]) {
        $where .= " AND SEARCHDT >= '" . $param["sSearchFrom"] . "'";
    }
    if ($param["sSearchTo"]) {
        $where .= " AND SEARCHDT <= '" . $param["sSearchTo"] . "'";
    }
    if ($param["sArticle"]) {
        $where .= " AND ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sAddress"]) {
        $where .= " AND ADDRESS LIKE '%" . $param["sAddress"] . "%'";
    }
    if ($param["sStation"]) {
        $where .= " AND STATION LIKE '%" . $param["sStation"] . "%'";
    }
    if ($param["sFoot"]) {
        switch ($param["sFootC"]) {
            case 0:
                $where .= " AND FOOT <= " . $param["sFoot"];
                break;
            case 1:
                $where .= " AND FOOT >= " . $param["sFoot"];
                break;
            case 2:
                $where .= " AND FOOT = " . $param["sFoot"];
                break;
        }
    }
    if ($param["sAreaFrom"]) {
        $where .= " AND AREA >= " . $param["sAreaFrom"];
    }
    if ($param["sAreaTo"]) {
        $where .= " AND AREA <= " . $param["sAreaTo"];
    }
    if ($param["sYearsFrom"]) {
        $where .= " AND YEARS >= '" . $param["sYearsFrom"] . "'";
    }
    if ($param["sYearsTo"]) {
        $where .= " AND YEARS <= '" . $param["sYearsTo"] . "'";
    }
    if ($param["sPriceFrom"]) {
        $where .= " AND PRICE >= '" . $param["sPriceFrom"] . "'";
    }
    if ($param["sPriceTo"]) {
        $where .= " AND PRICE <= '" . $param["sPriceTo"] . "'";
    }
    if ($param["sSeller"]) {
        $where .= " AND SELLER LIKE '%" . $param["sSeller"] . "%'";
    }

    return $select . $from . $where . $order . $limit;
}

//
// 売主物件情報
//
function fnSqlSellEdit($sellNo)
{
    // 2025.01.30 売主物件更新画面で表示される日付の書式が仕様書と異なる不具合を修正
    // $select  = "SELECT SEARCHDT,ARTICLE,ADDRESS,STATION,IF(FOOT > 0,FOOT,''),";

    // 2025.01.31 数値項目に0を登録した場合、更新画面を開くと数値項目は全て空白になる不具合を修正　→2025.02.05 やらない
    $select = "SELECT IF(SEARCHDT > '0000-00-00',DATE_FORMAT(SEARCHDT,'%Y/%m/%d'),''),ARTICLE,ADDRESS,STATION,IF(FOOT > 0,FOOT,''),";
    $select .= "IF(YEARS > 0,YEARS,''),IF(FLOOR > 0,FLOOR,''),IF(AREA > 0,AREA,''),SELLER,IF(PRICE > 0,PRICE,''),NOTE";

    // Redmineの不具合修正内容を反映するとAPPRAISERの画面が真っ白になるのでコードを入れない
    /*
IF(FOOT > 0,FOOT,'')
IF(YEARS > 0,YEARS,'')
IF(FLOOR > 0,FLOOR,'')
IF(AREA > 0,AREA,'')
IF(PRICE > 0,PRICE,'')
*/
    $from = " FROM TBLSELL";
    $where = " WHERE DEL = 1";
    $where .= " AND SELLNO = $sellNo";

    return $select . $from . $where;
}

//
// 売主物件情報更新
//
function fnSqlSellUpdate($param)
{
    $sql = "UPDATE TBLSELL";
    $sql .= " SET SEARCHDT = '" . $param["searchDT"] . "'";
    $sql .= ",ARTICLE = '" . $param["article"] . "'";
    $sql .= ",ADDRESS = '" . $param["address"] . "'";
    $sql .= ",STATION = '" . $param["station"] . "'";
    $sql .= ",FOOT = '" . $param["foot"] . "'";
    $sql .= ",YEARS = '" . $param["years"] . "'";
    $sql .= ",FLOOR = '" . $param["floor"] . "'";
    $sql .= ",AREA = '" . $param["area"] . "'";
    $sql .= ",SELLER = '" . $param["seller"] . "'";
    $sql .= ",PRICE = '" . $param["price"] . "'";
    $sql .= ",NOTE = '" . $param["note"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";

    // 2025.01.30 売主物件更新時を行うと全てのデータが同じ内容で更新される不具合を修正（下記1行を追加）
    $sql .= " WHERE SELLNO = " . $param["sellNo"];
    return $sql;
}

//
// 売主物件情報登録
//
/*
function fnSqlSellInsert($param)
{
    $sql = "INSERT INTO TBLSELL(";
    $sql .= "SELLNO,SEARCHDT,ARTICLE,ADDRESS,STATION,FOOT,YEARS,FLOOR,AREA,SELLER,PRICE,NOTE,INSDT,UPDT";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["sellNo"] . "','" . $param["searchDT"] . "','" . $param["article"] . "','" . $param["address"] . "',"
        . "'" . $param["station"] . "','" . $param["foot"] . "','" . $param["years"] . "','" . $param["floor"] . "',"
        . "'" . $param["area"] . "','" . $param["seller"] . "','" . $param["price"] . "','" . $param["note"] . "',"
        // 2025.01.31 新規登録時した後、売主物件一覧の検索結果に表示されない不具合を修正
        // . "CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
        . "CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

    return $sql;
}
*/

function fnSqlSellInsert($param)
{
    $sql = "INSERT INTO TBLSELL(";
    $sql .= "SELLNO,SEARCHDT,ARTICLE,ADDRESS,STATION,FOOT,YEARS,FLOOR,AREA,SELLER,PRICE,NOTE,INSDT,UPDT,DEL"; // ← 最後に DEL 追加
    $sql .= ")VALUES(";
    $sql .= "'" . $param["sellNo"] . "','" . $param["searchDT"] . "','" . $param["article"] . "','" . $param["address"] . "',"
        . "'" . $param["station"] . "','" . $param["foot"] . "','" . $param["years"] . "','" . $param["floor"] . "',"
        . "'" . $param["area"] . "','" . $param["seller"] . "','" . $param["price"] . "','" . $param["note"] . "',"
        . "CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)"; // ← 最後に ,1 追加

    return $sql;
}

//
// 売主物件情報削除
//
function fnSqlSellDelete($sellNo)
{
    $sql = "UPDATE TBLSELL";
    // 2025.01.31 削除ボタンを押下しても削除されない不具合を修正
    // $sql .= " SET DEL = 1";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE SELLNO = '$sellNo'";

    return $sql;
}
