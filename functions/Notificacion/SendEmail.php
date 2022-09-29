<?PHP

   //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$Data = (isset($_POST['Data'])) ? $_POST['Data'] : "";
$DatosMail = explode(')',$Data);
$SendTo = $DatosMail[0];
$mail = new PHPMailer(true);

try {
    //Server settings                    
    $mail->isSMTP();                                            
    $mail->From = "jabessamailcenter@gmail.com";
    $mail->SMTPAuth   = true;                                   
    $mail->SMTPSecure = "tls";
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->Port       = 587;
    $mail->Username   = 'jabessamailcenter@gmail.com';                     
    $mail->Password   = '12JSAMC34';                              
    
    //Recipients
    $mail->setFrom('jabessamailcenter@gmail.com', 'System');
    $mail->addAddress($SendTo);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $DatosMail[1];
    $mail->Body    = $DatosMail[2];
    $mail->AltBody = str_replace('<br>',' ',$DatosMail[2]);

    $mail->send();
    echo 'Correo Enviado.';
} catch (Exception $e) {
    echo "El Correo no se pudo Enviar. Error: {$mail->ErrorInfo}";
}

?>