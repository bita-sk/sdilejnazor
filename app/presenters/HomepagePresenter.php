<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;

use App\Model;

class HomepagePresenter extends Nette\Application\UI\Presenter {

    private $database;

    function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    protected function createComponentAnswerForm() {
        $form = new Form;

        $form->addTextArea('answer')
                ->setRequired()
                ->addRule(Form::MIN_LENGTH, 'Zpráva musí obsahovat minimálně %d znaků', 5)
                ->addRule(Form::MAX_LENGTH, 'Zpráva může mít maximálně %d znaků', 500);

        $form->addSubmit('send', 'Sdílet názor');

        $form->onSuccess[] = array($this, 'answerFormSucceded');

        return $form;
    }
    
    public function answerFormSucceded($form,$values){
        
    }

}
