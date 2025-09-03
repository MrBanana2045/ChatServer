<?php
header('Content-Type: application/json');

$group = $_POST['group'] ?? '';
$userIp = $_SERVER['REMOTE_ADDR'];

$userIpGroup = str_replace('.', '_', $userIp);

if ($group !== $userIpGroup) {
    exit;
}

$folderPath = $group;

if (is_dir($folderPath)) {
    function deleteFolder($path) {
        if (!is_dir($path)) return false;
        
        $files = array_diff(scandir($path), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $path . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                deleteFolder($filePath);
            } else {
                unlink($filePath);
            }
        }
        return rmdir($path);
    }

    if (deleteFolder($folderPath)) {
        echo json_encode(['success' => true, 'message' => 'Server Deleted']);
    }
}
?>