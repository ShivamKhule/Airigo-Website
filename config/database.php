<?php
require_once 'firebase-config.php';

class Database {
    private $db;
    
    public function __construct() {
        $this->db = FirebaseConfig::getDatabase();
    }
    
    public function getReference($path) {
        return $this->db->getReference($path);
    }
    
    public function pushData($path, $data) {
        $ref = $this->getReference($path);
        return $ref->push($data);
    }
    
    public function setData($path, $data) {
        $ref = $this->getReference($path);
        return $ref->set($data);
    }
    
    public function updateData($path, $data) {
        $ref = $this->getReference($path);
        return $ref->update($data);
    }
    
    public function removeData($path) {
        $ref = $this->getReference($path);
        return $ref->remove();
    }
    
    public function getData($path) {
        $ref = $this->getReference($path);
        return $ref->getValue();
    }
    
    public function getDataByQuery($path, $query) {
        $ref = $this->getReference($path);
        $snapshot = $ref->orderByChild($query['field'])->equalTo($query['value'])->getValue();
        return $snapshot;
    }
}
?>