<?php

namespace App\Http\Requests;

use App\Rules\Password;
use App\Services\MediaStorage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
		return MediaStorage::mergeValidationRules([
			'name' => ['required', 'string', 'max:50'],
			'password' => ['nullable', 'string', 'confirmed', new Password],
			'active' => ['boolean'],
			'verified' => ['boolean'],
			'allow_push_notifications' => ['boolean'],
			'timezone' => ['required', 'timezone'],
			'locale' => ['nullable', 'string', Rule::in(config('custom.locales'))],
			'role_id' => ['nullable', 'uuid'],
			'avatar' => ['image', 'dimensions:ratio=1', 'max:' . setting('max_upload_size') / 1024],
		]);
	}
}
