<?php
    function console_log($input){
        echo "<script>console.log(".json_encode($input).")</script>";
    }
?>