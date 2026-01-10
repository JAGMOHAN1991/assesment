<?php

namespace Tests\Unit\Organizations;

use App\Services\CompanyOrboarding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingControllerTest extends TestCase
{
	use RefreshDatabase;

	public function test_onboarding_successful()
	{
		$response = $this->postJson('/api/bulk-onboard', [
			["name" => "Test Company",
			 "domain" => "example.com",
			 "contact_email" => "test@abc6.com"]
		]);

		$response->assertStatus(200)
				 ->assertJson([
								  'message' => 'Successfully onboarded.'
							  ]);
	}

	public function test_onboarding_service_exception()
	{
		$response = $this->postJson('/api/bulk-onboard', []);

		$response->assertStatus(400)
				 ->assertJson([
								  'message' => 'Empty Payload.'
							  ]);
	}

	public function test_onboarding_validation_fails()
	{
		$response = $this->postJson('/api/bulk-onboard', [
			["name" => "Test Company",
			 "domain" => "",
			 "contact_email" => "test@abc6.com"]
		]);

		$response->assertStatus(422);
	}
}