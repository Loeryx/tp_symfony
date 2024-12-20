<?php

namespace App\Enum;

enum RestaurantCategoryEnum: string
{
    case FRENCH = 'french';
    case ITALIAN = 'italian';
    case JAPANESE = 'japanese';
    case CHINESE = 'chinese';
    case SPANISH = 'spanish';
    case AMERICAN = 'american';
    case MEXICAN = 'mexican';
    case INDIAN = 'indian';
}