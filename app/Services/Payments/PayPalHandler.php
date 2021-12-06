<?php

namespace App\Services\Payments;

use App\Services\Support\BaseApiHandler;
use Illuminate\Http\Client\PendingRequest;

class PayPalHandler extends BaseApiHandler
{
	private string $clientId;
	private string $clientSecret;
	private ?string $token = null;

	public function __construct(?bool $sandbox = null)
	{
		$sandbox ??= setting('paypal_sandbox');

		$this->clientId = $sandbox ? setting('paypal_sandbox_client_id') : setting('paypal_client_id');
		$this->clientSecret = $sandbox ? setting('paypal_sandbox_client_secret') : setting('paypal_client_secret');

		parent::__construct($sandbox ? 'https://api-m.sandbox.paypal.com/' : 'https://api-m.paypal.com/');
	}

	public function isOrderValid(string $payId, float $amount): bool
	{
		$order = $this->getOrderDetails($payId);

		return !empty($order) && $order['status'] == 'APPROVED' && $order['purchase_units'][0]['amount']['value'] == $amount;
	}

	public function getOrderDetails(string $payId): ?array
	{
		$data = $this->client()->get('v2/checkout/orders/' . $payId);

		return $this->returnResponse($data);
	}

	private function client(): PendingRequest
	{
		return $this->auth()->client->asJson()->withToken($this->token);
	}

	private function auth(): self
	{
		if ($this->token) {
			return $this;
		}

		$data = $this->client->asForm()->withBasicAuth($this->clientId, $this->clientSecret)->post('v1/oauth2/token', ['grant_type' => 'client_credentials']);
		$data = $this->returnResponse($data);

		$this->token = $data['access_token'] ?? null;

		return $this;
	}
}
