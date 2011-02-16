<?php

class Encryption {

    public function encrypt($string, $key) {
        return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))), "\0");
    }

    public function decrypt($hash, $key) {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($hash), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)), "\0");
    }
}
