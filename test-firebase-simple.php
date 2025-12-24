<?php
require_once 'config/firebase-config.php';

try {
    echo "Testing Firebase connection...\n";
    
    $database = FirebaseConfig::getDatabase();
    echo "✓ Firebase initialized successfully\n";
    
    // Test reading data
    $reference = $database->getReference('jobs');
    $snapshot = $reference->limitToFirst(1)->getSnapshot();
    
    if ($snapshot->exists()) {
        echo "✓ Successfully connected to Firebase Realtime Database\n";
        echo "Sample job data found\n";
    } else {
        echo "⚠ Connected but no job data found\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>