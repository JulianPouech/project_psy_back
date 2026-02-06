<?php
$apiDir = dirname(__DIR__);

$files = [
    $apiDir.'UserController.php',
    $apiDir.'PatientController.php'
];

foreach ($files as $file) {
    if(file_exists($file))
    {
        require_once $file;
    }
}
?>
