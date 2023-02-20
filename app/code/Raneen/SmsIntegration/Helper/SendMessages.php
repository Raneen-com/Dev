<?php

namespace Raneen\SmsIntegration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\HTTP\Client\Curl;

class SendMessages extends AbstractHelper
{
    protected $curl;

    protected $smsProviderFactor;

    protected $_timezone;

    protected $smsHistoryFactory;
    public function __construct(
        Curl $curl,
        \Raneen\SmsIntegration\Model\SmsIntegrationsFactory $smsIntegrationsFactor,
        \Raneen\SmsIntegration\Model\SmsHistoryFactory $smsHistoryFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime         $timezone
    ) {
        $this->curl = $curl;
        $this->smsProviderFactor = $smsIntegrationsFactor;
        $this->smsHistoryFactory = $smsHistoryFactory;
        $this->_timezone = $timezone;
    }
    private function authCURL($URL, $type, $body)
    {
        $this->curl->addHeader("Content-Type", "application/json");

        if ($type == "POST") {
            $this->curl->post($URL, $body);
        } else {
            $this->curl->get($URL . '?' . http_build_query($body));
        }

        $response = $this->curl->getBody();

        return $response;
    }

    public function singleSmsCURL($message, $phone, $actionName)
    {
        /**
         * Get The Provider Is Enable
        **/
        $smsProviderModel = $this->smsProviderFactor->create()->getCollection();
        $smsProviderModel->addFieldToFilter('main_table.enable', ['eq' => '1']);

        try {
            if ($smsProviderModel->getData()) {
                $smsProviderData = $smsProviderModel->getData()[0];
                $arrBody = json_decode($smsProviderData['request_body'], true);
                $headers = [];

                $this->replaceVariablesInBody($arrBody, $message, $phone);

                if ($smsProviderData['authentication_static_header']) {
                    $headers = $smsProviderData['authentication_static_header'];
                }

//                $arr = json_encode([
//                    "status" => 200,
//                    "response" => [
//                        "apiKey" => "cmFuZWVuOm9RTG09K3hybF16Jnd8Mzo2MjQ="
//                    ]
//                ]);

                if ($smsProviderData['authentication_url']) {
                    //$apiAuthResponseJson = json_decode($arr, true);
                    $apiAuthResponseJson = $this->authCURL($smsProviderData['authentication_url'], $smsProviderData['authentication_request_type'], $smsProviderData['authentication_request_body']);
                    $this->getVariablesFromHeader($apiAuthResponseJson, $headers);
                }

                if ($headers) {
                    $this->curl->setHeaders(json_decode($headers, true));
                }

                $this->curl->setOption(CURLOPT_HEADER, 0);

                if ($smsProviderData['request_type'] == "GET") {
                    $this->curl->get($smsProviderData['provider_url'] . '?' . http_build_query($arrBody));
                } else {
                    $this->curl->post($smsProviderData['provider_url'], json_encode($arrBody));
                }

                $this->saveSmsLogs($phone, $smsProviderData['id'], $message, $actionName, $this->curl->getBody());

                if ($this->curl->getStatus() == 200 && ((is_string($this->curl->getBody()) && strpos($this->curl->getBody(), "Response") !== false) || (is_array(json_decode($this->curl->getBody(), true))))) {
                    return [
                        "status" => $this->curl->getStatus(),
                        "message" => $this->curl->getBody()
                    ];
                } else {
                    return [
                        "status" => $this->curl->getStatus(),
                        "message" => "Sorry, error in sms integration"
                    ];
                }
            } else {
                return [
                    "status" => 400,
                    "message" => "There are not enable SMS provider"
                ];
            }
        } catch (\Exception $e) {
            return [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        }
    }
    private function saveSmsLogs($mobile, $providerId, $message, $actionName, $SMSResponse)
    {
        $smslogsModel = $this->smsHistoryFactory->create();

        $smslogsModel->addData([
            "receiver_mobile_number" => $mobile,
            "provider_id" => $providerId,
            "message" => $message,
            "trigger" => $actionName,
            "response" => is_string($SMSResponse) ? json_encode($SMSResponse) : $SMSResponse,
            "created_at" => $this->_timezone->gmtDate()
        ]);

        $smslogsModel->save();
    }

    /**
     * replace variables in body object
    **/
    private function replaceVariablesInBody(&$arrBody, $message, $phone)
    {
        foreach ($arrBody as $key=>$val) {
            if ($val == "%message%") {
                $arrBody[$key] = $message;
            }
            if ($val == "%phone%") {
                $arrBody[$key] = $phone;
            }
        }
    }

    /**
     * Get The Response Of Auth API
    **/
    private function getVariablesFromHeader($apiAuthResponseJson, &$headers)
    {
        $arrHeaders = json_decode($headers, true);
        $arrAuthorizationHeader = str_replace("%", "", explode(" ", $arrHeaders['Authorization']));

        $arrAuthKeys = explode(".", $arrAuthorizationHeader[1]);
        $authValue = [];
        foreach ($arrAuthKeys as $i=>$arrAuthKey) {
            if ($i==0) {
                $authValue = $apiAuthResponseJson[$arrAuthKey];
            } else {
                $authValue = $authValue[$arrAuthKey];
            }
        }
        $arrAuthorizationHeader[1] = $authValue;

        $arrHeaders['Authorization'] = $arrAuthorizationHeader[0] . " " . $arrAuthorizationHeader[1];
        $headers = json_encode($arrHeaders);
    }
}
