<?php
if(isset($_POST['submit_email']) && $_POST['email'])
{
    mysqli_connect('localhost','root','');
    mysqli_select_db('sample');
    $select=mysqli_query("select email,password from user where email='$email'");
    if(mysqli_num_rows($select)==1)
    {
        while($row=mysqli_fetch_array($select))
        {
            $email=password_hash($row['email']);
            $pass=password_hash($row['password']);
        }
        $link="<a href='www.yilisa.com/reset.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
        require_once('phpmail/PHPMailerAutoload.php');
        $mail = new PHPMailer();
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "PHPMailer::ENCRYPTION_SMTPS";
        $mail->Port = 2525;
        $mail->mailer = "smtp";
        $mail->Username = '73bc2a1c40a76e';
        $mail->Password = 'ed73412715647f';

        // Recipient settings
        $mail->SetFrom('test_email_ignore@gmail.com', 'Ignore This Email');
        $mail->addAddress('falseemailshouldntreceivedit@gmail.com', 'NO');
        //$mail->addReplyTo('ADD-REPLY-TO-EMAIL', 'ADD-REPLY-TO-NAME');

        // Content settings
        $mail->IsHTML(true);
        // Title of the email (Subject)
        $mail->Subject = "Ignore";
        // Body of the mail
        $mail->Body = 'Test email for testing purposes, if you got this email then something went wrong. Please email this address to help us improve our site.';

        $mail->send();
    }
}
?>