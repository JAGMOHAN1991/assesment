<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding;
use App\Services\CompanyOrboarding;
use Illuminate\Support\Facades\Log;

/**
 * Class OnboardingController
 *
 * @package App\Http\Controllers\Organizations
 */
class OnboardingController extends Controller
{
	/**
	 * @param \App\Http\Requests\Onboarding $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index(Onboarding $request)
	{
		// If we reach here, validation has passed
		try
		{
			CompanyOrboarding::onboard(collect($request->all()));
		} catch (\Exception $e) {
			Log::error("Company onboarding data error : ", [$e->getMessage(), $e->getTrace()]);
			return $this->respondWithBadRequest([
											  'message' => "Something went wrong."
										  ]);
		}
		
		return $this->respondWithOkay([
										  'message' => 'Successfully onboarded.'
									  ]);
	}
}
