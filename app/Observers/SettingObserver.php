<?php

namespace App\Observers;

use App\Setting;
use App\Helpers\SettingHelper;

class SettingObserver
{
    public function saved(Setting $setting)
    {
        SettingHelper::invalidateVersion();
    }

    public function deleted(Setting $setting)
    {
        SettingHelper::invalidateVersion();
    }
}