<?php


namespace App\Serializer\Handler;


use App\Entity\Article;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

class ArticleHandler implements SubscribingHandlerInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'App\Entity\Article',
                'method' => 'serialize'
            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {
        $date = new \DateTime();
        return
            [
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'serialize_at_handler' => $date->format('l jS \of F Y h:i:s A')
            ];
    }
}