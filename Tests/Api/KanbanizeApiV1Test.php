<?php

namespace Tests\Chaplean\Bundle\KanbanizeApiClientBundle\Api;

use Chaplean\Bundle\ApiClientBundle\Api\Response\Failure\InvalidParameterResponse;
use Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class KanbanizeApiV1Test.
 *
 * @package   Tests\Chaplean\Bundle\KanbanizeApiClientBundle\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2019 Chaplean (https://www.chaplean.coop)
 */
class KanbanizeApiV1Test extends MockeryTestCase
{
    /** @var KanbanizeApiV1 */
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

        $this->api = new KanbanizeApiV1($client, $eventDispatcher, 'prefix/', 'apikey');
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1::__construct
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1::buildApi
     *
     * @return void
     */
    public function testBuildApiPrefixAndSuffixAreCorrectlyConfigured(): void
    {
        $this->assertStringStartsWith('prefix/', $this->api->getProjectsAndBoards()->getUrl());
        $this->assertStringEndsWith('/format/json', $this->api->getProjectsAndBoards()->getUrl());
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetProjectsAndBoardsOk(): void
    {
        $response = $this->api->getProjectsAndBoards()->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetboardStructureMissingBoardId(): void
    {
        $response = $this->api->postBoardStructure()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetboardStructureInvalidBoardId(): void
    {
        $response = $this->api->postBoardStructure()
            ->bindRequestParameters([
                'boardid' => '7'
            ])
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetboardStructureOk(): void
    {
        $response = $this->api->postBoardStructure()
            ->bindRequestParameters([
                'boardid' => 1,
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetfullBoardStructureMissingBoardId(): void
    {
        $response = $this->api->postFullBoardStructure()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetfullBoardStructureInvalidBoardId(): void
    {
        $response = $this->api->postFullBoardStructure()
            ->bindRequestParameters([
                'boardid' => '7'
            ])
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetfullBoardStructureOk(): void
    {
        $response = $this->api->postFullBoardStructure()
            ->bindRequestParameters([
                'boardid' => 1,
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardSettingsMissingBoardId(): void
    {
        $response = $this->api->postBoardSettings()->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardSettingsInvalidBoardId(): void
    {
        $response = $this->api->postBoardSettings()
            ->bindRequestParameters([
                'boardid' => '7'
            ])
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardSettingsOk(): void
    {
        $response = $this->api->postBoardSettings()
            ->bindRequestParameters([
                'boardid' => 1,
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardActivitiesMissingRequiredParameters(): void
    {
        $response = $this->api->postBoardActivities()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardActivitiesInvalidRequiredParameters(): void
    {
        $response = $this->api->postBoardActivities()
            ->bindRequestParameters([
                'boardid'  => '7',
                'fromdate' => 'not a date',
                'todate'   => 'not a date'
            ])
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
        $this->assertSame('{"request.boardid.0":"Expected argument of type \"integer\", \"string\" given","request.fromdate.0":"Expected argument of type \"DateTime\", \"string\" given","request.todate.0":"Expected argument of type \"DateTime\", \"string\" given"}', $response->getContent());
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetBoardActivitiesOk(): void
    {
        $response = $this->api->postBoardActivities()
            ->bindRequestParameters([
                'boardid'        => 7,
                'fromdate'       => new \DateTime(),
                'todate'         => new \DateTime(),
                'page'           => 1,
                'resultsperpage' => 10,
                'author'         => '',
                'eventtype'      => 'Transitions',
                'textformat'     => 'plain',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testPostCreateNewTaskMissingParameter(): void
    {
        $response = $this->api->postCreateTask()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testPostCreateNewTaskWithStrictMinimum(): void
    {
        $response = $this->api->postCreateTask()
            ->bindRequestParameters([
                'boardid' => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testPostCreateNewTaskWithAllParameter(): void
    {
        $response = $this->api->postCreateTask()
            ->bindRequestParameters([
                'boardid'           => 1,
                'title'             => 'Task',
                'description'       => 'edscription',
                'priority'          => 'Low',
                'assignee'          => 'foo',
                'color'             => 'fff',
                'size'              => '10',
                'tags'              => 'foo,bar',
                'deadline'          => new \DateTime('2019-01-01'),
                'extlink'           => 'https://chaplean.coop',
                'type'              => 'Support',
                'template'          => 'Development',
                'subtasks'          => [
                    [
                        'title'    => 'Delete me',
                        'assignee' => 'None',
                    ]
                ],
                'column'            => 'Backlog',
                'lane'              => '',
                'posiiton'          => 1,
                'exceedingreason'   => false,
                'returntaskdetails' => 1,
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testPostCreateNewTaskWithExtraFields(): void
    {
        $response = $this->api->postCreateTask()
            ->bindRequestParameters([
                'boardid' => 1,
                'Project' => 'Secret',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testPostCreateNewTaskWithWorkflowField(): void
    {
        $response = $this->api->postCreateTask()
            ->bindRequestParameters([
                'boardid'      => 1,
                'workflow'     => 1,
                'workflowid'   => 1,
                'workflowname' => 'Intiatives cards',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTaskDetailsMissingRequiredParameter(): void
    {
        $response = $this->api->postTaskDetails()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTaskDetailsWithRequiredParameters(): void
    {
        $response = $this->api->postTaskDetails()
            ->bindRequestParameters([
                'boardid' => 1,
                'taskid'  => 1
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTaskDetailsWithAllParameter(): void
    {
        $response = $this->api->postTaskDetails()
            ->bindRequestParameters([
                'boardid'    => 1,
                'taskid'     => 1,
                'history'    => 'yes',
                'comments'   => 'yes',
                'event'      => 'move',
                'textformat' => 'html',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTasksDetailsMissingRequiredParameter(): void
    {
        $response = $this->api->postTasksDetails()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTasksDetailsWithRequiredParameters(): void
    {
        $response = $this->api->postTasksDetails()
            ->bindRequestParameters([
                'boardid' => 1,
                'taskid'  => [1, 2],
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetTasksDetailsWithAllParameter(): void
    {
        $response = $this->api->postTasksDetails()
            ->bindRequestParameters([
                'boardid'    => 1,
                'taskid'     => [1, 2],
                'history'    => 'yes',
                'comments'   => 'yes',
                'event'      => 'move',
                'textformat' => 'html',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetAllTasksMissingRequiredParameter(): void
    {
        $response = $this->api->postAllTasks()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetAllTasksWithRequiredParameter(): void
    {
        $response = $this->api->postAllTasks()
            ->bindRequestParameters([
                'boardid'    => 1,
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetAllTasksWithAllParameters(): void
    {
        $response = $this->api->postAllTasks()
            ->bindRequestParameters([
                'boardid'    => 1,
                'subtasks'        => 'yes',
                'comments'        => 'yes',
                'container'       => 'archive',
                'fromdate'        => new \DateTime('2019-01-01'),
                'todate'          => new \DateTime('2019-01-01'),
                'showInitiatives' => '1',
                'version'         => '1',
                'page'            => 1,
                'textformat'      => 'html',
                'column'          => 'Development',
                'lane'            => '',
                'section'         => 'backlog',
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetLogTimeActivitiesMissingRequiredParameters(): void
    {
        $response = $this->api->postLogTimeActivities()
            ->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetLogTimeActivitiesWithRequiredParameters(): void
    {
        $response = $this->api->postLogTimeActivities()
            ->bindRequestParameters([
                'fromdate' => new \DateTime('2019-01-01'),
                'todate'   => new \DateTime('2019-01-01'),
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\KanbanizeApiClientBundle\Api\KanbanizeApiV1
     *
     * @return void
     */
    public function testGetLogTimeActivitiesWithAllParameter(): void
    {
        $response = $this->api->postLogTimeActivities()
            ->bindRequestParameters([
                'fromdate' => new \DateTime('2019-01-01'),
                'todate'   => new \DateTime('2019-01-01'),
                'author'   => 'foo'
            ])
            ->exec();

        $this->assertNotInstanceOf(InvalidParameterResponse::class, $response);
    }
}
