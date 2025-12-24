<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseConfig {
    private static $factory;
    private static $database;
    
    public static function initialize() {
        if (self::$factory === null) {
            try {
                $configFile = __DIR__ . '/firebase-credentials.json';
                
                if (file_exists($configFile)) {
                    self::$factory = (new Factory)
                        ->withServiceAccount($configFile)
                        ->withDatabaseUri('https://airigo-jobs-default-rtdb.firebaseio.com/');
                } else {
                    throw new Exception("Firebase credentials file not found");
                }
                
                self::$database = self::$factory->createDatabase();
            } catch (Exception $e) {
                error_log("Firebase initialization error: " . $e->getMessage());
                throw new Exception("Failed to initialize Firebase services: " . $e->getMessage());
            }
        }
    }
    
    public static function getDatabase() {
        self::initialize();
        return self::$database;
    }
}
?>