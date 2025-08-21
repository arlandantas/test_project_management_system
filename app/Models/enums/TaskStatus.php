<?php

namespace App\Models\enums;

enum TaskStatus: string
{
    case Pending = 'Pending';
    case Inactive = 'Inactive';
    case Completed = 'Completed';
}
