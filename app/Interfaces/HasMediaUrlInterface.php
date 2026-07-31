<?php

namespace App\Interfaces;

interface HasMediaUrlInterface
{
    public function getFirstMediaUrl(string $collectionName): string;
}
