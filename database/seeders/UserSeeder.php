<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Seed the User database table
     *
     * @return void
     */
    public function run(): void
    {
        $seedUsers = [
            [
                'email' => 'admin@plums.com',
                'password' => 'Password1',
                'profile' => [
                    'given_name' => 'Adrian',
                    'family_name' => 'Smith',
                    'city' => 'Birmingham',
                    'country' => 'GBR',
                ],
            ],
            [
                'email' => 'lsd@plums.com',
                'password' => 'Password2',
                'profile' => [
                    'given_name' => 'Alice',
                    'family_name' => 'Dee',
                    'city' => 'Sacramento',
                    'country' => 'USA',
                ],
            ],
            [
                'email' => 'jd@plums.com',
                'password' => 'Password3',
                'profile' => [
                    'given_name' => 'John',
                    'family_name' => 'Doe',
                    'city' => 'Perth',
                    'country' => 'AUS',
                ],
            ],
            [
                'email' => 'peter123@example.com',
                'password' => 'Password4',
                'profile' => [
                    'given_name' => 'Peter',
                    'family_name' => 'Smith',
                    'city' => 'Miami',
                    'country' => 'USA',
                ],
            ],
            [
                'email' => 'bob123@hotmail.com',
                'password' => 'Password5',
                'profile' => [
                    'given_name' => 'Bob',
                    'family_name' => 'Downe',
                    'city' => 'Auckland',
                    'country' => 'NZL',
                ],
            ],
        ];

        $countItems = count($seedUsers);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems Users ...");

        foreach ($seedUsers as $item) {
            $user['email'] = $item['email'];
            $user['password'] = Hash::make($item['password']);
            $profile['given_name'] = $item['profile']['given_name'];
            $profile['family_name'] = $item['profile']['family_name'];
            $profile['city'] = $item['profile']['city'];
            $profile['country'] = $item['profile']['country'];
            $user['profile'] = $profile;
            User::create($user);
            UserProfile::create($profile);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}
