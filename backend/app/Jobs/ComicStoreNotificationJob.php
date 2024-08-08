<?php

declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Packages\Infrastructure\Service\Notification\NotificationServiceInterface;

class ComicStoreNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $comic) {}

    /**
     * Execute the job.
     *
     *
     * @throws InvalidArgumentException
     */
    public function handle(NotificationServiceInterface $service): void
    {
        try {
            if (! isset($this->comic['id'])) {
                throw new InvalidArgumentException('Comic id is not provided.');
            }
            $message = sprintf(
                'Comic has been stored. id:%d',
                $this->comic['id']
            );
            $service->send($message);
        } catch (Exception $e) {
            Log::error('Failed to send notification: ', [
                'error' => $e->getMessage(),
                'params' => json_encode($this->comic),
            ]);

            throw $e;
        }
    }
}
