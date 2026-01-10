<?php

namespace App\Jobs;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessOrganizationOnboarding implements ShouldQueue
{
    use Queueable;

	private $companiesData;
    /**
     * Create a new job instance.
     */
    public function __construct(Organization $companiesData)
    {
        $this->companiesData = $companiesData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
		
		$this->companiesData->update([
										 Organization::STATUS => Organization::STATUS_PROCESSING,
									 ]);
		
		/*
		 * @todo processing code need to write here
		 */
		
		$success = true;
		
		if ($success) {
			$this->companiesData->update([
											 Organization::STATUS => Organization::STATUS_COMPLETED,
											 Organization::PROCESSED_AT => Carbon::now()->toDateTimeString(),
										 ]);
		} else {
			throw new \Exception("Onboarding failed due to external service error.");
			
		}
		Log::info("orboarding successful for company id: ", [$this->companiesData->id]);
    }

	/**
	 * @return int
	 */
	public function tries(): int
	{
		return 3;
	}

	// Retry after 10s on first failure, 30s on second, 60s on third

	/**
	 * @return int[]
	 */
	public function backoff(): array
	{
		return [10, 30, 60];
	}

	// Called after all retries are exhausted

	/**
	 * @param \Throwable $e
	 *
	 * @return void
	 */
	public function failed(\Throwable $e): void
	{
		$this->companiesData->update([
										 Organization::STATUS => Organization::STATUS_FAILED,
										 Organization::FAILED_REASON => $e->getMessage(),
									 ]);
		Log::error('Onboarding job permanently failed', [
			'org_id' => $this->companiesData->id,
			'error'  => $e->getMessage(),
		]);
	}
}
