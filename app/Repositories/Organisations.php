<?php

namespace App\Repositories;


use App\Models\Organization;
use Illuminate\Support\Facades\Cache;

class Organisations
{
	/**
	 * @param $company
	 *
	 * @return mixed
	 */
	public static function getOrganisation($company)  {
		return Cache::remember('companies_'. $company[Organization::DOMAIN], 60, function () use ($company) {
			return Organization::select(Organization::ID, Organization::NAME, Organization::DOMAIN)
						->where(Organization::NAME, $company[Organization::NAME])
						->where(Organization::DOMAIN, $company[Organization::DOMAIN])
//						->where(Organization::STATUS, $company->{Organization::STATUS_COMPLETED})
						->get();
		});
	}
}