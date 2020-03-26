<?php

namespace Bitaac\Account\Models;

use Google2FA;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BitaacAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '__bitaac_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'admin', 'email_change_time', 'email_change_new', 'reckey', 'last_login', 'total_points', 'points', 'secret'];

    /**
     * Renew the last_login value.
     *
     * @return void
     */
    public function updateLastLogin()
    {
        $this->last_login = Carbon::now()->toDateTimeString();
        $this->save();
    }

    /**
     * Generate a Two Factor Authentication secret to account.
     *
     * @return void
     */
    public function generateSecret()
    {
        $this->secret = Google2FA::generateSecretKey();
        $this->save();
    }

    /**
     * Set the account's admin status.
     *
     * @param  string  $value
     * @return void
     */
    public function setAdminAttribute($value)
    {
        $this->attributes['admin'] = (boolean) $value;
    }
}
