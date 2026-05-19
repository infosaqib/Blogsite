<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\Attributes\WithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

#[WithQueue(
    connection: 'database',
    queue: 'emails',
    tries: 3,
    timeout: 30
)]
class SendWelcomeEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw(
            "Hi {$this->user->name}, welcome to our blog! 🎉\n\nWe're glad to have you. ",
            function ($message) {
                $message->to($this->user->email)->subject('Welcome to our Blog!');
            }
        );
    }

    public function failed(\Throwable $exception): void
    {
        //Log the failure
        \Log::error('Welcome email failed for user: ' . $this->user->id, [
            'error' => $exception->getMessage(),
        ]);
    }
}
