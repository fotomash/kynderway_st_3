<?php

namespace App\Services;

use App\Interfaces\VideoIntroInterface;

class VideoService
{
    private $videoIntroRepository;

    public function __construct(VideoIntroInterface $videoIntroRepository)
    {
        $this->videoIntroRepository = $videoIntroRepository;
    }

    public function delete($user)
    {
        $video = $this->videoIntroRepository->get($user->id);
        if ($video != null && $video->videofile != '' && file_exists(storage_path('app/public/' . $video->videofile))) {
            unlink(storage_path('app/public/' . $video->videofile));
            $video->delete();
        }
    }
}
