<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Subject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $questions = [
            [
                'question' => 'متى ينتهي الشوب',
                'answers' => [
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'بعد منتصف الليل',
                        'state' => 1,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند المغرب',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند العصر',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند الظهر',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند العشاء',
                        'state' => 0,
                    ],
                ],
            ],
            [
                'question' => 'متى ينتهي البرد',
                'answers' => [
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'بعد منتصف الليل',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند الصيف',
                        'state' => 1,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند العصر',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند الظهر',
                        'state' => 0,
                    ],
                    [
                        'answer_uuid' => Str::uuid(),
                        'answer' => 'عند العشاء',
                        'state' => 0,
                    ],
                ],
            ],
        ];

        return [
            'uuid' => Str::uuid(),
            'subject_id' => Subject::all()->random()->id,
            'question' => $this->faker->randomElement($questions),
            'reference' => $this->faker->url,
            'is_book' => $this->faker->randomElement([0, 1]),
            'mark' => $this->faker->numberBetween(1, 2),
            'date' => $this->faker->date,
        ];
    }
}
