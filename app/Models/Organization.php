<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    const ID = 'id';
    const NAME = 'name';
    const DOMAIN = 'domain';
    const CONTACT_EMAIL = 'contact_email';
    const STATUS = 'status';
    const BATCH_ID = 'batch_id';
    const PROCESSED_AT = 'processed_at';
    const FAILED_REASON = 'failed_reason';
	
	const STATUS_PENDING = 'pending';
	const STATUS_PROCESSING = 'processing';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';
	
	protected $fillable = [
		self::NAME,
		self::DOMAIN,
		self::CONTACT_EMAIL,
		self::STATUS,
		self::BATCH_ID,
		self::PROCESSED_AT,
		self::FAILED_REASON,
	];
	
}
