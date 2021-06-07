<?php

function debug_log($msg) {
    error_log("$msg\n", 3, "/docker/logs/php_runtime.log");
}

?>