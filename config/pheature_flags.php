<?php

declare(strict_types=1);

use Pheature\Model\Toggle\EnableByMatchingIdentityId;
use Pheature\Model\Toggle\EnableByMatchingSegment;
use Pheature\Model\Toggle\IdentitySegment;
use Pheature\Model\Toggle\InCollectionMatchingSegment;
use Pheature\Model\Toggle\SegmentFactory;
use Pheature\Model\Toggle\StrategyFactory;
use Pheature\Model\Toggle\StrictMatchingSegment;

return [
    'api_prefix' => '',
    'api_enabled' => false,
    'driver' => 'inmemory',
    'segment_types' => [
        [
            'type' => IdentitySegment::NAME,
            'factory_id' => SegmentFactory::class
        ],
        [
            'type' => StrictMatchingSegment::NAME,
            'factory_id' => SegmentFactory::class
        ],
        [
            'type' => InCollectionMatchingSegment::NAME,
            'factory_id' => SegmentFactory::class
        ]
    ],
    'strategy_types' => [
        [
            'type' => EnableByMatchingSegment::NAME,
            'factory_id' => StrategyFactory::class
        ],
        [
            'type' => EnableByMatchingIdentityId::NAME,
            'factory_id' => StrategyFactory::class
        ],
    ],
    'toggles' => [
        'release_toggle_example_1' => [
            'id' => 'release_toggle_example_1',
            'enabled' => false,
            'strategies' => [],
        ],
        'ops_toggle_example_1' => [
            'id' => 'ops_toggle_example_1',
            'enabled' => true,
            'strategies' => [],
        ],
        'experiment_toggle_example_1' => [
            'id' => 'experiment_toggle_example_1',
            'enabled' => true,
            'strategies' => [
                [
                    'strategy_id' => 'rollout_by_location',
                    'strategy_type' => 'enable_by_matching_segment',
                    'segments' => [
                        [
                            'segment_id' => 'requests_from_barcelona',
                            'segment_type' => 'strict_matching_segment',
                            'criteria' => ['location' => 'barcelona'],
                        ],
                    ],
                ],
            ],
        ],
        'permission_toggle_example_1' => [
            'id' => 'permission_toggle_example_1',
            'enabled' => true,
            'strategies' => [
                [
                    'strategy_id' => 'rollout_by_role',
                    'strategy_type' => 'enable_by_matching_segment',
                    'segments' => [
                        [
                            'segment_id' => 'requests_from_paid_users',
                            'segment_type' => 'strict_matching_segment',
                            'criteria' => ['accountType' => 'paid'],
                        ],
                    ],
                ],
            ],
        ],
    ]
];
