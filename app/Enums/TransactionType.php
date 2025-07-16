<?php

namespace App\Enums;

enum TransactionType: int
{
    case DEPOSIT = 1;
    case WITHDRAWAL = -1;
}
