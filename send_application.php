<?php
$to = "menasamo2010@gmail.com"; // عدّل ده لإيميلك الحقيقي
$subject = "New Application from Website";

$message = "New model application received:\n\n";
$message .= "First Name: " . $_POST['first_name'] . "\n";
$message .= "Gender: " . $_POST['gender'] . "\n";
$message .= "Country: " . $_POST['country'] . "\n";
$message .= "Phone: " . $_POST['phone'] . "\n";
$message .= "Email: " . $_POST['email'] . "\n";
$message .= "Birthday: " . $_POST['birthday'] . "\n";
$message .= "Height: " . $_POST['height'] . " cm\n";
$message .= "Waist: " . $_POST['waist'] . " cm\n";
$message .= "Bust: " . $_POST['bust'] . " cm\n";
$message .= "Hip: " . $_POST['hip'] . " cm\n";
$message .= "Eye Color: " . $_POST['eye_color'] . "\n";
$message .= "Hair Color: " . $_POST['hair_color'] . "\n";
$message .= "Tattoos: " . $_POST['tattoo'] . "\n";
$message .= "Piercings: " . $_POST['piercings'] . "\n";
$message .= "Instagram: " . $_POST['instagram'] . "\n";
$message .= "Notes: " . $_POST['notes'] . "\n";

// معالجة الصور ورفعها
$attachments = [];
foreach ($_FILES as $key => $file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $attachments[] = [
            'name' => $file['name'],
            'content' => chunk_split(base64_encode(file_get_contents($file['tmp_name']))),
            'type' => $file['type']
        ];
    }
}

// إعداد رأس الرسالة
$boundary = md5(uniqid(time()));
$headers = "From: Website <noreply@yourdomain.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";

// بناء الرسالة بالجسم
$body = "--$boundary\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message . "\r\n";

foreach ($attachments as $attach) {
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: " . $attach['type'] . "; name=\"" . $attach['name'] . "\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"" . $attach['name'] . "\"\r\n\r\n";
    $body .= $attach['content'] . "\r\n";
}

$body .= "--$boundary--";

// الإرسال
$mail_sent = mail($to, $subject, $body, $headers);
if ($mail_sent) {
    echo "تم الإرسال بنجاح!";
} else {
    echo "فشل في إرسال الطلب.";
}
?>
