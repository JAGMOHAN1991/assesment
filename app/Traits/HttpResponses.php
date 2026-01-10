<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait HttpResponses
{
	protected function respondWithUnprocessableEntity($payload = null)
	{
		return \response()->json($payload, Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	protected function responseWithBadRequest($payload = null)
	{
		return \response()->json($payload, Response::HTTP_BAD_REQUEST);
	}

	protected function respondWithConflict($payload = null)
	{
		return \response()->json($payload, Response::HTTP_CONFLICT);
	}

	protected function respondWithCreated($payload = null)
	{
		return \response()->json($payload, Response::HTTP_CREATED);
	}

	protected function respondWithOkay($payload = null)
	{
		return \response()->json($payload, Response::HTTP_OK);
	}

	protected function responseWithServerError($payload = null)
	{
		return \response()->json($payload, Response::HTTP_INTERNAL_SERVER_ERROR);
	}

	protected function respondWithServerError($payload = null)
	{
		return \response()->json($payload, Response::HTTP_INTERNAL_SERVER_ERROR);
	}

	protected function respondWithBadRequest($payload = null)
	{
		return \response()->json($payload, Response::HTTP_BAD_REQUEST);
	}

	/**
	 * Create a response to signal a 404 not found result.
	 *
	 * @param mixed $payload The data that is to be sent in response
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithNotFound($payload = null)
	{
		return \response()->json($payload, Response::HTTP_NOT_FOUND);
	}

	/**
	 * Create a response to signal a 400 Bad request citing additional reasons, if any in the payload.
	 *
	 * @param $payload
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithValidationError($payload = null)
	{
		return $this->respondWithBadRequest($payload);
	}

	protected function respondWithForbidden($payload = null)
	{
		return \response()->json($payload, Response::HTTP_FORBIDDEN);
	}

	protected function respondWithUnauthorized($payload = null)
	{
		return \response()->json($payload, Response::HTTP_BAD_REQUEST);
	}
}
