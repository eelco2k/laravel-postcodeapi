<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class IdealPostcodes extends Provider {

    protected $apiKey;
    protected $requestUrl;

    /**
     * @return mixed
     */
    protected function request()
    {
        $client = $this->getHttpClient();
        $response = $client->get($this->getRequestUrl())->json();

        return $response;
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl($this->getRequestUrl().'/'.$postCode.'?api_key='.$this->getApiKey());
        $response = $this->request();

        $address = new Address();
        $address
            ->setTown($response['result'][0]['post_town'])
            ->setStreet($response['result'][0]['line_1'])
            ->setLatitude($response['result'][0]['latitude'])
            ->setLongitude($response['result'][0]['longitude']);

        return $address;
    }

    public function findByPostcode($postCode) {}
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber) {}
}