<?php
namespace Publication;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'books' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/books[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\BookController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'recordings' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/recordings[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\RecordingController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\BookController::class => Controller\Factory\BookControllerFactory::class,
            Controller\RecordingController::class => Controller\Factory\RecordingControllerFactory::class
        ],
    ],
    // We register module-provided controller plugins under this key.
    'controller_plugins' => [
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\BookController::class => [
                // Give access to anyone.
                ['actions' => [], 'allow' => '*'],
                // Give access to users having the "books.manage" permission.
                ['actions' => ['index', 'add', 'edit', 'delete'], 'allow' => '+books.manage']
            ],
            Controller\RecordingController::class => [
                // Give access to anyone.
                ['actions' => [], 'allow' => '*'],
                // Give access to users having the "books.manage" permission.
                ['actions' => ['index', 'add', 'edit', 'delete'], 'allow' => '+recordings.manage']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\PublicationManager::class => Service\Factory\PublicationManagerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // We register module-provided view helpers under this key.
    'view_helpers' => [
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
