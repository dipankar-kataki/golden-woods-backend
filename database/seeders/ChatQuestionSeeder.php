<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Question 1
        DB::table('chat_question')->insert([
            'questionNumber' => 1,
            'questionType' => 'choice',
            'question' => 'How did you hear about our real estate project?',
        ]);



        // Question 2
        DB::table('chat_question')->insert([
            'questionNumber' => 2,
            'questionType' => 'choice',
            'question' => 'What is your preferred property size?',
        ]);

        // Question 3
        DB::table('chat_question')->insert([
            'questionNumber' => 3,
            'questionType' => 'choice',
            'question' => 'Preferred number of bedrooms and bathrooms?',
        ]);

        // Question 4
        DB::table('chat_question')->insert([
            'questionNumber' => 4,
            'questionType' => 'subjective',
            'question' => 'Do you have specific features or amenities you are looking for? Please tell.',
        ]);

        // Question 5
        DB::table('chat_question')->insert([
            'questionNumber' => 5,
            'questionType' => 'choice',
            'question' => 'What is your budget range for the real estate investment?',
        ]);

        // Question 6
        DB::table('chat_question')->insert([
            'questionNumber' => 6,
            'questionType' => 'choice',
            'question' => 'Have you secured financing? If yes, please provide details. If not, are you interested in assistance with financing options?',
        ]);


        // Question 7
        DB::table('chat_question')->insert([
            'questionNumber' => 7,
            'questionType' => 'choice',
            'question' => 'Is this property intended for personal use or investment?',
        ]);


        // Question 8
        DB::table('chat_question')->insert([
            'questionNumber' => 8,
            'questionType' => 'choice',
            'question' => 'What is your expected return on investment (ROI) or holding period?',
        ]);

        // Question 9
        DB::table('chat_question')->insert([
            'questionNumber' => 9,
            'questionType' => 'choice',
            'question' => 'What is your expected timeline for making a purchase decision?',
        ]);

        // Question 10
        DB::table('chat_question')->insert([
            'questionNumber' => 10,
            'questionType' => 'choice',
            'question' => 'Are there any specific time constraints or considerations we should be aware of?',
        ]);

        // Question 11
        DB::table('chat_question')->insert([
            'questionNumber' => 11,
            'questionType' => 'subjective',
            'question' => 'Is there anything else you would like to share or inquire about regarding the real estate project?',
        ]);
    }
}
