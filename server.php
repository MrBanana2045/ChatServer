<?php
$group = $_POST['group'] ?? '';

if (empty($group)) {
    $group = str_replace('.', '_', $_SERVER['REMOTE_ADDR']);
}
if (!file_exists($group)) {
    mkdir($group, 0777, true);
}
?>