<?php

if(!function_exists('user_details')) {  
    function user_details($user_id) {
        $userModel = new App\Models\UserModel();
        $data = $userModel->forProfile($user_id);
        return $data;
    }
}