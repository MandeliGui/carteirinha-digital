<?php

namespace App\Enums;

enum PetsPersistence: string
{
    case UPDATE_PHOTO = 'UPDATE_PHOTO';
    case REMOVE_PHOTO = 'REMOVE_PHOTO';
}
