<?php

namespace Nieeonliv\AConstructor\Actions;

use Illuminate\Support\Facades\File;

class FindModelsAction
{
    public function handle(): array
    {
        $directory = app_path('Models');
        $modelPaths = [];

        foreach (File::allFiles($directory) as $file) {
            $filePath = str_replace(app_path('Models') . '/', '', $file->getPathname());
            $filePath = str_replace('.php', '', $filePath);
            $modelPaths[] = $filePath;
        }

        return $modelPaths;
    }
}
