<?php
// check_deployment.php - Diagnostic script for Firebase connection

// Set headers for clean output
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><title>Deployment Check</title>";
echo "<style>body{font-family:sans-serif;line-height:1.6;padding:20px;max-width:800px;margin:0 auto;}";
echo ".success{color:green;}.error{color:red;}.warning{color:orange;}";
echo "code{background:#f4f4f4;padding:2px 5px;border-radius:3px;}</style></head><body>";

echo "<h1>🛠️ Firebase Deployment Diagnostic Tool</h1>";

$checks = [];
$errors = 0;

// 1. Check PHP Version
$phpVersion = phpversion();
echo "<h2>🖥️ Server Environment</h2>";
echo "<div>PHP Version: <strong>$phpVersion</strong> " . (version_compare($phpVersion, '7.4', '>=') ? "<span class='success'>✅ Supported</span>" : "<span class='error'>❌ Upgrade Required (>= 7.4)</span>") . "</div>";

// 2. Check Required Extensions
echo "<h3>PHP Extensions</h3>";
$requiredExtensions = ['curl', 'json', 'openssl', 'mbstring', 'bcmath', 'ctype'];
foreach ($requiredExtensions as $ext) {
    echo "<div>Checking extension: <strong>$ext</strong>... ";
    if (extension_loaded($ext)) {
        echo "<span class='success'>✅ Loaded</span></div>";
    } else {
        echo "<span class='error'>❌ Missing</span></div>";
        $errors++;
    }
}

// 3. Check Vendor Directory
echo "<h2>📂 File & Directory Check</h2>";
$autoloadFile = __DIR__ . '/vendor/autoload.php';
echo "<div>Looking for Composer Autoload at: <code>vendor/autoload.php</code>... ";
if (file_exists($autoloadFile)) {
    echo "<span class='success'>✅ Found</span></div>";
} else {
    echo "<span class='error'>❌ NOT FOUND!</span></div>";
    echo "<p class='warning'>⚠️ Your 'vendor' folder is missing. The application requires it even if you don't use all libraries. Run 'composer install' or upload the 'vendor' folder.</p>";
    $errors++;
}

// 4. Check Credentials File
$credFile = __DIR__ . '/config/firebase-credentials.json';
echo "<div>Looking for credentials at: <code>config/firebase-credentials.json</code>... ";

if (file_exists($credFile)) {
    echo "<span class='success'>✅ Found</span></div>";

    if (is_readable($credFile)) {
        echo "<div>Read Permission: <span class='success'>✅ Readable</span></div>";

        $content = file_get_contents($credFile);
        $json = json_decode($content, true);

        if ($json && isset($json['project_id']) && isset($json['private_key'])) {
            echo "<div>JSON Content: <span class='success'>✅ Valid Service Account JSON</span></div>";
            echo "<div>Project ID: <strong>" . htmlspecialchars($json['project_id']) . "</strong></div>";
        } else {
            echo "<div>JSON Content: <span class='error'>❌ Invalid JSON structure</span></div>";
            $errors++;
        }
    } else {
        echo "<div>Read Permission: <span class='error'>❌ Not Readable (Check Permissions, should be 644)</span></div>";
        $errors++;
    }
} else {
    echo "<span class='error'>❌ NOT FOUND!</span></div>";
    echo "<p class='warning'>⚠️ You most likely forgot to upload <code>config/firebase-credentials.json</code> to the server.</p>";
    $errors++;
}

// 5. Test Connectivity
echo "<h2>🌐 Connectivity Test</h2>";

if ($errors === 0 || (file_exists($credFile) && !file_exists($autoloadFile))) {
    // We attempt connectivity even if vendor is missing, just to prove credentials work
    try {
        echo "<div>Attempting to generate token...</div>";

        // Inline simple test from FirestoreDB logic to isolate issues
        $credentials = json_decode(file_get_contents($credFile), true);
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
        $signResult = openssl_sign($base64Header . '.' . $base64Payload, $signature, $credentials['private_key'], 'SHA256');

        if ($signResult) {
            echo "<div>OpenSSL Signing: <span class='success'>✅ Success</span></div>";

            $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
            $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;

            // Curl request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Disable SSL verification strictly for diagnosis if certificate bundle is missing on cheap hosting
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if (isset($data['access_token'])) {
                    echo "<div>Google Auth: <span class='success'>✅ Access Token Received</span> (Token length: " . strlen($data['access_token']) . ")</div>";
                    echo "<h3>🎉 Firebase Connection is WORKING!</h3>";
                    echo "<p>If you see this message, your server IS connecting to Firebase. If jobs are still not loading, check your database rules or collection names.</p>";
                } else {
                    echo "<div>Google Auth: <span class='error'>❌ Invalid Response</span> - " . htmlspecialchars($response) . "</div>";
                }
            } else {
                echo "<div>Google Auth: <span class='error'>❌ HTTP $httpCode</span></div>";
                if ($curlError)
                    echo "<div>Curl Error: $curlError</div>";
                echo "<div>Response: " . htmlspecialchars($response) . "</div>";
            }

        } else {
            echo "<div>OpenSSL Signing: <span class='error'>❌ Failed</span> (Check Private Key format)</div>";
        }

    } catch (Exception $e) {
        echo "<div>Exception: <span class='error'>" . $e->getMessage() . "</span></div>";
    }
} else {
    echo "<div>Skipping connectivity test due to critical missing files.</div>";
}

echo "</body></html>";
?>