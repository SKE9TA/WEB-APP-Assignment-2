<?php

require_once '../configs/connection.php';

session_start();

// PHP Mailer Imports for Email Function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Register, Update, Delete User
if (isset($_POST['regu']) || isset($_POST['upu']) || ($_REQUEST['action'] == 'deleteU' && !empty($_REQUEST['id']))) {
    if (isset($_POST['regu'])) {
        // Register User logic
        $fname = $_POST['fname'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $passwordconfirm = $_POST['cpassword'];

        $filename = $_FILES['image']['name'];

        $valid_extensions = array("jpg", "jpeg", "png");

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $valid_extensions)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $filename);

            if ($password == $passwordconfirm) {
                $sql = "INSERT INTO `users`(`Full_Name`, `User_Name`, `phone_Number`, `email`, `Gender`, `Password`, `UserType`, `Address`, `profile_Image`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $hashedPassword = md5($password);
                $stmt->execute([$fname, $uname, $phone, $email, $gender, $hashedPassword, $type, $address, $filename]);
            } else {
                echo "Passwords do not match.";
            }
        } else {
            echo "There is an error with saving the images, kindly check the image format.";
        }
    } elseif (isset($_POST['upu'])) {
        // Update User logic
        $uid = $_POST['uid'];
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordconfirm = $_POST['cpassword'];
                $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $mod = $_POST['mod'];

        $filename = $_FILES['image']['name'];

        $valid_extensions = array("jpg", "jpeg", "png");

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $valid_extensions)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $filename);

            if ($password == $passwordconfirm) {
                $sql = "UPDATE `users` SET `Full_Name`=?, `phone_Number`=?, `email`=?, `Gender`=?, `Password`=?, `Address`=?, `profile_Image`=? WHERE `userId`=?";
                $stmt = $conn->prepare($sql);
                $hashedPassword = md5($password);
                $stmt->execute([$fname, $phone, $email, $gender, $hashedPassword, $address, $filename, $uid]);
            } else {
                echo "Passwords do not match.";
            }
        } else {
            echo "There is an error with saving the images, kindly check the image format.";
        }
    } elseif ($_REQUEST['action'] == 'deleteU' && !empty($_REQUEST['id'])) {
        // Delete User logic
        $deleteItem = $_REQUEST['id'];
        $sql = "DELETE FROM `users` WHERE `userId` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$deleteItem]);
        $sql1 = "DELETE FROM `articles` WHERE `authorId` = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$deleteItem]);
    }

    // Redirect logic
    if (isset($_SESSION['supname'])) {
        header("Location: ../super_user.php");
    } elseif (isset($_SESSION['adminame'])) {
        header("Location: ../administrator.php");
    }elseif (isset($_SESSION['authname']) && isset($_SESSION['authname1']) && isset($_SESSION['authname2'])) {
        header("Location: ../author.php");
    }
}

