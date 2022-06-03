<?php
    // ローカル環境がデフォルト
    function lclDbConn($dbName, $host = 'localhost', $userName = 'root', $pwd = ''){
        try {
            $dsn = 'mysql:dbname='.$dbName.';host='.$host.';charset=utf8';
            return new PDO($dsn, $userName, $pwd);
        } catch (PDOException $e) {
            exit('DBConnection Error: '.$e->getMessage());
        }
    }
    // $dbh = localDbConn('userInfo');



    // データベース内に引数名のテーブルが存在しない場合作成  **デフォルト値注意
    function mkTbIF($tableName, $structure, $PDO){
        try {
            $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (id INT(12) NOT NULL auto_increment PRIMARY KEY,'.$structure.') DEFAULT CHARSET="utf8"';
            return $PDO -> query($sql);
        } catch (PDOException $e){
            exit('TableCreate Error: '.$e -> getMessage());
        }
    }
    // $result = mkTbIF('basicProfile', 'email VARCHAR(256), password VARCHAR(256)', $dbh);



    // 下記データ登録用関数のみで使用
    function cvtStruc($structure){
        $structureArray = explode(',', $structure);
        for ($i=0; $i<count($structureArray); $i++){
            $structureArray[$i] = ':'.$structureArray[$i];
        }
        return implode(',', $structureArray);
    }
    // データ登録  **$structureと$_POSTから取得したデータのnameは同一でなければならない
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
    // $status = addData('basicProfile', 'email,password', $dbh, $userInfo);
    
    
?>