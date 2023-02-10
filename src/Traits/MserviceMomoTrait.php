<?php
namespace VandatPiko\Mservice\Traits;

use VandatPiko\Mservice\Contracts\OpenSSLContract;

trait MserviceMomoTrait
{

    /**
     * @param $method
     * @param $arguments
     */
    private function SEND_OTP_MSG()
    {
        try {
            $microtime = getMicrotime();
            $res =  $this->clientHttpRequest->request('POST', 'https://api.momo.vn/backend/otp-app/public/', [
                'json'  => array(
                    'user'    => $this->mserviceMomo->username,
                    'msgType' => 'SEND_OTP_MSG',
                    'cmdId'   => (string) $microtime . '000000',
                    'lang'    => 'vi',
                    'time'    => (int) $microtime,
                    'channel' => 'APP',
                    'appVer'  => $this->configure['app_version'],
                    'appCode' => $this->configure['app_code'],
                    'deviceOS'=> $this->configure['details']['device_os'],
                    'buildNumber' => 0,
                    'appId'   => 'vn.momo.platform',
                    'result'  => true,
                    'errorCode' => 0,
                    'errorDesc' => '',
                    'momoMsg' => array(
                        '_class'    => 'mservice.backend.entity.msg.RegDeviceMsg',
                        'number'    => $this->mserviceMomo->username,
                        'imei'      => $this->mserviceMomo->imei,
                        'cname'     => $this->configure['details']['cnname'],
                        'ccode'     => $this->configure['details']['ccode'],
                        'device'    => $this->configure['device'],
                        'firmware'  => $this->configure['details']['firmware'],
                        'hardware'  => $this->configure['hardware'],
                        'manufacture' => $this->configure['facture'],
                        'csp'       => $this->configure['details']['csp'],
                        'icc'       => '',
                        'mcc'       => $this->configure['details']['mcc'],
                        'device_os' => $this->configure['details']['device_os'],
                        'secure_id' => $this->mserviceMomo->secure_id
                    ),
                    'extra' => array(
                        'action'        => 'SEND',
                        'rkey'          => $this->mserviceMomo->rkey,
                        'IDFA'          => '',
                        'TOKEN'         => $this->mserviceMomo->token,
                        'ONESIGNAL_TOKEN'   => $this->mserviceMomo->token,
                        'SIMULATOR'     => false,
                        'SECUREID'      => $this->mserviceMomo->secure_id,
                        'MODELID'       => $this->mserviceMomo->model_id,
                        'DEVICE_TOKEN'  => strtoupper(hash('sha256', $this->mserviceMomo->MODELID)),
                        'isVoice'       => true,
                        'REQUIRE_HASH_STRING_OTP' => true,                    ),
                ),
                'headers' => array(
                    'Host'          => 'api.momo.vn',
                    'agent_id'      => 'undefined',
                    'user_phone'    => '',
                    'sessionkey'    => '',
                    'authorization' => 'Bearer undefined',
                    'userid'        => '',
                    'msgtype'       => 'SEND_OTP_MSG'
                )
            ]);
            return json_decode($res->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $e){}
        return false;
    }

    private function CHECK_USER_BE_MSG()
    {
        try {
            $microtime = getMicrotime();
            $res    = $this->clientHttpRequest->request('POST', 'https://api.momo.vn/backend/auth-app/public/CHECK_USER_BE_MSG', [
                'json'  =>  array(
                    'user'    => $this->mserviceMomo->username,
                    'msgType' => 'CHECK_USER_BE_MSG',
                    'cmdId'   => (string) $microtime . '000000',
                    'lang'    => 'vi',
                    'time'    => (int) $microtime,
                    'channel' => 'APP',
                    'appVer'  => $this->configure['app_version'],
                    'appCode' => $this->configure['app_code'],
                    'deviceOS' => 'ANDROID',
                    'buildNumber' => 0,
                    'appId'   => 'vn.momo.platform',
                    'result'  => true,
                    'errorCode' => 0,
                    'errorDesc' => '',
                    'momoMsg' => array(
                        '_class'    => 'mservice.backend.entity.msg.RegDeviceMsg',
                        'number'    => $this->mserviceMomo->username,
                        'imei'      => $this->mserviceMomo->imei,
                        'cname'     => $this->configure['details']['cnname'],
                        'ccode'     => $this->configure['details']['ccode'],
                        'device'    => $this->configure['device'],
                        'firmware'  => $this->configure['details']['firmware'],
                        'hardware'  => $this->configure['hardware'],
                        'manufacture' => $this->configure['facture'],
                        'csp'       => $this->configure['details']['csp'],
                        'icc'       => '',
                        'mcc'       => $this->configure['details']['mcc'],
                        'device_os' => $this->configure['details']['device_os'],
                        'secure_id' => $this->mserviceMomo->secure_id
                    ),
                    'extra' => array(
                        'checkSum' => '',
                    ),
                ),
                'headers' => array(
                    'Host'          => 'api.momo.vn',
                    'agent_id'      => 'undefined',
                    'user_phone'    => '',
                    'sessionkey'    => '',
                    'authorization' => 'Bearer undefined',
                    'userid'        => '',
                    'msgtype'       => 'CHECK_USER_BE_MSG'
                )
            ]);
            return json_decode($res->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
        }
        return false;
    }

    /**
     * @param
     */
    private function RE_LOGIN()
    {
        try {
            $microtime = getMicrotime();
            $res    = $this->clientHttpRequest->request('POST', 'https://api.momo.vn/backend/auth-app/public/CHECK_USER_BE_MSG', [

            ]);
            return json_decode($res->getBody());
        }catch (\GuzzleHttp\Exception\ClientException $e) {}
        return false;
    }

    private function get_setupKey(string $setup_key)
    {
        return OpenSSLContract::decrypt(base64_decode($setup_key), $this->mserviceMomo->ohash);
    }


    private function get_pHash()
    {
        return OpenSSLContract::encrypt($this->mserviceMomo->imei . "|" . $this->mserviceMomo->password,$this->mserviceMomo->setup_key_decrypt);
    }

    private function generateCheckSum($msg_type, $microtime)
    {
        return OpenSSLContract::encrypt($this->mserviceMomo->username . $microtime . '000000' . $msg_type . ($microtime / 1000000000000.0) . 'E12',$this->mserviceMomo->setup_key_decrypt);
    }
}
