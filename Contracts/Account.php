<?php

namespace Bitaac\Contracts;

use Illuminate\Contracts\Auth\Authenticatable as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;

interface Account extends Authenticatable, CanResetPassword
{
}
