<?php

namespace Chaplean\Bundle\KanbanizeApiClientBundle\Api;

use Chaplean\Bundle\ApiClientBundle\Api\AbstractApi;
use Chaplean\Bundle\ApiClientBundle\Api\Parameter;
use Chaplean\Bundle\ApiClientBundle\Api\Route;
use GuzzleHttp\ClientInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class KanbanizeApiV2.
 *
 * @method Route getBoards()            Get a list of boards                       ( #/Boards/getBoards )
 * @method Route getChildCards()        Get a list of child cards                  ( #/Child_Cards/getChildCards )
 * @method Route putChildCard()         Make a card a child of a given card        ( #/Child_Cards/addChildCard )
 * @method Route getParentCards()       Get a list of parent cards                 ( #/Parent_Cards/getParentCards )
 * @method Route putParentCard()        Make a card a parent of a given card       ( #/Parent_Cards/addParentCard )
 * @method Route getPredecessorCards()  Get a list of predecessor cards            ( #/Predecessor_Cards/getPredecessorCards )
 * @method Route putPredecessorCard()   Make a card a predecessor of a given card  ( #/Predecessor_Cards/addPredecessorCard )
 * @method Route getSuccessorCards()    Get a list of successor cards              ( #/Successor_Cards/getSuccessorCards )
 * @method Route putSuccessorCard()     Make a card a successor of a given card    ( #/Successor_Cards/addSuccessorCard )
 *
 * @package   Chaplean\Bundle\KanbanizeApiClientBundle\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2019 Chaplean (https://www.chaplean.coop)
 */
class KanbanizeApiV2 extends AbstractApi
{
    /** @var string */
    private $apikey;

    /** @var string */
    private $urlPrefix;

    /**
     * KanbanizeApi constructor.
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
            ->urlPrefix($this->urlPrefix);

        // Boards

        $this->get('boards', '/boards')
            ->queryParameters([
                'board_ids'                       => Parameter::arrayList(Parameter::int())->optional(),
                'project_ids'                     => Parameter::arrayList(Parameter::int())->optional(),
                'is_archived'                     => Parameter::enum([0, 1])->optional(),
                'if_assigned'                     => Parameter::enum([0, 1])->optional(),
                'cards_workflow_exists'           => Parameter::enum([0, 1])->optional(),
                'cards_workflow_is_enabled'       => Parameter::enum([0, 1])->optional(),
                'initiatives_workflow_exists'     => Parameter::enum([0, 1])->optional(),
                'initiatives_workflow_is_enabled' => Parameter::enum([0, 1])->optional(),
                'fields'                          => Parameter::enum(['board_id', 'project_id', 'is_archived', 'name'])->optional(),
                'expand'                          => Parameter::arrayList(Parameter::string())->optional()
            ]);


        // Child cards

        $this->get('childCards', '/cards/{card_id}/children')
            ->urlParameters([
                'card_id' => Parameter::int(),
            ]);

        $this->put('childCard', '/cards/{card_id}/children/{child_card_id}')
            ->urlParameters([
                'card_id'       => Parameter::int(),
                'child_card_id' => Parameter::int(),
            ]);

        // Parent cards

        $this->get('parentCards', '/cards/{card_id}/parents')
            ->urlParameters([
                'card_id' => Parameter::int(),
            ]);

        $this->put('parentCard', '/cards/{card_id}/parents/{parent_card_id}')
            ->urlParameters([
                'card_id'        => Parameter::int(),
                'parent_card_id' => Parameter::int(),
            ]);

        // Predecessor cards

        $this->get('predecessorCards', '/cards/{card_id}/predecessors')
            ->urlParameters([
                'card_id' => Parameter::int(),
            ]);

        $this->put('predecessorCard', '/cards/{card_id}/predecessors/{predecessor_card_id}')
            ->urlParameters([
                'card_id'             => Parameter::int(),
                'predecessor_card_id' => Parameter::int(),
            ]);

        // Successor cards

        $this->get('successorCards', '/cards/{card_id}/successors')
            ->urlParameters([
                'card_id' => Parameter::int(),
            ]);

        $this->put('successorCard', '/cards/{card_id}/successors/{successor_card_id}')
            ->urlParameters([
                'card_id'           => Parameter::int(),
                'successor_card_id' => Parameter::int(),
            ]);
    }
}
