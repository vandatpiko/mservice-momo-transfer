<?php
namespace VandatPiko\Mservice\Contracts;

interface CryptRsaContract
{
    /**
     * @param string $key
     * @param string $message
     *
     */
    public static function encrypt(string $publicKey, string $message);

}
