<?php
/**
 * Created by elpiel.
 * Project: swiftmailer-content-type-modifier
 * Date: 18/02/16
 */

namespace TW\Swiftmailer\Plugin;

use Swift_Events_SendEvent;

/**
 * Class ContentTypePlugin
 *
 * @package TW\Swiftmailer\Plugin
 */
class ContentTypePlugin implements \Swift_Events_SendListener
{

    /**
     * @var
     */
    private $contentType;

    /**
     * ContentTypePlugin constructor.
     *
     * @param $contentType
     */
    public function __construct ($contentType)
    {
        // using this string, we do not validated, because Swiftmailer
        // doesn't validates the value but just sets it
        $this->contentType = $contentType;
    }


    /**
     * Invoked immediately before the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed (Swift_Events_SendEvent $evt)
    {
        $message = $evt->getMessage();
        $message->setBody($message->getBody(), $this->contentType);
    }

    /**
     * Invoked immediately after the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed (Swift_Events_SendEvent $evt)
    {
        // Nothing to do here..
    }

    /**
     * @return string
     */
    public function getContentType ()
    {
        return $this->contentType;
    }

}