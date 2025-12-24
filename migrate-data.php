<?php
require_once 'config/firebase-config.php';

// Sample data structure for Realtime Database
$sampleData = [
    'jobs' => [
        'job1' => [
            'designation' => 'Flight Attendant',
            'companyName' => 'Emirates Airlines',
            'location' => 'Dubai, UAE',
            'jobType' => 'Full-time',
            'category' => 'Aviation',
            'ctc' => '50000-80000',
            'skills' => 'Customer Service, Safety Protocols',
            'description' => 'Join our cabin crew team and provide exceptional service to passengers.',
            'isUrgentHiring' => true,
            'createdAt' => date('Y-m-d H:i:s'),
            'postedBy' => 'recruiter@emirates.com'
        ],
        'job2' => [
            'designation' => 'Pilot',
            'companyName' => 'Qatar Airways',
            'location' => 'Doha, Qatar',
            'jobType' => 'Full-time',
            'category' => 'Aviation',
            'ctc' => '120000-200000',
            'skills' => 'Commercial Pilot License, Flight Experience',
            'description' => 'Experienced pilot needed for international flights.',
            'isUrgentHiring' => false,
            'createdAt' => date('Y-m-d H:i:s'),
            'postedBy' => 'hr@qatarairways.com'
        ],
        'job3' => [
            'designation' => 'Hotel Manager',
            'companyName' => 'Marriott International',
            'location' => 'Mumbai, India',
            'jobType' => 'Full-time',
            'category' => 'Hospitality',
            'ctc' => '60000-90000',
            'skills' => 'Hotel Management, Leadership',
            'description' => 'Manage daily operations of luxury hotel property.',
            'isUrgentHiring' => true,
            'createdAt' => date('Y-m-d H:i:s'),
            'postedBy' => 'careers@marriott.com'
        ]
    ],
    'jobseekers' => [
        'john_doe_gmail_com' => [
            'email' => 'john.doe@gmail.com',
            'fullName' => 'John Doe',
            'phone' => '+1234567890',
            'experience' => '5 years',
            'skills' => 'Customer Service, Aviation',
            'createdAt' => date('Y-m-d H:i:s')
        ]
    ],
    'recruiters' => [
        'hr_emirates_com' => [
            'email' => 'hr@emirates.com',
            'companyName' => 'Emirates Airlines',
            'contactPerson' => 'Sarah Johnson',
            'phone' => '+971501234567',
            'createdAt' => date('Y-m-d H:i:s')
        ]
    ]
];

try {
    $database = FirebaseConfig::getDatabase();
    
    echo "Migrating sample data to Realtime Database...\n";
    
    // Set the data
    $database->getReference()->set($sampleData);
    
    echo "✓ Sample data migrated successfully!\n";
    echo "Jobs: " . count($sampleData['jobs']) . "\n";
    echo "Jobseekers: " . count($sampleData['jobseekers']) . "\n";
    echo "Recruiters: " . count($sampleData['recruiters']) . "\n";
    
} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
}
?>