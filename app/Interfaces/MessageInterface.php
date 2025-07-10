<?php

namespace App\Interfaces;

interface MessageInterface
{
    public function getMessageList();

    public function getMessages($id);

    public function getJobDetails($id);

    public function delete($id);

    public function deleteFromTo($id);
}
