<?php
require_once 'config/firestore-db.php';

try {
    $db = new FirestoreDB();
    $jobs = $db->getJobs([], 3);
    
    echo "<h2>🔥 Firebase Connection Test</h2>";
    echo "<p><strong>Status:</strong> ✅ Connected Successfully!</p>";
    echo "<p><strong>Jobs Found:</strong> " . count($jobs) . "</p>";
    
    if (!empty($jobs)) {
        echo "<h3>Sample Jobs:</h3>";
        foreach ($jobs as $job) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
            echo "<h4>" . htmlspecialchars($job['designation']) . "</h4>";
            echo "<p><strong>Company:</strong> " . htmlspecialchars($job['companyName']) . "</p>";
            echo "<p><strong>Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
            echo "<p><strong>CTC:</strong> " . htmlspecialchars($job['ctc']) . "</p>";
            echo "</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Firebase Connection Failed</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}
?>