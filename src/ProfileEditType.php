<?php

namespace BoltAuth\AuthFields;

use Bolt\Extension\BoltAuth\Auth\Form\Type\ProfileEditType as AuthProfileEditType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Bolt\Extension\BoltAuth\Auth\Config\Config as AuthConfig;

class ProfileEditType extends AuthProfileEditType
{
    /**
     * Constructor.
     *
     * @param AuthConfig $authsConfig
     * @param array         $fieldConfigs
     */
    public function __construct(AuthConfig $authsConfig, $fieldConfigs)
    {
        parent::__construct($authsConfig);
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
            if ($field['type'] === 'checkbox') {
                $builder->get($key)->addModelTransformer(new CallbackTransformer(
                    function ($boolAsString) {
                        return intval($boolAsString) ? true : false;
                    },
                    function ($stringAsBool) {
                        return $stringAsBool ? "1" : "0";
                    }
                ));
            } elseif ($field['type'] === 'integer') {
                $builder->get($key)->addModelTransformer(new CallbackTransformer(
                    function ($intAsString) {
                        return intval($intAsString);
                    },
                    function ($stringAsInt) {
                        return (string)$stringAsInt;
                    }
                ));
            }

        }
    }
}
