<?php
header('Content-Type: application/json');

if (isset($_GET['group'])) {
    $group = $_GET['group'];
    $file = $group . '/server.txt';
    $messages = [];
    if (file_exists($file)) {
        $messages = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    $ip = $group;
    echo json_encode([
        'ip' => $ip,
        'messages' => $messages
    ]);
    exit;
}

$folders = scandir(getcwd());
$groupNames = [];
foreach($folders as $end) {
    if ($end != '.' && $end != '..' && $end != 'save.php' && $end != 'load.php' && $end != 'index.html' && $end != 'user.php' && $end != 'users.json' && $end != 'server.php' && $end != 'users.json') { 
        $groupNames[] = $end;
    }
}

echo json_encode([
    'groupName' => $groupNames
]);
?>