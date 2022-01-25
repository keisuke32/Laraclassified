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

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\LoginRequest;
use App\Events\UserWasLogged;
use App\Http\Resources\UserResource;
use App\Models\Permission;
use App\Models\User;
use App\Helpers\Auth\Traits\AuthenticatesUsers;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 */
class LoginController extends BaseController
{
	use AuthenticatesUsers;
	
	// The maximum number of attempts to allow
	protected $maxAttempts = 5;
	
	// The number of minutes to throttle for
	protected $decayMinutes = 15;
	
	/**
	 * LoginController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Get values from Config
		$this->maxAttempts = (int)config('settings.security.login_max_attempts', $this->maxAttempts);
		$this->decayMinutes = (int)config('settings.security.login_decay_minutes', $this->decayMinutes);
	}
	
	/**
	 * Log in
	 *
	 * @bodyParam login string required The user's login (Can be email address or phone number). Example: user@demosite.com
	 * @bodyParam password string required The user's password. Example: 123456
	 * @bodyParam captcha_key string Key generated by the CAPTCHA endpoint calling (Required if the CAPTCHA verification is enabled from the Admin panel).
	 *
	 * @param \App\Http\Requests\LoginRequest $request
	 * @return \Illuminate\Http\JsonResponse|void
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(LoginRequest $request)
	{
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);
			
			return $this->sendLockoutResponse($request);
		}
		
		// Get the right login field
		$loginField = getLoginField($request->input('login'));
		
		// Get the User by Login field
		$user = User::where($loginField, $request->input('login'))->first();
		
		if (!empty($user)) {
			// Check the User's password
			if (Hash::check($request->input('password'), $user->password)) {
				
				// Update last user logged Date
				Event::dispatch(new UserWasLogged($user));
				
				// Redirect admin users to the Admin panel
				$isAdmin = false;
				if ($user->hasAllPermissions(Permission::getStaffPermissions())) {
					$isAdmin = true;
				}
				
				// Revoke previous tokens
				$user->tokens()->delete();
				
				// Create the API access token
				$deviceName = $request->input('device_name', 'Desktop Web');
				$token = $user->createToken($deviceName);
				
				$data = [
					'success' => true,
					'result'  => new UserResource($user),
					'extra'   => [
						'authToken' => $token->plainTextToken,
						'tokenType' => 'Bearer',
						'isAdmin'   => $isAdmin,
					],
				];
				
				return $this->apiResponse($data);
				
			}
		}
		
		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);
		
		return $this->respondError(trans('auth.failed'));
	}
	
	/**
	 * Log out
	 *
	 * @authenticated
	 * @header Authorization Bearer {YOUR_AUTH_TOKEN}
	 *
	 * @urlParam userId int The ID of the user to logout.
	 *
	 * @param $userId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout($userId)
	{
		if (auth('sanctum')->check()) {
			// Get the User Personal Access Token Object
			$personalAccess = request()->user()->tokens()->where('id', getApiAuthToken())->first();
			
			// Revoke all user's tokens
			if (!empty($personalAccess)) {
				if ($personalAccess->tokenable_id == $userId) {
					// Revoke a specific token
					$personalAccess->delete();
					
					// Revoke all tokens
					// request()->user()->tokens()->delete();
				}
			}
		}
		
		$message = t('You have been logged out') . ' ' . t('See you soon');
		
		return $this->respondSuccess($message);
	}
}
