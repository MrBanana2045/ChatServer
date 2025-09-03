<?php
header('Content-Type: application/json');

$group = $_POST['group'] ?? '';
$message = $_POST['msg'] ?? '';
$reply = $_POST['reply'] ?? '';
$userIp = $_SERVER['REMOTE_ADDR'];
$userFile = $group . '/users.txt';
$users = [];

if (file_exists($userFile)) {
    $lines = file($userFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $users = $lines;
}

$isNewUser = !in_array($userIp, $users);
if ($isNewUser) {
    $joinedMsg = "\n* Joined User " . '[' . $userIp . ']';
    $file = $group . '/server.txt';
    file_put_contents($file, $joinedMsg . PHP_EOL, FILE_APPEND);
    file_put_contents($userFile, $userIp . PHP_EOL, FILE_APPEND);
}
if (empty($message)) {
    echo json_encode(['success' => true]);
    exit;
}

if (strpos($message, '┏╼╼┫') !== false && strpos($message, '│') !== false && strpos($message, '┗╾╾┫') !== false) {
    echo json_encode(['success' => true]);
    exit;
}

$finalMsg = "\n" . '[' . date('H:i A') . '] ' . $userIp . ' : ' . htmlspecialchars($message);
if ($reply) {
    $finalMsg .= "\n┏╼╼┫ " . htmlspecialchars($reply) . "\n│\n┗╾╾┫ " . '[' . date('H:i A') . '] ' . $userIp . ' : ' . htmlspecialchars($message);
}
$file = $group . '/server.txt';
file_put_contents($file, $finalMsg . PHP_EOL, FILE_APPEND);

if ($reply) {
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $totalLines = count($lines);
    if ($totalLines >= 4) {
        unset($lines[$totalLines - 4]);
        $lines = array_values($lines);
        file_put_contents($file, implode("\n", $lines));
    }
}
echo json_encode(['success' => true]);
?>
