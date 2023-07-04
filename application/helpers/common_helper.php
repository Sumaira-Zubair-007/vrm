<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('sendMail'))
{

	// MAIL FUNCTION
	function sendMail($subject , $message , $email , $attachment = NULL, $cc = NULL)
	{
		$ci = & get_instance();
		$config = Array(
            'protocol' => 'ssmtp',
            'smtp_host' => 'ssl://ssmtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'fersen@newgents.com',
            'smtp_pass' => 'jhsqngwvzyaxbeet',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        	
        
        $ci->email->from('fersen@newgents.com', 'Admin');
        $ci->email->to($email); 
        $ci->email->subject($subject);
        $ci->email->message($message);
        
        // cc 
        if(!empty($cc))
        	$ci->email->cc($cc);



        // in case of attachment
    	if($attachment != NULL)
    		$ci->email->attach($attachment);
    
    	if($ci->email->send())
    		return true;
    	else
    		return false;

	}   

}


// language
if(!function_exists('lang')){
	function lang($key = ""){
		$CI = &get_instance();
		$lang_text = $CI->lang->line($key);
		if($lang_text != ""){
			return $lang_text;
		}else{
			return ucfirst(str_replace("_", " ", $key));
		}
	}
}


// helper
if(!function_exists('config')){
	function config($key = ""){
		$CI = &get_instance();
		// load the configuration file
		$CI->config->load('plaid');

		// return the value.
		return $CI->config->item($key);
	}
}


