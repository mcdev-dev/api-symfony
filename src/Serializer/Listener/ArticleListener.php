<?php


namespace App\Serializer\Listener;


use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
class ArticleListener implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.post_serialize',
                'format' => 'json',
                'class' => 'App\Entity\Article',
                'method' => 'onPostSerialize'
            ]
        ];
    }

    public static function onPostSerialize(ObjectEvent $event)
    {
        $date = new \DateTime();
        $event->getVisitor()->visitProperty(
            new StaticPropertyMetadata('',
            'serialize_at_listener',
            null),
            $date->format('l jS \of F Y h:i:s A'));
    }

}