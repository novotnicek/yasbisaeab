<?php

namespace App\Model\Enum;

use App\Model\Enum\Interface\HasLabelInterface;

enum UserRoleEnum: string implements HasLabelInterface
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';

    
    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'Commentator',
        };
    }

    static public function getChoices(): array
    {
        $roles = [];

        foreach (self::cases() as $role) {
            $roles[$role->getLabel()] = $role->value;
        }

        return $roles;
    }
}
