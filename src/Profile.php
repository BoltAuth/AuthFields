<?php

namespace sahassar\MemberFields;

use Bolt\Extension\Bolt\Members\Form\Entity\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function __get($name)
    {
        return property_exists($this, $name) ? $this->{$name} : null;
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
}
