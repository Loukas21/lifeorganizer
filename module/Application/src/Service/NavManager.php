<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        $items[] = [
            'id' => 'home',
            'label' => 'Strona główna',
            'link'  => $url('home')
        ];

        $items[] = [
            'id' => 'about',
            'label' => 'O aplikacji',
            'link'  => $url('about')
        ];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Zaloguj się',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {

            // Determine which items must be displayed in Admin dropdown.
            $adminDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'users',
                            'label' => 'Użytkownicy',
                            'link' => $url('users')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'roles',
                            'label' => 'Role',
                            'link' => $url('roles')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'permissions',
                            'label' => 'Uprawnienia',
                            'link' => $url('permissions')
                        ];
            }

            if (count($adminDropdownItems)!=0) {
                $items[] = [
                    'id' => 'admin',
                    'label' => 'Admin',
                    'dropdown' => $adminDropdownItems
                ];
            }

            $activitiesDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'tasks.manage')) {
                $activitiesDropdownItems[] = [
                            'id' => 'tasks',
                            'label' => 'Zadania',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'habbits.manage')) {
                $activitiesDropdownItems[] = [
                            'id' => 'habbits',
                            'label' => 'Nawyki',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'events.manage')) {
                $activitiesDropdownItems[] = [
                            'id' => 'events',
                            'label' => 'Wydarzenia',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'notifications.manage')) {
                $activitiesDropdownItems[] = [
                            'id' => 'notifications',
                            'label' => 'Powiadomienia',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'ideas.manage')) {
                $activitiesDropdownItems[] = [
                            'id' => 'ideas',
                            'label' => 'Pomysły',
                            'link' => $url('about')
                        ];
            }

            if (count($activitiesDropdownItems)!=0) {
              $items[] = [
                  'id' => 'activities',
                  'label' => 'Działalność',
                  'dropdown' => $activitiesDropdownItems
              ];
            }

            $healthDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'medicaltests.manage')) {
                $healthDropdownItems[] = [
                            'id' => 'medicaltests',
                            'label' => 'Wyniki badań',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'symptomdiary.manage')) {
                $healthDropdownItems[] = [
                            'id' => 'symptomdiary',
                            'label' => 'Dziennik objawów',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'blooddonation.manage')) {
                $healthDropdownItems[] = [
                            'id' => 'blooddonation',
                            'label' => 'Krwiodawstwo',
                            'link' => $url('about')
                        ];
            }

            if (count($healthDropdownItems)!=0) {
              $items[] = [
                  'id' => 'health',
                  'label' => 'Zdrowie',
                  'dropdown' => $healthDropdownItems
              ];
            }

            $financeDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'homebudget.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'homebudget',
                            'label' => 'Budżet domowy',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'accounts.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'accounts',
                            'label' => 'Konta',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'banking.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'banking',
                            'label' => 'Bankowość',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'investments.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'investments',
                            'label' => 'Inwestycje',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'wealth.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'wealth',
                            'label' => 'Majątek',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'taxes.manage')) {
                $financeDropdownItems[] = [
                            'id' => 'taxes',
                            'label' => 'Podatki',
                            'link' => $url('about')
                        ];
            }

            if (count($financeDropdownItems)!=0) {
              $items[] = [
                  'id' => 'finance',
                  'label' => 'Finanse',
                  'dropdown' => $financeDropdownItems
              ];
            }

            $experienceDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'education.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'education',
                            'label' => 'Wykształcenie',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'skills.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'skills',
                            'label' => 'Umiejętności',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'workplaces.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'workplaces',
                            'label' => 'Miejsca pracy',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'languages.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'languages',
                            'label' => 'Języki',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'authorities.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'authorities',
                            'label' => 'Autorytety',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'interests.manage')) {
                $experienceDropdownItems[] = [
                            'id' => 'interests',
                            'label' => 'Zainteresowania',
                            'link' => $url('about')
                        ];
            }

            if (count($experienceDropdownItems)!=0) {
              $items[] = [
                  'id' => 'experience',
                  'label' => 'Doświadczenie',
                  'dropdown' => $experienceDropdownItems
              ];
            }

            $referencesDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'quotes.manage')) {
                $referencesDropdownItems[] = [
                            'id' => 'quotes',
                            'label' => 'Cytaty',
                            'link' => $url('quotes')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'books.manage')) {
                $referencesDropdownItems[] = [
                            'id' => 'books',
                            'label' => 'Książki',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'recordings.manage')) {
                $referencesDropdownItems[] = [
                            'id' => 'recordings',
                            'label' => 'Nagrania',
                            'link' => $url('about')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'files.manage')) {
                $referencesDropdownItems[] = [
                            'id' => 'files',
                            'label' => 'Pliki',
                            'link' => $url('about')
                        ];
            }

            if (count($referencesDropdownItems)!=0) {
              $items[] = [
                  'id' => 'references',
                  'label' => 'Materiały',
                  'dropdown' => $referencesDropdownItems
              ];
            }

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Ustawienia',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Wyloguj się',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }

        return $items;
    }
}
