<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class AppKeyGenerate extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keys:generate:app
                    {--show : Display the key instead of modifying files}
                    {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the app key';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $key = $this->generateRandomKey();

        if ($this->option('show')) {
            $this->line('<comment>'.$key.'</comment>');
            return;
        }

        // Next, we will replace the app key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($key)) {
            return;
        }

        $this->laravel['config']['app.key'] = $key;

        $this->info("APP key [$key] set successfully.");
    }

    /**
     * Generate a random key for the APP.
     *
     * @return string
     * @throws Exception
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(random_bytes(
                $this->laravel['config']['app.cipher'] === 'AES-128-CBC' ? 16 : 32
            ));
    }

    /**
     * Set the API key in the environment file.
     *
     * @param  string  $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key)
    {
        $currentKey = $this->laravel['config']['app.key'] ?: env('APP_KEY');

        if ($currentKey !== '' && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key)
    {
        file_put_contents($this->laravel->basePath('.env'), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents($this->laravel->basePath('.env'))
        ));
    }

    /**
     * Get a regex pattern that will match env API_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $currentKey = $this->laravel['config']['app.key'] ?: env('APP_KEY');
        $escaped = preg_quote('='.$currentKey, '/');

        return "/^APP_KEY{$escaped}/m";
    }
}