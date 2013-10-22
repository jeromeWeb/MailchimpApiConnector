<?php

namespace MailchimpApi\Tests\HttpAdapter;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Service\Client;
use MailchimpApi\HttpAdapter\GuzzleHttpAdapter;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class GuzzleHttpAdapterTest extends \MailchimpApi\Tests\TestCase
{
    protected function setUp()
    {
        if (!class_exists('Guzzle\Service\Client')) {
            $this->markTestSkipped('Guzzle library has to be installed');
        }
    }

    public function testGetName()
    {
        $adapter = new GuzzleHttpAdapter();
        $this->assertEquals('guzzle', $adapter->getName());
    }

    /**
     * @covers MailchimpApi\HttpAdapter\GuzzleHttpAdapter::__construct
     */
    public function testCreatesDefaultClient()
    {
        $adapter = new GuzzleHttpAdapter();
        $this->assertEquals('guzzle', $adapter->getName());
    }

    /**
     * @covers MailchimpApi\HttpAdapter\GuzzleHttpAdapter::__construct
     * @covers MailchimpApi\HttpAdapter\GuzzleHttpAdapter::getContent
     */
    public function testRetrievesResponseFromGetRequest()
    {
        $historyPlugin = new HistoryPlugin();
        $mockPlugin = new MockPlugin(array(new Response(200, null, 'body')));

        $client = new Client();
        $client->getEventDispatcher()->addSubscriber($mockPlugin);
        $client->getEventDispatcher()->addSubscriber($historyPlugin);

        $adapter = new GuzzleHttpAdapter($client);
        $this->assertEquals('body', $adapter->getContent('http://test.com/'));

        $this->assertEquals(
            'http://test.com/',
            $historyPlugin->getLastRequest()->getUrl()
        );
    }

    /**
     * @covers MailchimpApi\HttpAdapter\GuzzleHttpAdapter::__construct
     * @covers MailchimpApi\HttpAdapter\GuzzleHttpAdapter::postContent
     */
    public function testRetrievesResponseFromPostRequest()
    {
        $historyPlugin = new HistoryPlugin();
        $mockPlugin = new MockPlugin(array(new Response(200, null, 'body')));

        $client = new Client();
        $client->getEventDispatcher()->addSubscriber($mockPlugin);
        $client->getEventDispatcher()->addSubscriber($historyPlugin);

        $adapter = new GuzzleHttpAdapter($client);
        $this->assertEquals('body', $adapter->postContent('http://test.com/', array(), 'body'));
    }
}
