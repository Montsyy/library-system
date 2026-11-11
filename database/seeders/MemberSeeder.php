<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_code' => 'LS001',
                'name' => 'Mizuki',
                'email' => 'Mizuki@example.com',
            ],
            [
                'member_code' => 'LS002',
                'name' => 'Rizki',
                'email' => 'Rizki@example.com',
            ],
            [
                'member_code' => 'LS003',
                'name' => 'Ayu',
                'email' => 'Ayu@example.com',
            ]

        ];

        foreach ($members as $member) {
            \App\Models\Member::updateOrCreate(
                ['member_code' => $member['member_code']],
                $member
            );
        }
    }
}
