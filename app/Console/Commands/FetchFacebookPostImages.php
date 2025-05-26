<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\FacebookPost;


class FetchFacebookPostImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature    = 'fetch:facebook-posts';
    protected $description  = 'Fetches Facebook post images and stores them in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch data from the URL
        $response = Http::get('https://graph.facebook.com/v18.0/110337085309622?fields=posts%7Bfull_picture%7D&access_token=EAAEU5c4qbN0BO395hfm5ZCNBr6t10DZAYoYHNlkr6o572SGaVdWSO81bdZASRuQRRVQyTtbZC3hv39dmcgYlr0GLZBYwdJXicbZBmObXkD8HpRmeMaBmcTwSMbZB8tqGnNZC2uBHKTnDCOF8u8IqAmOsZB2DIXFwyAU8pnxZCTZCiAkgJkGjrSYXzee7t4iFmpC');

         $data = $response->json();

        // Check if $data['posts']['data'] is set and not empty
        if (isset($data['posts']['data']) && is_array($data['posts']['data']) && count($data['posts']['data']) > 0) {
            $posts = array_slice($data['posts']['data'], 0, 10); // Limit the posts to 10

            // Save the data in the database
            // Make sure to adjust the saving logic as per your database structure
            FacebookPost::truncate(); // Delete old records
            foreach ($posts as $post) {
                FacebookPost::create([
                    'image_url' => $post['full_picture'],
                    'post_id' => $post['id']
                    // Add other necessary fields here
                ]);
            }

            $this->info('Facebook post images fetched and stored successfully!');
        } else {
            $this->error('No data found in the response or data structure is not as expected!');
        }

    }
}
