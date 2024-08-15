<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 从环境变量中获取鉴权密钥
$authKey = getenv('AUTH_KEY');

// 检查请求中是否包含正确的鉴权密钥
if (!isset($_SERVER['HTTP_X_AUTH_KEY']) || $_SERVER['HTTP_X_AUTH_KEY'] !== $authKey) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Unauthorized';
    exit;
}

// 获取 POST 请求中的 JSON 数据
$data = json_decode(file_get_contents('php://input'), true);

$smtpHost = $data['smtpHost'] ?? '';
$smtpPort = $data['smtpPort'] ?? 587;
$smtpUser = $data['smtpUser'] ?? '';
$smtpPass = $data['smtpPass'] ?? '';
$fromEmail = $data['fromEmail'] ?? $smtpUser;
$toEmail = $data['toEmail'] ?? '';
$content = $data['content'] ?? '';
$subject = $data['subject'] ?? '默认邮件标题';

// 创建 PHPMailer 实例
$mail = new PHPMailer(true);

try {
    // 配置 SMTP
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    // 设置发件人
    $mail->setFrom($fromEmail);
    // 设置收件人
    $mail->addAddress($toEmail);
    // 设置邮件主题
    $mail->Subject = $subject;
    // 设置邮件正文
    $mail->Body    = $content;

    // 发送邮件
    $mail->send();
    echo '邮件发送成功';
} catch (Exception $e) {
    echo "邮件发送失败: {$mail->ErrorInfo}";
}
?>