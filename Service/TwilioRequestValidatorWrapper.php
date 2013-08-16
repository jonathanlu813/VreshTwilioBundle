<?php
namespace Vresh\TwilioBundle\Service;

/**
 * This file is part of the VreshTwilioBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Fridolin Koch <info@fridokoch.de>
 */
class TwilioRequestValidatorWrapper extends \Services_Twilio_RequestValidator
{
    /**
     * @param string $token
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Returns a new \Services_Twilio_RequestValidator instance from the given parameters
     *
     * @param      $token
     *
     * @return \Services_Twilio_RequestValidator
     */
    public function createInstance($token)
    {
        return new \Services_Twilio_RequestValidator($token);
    }

}