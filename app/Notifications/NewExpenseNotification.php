<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Expense;

class NewExpenseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $expense;
    /**
     * Create a new notification instance.
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Expense')
            ->greeting('Hello ' . $this->expense->user->name)
            ->line('A new expense has been registered!')
            ->line('Description: ' . $this->expense->description)
            ->line('Value: ' . $this->expense->value)
            ->line('Date: ' . $this->expense->date);
    }
}
