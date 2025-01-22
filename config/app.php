<?php

class App
{
    private $host;
    private $dbname;
    private $user;
    private $pass;
    public $url;
    public $link;

    // Hold the class instance.
    private static $instance = null;

    private function __construct()
    {
        $this->connect();
    }

    private function __clone() {}

    public function __wakeup() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    public function connect()
    {
        $this->host = "localhost";
        $this->dbname = "events_db";
        $this->user = "root";
        $this->pass = "";
        $this->url = "http://localhost/ems/";

        try {
            $this->link = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Select all rows with prepared statements
    public function selectAll($query, $arr = [])
    {
        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Select one row with prepared statements
    public function selectOne($query, $arr = [])
    {
        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Insert operation with prepared statement
    public function insert($query, $arr, $path)
    {
        if ($this->validate($arr) == "empty") {
            echo "<script>alert('One or more input fields are empty!')</script>";
        } else {
            $stmt = $this->link->prepare($query);
            $stmt->execute($arr);
            header("location: " . $path);
        }
    }

    // Update operation with prepared statement
    public function update($query, $arr, $path)
    {
        if ($this->validate($arr) == "empty") {
            echo "<script>alert('One or more input fields are empty!')</script>";
        } else {
            $stmt = $this->link->prepare($query);
            $stmt->execute($arr);
            header("location: " . $path);
        }
    }

    // Delete operation with prepared statement
    public function delete($query, $arr, $path)
    {
        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        header("location: " . $path);
    }

    // Login operation with prepared statement
    public function login($query, $data, $path)
    {
        $stmt = $this->link->prepare($query);
        $stmt->execute([':email' => $data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            session_start();
            $_SESSION['id'] = $user['id'];
            header("location:" . $path);
        } else {
            echo "<script>alert('Invalid credentials!')</script>";
        }
    }
    public function register($query, $arr, $path)
    {
        if ($this->validate($arr) == "empty") {
            echo "<script>alert('one or more input fields are empty !!') </script>";
        } else {
            $register_user = $this->link->prepare($query);
            $register_user->execute($arr);

            header("location: " . $path . "");
        }
    }
    public function validate($arr)
    {
        return in_array("", $arr) ? "empty" : null;
    }

    public function startingSession()
    {
        session_start();
    }

    public function validateSession($path)
    {
        if (isset($_SESSION['id'])) {
            header("location:" . $path);
        }
    }
}
