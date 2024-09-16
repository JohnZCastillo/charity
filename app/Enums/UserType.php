<?php

namespace App\Enums;

enum UserType: string{

    case DONOR = 'donor';
    case RECIPIENT = 'recipient';
}
