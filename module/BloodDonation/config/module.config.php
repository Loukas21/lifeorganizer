<?php
namespace BloodDonation;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'blooddonation' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/blooddonation[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\BloodDonationController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\BloodDonationController::class => Controller\Factory\BloodDonationControllerFactory::class,
        ],
    ],
    // We register module-provided controller plugins under this key.
    'controller_plugins' => [
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\BloodDonationController::class => [
                // Give access to anyone.
                ['actions' => [], 'allow' => '*'],
                // Give access to users having the "blooddonation.manage" permission.
                ['actions' => ['index', 'add', 'edit', 'delete'], 'allow' => '+blooddonation.manage']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            //\Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\BloodDonationManager::class => Service\Factory\BloodDonationManagerFactory::class,
            //Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            //Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
            //Service\PermissionManager::class => Service\Factory\PermissionManagerFactory::class,
            //Service\RbacManager::class => Service\Factory\RbacManagerFactory::class,
            //Service\RoleManager::class => Service\Factory\RoleManagerFactory::class,
            //Service\UserManager::class => Service\Factory\UserManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // We register module-provided view helpers under this key.
    'view_helpers' => [
        'factories' => [
        ],
        'aliases' => [
        ],
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
