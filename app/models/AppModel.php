<?php

namespace app\models;

use computerShop\base\Model;

class AppModel extends Model
{

    protected function validateSpecialChars($value): string
    {
        return htmlspecialchars($value);
    }

    protected function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    protected function validateNumber($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }
}
