<?php //start php tag
//include connect.php page for database connection
include('User.php');
$message = "";
$UserName = "";
$messageColor ="red";
$pageTitle="ورود مدیر سایت";
ini_set('display_errors',0);
try{
    session_start();//راه اندازی سشن برای نگهداری وضعیت کاربر
}catch(Exception $exc){
}
$_SESSION['username'] = 'guest';//اگر ادمین است  به میهمان تبدیل شود
include "template_top.html";

if (isset($_REQUEST['Submit'])) //here give the name of your button on which you would like    //to perform action.
{
    // here check the submitted text box for null value by giving there name.
    $UserName = htmlspecialchars($_REQUEST['user_id']);
    $Password = htmlspecialchars($_REQUEST['password']);
    
    if ($UserName == "" || $Password == "") {
        $message = " نام کاربری یا گذرواژه وارد نشده";
        $messageColor ="red";
    }
    else {
        if ($UserName=='happyadmin' && $Password=='12346') {
            $message =   " خوش آمدید";
            $_SESSION['username'] = $UserName;  //نگهداری وضعیت کاربر برای استفاده در صفحه‌ها
        //  echo "<center>با موفقیت وارد شدید" . "<br>";
        //  echo "User Name: " . $currentUser->UserName . "<br>";
        //  echo "User Title: " . $currentUser->UserTitle . "<br>";
        //  echo "User Type: " . $currentUser->UserType . "<br> </center>";
        $messageColor ="green";
        header("Location: ./admin_page.php");
        exit();
        }
        else {
            $message = "نام کاربری یا گذرواژه درست نیست";
            $messageColor ="red";
        //  echo "نام کاربری یا گذرواژه درست نیست";
        }
    }
}
else{
    if ($UserName == "" || $Password == "") {
        $message = " نام کاربری و گذرواژه خود را وارد کنید";
        $messageColor ="white";
    }
}
?>

        <form class="row"  name="form_login1" method="post" action="./login.php" role="form">
            <div class="row" style="border: none;text-align: center;">
                <input class="field-input" style="float: none;text-align: center;font-size: 25px" name="user_id" type="text" id="user_id" placeholder="نام کاربری" required value=<?php echo $UserName ?>>
            </div>
            <div class="row" style="border: none;text-align: center;" >
                <input class="field-input" style="float: none;text-align: center;font-size: 25px" type="password" name="password" id="password" placeholder="گذرواژه" required>
            </div>
            <div class="row" style="border: none;text-align: center;color:<?php echo $messageColor; ?>">             
                    <?php echo $message; ?>                
            </div>
            <div class="row" style="border: none; width:200px;margin:auto">
                <input type="submit" name="Submit" value="ورود" class="buttonExtend"></input>
            </div>
        </form>
</body>
</html>