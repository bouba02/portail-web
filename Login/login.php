<!-- PHP Starts Here -->
<?php 
session_start();
    require_once "../connection/connection.php"; 
    // $message="Email Or Password Does Not Match";
    $message="";
    if(isset($_POST["btnlogin"]))
    {
        $username=$_POST["email"];
        $password=$_POST["password"];

        $query="select * from login where user_id='$username' and Password='$password' ";
        $result=mysqli_query($con,$query);
        if (mysqli_num_rows($result)>0) {
            while ($row=mysqli_fetch_array($result)) {
                if ($row["Role"]=="Admin")
                {
                    $_SESSION['LoginAdmin']=$row["user_id"];
                    header('Location: ../admin/admin-index.php');
                }
                else if ($row["Role"]=="Teacher" and $row["account"]=="Activate")
                {
                    $_SESSION['LoginTeacher']=$row["user_id"];
                    header('Location: ../teacher/teacher-index.php');
                }
                else if ($row["Role"]=="Student" and $row["account"]=="Activate")
                {   
                    $query="select * from student where email='$username' and password='$password' ";
                    $result=mysqli_query($con,$query);
                    $res=mysqli_fetch_array($result);
                    $_SESSION['LoginStudent']=$res['code'];
                    header('Location: ../student/student-index.php');
                }
            }
        }
        else
        { 
           
        //header("Location: login.php");
        $message="Email Or Password Does Not Match";
        }
    }
?>

<!doctype html>
<html lang="fr">
	<head>
		<title>Login - FSR</title>
        
	</head>
	<body class="login-background">
        
		<?php  include('../common/common-header.php') ?>
        <div class="login-div mt-3 rounded">
            <div class="logo-div text-center">
                <img src="../Images/logo.jpeg" alt="" class="align-items-center" width="100" height="100">
            </div>
            <div class="login-padding">
                <h2 class="text-center text-white">LOGIN</h2>
                <form class="p-1" action="login.php" method="POST">
                    <div class="form-group">
                        <label><h6>Entrez ID/Email:</h6></label>
                        <input type="text" name="email" placeholder="Entrez votre email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><h6>Entrez le Mot de Passe:</h6></label>
                        <input type="Password" name="password" placeholder="Entrez le Mot de Passe" class="form-control border-bottom" required>
                         <?php echo $message; ?> 
                    </div>
                    <div class="form-group text-center mb-3 mt-4">
                        <input type="submit" name="btnlogin" value="LOGIN" class="btn btn-white pl-5 pr-5 ">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>



