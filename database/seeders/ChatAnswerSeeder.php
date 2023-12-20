<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = [
            [
                'question' => 1,
                'answer' => 'Online advertising',
            ],
            [
                'question' => 1,
                'answer' => 'Social media',
            ],
            [
                'question' => 1,
                'answer' => 'Word of mouth',
            ],
            [
                'question' => 1,
                'answer' => 'Print media',
            ],
            [
                'question' => 1,
                'answer' => 'Other (please specify)',
            ],
            [
                'question' => 2,
                'answer' => 'less than 1000 sq. ft.',
            ],
            [
                'question' => 2,
                'answer' => '1000-2000 sq. ft.',
            ],
            [
                'question' => 2,
                'answer' => 'more than 2000 sq. ft.',
            ],
            [
                'question' => 3,
                'answer' => '1',
            ],
            [
                'question' => 3,
                'answer' => '2',
            ],
            [
                'question' => 3,
                'answer' => '3',
            ],
            [
                'question' => 3,
                'answer' => 'more than 3',
            ],
            [
                'question' => 5,
                'answer' => 'Less than 25lakh',
            ],
            [
                'question' => 5,
                'answer' => '25lakh - 50lakh',
            ],
            [
                'question' => 5,
                'answer' => '50Lakh - 1crore',
            ],
            [
                'question' => 5,
                'answer' => 'more than 1 crore',
            ],
            [
                'question' => 4,
                'answer' => 'Yes, I have secured financing. Details: [Provide details here]',
            ],
            [
                'question' => 4,
                'answer' => 'No, I have not secured financing but interested in assistance.',
            ],
            [
                'question' => 7,
                'answer' => 'For personal use',
            ],
            [
                'question' => 7,
                'answer' => 'For investment',
            ],
            [
                'question' => 8,
                'answer' => 'in 1 - 2 months',
            ],
            [
                'question' => 8,
                'answer' => 'in 2-4 months',
            ],
            [
                'question' => 8,
                'answer' => 'in 4-6 months',
            ],
            [
                'question' => 8,
                'answer' => 'in 6-12 months',
            ],
            [
                'question' => 9,
                'answer' => 'in 1 - 2 months',
            ],
            [
                'question' => 9,
                'answer' => 'in 2-4 months',
            ],
            [
                'question' => 9,
                'answer' => 'in 4-6 months',
            ],
            [
                'question' => 9,
                'answer' => 'in 6-12 months',
            ],
            [
                'question' => 10,
                'answer' => 'No specific time constraints',
            ],
            [
                'question' => 10,
                'answer' => 'Other considerations: [Specify other considerations]',
            ],
        ];

        DB::table('chat_answer')->insert($answers);
    }
}
