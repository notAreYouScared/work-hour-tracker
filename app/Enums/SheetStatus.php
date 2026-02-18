<?php

namespace App\Enums;

enum SheetStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case Approved = 'approved';
    case Denied = 'denied';
}
