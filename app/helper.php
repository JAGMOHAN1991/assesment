<?php

if (!function_exists('isProductionEnv'))
{
	function isProductionEnv(): bool
	{
		return (config('env_key.APP_ENV') == 'production');
	}
}