<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin [options]
                            {--name= : name of user}
                            {--email= : email of user}
                            {--password= : password of user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'makes an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminRole = Role::findByName('admin');

        if ($adminRole) {
            $name = $this->option('name') ?? $this->ask('Name');
            $email = $this->option('email') ?? $this->ask('E-mail');
            $password = $this->secret('Password');

            $user = User::where('email', $email)->first();

            if ($user) {
                return $this->error('User already exists');
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->assignRole($adminRole);

            $this->info("{$user->email} user created successfully...");
        }
    }
}
