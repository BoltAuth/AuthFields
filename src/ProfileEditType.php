<?php

namespace sahassar\MemberFields;

use Bolt\Extension\Bolt\Members\Form\Type\ProfileEditType as MembersProfileEditType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Bolt\Extension\Bolt\Members\Config\Config as MembersConfig;

class ProfileEditType extends MembersProfileEditType
{
    /**
     * Constructor.
     *
     * @param MembersConfig $membersConfig
     * @param array         $fieldConfigs
     */
    public function __construct(MembersConfig $membersConfig, $fieldConfigs)
    {
        parent::__construct($membersConfig);
        $this->fieldConfigs = $fieldConfigs;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        foreach ($this->fieldConfigs['fields'] as $key => $field) {
            $builder->add($key, $field['type'], $field['options']);
        }
    }
}
