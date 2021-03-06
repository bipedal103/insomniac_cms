<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:50'],
			'mode' => ['required', 'integer', 'min:1', 'max:2'],
			'protected' => ['boolean'],
			'api_rate_limit' => ['required', 'integer', 'min:1'],
			'api_rate_limit_backoff_minutes' => ['required', 'integer', 'min:1'],
			'routes' => ['array'],
			'routes.*' => ['required', 'string', 'max:50'],
		];
	}
}
