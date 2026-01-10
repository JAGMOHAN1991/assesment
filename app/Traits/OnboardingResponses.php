<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait OnboardingResponses
{
	protected function respondWithUnprocessableEntity($payload = null)
	{
		return \response()->json($payload, Response::HTTP_UNPROCESSABLE_ENTITY);
	}
}
