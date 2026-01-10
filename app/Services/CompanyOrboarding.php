<?php

namespace App\Services;


use App\Jobs\ProcessOrganizationOnboarding;
use App\Models\Organization;
use App\Repositories\Organisations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class CompanyOrboarding
 */
class CompanyOrboarding
{
	/**
	 * @param $organisationsData
	 *
	 * @return bool	
	 */
	public static function onboard($organisationsData)
	{
		try
		{
			$organisationsData
				->chunk(100)
				->each(function ($chunk) {
					DB::transaction(function () use ($chunk) {
						foreach ($chunk as $company) {
							// process each company
							$organisation = Organisations::getOrganisation($company);
							if ($organisation->isEmpty()) {
								try
								{
									$organisation = Organization::create([
																			 Organization::NAME => $company[Organization::NAME],
																			 Organization::DOMAIN => $company[Organization::DOMAIN],
																			 Organization::CONTACT_EMAIL => $company[Organization::CONTACT_EMAIL],
																			 Organization::STATUS => Organization::STATUS_PENDING,
																		 ]);

									if (isProductionEnv()) {
										dispatch(new ProcessOrganizationOnboarding($organisation))->onQueue('onboarding');
									}else{
										dispatch(new ProcessOrganizationOnboarding($organisation));
//									(new ProcessOrganizationOnboarding($organisation))->handle();
									}
								} catch (\Exception $e) {
									Log::error("Company onboarding create error : ", [$e->getMessage(), $e->getTrace()]);
								}
							}
						}
					});
				});
			return true;
		} catch (\Exception $e) {
			Log::error("Company data error : ", [$e->getMessage(), $e->getTrace()]);
			return false;
		}
	}
}