<?php

namespace Chaplean\Bundle\KanbanizeApiClientBundle\Tests\Api;

use Chaplean\Bundle\ApiClientBundle\Api\Response\Failure\InvalidParameterResponse;
use Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApi;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class KanbanizeApiTest.
 *
 * @package   Chaplean\Bundle\KanbanizeApiClientBundle\Tests\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2019 Chaplean (http://www.chaplean.coop)
 */
class KanbanizeApiTest extends MockeryTestCase
{
    /** @var KanbanizeApi */
    private $api;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $client = \Mockery::mock(ClientInterface::class);
        $eventDispatcher = \Mockery::mock(EventDispatcherInterface::class);

        $client->shouldReceive('request')->andReturn(new Response());
        $eventDispatcher->shouldReceive('dispatch');

        $this->api = new KanbanizeApi($client, $eventDispatcher, 'prefix/', 'apikey');
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApi::__construct
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApi::buildApi
     *
     * @return void
     */
    public function testBuildApiPrefixAreCorrectlyConfigured(): void
    {
        $this->assertStringStartsWith('prefix/', $this->api->getChildCards()->bindUrlParameters(['card_id' => 1])->getUrl());
    }

    /**
     * @return void
     */
    public function testGetChildCardsMissingUrlParameter(): void
    {
        $response = $this->api->getChildCards()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetChildCardsGood(): void
    {
        $response = $this->api->getChildCards()
            ->bindUrlParameters([
                'card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutChildCardMissingUrlParameter(): void
    {
        $response = $this->api->putChildCard()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutChildCardGood(): void
    {
        $response = $this->api->putChildCard()
            ->bindUrlParameters([
                'card_id'       => 1,
                'child_card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetParentCardsMissingUrlParameter(): void
    {
        $response = $this->api->getParentCards()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetParentCardsGood(): void
    {
        $response = $this->api->getParentCards()
            ->bindUrlParameters([
                'card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutParentCardMissingUrlParameter(): void
    {
        $response = $this->api->putParentCard()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutParentCardGood(): void
    {
        $response = $this->api->putParentCard()
            ->bindUrlParameters([
                'card_id'        => 1,
                'parent_card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetPredecessorCardsMissingUrlParameter(): void
    {
        $response = $this->api->getPredecessorCards()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetPredecessorCardsGood(): void
    {
        $response = $this->api->getPredecessorCards()
            ->bindUrlParameters([
                'card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutPredecessorCardMissingUrlParameter(): void
    {
        $response = $this->api->putPredecessorCard()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutPredecessorCardGood(): void
    {
        $response = $this->api->putPredecessorCard()
            ->bindUrlParameters([
                'card_id'             => 1,
                'predecessor_card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetSuccessorCardsMissingUrlParameter(): void
    {
        $response = $this->api->getSuccessorCards()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testGetSuccessorCardsGood(): void
    {
        $response = $this->api->getSuccessorCards()
            ->bindUrlParameters([
                'card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutSuccessorCardMissingUrlParameter(): void
    {
        $response = $this->api->putSuccessorCard()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testPutSuccessorCardGood(): void
    {
        $response = $this->api->putSuccessorCard()
            ->bindUrlParameters([
                'card_id'           => 1,
                'successor_card_id' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }
}
