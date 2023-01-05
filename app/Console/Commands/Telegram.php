<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Telegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get messages from telegram channel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings['app_info']['api_id'] = config('telegram.api_id');
        $settings['app_info']['api_hash'] = config('telegram.api_hash');

        $MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
        $MadelineProto->start();
        $me = $MadelineProto->getSelf();

        if (!$me['bot']) {
            $channel = config('telegram.channel');
            $offset_id = 0;
            $limit = 100;

            do {
                $messages_Messages = $MadelineProto->messages->getHistory([
                    'peer' => $channel,
                    'offset_id' => $offset_id,
                    'offset_date' => 0,
                    'add_offset' => 0,
                    'limit' => $limit,
                    'max_id' => 0,
                    'min_id' => 0,
                    'hash' => 0 ]);

                if(!array_key_exists('messages', $messages_Messages)) {
                    break;
                }

                foreach ($messages_Messages['messages'] as $message) {
                    if(array_key_exists('message', $message)) {
                        Log::channel('telegram')->info($message['message']);
                    }
                }

                $end =  end($messages_Messages['messages']);
                if(!$end) {
                    break;
                }
                $offset_id = $end['id'];
                sleep(2);
            } while (true);
        }

        return 0;
    }
}
