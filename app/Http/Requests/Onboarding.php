<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class Onboarding extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
		return [
			'*' => ['required', 'array', 'min:1'], // 👈 ensure non-empty array of organizations
			'*.name' => 'required|string|max:255',

			'*.domain' => [
				'required',
				'string',
				'max:255',
				'distinct',                     // 👈 no duplicate domains in request
				'unique:organizations,domain', // 👈 no duplicate in DB
			],

			'*.contact_email' => 'nullable|email|max:255',
		];
    }

	/**
	 * @return string[]
	 */
	public function messages(): array
	{
		if (empty($this->all())) {
			throw new HttpResponseException(
				response()->json([
									 'message' => 'Empty Payload.',
								 ], Response::HTTP_BAD_REQUEST)
			);
		}
		return [
			'*.required' => 'Empty Payload.',
			'*.name.required' => 'Name is required for each organization.',
			'*.domain.unique' => 'Domain already exists.',
			'*.domain.distinct' => 'Duplicate domains in request.',
			'*.contact_email.email' => 'Invalid Email format.',
		];
	}
	
	/**
	 * 🔥 Custom validation failure response
	 */
	protected function failedValidation(Validator $validator): void
	{
		$errors = [];

		foreach ($validator->errors()->messages() as $key => $messages) {
			// $key example: "0.domain"
			if (preg_match('/^(\d+)\.domain$/', $key, $matches)) {
				$index = $matches[1];

				$domain = $this->input("$index.domain") ?? "row_$index";

				$errors[$domain] = $messages;
			}else if (preg_match('/^(\d+)\.contact_email$/', $key, $matches)) {
				$index = $matches[1];

				$email = $this->input("$index.contact_email") ?? "row_$index";

				$errors[$email] = $messages;
			} else {
				// fallback for non-domain errors
				$errors[$key] = $messages;
			}
		}
		
		throw new HttpResponseException(
			response()->json([
								 'success' => false,
								 'message' => 'Validation failed',
								 'errors'  => $errors
							 ], 422)
		);
	}
}
