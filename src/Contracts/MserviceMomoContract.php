<?php
interface MserivceMomoContract
{
    /**
     * @var string
     */
    public function loginAuth($password);
    /**
     * @var string
     */
    public function requestOTP();
    /**
     * @var string
     */
    public function verifyOTP(string $otp);
}
