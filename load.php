<?php
header('Content-Type: application/json');
function Lines($filename) {
    if (!file_exists($filename)) {
        return 0;
    }
    $file = new SplFileObject($filename, 'r');
    $file->seek(PHP_INT_MAX);
    $lineCount = $file->key() + 1;
    
    if ($lineCount > 0) {
        $lineCount--;
    }
    
    return $lineCount;
}
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
    if ($end != '.' && $end != '..' && is_dir($end)) { 
        $groupNames[] = $end;
    }
}

$usersPerGroup = [];
foreach ($groupNames as $group) {
    $userFile = $group . '/users.txt';
    if (file_exists($userFile)) {
        $usersPerGroup[$group] = Lines($userFile);
    } else {
        $usersPerGroup[$group] = 0;
    }
}

echo json_encode([
    'groupName' => $groupNames,
    'usersPerGroup' => $usersPerGroup
]);
?>
