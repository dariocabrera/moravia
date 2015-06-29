<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Message,
    Phalcon\Mvc\Model\Validator\Uniqueness;

class Clients extends Model
// class Clients
{

    public function validation()
    {
        //Client name must be unique
        $this->validate(new Uniqueness(
            array(
                "field"   => "name",
                "message" => "The name must be unique"
            )
        ));

        //Age cannot be less than zero
        if ($this->age < 0) {
            $this->appendMessage(new Message("The year cannot be less than zero"));
        }

        //Check if any messages have been produced
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}