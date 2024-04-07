<?php

namespace App\Enums;

enum PaymentStatusEnum : string {
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}