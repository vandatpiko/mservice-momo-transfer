<?php
namespace VandatPiko\Mservice\Contracts;

interface MserviceMomoContract
{
    /**
     * @var string
     */
    public function loginAuth(string $password);
    /**
     * @var string
     */
    public function requestOTP();
    /**
     * @var string
     */
    public function verifyOTP(string $otp);

    /**
     * @var string
     */
    public function setMserviceMomo($userId);
}
