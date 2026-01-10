<?php

namespace Tests\Unit\Organizations;

use App\Jobs\ProcessOrganizationOnboarding;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessOrganizationOnboardingTest extends TestCase
{
	use RefreshDatabase;

	public function test_is_idempotent_when_updating_organization(): void
	{
		$organization = Organization::create([
												 'name' => 'Test Org',
												 'domain' => 'test-org.com',
												 'status' => Organization::STATUS_PENDING,
												 'processed_at' => null,
											 ]);

		$job = new ProcessOrganizationOnboarding($organization);

		// First run
		$job->handle();
		$organization->refresh();

		$firstProcessedAt = $organization->processed_at;
		$firstStatus = $organization->status;

		// Retry (simulate job retry)
		$job->handle();
		$organization->refresh();

		// Assert
		$this->assertEquals(Organization::STATUS_COMPLETED, $organization->status);
		$this->assertEquals($firstStatus, $organization->status);
		$this->assertEquals($firstProcessedAt, $organization->processed_at);
	}
}