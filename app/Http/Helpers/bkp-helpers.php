<?php
use App\Etemplate;
use App\GeneralSettings;
use App\Advertisment;

if (! function_exists('send_email')) {

    function send_email( $to, $name, $subject, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        $template = $temp->emessage;
        $from = $temp->esender;
		if($gnl->email_notification == 1)
		{
			$headers = "From: $gnl->title <$from> \r\n";
			$headers .= "Reply-To: $gnl->title <$from> \r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$mm = str_replace("{{name}}",$name,$template);
			$message = str_replace("{{message}}",$message,$mm);

			if (@mail($to, $subject, $message, $headers)) {
			  // echo 'Your message has been sent.';
			} else {
			 //echo 'There was a problem sending the email.';
			}
		}
    }
}


if (! function_exists('send_sms'))
{

    function send_sms( $to, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        if($gnl->sms_notification == 1)
        {
            $sendtext = urlencode($message);
            $appi = $temp->smsapi;
            $appi = str_replace("{{number}}",$to,$appi);
            $appi = str_replace("{{message}}",$sendtext,$appi);
            $result = file_get_contents($appi);
        }
    }
}


if (! function_exists('notify'))
{
    function notify( $user, $subject, $message)
    {
        send_email($user->email, $user->name, $subject, $message);
        send_sms($user->mobile, strip_tags($message));
    }
}

function show_add($size)
{
   $adds = Advertisment::where('size', $size)->inRandomOrder()->first();

    if($adds)
    {
        return view('partials.adds',compact('adds'));
    }
}



if (!function_exists('send_email_verification')) {
    function send_email_verification($to, $name, $subject, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        $template = $temp->emessage;
        $from = $temp->esender;

        $headers = "From: $gnl->title <$from> \r\n";
        $headers .= "Reply-To: $gnl->title <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mm = str_replace("{{name}}", $name, $template);
        $message = str_replace("{{message}}", $message, $mm);

        if (@mail($to, $subject, $message, $headers)) {
            // echo 'Your message has been sent.';
        } else {
            //echo 'There was a problem sending the email.';
        }
    }
}


if (!function_exists('send_sms_verification')) {

    function send_sms_verification($to, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        if ($gnl->sms_verification == 1) {
            $sendtext = urlencode($message);
            $appi = $temp->smsapi;
            $appi = str_replace("{{number}}", $to, $appi);
            $appi = str_replace("{{message}}", $sendtext, $appi);
            $result = file_get_contents($appi);
        }
    }
}