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

        foreach ($this->fieldConfigs['fields'] as $key => $value) {
            $builder
                ->add($key, Type\TextType::class, [
                    'label_attr'  => [
                        'class' => $value['labelclass'] ?: $key
                    ],
                    'attr'        => [
                        'class'       => $value['class'] ?: $key,
                        'placeholder' => $value['placeholder'] ?: $key
                    ],
                    'label'       => $value['label'] ?: $key,
                    'constraints' => [],
                    'required'    => $value['required']
                ])
            ;
        }
    }
}
