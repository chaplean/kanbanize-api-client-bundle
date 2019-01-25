<?php

namespace Chaplean\Bundle\KanbanizeApiClientBundle\Api;

use Chaplean\Bundle\ApiClientBundle\Api\AbstractApi;
use Chaplean\Bundle\ApiClientBundle\Api\Parameter;
use Chaplean\Bundle\ApiClientBundle\Api\Route;
use GuzzleHttp\ClientInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class KanbanizeApiV1.
 *
 * @method Route getProjectsAndBoards()   Get projects and boards     ( https://kanbanize.com/api/#get_projects_and_boards )
 * @method Route postBoardStructure()     Get board structure         ( https://kanbanize.com/api/#get_board_structure )
 * @method Route postFullBoardStructure() Get full board structure    ( https://kanbanize.com/api/#get_full_board_structure )
 * @method Route postBoardSettings()      Get board settings          ( https://kanbanize.com/api/#get_board_settings )
 * @method Route postBoardActivities()    Get board activities        ( https://kanbanize.com/api/#get_board_activities )
 * @method Route postCreateTask()         Create a new task           ( https://kanbanize.com/api/#create_new_task )
 * @method Route postTaskDetails()        Get details for one task    ( https://kanbanize.com/api/#get_task_details )
 * @method Route postTasksDetails()       Get details for many task   ( https://kanbanize.com/api/#get_task_details )
 * @method Route postAllTasks()           Get all tasks for one board ( https://kanbanize.com/api/#get_all_tasks )
 * @method Route postLogTimeActivities()  Create a new task           ( https://kanbanize.com/api/#get_log_time_activities )
 *
 * @package   Chaplean\Bundle\KanbanizeApiClientBundle\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2018 Chaplean (http://www.chaplean.coop)
 */
class KanbanizeApiV1 extends AbstractApi
{
    /** @var string */
    private $apikey;

    /** @var string */
    private $urlPrefix;

    /**
     * KanbanizeApiV1 constructor.
     *
     * @param ClientInterface          $client
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $urlPrefix
     * @param string                   $apikey
     */
    public function __construct(ClientInterface $client, EventDispatcherInterface $eventDispatcher, string $urlPrefix, string $apikey)
    {
        $this->apikey = $apikey;
        $this->urlPrefix = $urlPrefix;

        parent::__construct($client, $eventDispatcher);
    }

    /**
     * Defines the API you want, using the methods of AbstractApi (get, post, …)
     *
     * @return void
     */
    public function buildApi(): void
    {
        $this->globalParameters()
            ->sendJson()
            ->expectsJson()
            ->headers([
                'apikey' => Parameter::string()->defaultValue($this->apikey)
            ])
            ->urlPrefix($this->urlPrefix)
            ->urlSuffix('/format/json');

        $this->get('projectsAndBoards', 'get_projects_and_boards');

        $this->post('boardStructure', 'get_board_structure')
            ->requestParameters([
                'boardid' => Parameter::int()
            ]);

        $this->post('fullBoardStructure', 'get_full_board_structure')
            ->requestParameters([
                'boardid' => Parameter::int()
            ]);

        $this->post('boardSettings', 'get_board_settings')
            ->requestParameters([
                'boardid' => Parameter::int()
            ])->allowExtraRequestParameters();

        $this->post('boardActivities', 'get_board_activities')
            ->requestParameters([
                'boardid'        => Parameter::int(),
                'fromdate'       => Parameter::dateTime(),
                'todate'         => Parameter::dateTime(),
                'page'           => Parameter::int()->optional(),
                'resultsperpage' => Parameter::int()->optional(),
                'author'         => Parameter::string()->optional(),
                'eventtype'      => Parameter::enum(['Transitions', 'Updates', 'Comments', 'Blocks'])->optional(),
                'textformat'     => Parameter::enum(['plain', 'html'])->optional(),
            ]);

        $this->post('createTask', 'create_new_task')
            ->requestParameters([
                'boardid'           => Parameter::int(),
                'title'             => Parameter::string()->optional(),
                'description'       => Parameter::string()->optional(),
                'priority'          => Parameter::enum(['Low', 'Average', 'High'])->optional(),
                'assignee'          => Parameter::string()->optional(),
                'color'             => Parameter::string()->optional(),
                'size'              => Parameter::string()->optional(),
                'tags'              => Parameter::string()->optional(),
                'deadline'          => Parameter::dateTime()->optional(),
                'extlink'           => Parameter::string()->optional(),
                'type'              => Parameter::string()->optional(),
                'template'          => Parameter::string()->optional(),
                'subtasks'          => Parameter::arrayList(Parameter::object(
                    [
                        'title'    => Parameter::string()->optional(),
                        'assignee' => Parameter::string()->optional(),
                    ]
                ))->optional(),
                'column'            => Parameter::string()->optional(),
                'lane'              => Parameter::string()->optional(),
                'posiiton'          => Parameter::int()->optional(),
                'exceedingreason'   => Parameter::bool()->optional(),
                'returntaskdetails' => Parameter::int()->optional(),
            ])->allowExtraRequestParameters();

        $this->post('taskDetails', 'get_task_details')
            ->requestParameters([
                'boardid'    => Parameter::int(),
                'taskid'     => Parameter::int(),
                'history'    => Parameter::enum(['yes'])->optional(),
                'comments'   => Parameter::enum(['yes'])->optional(),
                'event'      => Parameter::enum(
                    ['move', 'create', 'update', 'block', 'delete', 'comment', 'archived', 'subtask', 'loggedtime']
                )->optional(),
                'textformat' => Parameter::enum(['plain', 'html'])->optional(),
            ]);

        $this->post('tasksDetails', 'get_task_details')
            ->requestParameters([
                'boardid'    => Parameter::int(),
                'taskid'     => Parameter::arrayList(Parameter::int()),
                'history'    => Parameter::enum(['yes'])->optional(),
                'comments'   => Parameter::enum(['yes'])->optional(),
                'event'      => Parameter::enum(
                    ['move', 'create', 'update', 'block', 'delete', 'comment', 'archived', 'subtask', 'loggedtime']
                )->optional(),
                'textformat' => Parameter::enum(['plain', 'html'])->optional(),
            ]);

        $this->post('allTasks', 'get_all_tasks')
            ->requestParameters([
                'boardid'         => Parameter::int(),
                'subtasks'        => Parameter::enum(['yes'])->optional(),
                'comments'        => Parameter::enum(['yes'])->optional(),
                'container'       => Parameter::enum(['archive'])->optional(),
                'fromdate'        => Parameter::dateTime()->optional(),
                'todate'          => Parameter::dateTime()->optional(),
                'showInitiatives' => Parameter::enum(['1'])->optional(),
                'version'         => Parameter::string()->optional(),
                'page'            => Parameter::int()->optional(),
                'textformat'      => Parameter::enum(['plain', 'html'])->optional(),
                'column'          => Parameter::string()->optional(),
                'lane'            => Parameter::string()->optional(),
                'section'         => Parameter::enum(['backlog', 'requested', 'progress', 'done', 'archive'])->optional(),
            ]);

        $this->post('logTimeActivities', 'get_log_time_activities')
            ->requestParameters([
                'fromdate' => Parameter::dateTime(),
                'todate'   => Parameter::dateTime(),
                'author'   => Parameter::string()->optional(),
            ]);
    }
}
