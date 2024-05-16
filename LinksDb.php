<?php

require_once "HappyUsers.php";
require_once "Links.php";

class LinksDB
{
    public $servername;
    public $dbName;
    public $username;
    public $password;
    public $port;
    public $conn;

    function __construct()
    {
        /* $this->servername = "sql106.infinityfree.com";
        $this->dbName = "if0_36134255_Links";        
        $this->username = "if0_36134255";
        $this->password = "Ph123465431";
        */
        /*
        $this->servername = "localhost";
        $this->dbName = "Links";
        // $this->username = "Happy_Admin";
        $this->username = "HappyUser";
        $this->password = "Happy_12346";
       */
        $this->servername = "localhost";
        //$this->dbName = "Links";
        //$this->dbName = "FoodsDb";
        //$this->dbName = "LinksDb";
        $this->dbName = "LordDb";
        // $this->username = "Happy_Admin";
        $this->username = "happy_user";
        $this->password = "Happy_12346";

        $this->port = 3306;
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName, $this->port);
    }


    function Connect()
    {
        //echo "Before connecting to the database<br> SN: " .$this->servername." UN:" . $this->username. "Pass:" . $this->password;        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName, $this->port);
        // echo "After connecting to the database<br>";
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function Disconnect()
    {
        try {
            $this->conn->close();
        } catch (Exception $e) {
        }
    }

    function Initialize()
    {/*
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        echo "Step > 1<br>";
        $this->createDatabase();
        echo "Step > 2<br>";
        $this->CreateLinksTable();
        echo "Step 3<br>";
        $this->CreateHappyUsersTable();
        echo "Step 4<br>";

        $this->AddRecords();
        */
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        echo "Step > 1<br>";
        $this->createDatabase();
        echo "Step > 2<br>";

        // Call importDumpFile() method after creating the database
        echo "Step > 3<br>";
        $this->importSQLFile();

      /*  echo "Step > 4 Create links table if not";
        $this->CreateLinksTable();

        echo "Step 3<br>";
        $this->AddRecords();*/
    }

    function CreateDB()
    {
        echo "Before connecting to the database<br> SN: " . $this->servername . " UN:" . $this->username . "Pass:" . $this->password;
        // Creating a database named newDB
        $this->conn = new mysqli($this->servername, $this->username, $this->password, "", $this->port); //اینجا نمیتوانم از متد کانکت استفاده کنم چون بانک اطلاعاتی هنوز ایجاد نشده 
        echo "After connecting to the database<br>";
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $strSQL = "CREATE DATABASE " . $this->dbName;
        if ($this->conn->query($strSQL) === TRUE) {
            echo "Database " . $this->dbName . " created successfully<br>";
        } else {
            echo "Error creating database: " . $this->conn->error . "<br>";
        }
        // closing connection
        $this->Disconnect();
    }

    function createDatabase()
    {
        echo "Step 0<br/>";

        // Establish a temporary connection without selecting a database
        $tempConn = new mysqli($this->servername, $this->username, $this->password, "", $this->port);

        echo "Step 1<br/>";

        // Check if the temporary connection is successful
        if ($tempConn->connect_error) {
            die("Temporary connection failed: " . $tempConn->connect_error);
        } else {
            echo "Temporary connection successful<br>";
        }


        echo "Step 2<br/>";

        // SQL command to create the database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbName;

        // Execute the query using the temporary connection
        if ($tempConn->query($sql) === TRUE) {
            echo "Database created successfully<br>";
        } else {
            echo "Error creating database: " . $tempConn->error . "<br>";
            echo "Query: " . $sql . "<br>";
        }

        echo "Step 3<br/>";

        // Close the temporary connection
        $tempConn->close();

        echo "Step 4<br/>";

        // Additional debug information
        echo "Server: " . $this->servername . "<br>";
        echo "Username: " . $this->username . "<br>";
        echo "Password: " . $this->password . "<br>";
        echo "Port: " . $this->port . "<br>";
        echo "DB Name: " . $this->dbName . "<br>";

        // Now, establish the main connection with the selected database
        $this->Connect();

        echo "Step 5<br/>";
    }

    public function importSQLFile() {
        $sqlDump = file_get_contents("DefaultDb.sql");
        if ($sqlDump === false) {
            die("Error reading SQL file<br/>");
        }
    
        // Execute the SQL commands to import data into the database
        if ($this->conn->multi_query($sqlDump)) {
            // Loop through all result sets (if any)
            do {
                // Store and free the current result set
                if ($result = $this->conn->store_result()) {
                    $result->free();
                }
                // Check if there are more result sets to process
                if (!$this->conn->more_results()) {
                    break;
                }
                // Move to the next result set
            } while ($this->conn->next_result());
    
            echo "SQL File executed successfully<br/>";
        } else {
            echo "Error executing SQL file: " . $this->conn->error . "<br/>";
        }
    }
    

    function exportToDumpFile()
    {
        // Generate a date string to include in the filename
        $dateString = date("Y-m-d_H-i-s");

        // Define the filename with the date string
        $dumpFileName = "dump_" . $dateString . ".sql";

        // Define the full path to the dump file
        $dumpFilePath = __DIR__ . "/" . $dumpFileName;

        // Report the current directory
        echo "Current Directory: " . __DIR__ . "<br/>";

        // Perform a mysqldump command to export the database structure and data to the dump file
        // Note: Replace 'your_database_name' with the actual name of your database
        $command = "mysqldump --user={$this->username} --password={$this->password} --host={$this->servername} {$this->dbName} > {$dumpFilePath}";

        // Report the command being executed
        echo "Executing Command: " . $command . "<br/>";

        // Execute the command and capture output and return status
        exec($command, $output, $returnVar);

        // Check if the command was executed successfully
        if ($returnVar === 0) {
            echo "Database exported to dump file '{$dumpFileName}' successfully<br/>";
        } else {
            // Output any errors or output from the command
            echo "Error exporting database to dump file<br/>";
            echo "Command Output:<br/>";
            print_r($output);
        }
    }

    function CreateLinksTable()
    {
        echo "Step 2.1<br>";
        $this->Connect();
        static $strSQL = "CREATE TABLE Links (";
        $strSQL .= "LinkId int NOT NULL, ";
        $strSQL .= "LinkTitle VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_persian_ci  NOT NULL,";
        $strSQL .= "LinkValue VARCHAR(4096) CHARACTER SET utf8 COLLATE utf8_persian_ci ,";
        $strSQL .= "PRIMARY KEY (LinkId)";
        $strSQL .= ")";

        if ($this->conn->query($strSQL) === TRUE) {
            echo "Table Links created successfully<br>";
        } else {
            echo "Error creating table Links: " . $this->conn->error . "<br>";
        }
        // closing connection
        $this->Disconnect();
    }

    function DeleteTable($Table_Name)
    {
        echo "Dropping table $Table_Name";
        $this->Connect();
        $str_SQL = "DROP TABLE $Table_Name ";
        if ($this->conn->query($str_SQL) === TRUE) {
            echo "The table $Table_Name Deleted successfully<br>";
        } else {
            echo "Error Deleting table $Table_Name: " . $this->conn->error . "<br>";
        }
        // closing connection
        $this->Disconnect();
    }

    //حذف تمام جدول ها برای مواقعی که ساختار تغییر کرده
    function DropTables()
    {
        echo "Start Deleting";
        $this->DeleteTable("HappyUsers");
        $this->DeleteTable("Links");
    }
    //جدول اطلاعات کاربران
    function CreateHappyUsersTable()
    {
        echo "Creating HappyUsers...<br>";
        $this->Connect();
        static $strSQL = "CREATE TABLE HappyUsers (";
        $strSQL .= "UserName VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_persian_ci  PRIMARY KEY,";
        $strSQL .= "UserTitle VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_persian_ci  NOT NULL,";
        $strSQL .= "Password VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_persian_ci ,";
        $strSQL .= "UserType VARCHAR(3))";
        //سه حرف برای نوع کاربر
        //ادمین AMD
        //کاربر معمولی STD

        if ($this->conn->query($strSQL) === TRUE) {
            echo "Table HappyUsers created successfully<br>";
        } else {
            echo "Error creating table HappyUsers: " . $this->conn->error . "<br>";
        }
        // closing connection
        $this->Disconnect();
    }



    function AddRecords()
    {

        //پس از ایجاد بانک اطلاعات و ایجاد جدول ها در آن 
        //در هر جدول یک رکورد مفید ثبت و ویرایش میکنیم
        //ثبت برای کاربرد رکورد است اما ویرایش در مراحل تست و رفع عیب برنامه بکار رفته است

        //تست عملکرد ثبت کاربر در بانک اطلاعات
        $tempUser = new User();
        if ($tempUser->UserExists("Admin")) {
            echo "Admin User Exists<br>";
        } else {
            $tempUser->SetAll("Admin", "مدیر سایت", "12589", "ADM");
            if ($tempUser->Insert()) {
                echo "Admin User Added<br>";
            } else {
                echo "Error adding Admin: " . $this->conn->error . "<br>";
            }
        }

        //تست عملکرد ثبت کاربر در بانک اطلاعات
        if ($tempUser->UserExists("Guest")) {
            echo "Guest User Exists<br>";
        } else {
            $tempUser->SetAll("Guest", "میهمان سایت", "12345", "USR");
            if ($tempUser->Insert()) {
                echo "Guest User Added<br>";
            } else {
                echo "Error adding Guest: " . $this->conn->error . "<br>";
            }
        }

        //تست عملکرد ویرایش اطلاعات کاربر در بانک اطلاعات
        $tempUser->SetAll("Guest", "کاربر میهمان", "123456", "USR");
        if ($tempUser->Update()) {
            echo "Guest User Editted<br>";
        } else {
            echo "Error editting Guest: " . $this->conn->error . "<br>";
        }

        $tempHappy = new Link(1);
        if ($tempHappy->HappyExists(1)) {
            echo "Happy 1 Exists<br>";
        } else {
            $tempHappy->LinkId = 1;
            $tempHappy->LinkTitle = "Server 1";
            $tempHappy->LinkValue = "https://";
            if ($tempHappy->Insert()) {
                echo "Happy 1 Added<br>";
            } else {
                echo "Error adding Happy 1 : " . $tempHappy->ErrorMessage . "<br>";
            }
        }

        $tempHappy = new Link(2);
        if ($tempHappy->HappyExists(2)) {
            echo "Happy 2 Exists<br>";
        } else {
            $tempHappy->LinkId = 2;
            $tempHappy->LinkTitle = "Server 1";
            $tempHappy->LinkValue = "https://Happy.com";
            if ($tempHappy->Insert()) {
                echo "Happy 2 Added<br>";
            } else {
                echo "Error adding Happy 2 : " . $tempHappy->ErrorMessage . "<br>";
            }
        }
    }

    // Function to fetch all Happy records
    function getAllLinks()
    {
        $sql = "SELECT * FROM Links  ORDER BY LinkTitle";
        $result = $this->conn->query($sql);
        $Links = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $Links[] = $row;
            }
        }

        return $Links;
    }
}
