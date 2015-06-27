<?php

class Hash {
    private function __construct() {}

    public function createHash($password) {
        $options = [
            'cost' => 15,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];

       return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}

?>