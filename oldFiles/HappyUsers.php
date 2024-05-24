<?php

require_once 'Links.php';

class User
{
    public $UserName = ""; //نام کاربری حدکاکثر 15 و حداقل 4 حرف
    public $UserTitle = ""; //عنوان کاربر حداکثر 50 حرف
    public $Password = ""; // گذر واژه حداکثر 15 حرف و حداقل 4 حرف
    public $UserType = ""; //برای نوع ادمین که بدانیم اجازه ویرایش دارد یا کاربر عادی
    public $ErrorMessage = ""; //برای اطلاع از خطای رخ داده

    public function __construct()
    {
    }

    public function fetchUser($User_Name)
    {
        $this->UserName = $User_Name;
        $myDB = new LinksDB();
        $myDB->Connect();

        $strSQL = "Select * From  HappyUsers Where UserName ='" . $this->UserName . "'";

        $result = $myDB->conn->query($strSQL);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $this->UserTitle = $row["UserTitle"];
                $this->Password = $row["Password"];
                $this->UserType = $row["UserType"];
            }
        } else {
            echo "0 results";
        }
        $myDB->Disconnect();
    }

    public function SetAll($User_Name, $User_Title, $Pass_Word, $User_Type)
    {
        $this->UserName = $User_Name;
        $this->UserTitle = $User_Title;
        $this->Password = $Pass_Word;
        $this->UserType = $User_Type;
    }

    public function UserExists($User_Name)
    {
        $this->UserName = $User_Name;
         $myDB = new LinksDB();      
        $myDB->Connect();

        $strSQL = "Select * From  HappyUsers Where UserName ='" . $this->UserName . "'";

        $result = $myDB->conn->query($strSQL);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Insert()
    {
        //نام کاربری و پسورد باید بیش از 4 حرف داشته  باشد
        if (strlen($this->UserName) < 4 || strlen($this->Password) < 4) {
            return false;
        }

        $strSQL = "INSERT INTO HappyUsers (UserName, UserTitle, Password, UserType)";
        $strSQL .= " VALUES ";
        $HashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        $strSQL .= "('" . $this->UserName . "','" . $this->UserTitle . "','" . $HashedPassword . "','" . $this->UserType . "')"; //(for sql code "'"+"'" to define string variable: '" + UserTitle +"'  )

        $myDB = new LinksDB();
        $myDB->Connect();

        if ($myDB->conn->query($strSQL) === true) {
            $myDB->Disconnect();
            return true;
        } else {
            $this->ErrorMessage =  $myDB->conn->error . "<br>";
            $myDB->Disconnect();
            return false;
        }
    }

    public function Update()
    {
        //نام کاربری و پسورد باید بیش از 4 حرف داشته  باشد
        if (strlen($this->UserName) < 4 || strlen($this->Password) < 4) {
            return false;
        }
        $HashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        $strSQL = "UPDATE HappyUsers Set ";
        $strSQL .= "UserTitle = '" . $this->UserTitle . "',";
        $strSQL .= "Password ='" . $HashedPassword . "',";
        $strSQL .= "UserType = '" . $this->UserType . "'";
        $strSQL .= " WHERE  UserName = '" . $this->UserName . "'";

        $myDB = new LinksDB();
        $myDB->Connect();

        if ($myDB->conn->query($strSQL) === true) {
            $myDB->Disconnect();
            return true;
        } else {
            $this->ErrorMessage =  $myDB->conn->error . "<br>";
            $myDB->Disconnect();
            return false;
        }
    }
}
