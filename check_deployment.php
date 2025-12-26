<?php
// check_deployment.php - Diagnostic Script v3 (Fingerprint Mode)

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><title>Deployment Check v3</title>";
echo "<style>body{font-family:sans-serif;line-height:1.6;padding:20px;max-width:800px;margin:0 auto;background:#f9f9f9;}";
echo ".card{background:white;padding:20px;margin-bottom:20px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);}";
echo ".success{color:green;font-weight:bold;}.error{color:red;font-weight:bold;}";
echo "code{background:#eee;padding:2px 5px;border-radius:3px;font-family:monospace;}";
echo ".hash{font-family:monospace;font-size:1.2em;background:#eef;padding:10px;display:block;word-break:break-all;}";
echo "</style></head><body>";

echo "<h1>🔍 Credential Fingerprint Tool</h1>";
echo "<p>Run this script <strong>LOCALLY</strong> and on <strong>HOSTINGER</strong>. Compare the 'Key Hash' values. They MUST match exactly.</p>";

$credFile = __DIR__ . '/config/firebase-credentials.json';

echo "<div class='card'>";
if (file_exists($credFile)) {
    $content = file_get_contents($credFile);
    $json = json_decode($content, true);
    
    if ($json && isset($json['private_key'])) {
        $key = $json['private_key'];
        
        // Calculate a simple hash of the key to verify integrity
        $hash = md5(preg_replace('/\s+/', '', $key)); // Remove all whitespace before hashing for robust comparison
        
        echo "<h3>🔑 Private Key Fingerprint</h3>";
        echo "<div class='hash'>$hash</div>";
        
        echo "<h3>� Service Account Email</h3>";
        echo "<code>" . htmlspecialchars($json['client_email']) . "</code>";
        
        echo "<h3>📁 File Stats</h3>";
        echo "Size: " . strlen($content) . " bytes<br>";
        echo "Last Modified: " . date("Y-m-d H:i:s", filemtime($credFile));
        
        // Actual connectivity test again
        echo "<h3>🌐 Live Connection Test</h3>";
        $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
        $now = time();
        $payload = json_encode([
            'iss' => $json['client_email'],
            'scope' => 'https://www.googleapis.com/auth/datastore',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]);
        
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = '';
        openssl_sign($base64Header . '.' . $base64Payload, $signature, $key, 'SHA256');
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
            echo "<span class='success'>✅ CONNECTED SUCCESSFULLY</span>";
        } else {
            echo "<span class='error'>❌ FAILED (HTTP $httpCode)</span>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        }

    } else {
        echo "<span class='error'>Invalid JSON in credential file</span>";
    }
} else {
    echo "<span class='error'>File not found: config/firebase-credentials.json</span>";
}
echo "</div>";

echo "</body></html>";
?>