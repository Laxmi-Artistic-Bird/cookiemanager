<?php

namespace Artisticbird\Cookies\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class GetUserdetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $userModelPath = app_path('Models/User.php');

        // Check if the User model exists
        if (File::exists($userModelPath)) {
            $content = File::get($userModelPath);

            // Check if the function already exists in the model
            if (strpos($content, 'function getFullName()') === false) {
                $newFunction = "
    public function getUserdetail()
    {
        return \$this->hasOne('Artisticbird\Cookies\Models\UserDetail','user_id','id');
    }
";
                $content = str_replace('}', $newFunction . "\n}", $content);
                File::put($userModelPath, $content);

                $this->info('Custom function added to User model successfully.');
            } else {
                $this->info('Custom function already exists in User model.');
            }
        } else {
            $this->error('User model not found. Make sure the model is in the correct location.');
        }
    }
}
