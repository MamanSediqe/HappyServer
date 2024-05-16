<?php
require_once 'LinksDb.php';
class Link
{
    public $LinkId = 0; 
    public $LinkTitle = ""; 
    public $LinkValue = ""; 
    public $ErrorMessage = ""; //برای اطلاع از خطای رخ داده

    public function __construct($Link_Id)
    {
        $this->LinkId = $Link_Id;
        $myDB = new LinksDB();
        $myDB->Connect();

        $strSQL = "Select * From  Links Where LinkId =" . $this->LinkId;

        $result = $myDB->conn->query($strSQL);
        try {
            if ($result) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $this->LinkTitle = $row["LinkTitle"];
                    $this->LinkValue = $row["LinkValue"];
                }
            }
        }
        catch (Exception $exc) {

        }
        $myDB->Disconnect();
    }

    public function fetchByTitle($Happy_Title)
    {
        $this->LinkTitle = $Happy_Title;
        $myDB = new LinksDB();
        $myDB->Connect();

        $strSQL = "Select * From  Links Where LinkTitle ='" . $this->LinkTitle . "'";

        $result = $myDB->conn->query($strSQL);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $this->LinkId = $row["LinkId"];
                $this->LinkValue = $row["LinkValue"];
            }
        }

        $myDB->Disconnect();
    }

    public function SetAll($Link_Id, $Happy_Title, $Happy_Link)
    {
        $this->LinkId = $Link_Id;
        $this->LinkTitle = $Happy_Title;
        $this->LinkValue = $Happy_Link;
    }

    public function HappyExists($Happy_Title)
    {
        $this->LinkTitle = $Happy_Title;
        $myDB = new LinksDB();
        $myDB->Connect();

        $strSQL = "Select * From  Links Where LinkTitle ='" . $this->LinkTitle . "'";

        $result = $myDB->conn->query($strSQL);

        if ($result->num_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    //گرفتن آخرین شناسه برای ایجاد شناسه جدید
    //از شمارنده اتوماتیک استفاده نکردم تا شناسه ها پشت سر هم باشند
    public function GetLastId()
    {
        $myDB = new LinksDB();
        $myDB->Connect();

        $strSQL = "SELECT MAX(LinkId)  FROM  Links ";

        $result = $myDB->conn->query($strSQL);
        if ($row = $result->fetch_assoc()) {
            return $row["MAX(LinkId)"] + 1;
        }
        else {
            //این اولین رکورد جدول است
            return 1;
        }
    }

    public function Insert()
    {
        //عنوان باید بیش از 4 حرف داشته  باشد
        if (strlen($this->LinkTitle) < 4 ) {
            return false;
        }

        $strSQL = "INSERT INTO Links (LinkId, LinkTitle, LinkValue)";
        $strSQL .= " VALUES ";
        $strSQL .= "( $this->LinkId , '$this->LinkTitle','" . $this->LinkValue . "');";

        $myDB = new LinksDB();
        $myDB->Connect();

        if ($myDB->conn->query($strSQL) === true) {
            $myDB->Disconnect();
            return true;
        }
        else {
            $this->ErrorMessage = $myDB->conn->error . "<br>";
            $myDB->Disconnect();
            return false;
        }
    }

    public function Update()
    {
        //عنوان  باید بیش از 4 حرف داشته  باشد
        if (strlen($this->LinkTitle) < 4 ) {
            return false;
        }

        $strSQL = "UPDATE Links Set ";
        $strSQL .= "LinkTitle = '" . $this->LinkTitle . "',";
        $strSQL .= "LinkValue = '" . $this->LinkValue . "'";
        $strSQL .= " WHERE  LinkId = '" . $this->LinkId . "'";

        $myDB = new LinksDB();
        $myDB->Connect();

        if ($myDB->conn->query($strSQL) === true) {
            $myDB->Disconnect();
            return true;
        }
        else {
            $this->ErrorMessage = $myDB->conn->error . "<br>";
            $myDB->Disconnect();
            return false;
        }
    }

    public function findByTitle($strTitle)
    {
        $strSQL = "SELECT * FROM  Links 
        WHERE  LinkTitle LIKE '%{$strTitle}%' ";
        $myDB = new LinksDB();
        $myDB->Connect();
        $result = $myDB->conn->query($strSQL);
        $rows = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($rows, $row);
        }
        $myDB->Disconnect();
        return $rows;
    }
}
