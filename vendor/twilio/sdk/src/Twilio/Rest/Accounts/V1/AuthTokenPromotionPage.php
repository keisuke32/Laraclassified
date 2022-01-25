<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Accounts\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AuthTokenPromotionPage extends Page {
    /**
     * @param Version $version Version that contains the resource
     * @param Response $response Response from the API
     * @param array $solution The context solution
     */
    public function __construct(Version $version, Response $response, array $solution) {
        parent::__construct($version, $response);

        // Path Solution
        $this->solution = $solution;
    }

    /**
     * @param array $payload Payload response from the API
     * @return AuthTokenPromotionInstance \Twilio\Rest\Accounts\V1\AuthTokenPromotionInstance
     */
    public function buildInstance(array $payload): AuthTokenPromotionInstance {
        return new AuthTokenPromotionInstance($this->version, $payload);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Twilio.Accounts.V1.AuthTokenPromotionPage]';
    }
}