// Add, Update, Delete Article
if (isset($_POST["addarticle"]) || isset($_POST["updatearticle"]) || ($_REQUEST['action'] == 'deleteA' && !empty($_REQUEST['id']))) {
    if (isset($_POST["addarticle"])) {
        // Add Article logic
        $aid = $_SESSION['authname'];
        $atitle = $_POST['atitle'];
        $aftext = $_POST['aftext'];
        $aorder = $_POST['aorder'];
        $adisplay = $_POST['adisplay'];

            $sql = "INSERT INTO `articles`(`authorId`, `article_title`, `article_full_text`, `article_display`, `article_order`) VALUES (?, ?, ?, ?, ?)";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([$aid, $atitle, $aftext, $adisplay, $aorder]);
    echo "Record inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
var_dump($stmt);
            $d = date('Y-m-d');
            
 $mail = new PHPMailer(true);

             $mail->isSMTP();
             $mail->Host = 'smtp.gmail.com';
             $mail->SMTPAuth = 'true';
             $mail->Username = 'giftshasa01@gmail.com'; //Your Gmail
             $mail->Password = 'jeoo zdcw oucc mxld'; //Your Gmail App Password
             $mail->SMTPSecure = 'ssl';
             $mail->Port = 465;

             $mail->setFrom($_SESSION['authname1']); //Your Gmail
             $mail->addAddress('giftshasa01@gmail.com'); //Sender Address
             $mail->isHTML(true);
             $mail->Subject = 'Notification of Published Article!';
             $mail->Body = 'Dear Esteemed Administrator Jabari,

I hope this message finds you in good health and high spirits. I am pleased to notify you that a new article has been successfully published on your prestigious article management web platform. The particulars of the published article are as follows:

Title - ' . $atitle . '
Author - ' . $_SESSION['authname2'] . '
Date of Publication - ' . $d . '

We firmly believe that this contribution significantly enhances the value of the platform and aligns seamlessly with the established standards. The author has diligently adhered to all submission guidelines, and the article has undergone a rigorous review process.

Your unwavering commitment to upholding content quality on the platform is commendable, and we are confident that this article will further elevate the reputation of the platform. Should any additional actions be necessary from our end or if you require further information, please feel free to reach out.

We sincerely appreciate your attention to this matter and eagerly anticipate the prospect of ongoing collaboration with the platform.

Best regards,
' . $_SESSION['authname2'] . ' .';

             $mail->send();

            header("Location: ../author.php?addarticle=success");

    } elseif (isset($_POST["updatearticle"])) {
        // Update Article logic
        $aid = $_POST['aid'];
        $atitle = $_POST['atitle'];
        $aftext = $_POST['aftext'];
        $aorder = $_POST['aorder'];
        $adisplay = $_POST['adisplay'];

            $sql = "UPDATE `articles` SET `article_title`=?, `article_full_text`=?, `article_display`=?, `article_order`=?, `article_last_update`=NOW() WHERE `article_id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$atitle, $aftext, $adisplay, $aorder, $aid]);

            header("Location: ../author.php?addarticle=success");

    } elseif ($_REQUEST['action'] == 'deleteA' && !empty($_REQUEST['id'])) {
        // Delete Article logic
        $deleteItem = $_REQUEST['id'];
        $sql = "DELETE FROM `articles` WHERE `article_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$deleteItem]);

        header("Location: ../author.php?deletearticle=success");
    }
}

// Print An Article
if ($_REQUEST['action'] == 'printA' && !empty($_REQUEST['id'])) {
    $selectItem = $_REQUEST['id'];
    $sql = "SELECT * FROM `articles` WHERE `article_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$selectItem]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $author = $_SESSION['authname2'];

    echo "<html>
            <head>
                <title>Articles Web Platform - Print Article</title>
            </head>
            <style type='text/css'>
                table{
                    align-items: center;
                }
                th, tr, td{
                    padding: 10px 10px;
                }
            </style>
            <script type='text/javascript'>
                function printData() {
                    var divToPrint=document.getElementById('article');
                    newWin= window.open('');
                    newWin.document.write(divToPrint.outerHTML);
                    newWin.print();
                    newWin.close();
                }

function redirectToPreviousPage() {
    // Use history to go back to the previous page
    window.history.back();
}

            </script>
            <script src='https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js'></script>

            <script> 
                window.onload = function() {
                    printData();
                    redirectToPreviousPage();
                }
            </script>
            <body id='article'>
                <div>
                    <h1>Title: " . $data['article_title']  ." by " . $author  .".</h1>
                </div>
                <br>
                <div>
                    <label>Display: " . $data['article_display']  ."</label>
                </div>
                <br>
                <div>
                    <p>Article Text: " . $data['article_full_text']  .".</p>
                    <br>
                    <p>Article Order: " . $data['article_order']  .".</p>
                    <br>
                    <p>Article Created At: " . $data['article_created_date']  .".</p>
                    <br>
                    <p>Article Last Updated At: " . $data['article_last_update']  .".</p>
                </div>
            </body>
          </html>";
}

?>