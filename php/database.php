<?php
    // ローカル環境内のデータベースへ接続  **デフォルト値注意
    function lclDbConn($dbName, $host = 'localhost', $userName = 'root', $pwd = ''){
        $dsn = 'mysql:dbname='.$dbName.';host='.$host.';charset=utf8';
        return new PDO($dsn, $userName, $pwd);
    }
    // $dbh = localDbConn('userInfo');



    // 接続されたデータベース内に引数として指定されたテーブル名が存在しない場合、テーブルを作成  **デフォルト値注意
    function mkTbIF($tableName, $structure, $PDO){
        try {
            $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (id INT(12) NOT NULL auto_increment PRIMARY KEY,'.$structure.') DEFAULT CHARSET="utf8"';
            return $PDO -> query($sql);
        } catch (PDOException $e){
            exit('PDOException Error: '.$e -> getMessage());
        }
    }
    // $result = mkTbIF('basicProfile', 'email VARCHAR(256), password VARCHAR(256)', $dbh);



    // 下記データ保存用関数のみに使用
    function cvtStruc($structure){
        $structureArray = explode(',', $structure);
        for ($i=0; $i<count($structureArray); $i++){
            $structureArray[$i] = ':'.$structureArray[$i];
        }
        return implode(',', $structureArray);
    }
    // データ保存  **$structureと$_POSTから取得したデータのnameは同一でなければならない
    function addData($tableName, $structure, $PDO, $postedData){
        $structured = cvtStruc($structure);
        $add = 'INSERT INTO '.$tableName.'('.$structure.') VALUES('.$structured.')';
        $stmt = $PDO -> prepare($add);
        $structureArray = explode(',', $structure);
        for ($i=0; $i<count($structureArray); $i++){
            $stmt -> bindValue($structureArray[$i], $postedData[$structureArray[$i]], PDO::PARAM_STR);
        }
        return $stmt -> execute();
    }
    // $status = addData('basicProfile', 'email,password', $dbh, $userInfo);
    
    
?>