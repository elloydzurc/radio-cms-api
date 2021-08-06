<?php
declare(strict_types=1);

return [
    'age_restrictions' => [
        [
            'code' => 'all-ages',
            'name' => 'All Ages',
            'minimum_age' => 0,
            'maximum_age' => 999
        ],
        [
            'code' => '13-plus',
            'name' => '13+',
            'minimum_age' => 13,
            'maximum_age' => 999,
        ],
        [
            'code' => '18-plus',
            'name' => '18+',
            'minimum_age' => 18,
            'maximum_age' => 999,
        ],
    ],
    
    'allowed_featured_station' => 3,

    'allowed_tune_in_station' => 1,

    'allowed_tune_in_station_content' => 1,

    'app_mobile_url' => env('APP_MOBILE_URL'),

    'avatar_logo_thumbnail' => [
        'allowed_file_type' => 'jpg,jpeg,png',
        'dimensions' =>  'min_width=100,min_height=100,max_width=350,max_height=350'
    ],

    'content' => [
        'max_upload_size' => 1024000,
        'allowed_file_types' => 'wav,mp3,aac,wma,avi,mp4,wmv,flv,mov'
    ],

    'permissions' => [
        'app_user' => [
            'Create App User',
            'Read App User',
            'Update App User',
            'Delete App User',
            'Restore App User'
        ],
        'user' => [
            'Create User',
            'Read User',
            'Update User',
            'Delete User',
            'Restore User'
        ],
        'role' => [
            'Create Role',
            'Read Role',
            'Update Role',
            'Delete Role',
            'Restore Role'
        ],
        'permission' => [
            'Create Permission',
            'Read Permission',
            'Update Permission',
            'Delete Permission',
            'Restore Permissions'
        ],
        'station' => [
            'Create Station',
            'Read Station',
            'Update Station',
            'Delete Station',
            'Restore Station'
        ],
        'station_content_on_demand' => [
            'Create Content On Demand',
            'Read Content On Demand',
            'Update Content On Demand',
            'Delete Content On Demand',
            'Restore Content On Demand'
        ],
        'station_content_stream' => [
            'Create Content Live Stream',
            'Read Content Live Stream',
            'Update Content Live Stream',
            'Delete Content Live Stream',
            'Restore Content Live Stream'
        ],
        'audit_trail' => [
            'Read Audit Trail'
        ],
        'program' => [
            'Create Program',
            'Read Program',
            'Update Program',
            'Delete Program',
            'Restore Program'
        ],
        'ads' => [
            'Create Ads',
            'Read Ads',
            'Update Ads',
            'Delete Ads',
            'Restore Ads'
        ],
        'push_notification' => [
            'Create Push Notification',
            'Read Push Notification',
            'Update Push Notification',
            'Delete Push Notification',
            'Restore Push Notification'
        ],
        'reports' => [
            'Download App Users',
            'Download Programs',
            'Download Channels',
            'Download Episodes',
        ],
        'comments' => [
            'Update Comment',
            'Read Comment',
            'Delete Comment',
            'Restore Comment',
        ],
    ],
];
