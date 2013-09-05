<?php

namespace Mparaiso\SilexPress\Core\Event;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\SecurityContext;

class PostEventListener implements EventSubscriberInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(PostEvents::BEFORE_PERSIST => "beforePersist");
    }

    function beforePersist(GenericEvent $event)
    {
        $post = $event->getSubject();
        if (!$post->getPostAuthor()) {
            $app = $event->getArgument("app");
            $security = $app["security"];
            /* @var SecurityContext $security */
            $securityUser = $security->getToken()->getUser();
            $user = $app['user_manager']->getByUsername($securityUser->getUsername());
            $app["sp.core.service.post"]->setPostAuthor($post, $user);
        }
    }
}
