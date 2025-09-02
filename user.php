<?php
header('Content-Type: application/json');
$usersFile = $_POST['group'] . '/users.json';

if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

$currentIp = $_SERVER['REMOTE_ADDR'];
$group = isset($_POST['group']) ? $_POST['group'] : null;
$users = json_decode(file_get_contents($usersFile), true);
$exists = false;
foreach ($users as $user) {
    if ($user['ip'] === $currentIp && $user['group'] === $group) {
        $exists = true;
        break;
    }
}

if (!$exists) {
    $newUser = [
        'group' => $group,
        'ip' => $currentIp,
        'last_seen' => date('Y-m-d H:i:s')
    ];
    $users[] = $newUser;
    file_put_contents($usersFile, json_encode($users));
}

echo json_encode(['users' => $users]);
?>