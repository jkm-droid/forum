<?php

namespace App\Constants;

class AppConstants
{
    public static $special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
    public static $events = array(
        'admin_email' => 'ADMIN_EMAIL',
        'member_email' => 'MEMBER_EMAIL',
        'systems_logs'=>'SYSTEM_LOGS',
        'new_message'=>'NEW_MESSAGE'
    );
}
