<?php

namespace App\Services;

use App\Interfaces\MessageInterface;

class MessageService
{
    private $messageRepository;

    public function __construct(
        MessageInterface $messageRepository
    ) {
        $this->messageRepository = $messageRepository;
    }

    public function getMessageList()
    {
        return $this->messageRepository->getMessageList();
    }

    public function getMessages($id)
    {
        return $this->messageRepository->getMessages($id);
    }

    public function getJobDetails($id)
    {
        return $this->messageRepository->getJobDetails($id);
    }

    public function deleteFromTo($user)
    {
        return $this->messageRepository->deleteFromTo($user->id);
    }
}
