<?php

namespace sahassar\MemberFields;

use Bolt\Extension\SimpleExtension;
use Bolt\Extension\Bolt\Members\Event\FormBuilderEvent;
use Bolt\Extension\Bolt\Members\Event\MembersProfileEvent;
use Bolt\Extension\Bolt\Members\Form\MembersForms;
use Bolt\Extension\Bolt\Members\Event\MembersEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MemberFieldsExtension extends SimpleExtension
{
    /**
     * {@inheritdoc}
     */
    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener(MembersEvents::MEMBER_PROFILE_PRE_SAVE, [$this, 'onProfileSave']);
        $dispatcher->addListener(MembersEvents::MEMBER_PROFILE_REGISTER, [$this, 'onProfileSave']);
        $dispatcher->addListener(FormBuilderEvent::BUILD, [$this, 'onRequest']);
    }

    /**
     * Tell Members what fields we want to persist.
     *
     * @param MembersProfileEvent $event
     */
    public function onProfileSave(MembersProfileEvent $event)
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
        if ($event->getName() !== MembersForms::PROFILE_EDIT && $event->getName() !== MembersForms::PROFILE_VIEW && $event->getName() !== MembersForms::PROFILE_REGISTER) {
            return;
        }
        $app = $this->getContainer();

        $type = new ProfileEditType($app['members.config'], $this->getConfig());

        $entityClassName = Profile::class;

        $event->setType($type);
        $event->setEntityClass($entityClassName);
    }
}
