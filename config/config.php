<?php
/**
 * Configuration Loader
 * Loads environment variables and application configuration
 */

class Config {
    private static $config = [];
    private static $loaded = false;
    
    public static function load() {
        if (self::$loaded) {
            return;
        }
        
        // Load .env file if it exists
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '#') === 0) {
                    continue; // Skip comments
                }
                
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value, '"\'');
                    
                    // Set environment variable if not already set
                    if (!getenv($key)) {
                        putenv("{$key}={$value}");
                        $_ENV[$key] = $value;
                    }
                }
            }
        }
        
        // Set default configuration
        self::$config = [
            'app' => [
                'env' => self::env('APP_ENV', 'development'),
                'debug' => self::env('APP_DEBUG', 'true') === 'true',
                'url' => self::env('APP_URL', 'http://localhost'),
            ],
            'database' => [
                'firebase_project_id' => self::env('FIREBASE_PROJECT_ID'),
                'firebase_database_url' => self::env('FIREBASE_DATABASE_URL'),
            ],
            'mail' => [
                'host' => self::env('MAIL_HOST', 'localhost'),
                'port' => self::env('MAIL_PORT', 587),
                'username' => self::env('MAIL_USERNAME'),
                'password' => self::env('MAIL_PASSWORD'),
                'encryption' => self::env('MAIL_ENCRYPTION', 'tls'),
                'from_address' => self::env('MAIL_FROM_ADDRESS', 'noreply@localhost'),
                'from_name' => self::env('MAIL_FROM_NAME', 'Airigojobs'),
            ],
            'upload' => [
                'max_size' => self::env('MAX_UPLOAD_SIZE', 5242880),
                'allowed_types' => explode(',', self::env('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,pdf,doc,docx')),
            ],
            'security' => [
                'session_lifetime' => self::env('SESSION_LIFETIME', 7200),
                'csrf_token_lifetime' => self::env('CSRF_TOKEN_LIFETIME', 3600),
            ],
            'cache' => [
                'enabled' => self::env('CACHE_ENABLED', 'true') === 'true',
                'lifetime' => self::env('CACHE_LIFETIME', 3600),
            ],
            'rate_limit' => [
                'enabled' => self::env('RATE_LIMIT_ENABLED', 'false') === 'true',
                'requests' => self::env('RATE_LIMIT_REQUESTS', 100),
                'window' => self::env('RATE_LIMIT_WINDOW', 3600),
            ]
        ];
        
        self::$loaded = true;
    }
    
    public static function get($key, $default = null) {
        self::load();
        
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    public static function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            $value = $_ENV[$key] ?? $default;
        }
        return $value;
    }
    
    public static function isProduction() {
        return self::get('app.env') === 'production';
    }
    
    public static function isDebug() {
        return self::get('app.debug', false);
    }
}

// Auto-load configuration
Config::load();
?>