<?php

namespace DvojkaT\Forumkit\Console\Commands;

use DvojkaT\Forumkit\Providers\ForumConsoleServiceProvider;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum-kit:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install forum-kit';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->comment('Установка начата. Пожалуйста подождите...');

        $this->callSilent("vendor:publish", [
            '--tag' => [
                'forum-kit-migrations',
            ]]);
        $this->info('Перенесены миграции');
        $this->callSilent('migrate');
        $this->info('Запущены миграции');
        $this->callSilent('storage:link');
        $this->changeUserModel();

        $this->info('Установлено!');
    }

    /**
     * @return void
     */
    private function changeUserModel(): void
    {
        $this->info('Попытка обновления модели User');

        if (! file_exists(app_path('Models/User.php'))) {
            $this->warn('Не найдено "app/Models/User.php"');
            return;
        }

        $user = file_get_contents(__DIR__.'/../../Models/User.stub');
        file_put_contents(app_path('Models/User.php'), $user);

    }
}
