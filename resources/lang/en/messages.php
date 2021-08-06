<?php
declare(strict_types=1);

return [
    'ads' => [
        'not_exists' => 'Ads not exists. Section: :section, ID: :id.'
    ],

    'app_user' => [
        'not_active' => 'User with ID of :id is not active.',
        'unable_to_upload_avatar' => 'Unable to upload avatar. ID: :id. Message: :message',
    ],

    'content' => [
        'not_exists' => 'Content is not exists. Content ID: :contentId',
    ],

    'domain' => [
        'response' => [
            'invalid_transformer_class' => 'Invalid transformer class. :class',
            'no_pagination' => 'Response Paginator is missing.'
        ],
        'unsupported_processor' => 'Unsupported processor for :processor',
    ],

    'playlist' => [
        'already_exists' => 'Playlist with name of :name is already exists.',
        'content_not_exists' => 'Content with ID of :id is not exists.',
        'not_exists' => 'Playlist is not exists.',
        'delete_error' => 'Error occurred while deleting playlist with ID of :id.',
        'name_exists' => 'Playlist with name of :name is already exists.',
        'remove_content_failed' => 'Failed to remove content from your playlist. Content with ID of :id is not exists on your playlist.'
    ],

    'program' => [
        'not_exists' => 'Program with ID of :id is not exists.',
    ],

    'security' => [
        'invalid_access_token' => 'Invalid :provider access token.',
        'invalid_credentials' => 'Invalid username/password.',
        'invalid_password' => 'Invalid password.',
        'invalid_social_provider' => 'Social provider :provider is not supported.',
        'new_password_sent' => 'New password sent to an email.',
        'unable_to_revoke_token' => 'Unable to revoke token of user with ID of :id',
        'user_exists' => 'Email address is already exists.',
        'user_not_exists' => 'Email address does not exists.',
        'user_id_not_exists' => 'User does not exists.',
        'user_not_active' => 'Inactive user account.',
    ],

    'station' => [
        'not_exists' => 'Station is not exists. Station ID: :id',
        'not_active' => 'Station is not active. Station ID: :id',
    ]
];
