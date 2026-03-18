<?php
namespace App\Http\Controllers;
use App\Models\Newsletter;

abstract class Controller{

    public function newsletter($email = NULL){
		if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = strtolower(trim($email));
			$emailExist = Newsletter::where('email',$email)->count();
            if($emailExist == 0){
				$newsletter = new Newsletter();
                $newsletter->email = $email;
				$newsletter->save();
            }			
		}
		return "success";	
	}

	public function generateUniqueId(){
		$random = mt_rand(111,999).mt_rand(11,99).mt_rand(111,999);
		return str_shuffle($random);
	}
	
	/*Generate Randam Password*/
	public function __randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for($i = 0; $i < 9; $i++){
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
	#encryptData
    public function encryptData($value = NULL){
        if(!empty($value)){
            $value = trim(preg_replace('/\s+/', ' ', $value));
            date_default_timezone_set('UTC');
            $encryptionMethod = "AES-256-CBC";
            $secret = "MYSECURITYSS12020PKSEncryption19";  //must be 32 char length
            $iv = substr($secret, 0, 16);
            $encryptedText = openssl_encrypt($value, $encryptionMethod, $secret,0,$iv);
            $result = "";
            if($encryptedText != ""){
                $result = trim($encryptedText);
            }
            return $result;
        }else{
            return $value;
        }
    }

    #decryptData
    public function decryptData($value = NULL){
        if(!empty($value)){
            date_default_timezone_set('UTC');
            $encryptionMethod = "AES-256-CBC";
            $secret = "MYSECURITYSS12020PKSEncryption19";  //must be 32 char length
            $iv = substr($secret, 0, 16);
            $decryptedText = openssl_decrypt($value, $encryptionMethod, $secret,0,$iv);
            $result = "";
            if($decryptedText != ""){
                $result = trim($decryptedText);
            }
            return $result;
        }else{
            return $value;
        }
    }
	
}