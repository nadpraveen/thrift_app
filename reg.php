<?php
ob_start();
include 'header.php';
//session_start();
?>

<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="mainbar">
                <div class="article">
                    <div class="panel-heading">
                        <h3 class="panel-title"> New User Registration </h3>
                    </div>

                    <div id="edata">
                        <form id="reg" method="POST" style=" margin: auto; width: 35%;">
                            <strong>Enter Your Employee Number</strong> <br> <input type="text" name="emp_no"> <input type="submit" name="btn_get_data" value="Genarate Password">
                        </form>
                        <hr>
                        <div>
                            <?php

                            use PHPMailer\PHPMailer\PHPMailer;
                            use PHPMailer\PHPMailer\Exception;

                            if (isset($_POST['btn_get_data'])) {
                                $e_no = trim($_POST['emp_no']);
                                
                                if (substr($_POST['emp_no'], 0, 1) == 2) {
                                    echo "<script>alert('You are not a employee');</script>";
                                    header("Location:index.php");
                                } else {
                                    $cheak_member_status = new Database;
                                    $q = "select * from th_member_master where EMP_NO='$e_no'";
                                    $cheak_member_status->query($q);

                                    $count = $cheak_member_status->count();
                                    if ($count > 0) {
                                        $row = $cheak_member_status->resultset();
                                        foreach ($row as $row) {
                                            $emp_no = $row['EMP_NO'];
                                            $name = $row['EMP_NAME'];
                                            $dep = $row['DEPT'];
                                            $phone = $row['PH_NO_R'];
                                            $email = $row['EMAIL_ID'];
                                        }

                                        $cheak_exsisting_pass = new Database;

                                        if ($email == NULL && $phone == NULL) {
                                            echo "<script>alert('Please update your email id or mobile number at Sociey office');</script>";
                                            header("refresh:0;url=index.php");
                                        } else {

                                            function randStrGen() {
                                                $result = "";
                                                $chars = "0123456789";
                                                $charArray = str_split($chars);
                                                for ($i = 0; $i < 4; $i++) {
                                                    $randItem = array_rand($charArray);
                                                    $result .="" . $charArray[$randItem];
                                                }
                                                return $result;
                                            }

                                            $password = randStrGen();
                                            $randstr = md5($password);
                                            $cheak_exsisting_pass->query("select * from pass_word where EMP_NO = $emp_no");
                                            $pass_count = $cheak_exsisting_pass->count();
                                            if ($pass_count == 0) {
                                                $insert_password = new Database;
                                                $query = "insert into pass_word values($emp_no,'$randstr',0)";
                                                $insert_password->query($query);

                                                $message = "Dear Member your website login password is $password . Vsp Thrift Society";



                                                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                                try {
                                                    //Server settings
                                                    //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
                                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                                    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                                    $mail->Username = 'vspthriftsociety@gmail.com';       // SMTP username
                                                    $mail->Password = 'Thrift@86';                        // SMTP password
                                                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                                    $mail->Port = 587;                                    // TCP port to connect to
                                                    //Recipients
                                                    $mail->setFrom('vspthriftsociety@gmail.com', 'VSP Thrift Society');
                                                    $mail->addAddress($email, $name);     // Add a recipient
                                                    //Content
                                                    $mail->isHTML(true);                                  // Set email format to HTML
                                                    $mail->Subject = 'Your password for login';
                                                    $mail->Body = $message;
                                                    $mail->AltBody = $message;

                                                    $mail->send();
                                                    //echo 'Message has been sent';
                                                } catch (Exception $e) {
                                                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                                                }
                                                $message = urlencode($message);
                                                $url = "http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=vspthriftsociety&password=Thrift@1918&msisdn=$phone&sid=THRIFT&msg=$message&fl=0&gwid=2";

                                                file_get_contents($url);
                                                //file_get_contents("http://login.smsgatewayhub.com/smsapi/pushsms.aspx?user=abc&pwd=$password&to=919898123456&sid=senderid&msg=test%20message&fl=0");
                                                //die();
                                                //mail($email, 'Your password for login', $message);
                                                echo "<script>alert('password genarated successefully. You can cheak your email for the password');</script>";
                                                header("refresh:0;url=index.php");
                                            } else {
                                                echo "<script>alert('You have alredy genrated the password in case you forgot the password use forgot password link in login form');</script>";
                                                header("refresh:0;url=index.php");
                                            }
                                        }
                                    } else {
                                        echo "<script>alert('You are not a member');</script>";
                                        header("refresh:0;url=index.php");
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>