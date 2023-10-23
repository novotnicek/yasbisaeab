<?php

namespace App\Model\Enum\Interface;

interface HasLabelInterface
{
    public function getLabel(): string;

    static public function getChoices(): array;
}
