<?php

class Generate {

    public function formkey() {
        return $this->alphanumeric(128);
    }

    public function ascii($length) {
        $printable = "!#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_abcdefghijklmnopqrstuvwxyz{|}~";
        return $this->custom(str_split($printable), $length);
    }

    public function alphanumeric($length) {
        $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        return $this->custom(str_split($alphanum), $length);
    }

    public function alpha($length) {
        $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        return $this->custom(str_split($alphanum), $length);
    }

    public function numeric($length) {
        $alphanum = "0123456789";
        return $this->custom(str_split($alphanum), $length);
    }

    public function hex($length) {
        $hex = "0123456789ABCDEF";
        return $this->custom(str_split($hex), $length);
    }

    public function custom($characterSet, $length) {
        if($length < 1 || !is_array($characterSet)) {
            return false;
        }
        $charSetLen = count($characterSet);
        if($charSetLen == 0) {
            return false;
        }
        $random = self::getRandomInts($length * 2);
        $mask = self::getMinimalBitMask($charSetLen - 1);
        $password = "";
        $iterLimit = max($length, $length * 64);
        $randIdx = 0;
        while(strlen($password) < $length) {
            if($randIdx >= count($random)) {
                $random = self::getRandomInts(2*($length - count($password)));
                $randIdx = 0;
            }
            $c = $random[$randIdx++] & $mask;
            if($c < $charSetLen) {
                $password .= $characterSet[$c];
            }
            $iterLimit--;
            if($iterLimit <= 0) {
                return false;
            }
        }
        return $password;
    }

    private static function getMinimalBitMask($toRepresent) {
        if($toRepresent < 1){
            return false;
        }
        $mask = 0x1;
        while($mask < $toRepresent){
            $mask = ($mask << 1) | 1;
        }
        return $mask;
    }

    private static function getRandomInts($numInts) {
        $rawBinary = mcrypt_create_iv($numInts * PHP_INT_SIZE, MCRYPT_DEV_URANDOM);
        $ints = array();
        for($i = 0; $i < $numInts; $i+=PHP_INT_SIZE) {
            $thisInt = 0;
            for($j = 0; $j < PHP_INT_SIZE; $j++) {
                $thisInt = ($thisInt << 8) | (ord($rawBinary[$i+$j]) & 0xFF);
            }
            $thisInt = $thisInt & PHP_INT_MAX;
            $ints[] = $thisInt;
        }
        return $ints;
    }

}
