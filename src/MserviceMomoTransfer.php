<?php

namespace VandatPiko\Mservice;

use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\Factory;
use VandatPiko\Mservice\Contracts\MserviceMomoContract;
use VandatPiko\Mservice\Models\MserviceMomo;
use VandatPiko\Mservice\Traits\MserviceMomoTrait;

class MserviceMomoTransfer implements MserviceMomoContract
{
    use MserviceMomoTrait;
    /**
     * @var \VandatPiko\Mutils
     */

    protected $clientHttpRequest;

    protected $mserviceMomo;

    /**
     * @param Client $client
     * @param $mserviceMomo
     */

    protected $configure;

    protected $auth;


    public function __construct(Client $clientHttpRequest,Factory $auth)
    {
        /**
         * @var clientHttpRequest
         */
        $this->clientHttpRequest = $clientHttpRequest;
        /**
         * @var configure
         */
        $this->configure = config('mservice');
        /**
         * @var auth
         */
        $this->auth = $auth;
    }

    public function setMserviceMomo($userId)
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('UserName MserviceMomo id is required');
        }
        $this->mserviceMomo = MserviceMomo::findOrFail($userId);
        if (!$this->mserviceMomo){
            $this->mserviceMomo = MserviceMomo::create([
                'user_id'  => $this->auth->id(),
                'username' => $userId,
                'imei'     => generateImei(),
                'rkey'     => generateRandomString(32),
                'aaid'     => generateImei(),
                'token'    => generateToken(),
                'secure_id'=> generateRandom(17),
                'model_id' => hash('sha256', 'samsung sm-' . generateRandom(32))
            ]);
        }
        return $this;
    }

    public function loginAuth(string $password)
    {
    }

    public function requestOTP()
    {
        $result = $this->CHECK_USER_BE_MSG();
        if ($result != false) {
            if (empty($result->errorCode)) {
                if (isset($result->extra->userGroup)) {
                    if ($result->extra->userGroup == 'skip_otp_group') {
                        $result = $this->RE_LOGIN();
                        if ($result !== false) {
                            if (empty($result->errorCode)) {
                                $this->mserviceMomo->ohash = $this->mserviceMomo->rkey;
                                $this->mserviceMomo->setupKeyDecrypt = $this->get_setupKey($result->extra->setupKey);
                                $this->mserviceMomo->save();
                                return (object) [
                                    'success' => true,
                                    'otp'     => false,
                                    'message' => 'Đăng nhập thành công vui lòng nhập mật khẩu'
                                ];
                            }
                        }
                    }
                }
                $result = $this->SEND_OTP_MSG();
                if ($result != false) {
                    if (empty($result->errorCode)) {
                        $this->mserviceMomo->save();
                        return (object) array(
                            'success' => true,
                            'otp'     => true,
                            'message' => 'Gửi mã OTP thành công'
                        );
                    }
                }
            }
        }
        return (object) array(
            'success' => false,
            'message' => $result->errorDesc ?? 'Đã xảy ra lỗi yêu cầu OTP vui lòng thử lại'
        );
    }

    public function verifyOTP(string $otp)
    {
    }

}
