<?php

namespace App;

use App\Models\Theme;

trait CmsTrait
{
    public function default_template()
    {
        $theme = Theme::where('status', 'active')->first();

        if ($theme) {
            $themeFolder = $theme->folder;
        } else {
            $themeFolder = "theme.default";
        }

        return $themeFolder;
    }
}
