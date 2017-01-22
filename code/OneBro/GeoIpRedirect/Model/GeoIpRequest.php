<?php

namespace OneBro\GeoIpRedirect\Model;

use Magento\Framework\App\Request\Http;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Json\Helper\Data;

class GeoIpRequest {
	const REQUEST_TIMEOUT = 2000;

	const ENDPOINT_URL = 'http://freegeoip.net';

	const REQUEST_TYPE = 'json';

	private $response;

	public function __construct(
		CurlFactory $curlFactory,
		Http $http,
		Data $jsonHelper

	) {
		$this->curlFactory = $curlFactory;
		$this->http = $http;
		$this->jsonHelper = $jsonHelper;
	}

	public function getCountryCode() {
		return $this->getGeoIpResponse()->country_code;
	}

	public function getGeoIpResponse() {
		if (!$this->response) {
			$this->response = (object) $this->getResponseFromEndpoint();
		}
		return $this->response;
	}

	private function getResponseFromEndpoint() {
		return $this->jsonHelper->jsonDecode($this->getResponse());
	}

	private function getResponse() {
		$client = $this->curlFactory->create();

		$client->setTimeout(self::REQUEST_TIMEOUT);
		$client->get(
			self::ENDPOINT_URL . '/' . self::REQUEST_TYPE . '/' .
			$this->http->getClientIp()
		);
		return $client->getBody();
	}
}