<?php
require_once 'firebase-config.php';

class FirestoreDB
{
    private $projectId = 'airigo-jobs';
    private $fallbackData;

    public function __construct()
    {
        $this->fallbackData = [
            'jobs' => [
                'job1' => [
                    'designation' => 'Flight Attendant',
                    'companyName' => 'Emirates Airlines',
                    'location' => 'Dubai, UAE',
                    'jobType' => 'Full-time',
                    'category' => 'Aviation',
                    'ctc' => '50000-80000',
                    'skills' => 'Customer Service, Safety Protocols, Languages',
                    'description' => 'Join our world-class cabin crew team and provide exceptional service to passengers on international flights. We are looking for enthusiastic individuals who are passionate about delivering outstanding customer service.',
                    'requirements' => 'Minimum height 160cm, Excellent English communication, Customer service experience, Willingness to relocate',
                    'isUrgentHiring' => true,
                    'createdAt' => '2024-01-15 10:30:00',
                    'postedBy' => 'hr@emirates.com'
                ],
                'job2' => [
                    'designation' => 'Commercial Pilot',
                    'companyName' => 'Qatar Airways',
                    'location' => 'Doha, Qatar',
                    'jobType' => 'Full-time',
                    'category' => 'Aviation',
                    'ctc' => '120000-200000',
                    'skills' => 'ATPL License, Boeing 777 Type Rating, 5000+ Flight Hours',
                    'description' => 'Experienced commercial pilot needed for long-haul international flights. Join one of the world\'s leading airlines.',
                    'requirements' => 'Valid ATPL License, Type rating on wide-body aircraft, Minimum 5000 flight hours, Clean medical certificate',
                    'isUrgentHiring' => false,
                    'createdAt' => '2024-01-14 14:20:00',
                    'postedBy' => 'careers@qatarairways.com'
                ],
                'job3' => [
                    'designation' => 'Hotel Manager',
                    'companyName' => 'Marriott International',
                    'location' => 'Mumbai, India',
                    'jobType' => 'Full-time',
                    'category' => 'Hospitality',
                    'ctc' => '60000-90000',
                    'skills' => 'Hotel Management, Leadership, Revenue Management',
                    'description' => 'Manage daily operations of our luxury hotel property in Mumbai. Lead a team of hospitality professionals.',
                    'requirements' => 'Bachelor\'s in Hotel Management, 5+ years management experience, Strong leadership skills, Revenue management knowledge',
                    'isUrgentHiring' => true,
                    'createdAt' => '2024-01-13 09:15:00',
                    'postedBy' => 'careers@marriott.com'
                ],
                'job4' => [
                    'designation' => 'Airport Ground Staff',
                    'companyName' => 'IndiGo Airlines',
                    'location' => 'Delhi, India',
                    'jobType' => 'Full-time',
                    'category' => 'Aviation',
                    'ctc' => '25000-35000',
                    'skills' => 'Customer Service, Airport Operations, Communication',
                    'description' => 'Handle passenger check-in, baggage handling, and ground operations at Delhi airport.',
                    'requirements' => 'Graduate degree, Good communication skills, Ability to work in shifts, Physical fitness',
                    'isUrgentHiring' => true,
                    'createdAt' => '2024-01-12 16:45:00',
                    'postedBy' => 'hr@goindigo.in'
                ],
                'job5' => [
                    'designation' => 'Restaurant Manager',
                    'companyName' => 'Taj Hotels',
                    'location' => 'Goa, India',
                    'jobType' => 'Full-time',
                    'category' => 'Hospitality',
                    'ctc' => '45000-65000',
                    'skills' => 'Restaurant Management, Food & Beverage, Team Leadership',
                    'description' => 'Oversee restaurant operations in our luxury resort property in Goa.',
                    'requirements' => 'Hotel Management degree, F&B experience, Leadership skills, Knowledge of food safety standards',
                    'isUrgentHiring' => false,
                    'createdAt' => '2024-01-11 11:30:00',
                    'postedBy' => 'careers@tajhotels.com'
                ],
                'job6' => [
                    'designation' => 'Aircraft Maintenance Engineer',
                    'companyName' => 'Air India',
                    'location' => 'Bangalore, India',
                    'jobType' => 'Full-time',
                    'category' => 'Aviation',
                    'ctc' => '70000-100000',
                    'skills' => 'Aircraft Maintenance, AME License, Technical Skills',
                    'description' => 'Maintain and repair aircraft to ensure safety and airworthiness standards.',
                    'requirements' => 'AME License, Aeronautical Engineering degree, 3+ years experience, Knowledge of aviation regulations',
                    'isUrgentHiring' => true,
                    'createdAt' => '2024-01-10 08:00:00',
                    'postedBy' => 'careers@airindia.in'
                ],
                'job7' => [
                    'designation' => 'Cruise Ship Staff',
                    'companyName' => 'Royal Caribbean',
                    'location' => 'International Waters',
                    'jobType' => 'Contract',
                    'category' => 'Hospitality',
                    'ctc' => '40000-60000',
                    'skills' => 'Customer Service, Entertainment, Languages',
                    'description' => 'Work aboard luxury cruise ships providing exceptional guest experiences.',
                    'requirements' => 'Valid passport, STCW certification, Customer service experience, Flexibility to work contracts',
                    'isUrgentHiring' => true,
                    'createdAt' => '2024-01-09 15:30:00',
                    'postedBy' => 'jobs@royalcaribbean.com'
                ],
                'job8' => [
                    'designation' => 'Travel Consultant',
                    'companyName' => 'Thomas Cook',
                    'location' => 'Chennai, India',
                    'jobType' => 'Full-time',
                    'category' => 'Travel & Tourism',
                    'ctc' => '30000-45000',
                    'skills' => 'Travel Planning, Sales, Customer Relations',
                    'description' => 'Help customers plan and book their dream vacations and business travel.',
                    'requirements' => 'Tourism degree preferred, Sales experience, Knowledge of travel destinations, Computer skills',
                    'isUrgentHiring' => false,
                    'createdAt' => '2024-01-08 12:00:00',
                    'postedBy' => 'hr@thomascook.in'
                ]
            ]
        ];
    }

