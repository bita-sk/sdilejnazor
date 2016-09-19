<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;
use App\Model\QuestionManager;
use App\Model\AnswerManager;

class HomepagePresenter extends Nette\Application\UI\Presenter {

    /** @var QuestionManeger */
    private $questionManager;
    private $answerManager;

    function __construct(QuestionManager $questionManager, AnswerManager $answerManager) {
        $this->questionManager = $questionManager;
        $this->answerManager = $answerManager;
    }

    public function renderDefault() {
        $this->template->dayQuestion = $this->questionManager->getQuestionOfDay();
        $this->template->answers = $this->answerManager->answersRelated();
    }

    protected function createComponentAnswerForm() {
        $form = new Form;

        $form->addTextArea('answer')
                ->setRequired()
                ->addRule(Form::MIN_LENGTH, 'Zpráva musí obsahovat minimálně %d znaků', 5)
                ->addRule(Form::MAX_LENGTH, 'Zpráva může mít maximálně %d znaků', 500);
        $form->addHidden('questionId', $this->questionManager->getQuestionOfDay()->id);
        $form->addSubmit('send', 'Sdílet názor');

        $form->onSuccess[] = array($this, 'answerFormSucceded');

        return $form;
    }

    public function answerFormSucceded($form, $values) {
        $this->answerManager->insert($form, $values);
        $this->flashMessage("Děkujeme za názor");
        $this->redirect('this');
    }

}
