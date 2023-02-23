<?php

$post_json = file_get_contents('php://input');
$post = json_decode($post_json);

?>