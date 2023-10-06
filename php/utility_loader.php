<?php
$current_hostname = gethostname(); // Requires PHP 5.3+

// Define the desired hostnames and corresponding new root directories in an associative array
$hostnameRootMap = array(
    "computer.pcru.ac.th" => "/s641102064111/eportfolio66/",
    "10.10.10.63" => "/s641102064111/eportfolio66/"
);

// Check if the current hostname is in the array
if (array_key_exists($current_hostname, $hostnameRootMap)) {
    $_SERVER["DOCUMENT_ROOT"] = $hostnameRootMap[$current_hostname];
    $root_directory = $_SERVER["DOCUMENT_ROOT"];
    echo "<script>console.log('Utility-loader:Root directory changed to: $root_directory');</script>";
} else {
    echo "<script>console.log('Utility-loader:Hostname does not match, no custom root path change needed.');</script>";
}

$dir = $_SERVER['DOCUMENT_ROOT'] . '/php/auto/';
$excludedFiles = [];
$files = scandir($dir);
foreach ($files as $file) {
    $filePath = $dir . $file;
    if (is_file($filePath) && !in_array($file, $excludedFiles)) {
        include_once $filePath;
    } elseif (is_dir($filePath) && $file !== '.' && $file !== '..') {
        $subFiles = scandir($filePath);
        foreach ($subFiles as $subFile) {
            $subFilePath = $filePath . '/' . $subFile;
            if (is_file($subFilePath) && !in_array($subFile, $excludedFiles)) {
                include_once $subFilePath;
            }
        }
    }
}


$jsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/js/auto/';
$files = scandir($jsDirectory);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }
    if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
        echo '<script src="/js/auto/' . $file . '?epoch=' . floor(time()) . '"></script>' . PHP_EOL;
    }
}

echo '<meta charset="utf-8mb4">
<meta name="viewport" content="width=device-width, initial-scale=1">' . PHP_EOL;

include_once $_SERVER['DOCUMENT_ROOT'] . '/template/font.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/template/bootstrap.php';

echo '<link rel="stylesheet" href="/template/style.css?epoch='.floor(time()).'">' . PHP_EOL;
echo '<link rel="icon" href="/res/img/yy_genshin230207.gif" type="image/gif">' . PHP_EOL;
?>