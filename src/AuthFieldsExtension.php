<?php

namespace BoltAuth\AuthFields;

use Bolt\Extension\SimpleExtension;
use Bolt\Extension\BoltAuth\Auth\Event\FormBuilderEvent;
use Bolt\Extension\BoltAuth\Auth\Event\AuthProfileEvent;
use Bolt\Extension\BoltAuth\Auth\Form\AuthForms;
use Bolt\Extension\BoltAuth\Auth\Event\AuthEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AuthFieldsExtension extends SimpleExtension
{
    /**
     * {@inheritdoc}
     */
    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener(AuthEvents::AUTH_PROFILE_PRE_SAVE, [$this, 'onProfileSave']);
        $dispatcher->addListener(AuthEvents::AUTH_PROFILE_REGISTER, [$this, 'onProfileSave']);
        $dispatcher->addListener(FormBuilderEvent::BUILD, [$this, 'onRequest']);
    }

    /**
     * Tell Auth what fields we want to persist.
     *
     * @param AuthProfileEvent $event
     */
    public function onProfileSave(AuthProfileEvent $event)
    {
        // Meta fields that we want to register
        $fields = [];

        foreach ($this->getConfig()['fields'] as $key => $value) {
            $fields[] = $key;
        }

        $event->addMetaEntryNames($fields);
    }

    /**
     * @param FormBuilderEvent $event
     */
    public function onRequest(FormBuilderEvent $event)
    {
        if ($event->getName() !== AuthForms::PROFILE_EDIT) {
            return;
        }
        $app = $this->getContainer();

        $type = new ProfileEditType($app['auth.config'], $this->getConfig());

        $event->setType($type);
        $event->setEntityClass(null);
    }
}
