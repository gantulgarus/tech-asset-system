<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject)
    {
        if (empty($subject)) {
            throw new \InvalidArgumentException("The subject field cannot be empty.");
        }

        $log = [
            'subject' => $subject,
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'ip' => Request::ip(),
            'agent' => Request::header('user-agent'),
            'user_id' => auth()->check() ? auth()->user()->id : null,
        ];

        LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }
}