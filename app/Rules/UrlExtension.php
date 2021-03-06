<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UrlExtension implements Rule
{
	private string $attribute;
	private array $extensions;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct(array $extensions)
	{
		$this->extensions = $extensions;
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
		$this->attribute = $attribute;

		return empty($value) || $this->checkUrlExtension($value);
	}

	/**
	 * Get the validation error message.
	 */
	public function message(): string
	{
		return __('validation.mimes', ['attribute' => $this->attribute, 'values' => implode(', ', $this->extensions)]);
	}

	private function checkUrlExtension(string $value): bool
	{
		$value = strtolower(pathinfo($value, PATHINFO_EXTENSION));

		return in_array($value, $this->extensions);
	}
}
