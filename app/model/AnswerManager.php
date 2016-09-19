<?php

namespace App\Model;

use Nette;
use App\Model\Manager;
use App\Model\QuestionManager;

class AnswerManager {

    private $database;
    private $questionManager;

    public function __construct(\Nette\Database\Context $database, QuestionManager $questionManager) {
        $this->database = $database;
        $this->questionManager = $questionManager;
    }

    public function insert($form, $values) {
        $this->database->table('answers')->insert(array(
            'answer' => $values->answer,
            'question_id' => $values->questionId,
            'ip' => Manager::getUserIP()
        ));
    }

    public function answersRelated() {
        $question = $this->database->table('questions')->get($this->questionManager->getQuestionOfDay()->id);

        return $this->database->table('answers')
                        ->select('answer')
                        ->where('question_id', $question)
                ->order('created_at DESC')
                        ->fetchAll();
    }

}
