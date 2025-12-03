<?php

echo "Checking if composer installation is complete...\n";

// Check if autoload.php exists
if (file_exists('vendor/autoload.php')) {
    echo "✓ Autoload file exists\n";
    
    // Try to include the autoload file
    require_once 'vendor/autoload.php';
    
    echo "✓ Autoload file loaded successfully\n";
    echo "Composer installation appears to be complete!\n";
} else {
    echo "✗ Autoload file not found\n";
    echo "Composer installation is still in progress or incomplete.\n";
}

echo "Checking vendor directory contents:\n";
$vendorDirs = scandir('vendor');
foreach ($vendorDirs as $dir) {
    if ($dir !== '.' && $dir !== '..' && is_dir("vendor/$dir")) {
        echo "  - $dir\n";
    }
}