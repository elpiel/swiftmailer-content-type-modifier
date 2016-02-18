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
class ContentTypePluginTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::getContentType
     * @covers ::__construct
     */
    public function testConstructor ()
    {
        $contentType = 'text/html';
        $modifyPlugin = new ContentTypePlugin($contentType);
        $this->assertSame($contentType, $modifyPlugin->getContentType());
    }

    public function testEvent ()
    {
        $setContentType = 'text/html';
        $overriddenContentType = 'text/plain';
        // create new Plugin instance with text/html content type
        $contentType = new ContentTypePlugin($setContentType);

        // Create new message with text/plain content type
        $message = \Swift_Message::newInstance('', '', $overriddenContentType);

        $sendEvent = $this->createSendEvent($message);
        $contentType->beforeSendPerformed($sendEvent);
        $this->assertEquals($setContentType, $message->getContentType());
        $contentType->sendPerformed($sendEvent);
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

    public function createSendEvent (\Swift_Message $message)
    {
        $event = $this->getMockBuilder('Swift_Events_SendEvent')
                      ->disableOriginalConstructor()
                      ->getMock();
        $event->expects($this->any())
              ->method('getMessage')
              ->will($this->returnValue($message));

        return $event;
    }
}