<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Listing;
use Illuminate\Support\Str;

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

        $messagesArray = [];
        if (!$me['bot']) {
            $channel = config('telegram.channel');
            $offset_id = 0;
            $limit = 100;

            do {
                $messages_Messages = $MadelineProto->messages->getHistory([
                    'peer'        => $channel,
                    'offset_id'   => $offset_id,
                    'offset_date' => 0,
                    'add_offset'  => 0,
                    'limit'       => $limit,
                    'max_id'      => 0,
                    'min_id'      => 0,
                    'hash'        => 0
                ]);

                if(!array_key_exists('messages', $messages_Messages)) {
                    break;
                }

                foreach ($messages_Messages['messages'] as $message) {
                    if(array_key_exists('message', $message)) {
                        $link = '';
                        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#',
                            $message['message'], $matches);
                        if (isset($matches[0])) {
                            $link = $matches[0];
                        }

                        Log::info($message);
                        Log::info('==========================');

                        $data = [
                            'date'        => date('m/d/Y H:i:s', $message['date']),
                            'message'     => $message['message'],
                            'link'        => $link,
                            'views'       => $message['views'],
                            'forwards'    => $message['forwards'],
                            'post_author' => array_key_exists('post_author', $message) ? $message['post_author'] : null,
                            'title'       => ''
                        ];

                        $media = array_key_exists('media', $message) ? $message['media'] : null;

                        if ($media) {
                            try {
                               $MadelineProto->downloadToDir($media, public_path('images_list'));
                               $data['image'] = public_path('images_list').'/'.$media['photo']['id'].'.jpg';
                            } catch (\Exception $e) {

                            }

                            if(array_key_exists('webpage', $media)) {
                                $data['url'] = array_key_exists('url', $media['webpage']) ?
                                    $media['webpage']['url'] : null;
                                $data['title'] = array_key_exists('title', $media['webpage']) ?
                                    $media['webpage']['title'] : null;
                            }
                        }

                        if(!isset($data['url']) && isset($data['link'][0])) {
                            $data['url'] = $data['link'][0];
                        }

                        if(!isset($data['title']) && isset($data['message'])) {
                            $first = explode('.', $data['message']);
                            if($first) {
                                $data['title'] =  $first[0];
                            }
                        }

                        Listing::create([
                            'user_id'        => 1,
                            'title'          => $data['title'],
                            'slug'           => Str::slug($data['title']),
                            'company'        => $data['post_author'],
                            'location'       => 'Germany',
                            'logo'           => array_key_exists('image', $data) ? $data['image'] : null,
                            'is_highlighted' => false,
                            'is_active'      => false,
                            'content'        => $data['message'],
                            'apply_link'     => array_key_exists('url', $data) ? $data['url'] : '',
                        ]);

                        $messagesArray[] = $data;
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

        Log::channel('telegram')->info(print_r($messagesArray, true));

        return 0;
    }
}
