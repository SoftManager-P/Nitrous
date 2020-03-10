<?php

namespace App\paytriot;

//Card test Visa 4929421234600821 cvv 038
class Payment
{
    private $_key;
    private $_3des_key;
    private $_merchantID;
    private $_serviceUrl;
    private $_version = '1.0';
    private $data = [];


    public function __construct()
    {
        $mode = env("PAYTRIOT_MODE", 0);
        $this->_serviceUrl = env("PAYTRIOT_URL", "https://gateway.paytriot.co.uk/paymentform/");
        $this->_key = ($mode)? env("PAYTRIOT_KEY"):'Media49Stone36Carrot';

        $this->_3des_key = 'SHA512';

        $this->data['merchantID'] = ($mode)? env("PAYTRIOT_MERCHANT_ID"):'105630';
        $this->data['action'] = 'SALE';
        $this->data['type'] = 1;

        $this->data['countryCode'] =  env('PAYTRIOT_COUNTRY_CODE',826);
        $this->data['currencyCode'] = env('PAYTRIOT_CURRENCY_CODE',826);
        $this->data['redirectURL'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .
            $_SERVER['HTTP_HOST'].env('PAYTRIOT_SUCCESS_URL','/order/payCallback');




    }

    public function getVersion() { return $this->_version; }

    public function setData($data){
        foreach ($data as $k=>$v){
            $this->data[$k] = $v;
        }
    }


    public function createSignature()
    {
        $data = $this->data;

        ksort($data);

        $ret = http_build_query($data, '', '&');

        $ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);

        return hash($this->_3des_key, $ret . $this->_key);
    }

    public function buildForm(){
        $this->data['signature'] = $this->createSignature($this->data, $this->_key);
        $html = '<form id="frmPaytriotPayment" action="' . htmlentities($this->_serviceUrl) . '" method="post">' . PHP_EOL;
        foreach ($this->data as $field => $value) {
            $html .=' <input type="hidden" name="' . $field . '" value="' .
                htmlentities($value) . '">' . PHP_EOL;
        }
        $html .= ' <input type="submit" value="Pay Now">' . PHP_EOL;
        $html .= '</form>' . PHP_EOL;

        return $html;
    }

    public function callback(){
        $res = $_POST;
        echo '<pre>';print_r($res);echo '<pre>';
        // Extract the return signature as this isn't hashed
        $signature = null;
        if (isset($res['signature'])) {
            $signature = $res['signature'];
            unset($res['signature']);
        }
    }

    public function getData(){
        return $this->data;
    }
}