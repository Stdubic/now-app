<?php

return [
	[
		'type' => 'divider',
		'title' => 'PAGES'
	],
	[
		'title' => 'Dashboard',
		'icon_class' => 'fa fa-chart-line',
		'route' => 'dashboard'
	],
    [
        'title' => 'Categories',
        'icon_class' => 'fa fa-search',
        'items' => [
            [
                'title' => 'Add Category',
                'route' => 'categories.add'
            ],
            [
                'title' => 'List Category',
                'route' => 'categories.list'
            ]
        ]
    ],
    [
        'title' => 'Instances',
        'icon_class' => 'fa fa-map-pin',
        'items' => [
            [
                'title' => 'List Instance',
                'route' => 'instances.list'
            ]
        ]
    ],
    [
        'title' => 'Notifications',
        'icon_class' => 'fa fa-broadcast-tower',
        'items' => [
            [
                'title' => 'Add notification',
                'route' => 'notifications.add'
            ],
            [
                'title' => 'List notifications',
                'route' => 'notifications.list'
            ],

        ]
    ],
    [
        'title' => 'App Users',
        'icon_class' => 'fa fa-users',
        'items' => [
            [
                'title' => 'Add user',
                'route' => 'app-users.add'
            ],
            [
                'title' => 'List users',
                'route' => 'app-users.list'
            ]
        ]
    ],
    [
        'title' => 'App Clients',
        'icon_class' => 'fa fa-users',
        'items' => [
            [
                'title' => 'Add user',
                'route' => 'app-clients.add'
            ],
            [
                'title' => 'List users',
                'route' => 'app-clients.list'
            ]
        ]
    ],
	[
		'title' => 'Users',
		'icon_class' => 'fa fa-users',
		'items' => [
			[
				'title' => 'Add user',
				'route' => 'users.add'
			],
			[
				'title' => 'List users',
				'route' => 'users.list'
			]
		]
	],
    [
        'title' => 'Terms of service',
        'icon_class' => 'fa fa-print',
        'items' => [
            [
                'title' => 'Set Terms of service',
                'route' => 'tos.edit'
            ]
        ]
    ],
    [
        'title' => 'Feedback messages',
        'icon_class' => 'fa fa-comments',
        'items' => [
            [
                'title' => 'Add Feedback message',
                'route' => 'feedback.add'
            ],
            [
                'title' => 'List Feedback message',
                'route' => 'feedback.list'
            ]
        ]
    ],
    [
		'title' => 'Roles',
		'icon_class' => 'fa fa-ban',
		'items' => [
			[
				'title' => 'Add role',
				'route' => 'roles.add'
			],
			[
				'title' => 'List roles',
				'route' => 'roles.list'
			]
		]
	],
	[
		'title' => 'Administration',
		'icon_class' => 'fa fa-cogs',
		'items' => [
			[
				'title' => 'Settings',
				'route' => 'settings.edit'
			],
			[
				'title' => 'Technical info',
				'route' => 'tech-info'
			]
		]
	],
];