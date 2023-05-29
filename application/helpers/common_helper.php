<?php 
 function token_get(){
    $tokenData = array();
    $tokenData['id'] = mt_rand(10000,99999); //TODO: Replace with data for token
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    return $output['token'];
}
function get_session_name($user_type='')
    {
		switch ($user_type) {
		    case "superadmin":
		       	return "feenixx_hospital_superadmin_logged_in";
		        break;
		    case "doctor":
		       	return "feenixx_hospital_doctor_logged_in";
		        break;
		    case "receptionists":
		       	return "feenixx_hospital_receptionists_logged_in";
		        break;
		    default:
		        return "feenixx_hospital_receptionists_logged_in";
		}
    }
	function get_allowed_file_type(){
        $allowed_file_type = 'jpg|jpeg|jpe|gif|webp|bmp|gd2|png|doc|docx|pdf';
         return $allowed_file_type;
    }