<?php
/**
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Observers\AdvertisingObserver;
use Illuminate\Support\Str;
use Larapen\Admin\app\Models\Traits\Crud;

class Advertising extends BaseModel
{
	use Crud;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'advertising';
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'slug'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'slug',
		'integration',
		'is_responsive',
		'provider_name',
		'description',
		'tracking_code_large',
		'tracking_code_medium',
		'tracking_code_small',
		'active',
	];
	
	/**
	 * The attributes that should be hidden for arrays
	 *
	 * @var array
	 */
	// protected $hidden = [];
	
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	// protected $dates = [];
	
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();
		
		Advertising::observe(AdvertisingObserver::class);
		
		static::addGlobalScope(new ActiveScope());
	}
	
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| ACCESSORS
	|--------------------------------------------------------------------------
	*/
	public function getTrackingCodeLargeAttribute($value)
	{
		$value = $this->checkAndTransformCode($value);
		
		return $value;
	}
	
	public function getTrackingCodeMediumAttribute($value)
	{
		$value = $this->checkAndTransformCode($value);
		
		return $value;
	}
	
	public function getTrackingCodeSmallAttribute($value)
	{
		$value = $this->checkAndTransformCode($value);
		
		return $value;
	}
	
	private function checkAndTransformCode($value)
	{
		// If the code is from Google Adsense
		if (Str::contains($value, 'adsbygoogle.js')) {
			$patten = '/class="adsbygoogle"/ui';
			$replace = 'class="adsbygoogle ads-slot-responsive"';
			$value = preg_replace($patten, $replace, $value);
			
			$value = preg_replace('/data-ad-format="[^"]*"/ui', '', $value);
		}
		
		return $value;
	}
	
	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
