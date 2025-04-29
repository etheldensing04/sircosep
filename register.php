
<?php
require 'vendor/autoload.php'; // Load PHPMailer
require 'dbconnection.php'; // Include your database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: application/json"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $school = $_POST['school'];
    $email = $_POST['email'];
    $school_address = $_POST['school_address'];
    $contact = $_POST['contact'];
    $coordinator = $_POST['coordinator'];
    $organization = $_POST['organization'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verification_code = bin2hex(random_bytes(16)); 

    // Handle profile image upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_name = basename($_FILES['profile_image']['name']);
        $image_path = "uploads/" . $image_name;
        move_uploaded_file($image_tmp_name, $image_path);
        $profile_image = $image_path;
    }

    // Insert user into the database
    $stmt = $pdo->prepare("INSERT INTO students (student_name, school, email, school_address, contact, coordinator, profile_image, organization, password, verification_code, is_verified) 
    VALUES (:student_name, :school, :email, :school_address, :contact, :coordinator, :profile_image, :organization, :password, :verification_code, 0)");

    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':school', $school);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':school_address', $school_address);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':coordinator', $coordinator);
    $stmt->bindParam(':profile_image', $profile_image);
    $stmt->bindParam(':organization', $organization);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':verification_code', $verification_code);

    if ($stmt->execute()) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tulodemarie@gmail.com'; // Replace with your email
            $mail->Password = 'hghv auyv nnki vxze'; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('tulodemarie@gmail.com', 'Admin');
            $mail->addAddress($email); 

            $mail->isHTML(true);
            $mail->Subject = 'Account Verification';
            $mail->Body = 'Click the link to verify your account: 
                <a href="http://localhost/Semi-Final/verify.php?code=' . $verification_code . '">Verify Account</a>';
                

            $mail->send();
            
            echo json_encode(["success" => true, "message" => "Registration successful! Please check your email to verify your account."]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error: Could not register user."]);
    }
}
?>
