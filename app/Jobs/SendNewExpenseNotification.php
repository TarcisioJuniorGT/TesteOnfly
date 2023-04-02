<?php

namespace App\Jobs;

use App\Models\Expense;
use App\Notifications\NewExpenseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewExpenseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Notifiable;

    public $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }


    public function handle(): void
    {
        $this->expense->notify(new NewExpenseNotification($this->expense));
    }
}
