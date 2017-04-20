<?php

namespace sahassar\MemberFields;

use Bolt\Extension\Bolt\Members\Form\Entity\Profile as BaseProfile;
use Symfony\Component\Validator\Constraints as Assert;

class Profile extends BaseProfile
{
    /** @var string */
    protected $postcode;

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }
}
