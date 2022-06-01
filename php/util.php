<?php
    function console_log($input){
        echo "<script>console.log(".json_encode($input).")</script>";
    }

    function h($input){
        return htmlspecialchars($input, ENT_QUOTES);
    }
?>