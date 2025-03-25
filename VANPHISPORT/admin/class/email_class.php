<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../vendor/autoload.php';  // Đảm bảo đường dẫn đúng đến autoload.php

class Email {
    public function send_email($to, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Đổi thành SMTP của bạn
            $mail->SMTPAuth   = true;
            $mail->Username   = 'vanphi101220033@gmail.com'; // Thay bằng email của bạn
            $mail->Password   = 'dqoo wybv gbsw ehzo'; // Thay bằng mật khẩu email hoặc App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Cấu hình người gửi & nhận
            $mail->setFrom('vanphi101220033@gmail.com', 'VĂN PHI SPORT');
            $mail->addAddress($to);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
