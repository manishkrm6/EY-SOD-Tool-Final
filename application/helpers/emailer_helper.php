 <?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 require_once(APPPATH.'third_party/mail/class.phpmailer.php');

 function send_mail($recipients, $subject, $message,$cc_recipients='', $from=''){

 	$mail = new PHPMailer();
	
	//return true;

 	$mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;
    $mail->SMTPAuth = true;                   // set the SMTP port for the GMAIL server
    $mail->Username   = 'ivsdevmail@gmail.com';  // GMAIL username
    $mail->Password   = 'ivsdevmail@1231#';            // GMAIL password
    //$mail->SMTPSecure = 'tls';
    $mail->SetFrom("ivsdevmail@gmail.com","EY SOD Tool");
    $mail->AddReplyTo("ivsdevmail@gmail.com","Reply : ");
    
    $mail->Subject    = $subject;
    //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";// optional, comment out and test
    $mail->MsgHTML($message);
	
	$type = gettype($recipients);
	
	switch ($type) {
    	
    	case 'string':
    	if($recipients != ''){
    		if(isValidEmail($recipients)){
    			$mail->AddAddress($recipients);	
    		}
    	}
		break;
		
		case 'array':
		if(!empty($recipients)){
			foreach ($recipients as $recipient) {
				if(isValidEmail($recipient)){
					$mail->AddAddress($recipient);		
				}
			}
		}
		break;

		default:
			return false;
	}

		$type = gettype($cc_recipients); 

		//pr($cc_recipients); die;

    	switch ($type) {
    		case 'string':
    			if(isValidEmail($cc_recipients)){
    				$mail->AddCC($cc_recipients);	
    			}
    			break;
    		case 'array':
    			if(!empty($cc_recipients)){
    				foreach ($cc_recipients as $cc) {
    					
    					if(isValidEmail($cc)){
    						
    						$mail->AddCC($cc);
    					}	
    				}
    			}
    			break;
    		default:
    			return false;

    	}
    	

    try{
			//var_dump($mail->Send()); die;
			
			if(!$mail->Send()) {
				//echo $arr['msg123']=$mail->ErrorInfo;
				return false;
			}
			else
			{
				//$arr['msg123']="Message sent!";
				return true;
			}
	}catch(Exception $e) {
		
		//echo 'Message: ' .$e->getMessage();
		//die;
	}

	return false;

 }

 
 
 