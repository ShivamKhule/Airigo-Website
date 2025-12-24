<?php
require_once 'config/firestore-db.php';

$db = new FirestoreDB();

echo "Testing job database...\n";

// Test getting all jobs
$jobs = $db->getJobs([], 5);
echo "Found " . count($jobs) . " jobs\n";

foreach ($jobs as $job) {
    echo "Job ID: " . $job['id'] . " - " . $job['designation'] . "\n";
}

// Test getting specific job
echo "\nTesting job details for job1:\n";
$job = $db->getJobById('job1');
if ($job) {
    echo "Job found: " . $job['designation'] . " at " . $job['companyName'] . "\n";
} else {
    echo "Job not found\n";
}
?>