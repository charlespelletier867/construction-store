<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;

class NotificationsController extends SchemaResourceController
{
    protected string $modelClass = Notification::class;
    protected string $viewPrefix = 'admin.notifications';
    protected string $routePrefix = 'admin.notifications';
    protected array $indexColumns = ['id', 'notification_type', 'event_type', 'title', 'user_id', 'is_read'];

    public function __construct()
    {
        $this->singular = 'Notification';
        $this->pluralLabel = 'Notifications';
    }
}
