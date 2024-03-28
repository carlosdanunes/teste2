<?php

namespace App\Enum;

enum GatewayType: string
{
    case EzzeBank = 'ezzebank';
    case SuitPay = 'suitpay';
    case GamePix = 'gamepix';
}
