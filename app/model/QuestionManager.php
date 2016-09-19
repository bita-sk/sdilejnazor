<?php

namespace App\Model;

use Nette;

class QuestionManager {

    use \Nette\SmartObject;

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(\Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function getQuestionOfDay() {
        $selection = $this->database->table('questions')
                ->select('question,id')
                ->where('id')
                ->order('id DESC')
                ->limit(1)
                ->fetch();

        return $selection;
    }

}
