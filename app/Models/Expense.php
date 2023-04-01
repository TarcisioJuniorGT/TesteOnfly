<?php

namespace App\Models;

use App\Policies\ExpensePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Expense extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['description', 'date', 'id_user', 'value', 'email'];
    protected $policy = ExpensePolicy::class;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
