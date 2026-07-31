<?php

namespace App\Traits;

use App\Interfaces\HasMediaUrlInterface;

trait MediaUrlTrait
{
    private function mediaUrl(HasMediaUrlInterface $model): string
    {
        $url = $model->getFirstMediaUrl('images');

        return preg_replace('/^\/storage\/(\d+)\//', '/media/$1/', $url);
    }
}
