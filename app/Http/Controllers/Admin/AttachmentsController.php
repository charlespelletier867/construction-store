<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;

class AttachmentsController extends SchemaResourceController
{
    protected string $modelClass = Attachment::class;
    protected string $viewPrefix = 'admin.attachments';
    protected string $routePrefix = 'admin.attachments';
    protected array $indexColumns = ['id', 'attachable_type', 'attachable_id', 'file_name', 'mime_type', 'uploaded_by'];

    public function __construct()
    {
        $this->singular = 'Attachment';
        $this->pluralLabel = 'Attachments';
    }
}
