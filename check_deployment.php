<?php
// check_deployment.php - Advanced Diagnostic Script v2

// Set headers for clean output
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><title>Deployment Check v2</title>";
echo "<style>body{font-family:sans-serif;line-height:1.6;padding:20px;max-width:800px;margin:0 auto;}";
echo ".success{color:green;}.error{color:red;}.warning{color:orange;}.info{color:blue;}";
echo "code{background:#f4f4f4;padding:2px 5px;border-radius:3px;}</style></head><body>";

echo "<h1>🛠️ Firebase Deployment Diagnostic Tool v2</h1>";

$credFile = __DIR__ . '/config/firebase-credentials.json';
$errors = 0;

// 1. Check Server Time
echo "<h2>CLOCK CHECK 🕒</h2>";
$serverTime = time();
echo "<div>Server Time: <strong>" . date('Y-m-d H:i:s', $serverTime) . "</strong> (Timestamp: $serverTime)</div>";
echo "<p class='info'>Note: If this time is more than 5 minutes off from real UTC time, authentication will fail.</p>";

// 2. Load Credentials
if (!file_exists($credFile)) {
    die("<h2 class='error'>Credentials file not found.</h2>");
}

$content = file_get_contents($credFile);
$json = json_decode($content, true);
$privateKey = $json['private_key']; // Default read

// 3. Test Connectivity with Variations
echo "<h2>🔥 Authentication Tests</h2>";

function testAuth($pkey, $email, $label)
{
    echo "<h3>Test: $label</h3>";

    try {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
        $now = time();
        $payload = json_encode([
            'iss' => $email,
            'scope' => 'https://www.googleapis.com/auth/datastore',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]);

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = '';
        $success = openssl_sign($base64Header . '.' . $base64Payload, $signature, $pkey, 'SHA256');

        if (!$success) {
            echo "<div>OpenSSL Sign: <span class='error'>❌ Failed locally</span></div>";
            while ($msg = openssl_error_string())
                echo "<small>OpenSSL Error: $msg</small><br>";
            return false;
        }

        echo "<div>OpenSSL Sign: <span class='success'>✅ Signed Locally</span></div>";

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
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            echo "<div>Google Response: <span class='success'>✅ SUCCESS! (HTTP 200)</span></div>";
            echo "<p><strong>Valid Token Received.</strong></p>";
            return true;
        } else {
            echo "<div>Google Response: <span class='error'>❌ Failed (HTTP $httpCode)</span></div>";
            echo "<div>Response: " . htmlspecialchars($response) . "</div>";
            return false;
        }
    } catch (Exception $e) {
        echo "<div>Exception: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Attempt 1: Original Key
$result1 = testAuth($privateKey, $json['client_email'], "Original Key");

if (!$result1) {
    echo "<hr><div><i>Trying Key Repairs...</i></div>";

    // Repair Strategy 1: Replace literal \n with NEWLINE char, case-insensitive
    $repair1 = str_replace('\n', "\n", $privateKey);
    $repair1 = str_replace('\r', '', $repair1); // remove CRs

    if ($repair1 !== $privateKey) {
        testAuth($repair1, $json['client_email'], "Repaired Key (Fixed Newlines)");
    } else {
        echo "<div> Repair 1 skipped (no change)</div>";
    }

    // Repair Strategy 2: Double unescape just in case
    $repair2 = stripcslashes($privateKey);
    if ($repair2 !== $privateKey && $repair2 !== $repair1) {
        testAuth($repair2, $json['client_email'], "Repaired Key (stripcslashes)");
    }
}

echo "<h2>Next Steps</h2>";
echo "<ul>";
echo "<li>If 'Original Key' passed, everything is fine. Delete this script.</li>";
echo "<li>If a 'Repaired Key' passed, your private key file has formatting issues. Correct it in your code or re-upload the file.</li>";
echo "<li>If <strong>HTTP 400 Invalid Grant</strong> persists, verify Server Time vs Real Time.</li>";
echo "</ul>";

echo "</body></html>";
?>