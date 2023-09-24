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
    echo "<script>console.log('Post-loader:Root directory changed to: $root_directory');</script>";
} else {
    echo "<script>console.log('Post-loader:Hostname does not match, no custom root path change needed.');</script>";
}

$jsDirectory = $_SERVER['DOCUMENT_ROOT'] . '/js/post/';
$files = scandir($jsDirectory);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }
    if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
        echo '<script src="/js/post/' . $file . '?epoch=' . floor(time()) . '"></script>' . PHP_EOL;
    }
}
?>