    private function getAccessToken()
    {
        try {
            $credentialsPath = __DIR__ . '/firebase-credentials.json';
            if (!file_exists($credentialsPath)) {
                return null;
            }

            $credentials = json_decode(file_get_contents($credentialsPath), true);

            $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
            $now = time();
            $payload = json_encode([
                'iss' => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/datastore',
                'aud' => 'https://oauth2.googleapis.com/token',
                'exp' => $now + 3600,
                'iat' => $now
            ]);

            $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
            $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

            $signature = '';
            openssl_sign($base64Header . '.' . $base64Payload, $signature, $credentials['private_key'], 'SHA256');
            $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            return $data['access_token'] ?? null;
        } catch (Exception $e) {
            error_log("Error getting access token: " . $e->getMessage());
            return null;
        }
    }

    private function fetchFromFirestore($collection)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/{$collection}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['documents'])) {
            $results = [];
            foreach ($data['documents'] as $doc) {
                $id = basename($doc['name']);
                $fields = $doc['fields'] ?? [];

                $item = ['id' => $id];
                foreach ($fields as $key => $value) {
                    if (isset($value['stringValue'])) {
                        $item[$key] = $value['stringValue'];
                    } elseif (isset($value['booleanValue'])) {
                        $item[$key] = $value['booleanValue'];
                    } elseif (isset($value['integerValue'])) {
                        $item[$key] = (int) $value['integerValue'];
                    }
                }
                $results[$id] = $item;
            }
            return $results;
        }

        return null;
    }

    public function getJobs($filters = [], $limit = 10, $offset = 0)
    {
        $jobs = $this->fetchFromFirestore('jobs') ?: $this->fallbackData['jobs'];

        // Ensure all jobs have IDs
        $jobsWithIds = [];
        foreach ($jobs as $id => $job) {
            $job['id'] = $job['id'] ?? $id;
            $jobsWithIds[$id] = $job;
        }
        $jobs = $jobsWithIds;

        // Apply filters
        if (!empty($filters['category'])) {
            $jobs = array_filter($jobs, function ($job) use ($filters) {
                return isset($job['category']) && $job['category'] === $filters['category'];
            });
        }

        return array_slice(array_values($jobs), 0, $limit);
    }

    public function getJobById($jobId)
    {
        $jobs = $this->fetchFromFirestore('jobs') ?: $this->fallbackData['jobs'];

        // First try to find by exact ID (Document Key)
        if (isset($jobs[$jobId])) {
            $job = $jobs[$jobId];
            $job['id'] = $jobId;
            return $job;
        }

        // Search by 'id' field within the job data
        foreach ($jobs as $key => $job) {
            $currentId = $job['id'] ?? $key;
            if ($currentId === $jobId) {
                // Found the job by its internal ID field
                $job['id'] = $currentId;
                return $job;
            }
        }

        // Allow partial match on document ID (legacy fallback)
        foreach ($jobs as $id => $job) {
            if (strpos($id, $jobId) !== false) {
                $job['id'] = $id;
                return $job;
            }
        }

        return null;
    }

    public function searchJobs($keyword = '', $location = '', $limit = 10)
    {
        $jobs = $this->fetchFromFirestore('jobs') ?: $this->fallbackData['jobs'];

        $results = [];
        foreach ($jobs as $id => $job) {
            if (!empty($keyword)) {
                $searchText = strtolower($keyword);
                $jobText = strtolower($job['designation'] . ' ' . $job['companyName'] . ' ' . $job['skills']);
                if (strpos($jobText, $searchText) === false) {
                    continue;
                }
            }

            if (!empty($location)) {
                $locationText = strtolower($location);
                $jobLocation = strtolower($job['location']);
                if (strpos($jobLocation, $locationText) === false) {
                    continue;
                }
            }

            $results[] = $job;
            if (count($results) >= $limit)
                break;
        }

        return $results;
    }

    // Simplified methods for other operations
    public function getJobseekerByEmail($email)
    {
        return null;
    }
    public function createJobseeker($email, $data)
    {
        return true;
    }
    public function updateJobseeker($email, $data)
    {
        return true;
    }
    public function getRecruiterByEmail($email)
    {
        return null;
    }
    public function createRecruiter($email, $data)
    {
        return true;
    }
    public function updateRecruiter($email, $data)
    {
        return true;
    }
    public function createApplication($jobId, $jobseekerEmail, $data)
    {
        return true;
    }
    public function getApplication($jobId, $jobseekerEmail)
    {
        return null;
    }
    public function toggleFavorite($jobId, $jobseekerEmail)
    {
        return true;
    }
}
?>