<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckLikesThreshold extends Command
{
    protected $signature = 'likes:check-threshold';
    protected $description = 'Check if any person has received more than 50 likes and send email notification';

    public function handle()
    {
        $threshold = 50;
        
        $popularPeople = Person::withCount('likes')
            ->having('likes_count', '>=', $threshold)
            ->get();

        foreach ($popularPeople as $person) {
            $alreadyNotified = EmailNotification::where('person_id', $person->id)
                ->where('like_count', '>=', $threshold)
                ->exists();

            if (!$alreadyNotified) {
                $this->sendEmailToAdmin($person);
                
                EmailNotification::create([
                    'person_id' => $person->id,
                    'like_count' => $person->likes_count,
                    'sent_at' => now(),
                ]);

                $this->info("Email sent for {$person->name} with {$person->likes_count} likes");
            }
        }

        $this->info('Threshold check completed');
        return Command::SUCCESS;
    }

    private function sendEmailToAdmin($person)
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@mailinator.com');
        
        try {
            Mail::raw(
                "Person {$person->name} (ID: {$person->id}) has received {$person->likes_count} likes!",
                function ($message) use ($adminEmail, $person) {
                    $message->to($adminEmail)
                        ->subject("Popular Person Alert: {$person->name}");
                }
            );
        } catch (\Exception $e) {
            Log::error("Failed to send email: " . $e->getMessage());
        }
    }
}
