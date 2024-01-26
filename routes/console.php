<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fill_test', function () {
    $arr = [["My house is big. It ... also very cozy", "are", "am", "in", "is"], ["This girl is my niece. - … is charming!", "it", "I", "he", "She"], ["Where are the children? - … are at school.", "We", "You", "He", "They"], ["The box is … the closet.", "on", "at", "to", "in"], ["I like when my holiday is … summer.", "on", "at", "about", "In"], ["This mountain is … highest in the country.", "a", "an", "the"], ["We have … brown dog.", "an", "the", "a"], ["She has … friends. It’s a pity!", "many", "much", "few", "little"], ["… did you go to India? – Two years ago.", "Why", "Who", "Where", "When"], ["He thinks that this company is … than the others", "much professional", "more professionaler", "much professioaler", "much more professional"], ["Run …! The shop is closing in 15 minutes.", "the faster", "fastest", "the fastest", "faster"], ["When … you … Rome last time? – In 1998.", "do...visit", "have...visited", "had...visisted", "did..visit"], ["She … because your joke is funny.", "laugh", "are laughing", "will laugh", "is laughing"], ["It’s hot here. We … the windows. Don’t close them.", "opened", "has opened", "had opened", "have opened"], ["Let’s meet at 10 tomorrow. – No, I can’t. I … my driving test just at this time.", "have", "will have", "will have had", "will be having"], ["What is going on? – The floors … now.", "are replaced", "have been replaced", "will be replaced", "are being replaced"], ["If I … the password, I would have broken all their system.", "know", "knew", "have known", "had known"], ["My Granny said that my Granddad … a war veteran.", "-", "had been", "has been", "is"], ["It’s your … to look after the children.", "responsible", "response", "irresponsible", "responsibility"], ['You won’t remember everything! You should … it …', 'lost…back', 'run…back', 'carry...out', 'put...down']];
    $test = \App\Models\Test::create(['title' => 'base_test']);
    foreach ($arr as $item) {
        $question = \App\Models\TestQuestion::create(['test_id' => $test->id, 'description' => $item[0]]);
        $tmp = array_slice($item, 1);
        foreach ($tmp as $key => $answer) {
            \App\Models\TestAnswers::create(['test_question_id' => $question->id, 'text' => $answer, 'is_correct' => ($key + 1) == count($tmp)]);
        }
    }
});
