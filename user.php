<?php
header('Content-Type: application/json');

$group = isset($_POST['group']) ? $_POST['group'] : null;
if (!$group) {
    echo json_encode(['error' => 'Group not specified']);
    exit;
}

$usersFile = $group . '/users.json';
$serverFile = $group . '/server.txt'; 

if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

$currentIp = $_SERVER['REMOTE_ADDR'];
$users = json_decode(file_get_contents($usersFile), true);

$messageCounts = [];
if (file_exists($serverFile)) {
    $serverContent = file_get_contents($serverFile);
    $lines = explode("\n", $serverContent);
    
    foreach ($lines as $line) {
        if (preg_match('/\[(\d{1,2}:\d{2}\s[AP]M)\]\s(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s:\s(.+)/', $line, $matches)) {
            $ip = $matches[2];
            if (!isset($messageCounts[$ip])) {
                $messageCounts[$ip] = 0;
            }
            $messageCounts[$ip]++;
        }
    }
}

$exists = false;
foreach ($users as &$user) {
    if ($user['ip'] === $currentIp && $user['group'] === $group) {
        $user['last_seen'] = date('Y-m-d H:i:s');
        $user['msg'] = isset($messageCounts[$currentIp]) ? $messageCounts[$currentIp] : 0;
        $exists = true;
        break;
    }
}

if (!$exists) {
    $newUser = [
        'group' => $group,
        'ip' => $currentIp,
        'last_seen' => date('Y-m-d H:i:s'),
        'msg' => isset($messageCounts[$currentIp]) ? $messageCounts[$currentIp] : 0
    ];
    $users[] = $newUser;
}
foreach ($users as &$user) {
    if (isset($messageCounts[$user['ip']])) {
        $user['msg'] = $messageCounts[$user['ip']];
    } else {
        $user['msg'] = 0;
    }
}

file_put_contents($usersFile, json_encode($users));
echo json_encode(['users' => $users]);
?>
