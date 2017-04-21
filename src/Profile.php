<?php

namespace sahassar\MemberFields;

use Bolt\Extension\Bolt\Members\Form\Entity\Profile as BaseProfile;

class Profile extends BaseProfile
{

    public function __call($method, $arguments)
    {
        $var = lcfirst(preg_replace('/^(get|set)/i', '', $method));
        $lowercased = lcfirst($var);

        $try = [
            $var,
            $lowercased
        ];

        if (strncasecmp($method, 'get', 3) == 0) {
            foreach ($try as $test) {
                if (property_exists($this, $test)) {
                    return $this->$test;
                }
            }
        }

        if (strncasecmp($method, 'set', 3) == 0) {
            $this->$var = $arguments[0];
        }
    }
}
