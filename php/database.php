<?php
    // DB接続（ローカル環境がデフォルト）
    function DbConn($dbName, $host = 'localhost', $userName = 'root', $pwd = ''){
        try {
            $dsn = 'mysql:dbname='.$dbName.';host='.$host.';charset=utf8';
            return new PDO($dsn, $userName, $pwd);
        } catch (PDOException $e) {
            exit('DBConnection Error: '.$e->getMessage());
        }
    }
    // $dbh = localDbConn('userInfo');



    // テーブル作成
    function mkTbIF($tableName, $structure, $PDO){
        try {
            $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (id INT(12) NOT NULL auto_increment PRIMARY KEY,'.$structure.') DEFAULT CHARSET="utf8"';
            return $PDO -> query($sql);
        } catch (PDOException $e){
            exit('TableCreate Error: '.$e -> getMessage());
        }
    }
    // mkTbIF('basicProfile', 'email VARCHAR(256), password VARCHAR(256)', $dbh);



    // 下記データ登録関数で使用
    function cvtStruc($structure){
        $structureArray = explode(',', $structure);
        for ($i=0; $i<count($structureArray); $i++){
            $structureArray[$i] = ':'.$structureArray[$i];
        }
        return implode(',', $structureArray);
    }
    // データ登録（フォームからデータ取得の場合）
    function addData($tableName, $structure, $PDO, $postedData){
        $structured = cvtStruc($structure);
        $add = 'INSERT INTO '.$tableName.'('.$structure.') VALUES('.$structured.')';
        $stmt = $PDO -> prepare($add);
        $structureArray = explode(',', $structure);
        for ($i=0; $i<count($structureArray); $i++){
            $stmt -> bindValue($structureArray[$i], $postedData[$structureArray[$i]], PDO::PARAM_STR);
        }
        $status = $stmt -> execute();
        if ($status == false){
            $error = $stmt->errorInfo();
            exit("SQLData Error: ".$error[2]);
        } else {
            return $status;
        }
    }
    // addData('basicProfile', 'email,password', $dbh, $_POST);



    // フィールドにある全ての値を配列として取得
    function fldArray($field, $tableName, $PDO){
        $sql = 'SELECT '.$field.' FROM '.$tableName;
        $result = $PDO -> query($sql);
        return $result -> fetchAll(PDO::FETCH_COLUMN);
    }
    // $existingEmail = fldArray('email', 'basicProfile', $db);



    // 条件からデータ取得（基本一つの値を想定）
    function CondSQL($category, $tableName, $condition, $PDO){
        $sql = 'SELECT '.$category.' FROM '.$tableName.' WHERE '.$condition;
        $result = $PDO -> query($sql);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }
    // $truePwd = CondSQL('password', 'basicProfile', 'email="'.$_SESSION['email'].'"', $db);



    // データ更新（複数可）
    function updateSQL($tableName, $newVal, $condition, $PDO){
        $sql = 'UPDATE '.$tableName.' SET '.$newVal.' WHERE '.$condition;
        $result = $PDO -> query($sql);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }
    // updateSQL('basicProfile', 'attempts='.$LoginAttempts['attempts'], 'email="'.$_POST['email'].'"', $db);



    // 特定データの複製 注意：primary key idを設定している場合、下記例のようなカテゴリ指定必須
    function copyData($newTable, $values, $oldTable, $condition, $PDO){
        $sql = 'INSERT INTO '.$newTable.' SELECT '.$values.' FROM '.$oldTable.' WHERE '.$condition;
        $result = $PDO -> query($sql);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }
    // copyData('frozenAccounts(email, password, displayName, attempts)', 'email, password, displayName, attempts', 'basicProfile', 'email="'.$_POST['email'].'"', $db);      
    
    

    // レコード削除
    function delData($tableName, $condition, $PDO){
        $sql = 'DELETE FROM '.$tableName.' WHERE '.$condition;
        $result = $PDO -> query($sql);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }
    // delData('basicProfile', 'email="'.$_POST['email'].'"', $db);    
    
    

    // 作成中：イベント作成
    // function createEvent(){
    //     $sql = 'CREATE EVENT myevent ON SCHEDULE EVERY 10 MINUTE';
    //     $result = $PDO -> query($sql);
    //     return $result -> fetch(PDO::FETCH_ASSOC);
    // }



    // ワンタイムURL生成
    function uniqURL($default){ // https..から含む
        $url = $default.'?key=';
        $key = md5(uniqid(mt_rand(), true));
        $url .= $key;
        return $url;
    }
    // uriqURL('https://momo115.sakura.ne.jp/atto_php/reset.php');
?>