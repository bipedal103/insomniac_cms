<?php

namespace App\Rules;

use App\Services\Payments\PayPalHandler;
use Illuminate\Contracts\Validation\Rule;

class VerifyPayPalPayment implements Rule
{
	private float $amount;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct(float $amount)
	{
		$this->amount = $amount;
	}

	public function __toString(): string
	{
		return self::class;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param string $attribute
	 */
	public function passes($attribute, $value): bool
	{
		$paypal = new PayPalHandler;

		return $paypal->isOrderValid($value, $this->amount);
	}

	/**
	 * Get the validation error message.
	 */
	public function message(): string
	{
		return __('validation.custom.invalid-paypal');
	}
}
