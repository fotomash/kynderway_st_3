<?php

namespace App\Services;

use App\Interfaces\ProfilePostInterface;
use App\Interfaces\UserConnectionsInterface;
use App\Interfaces\MessageInterface;
use App\Interfaces\ReportInterface;
use App\Interfaces\ReportUserInterface;
use App\Interfaces\JobTypesInterface;
use App\Interfaces\SpecialitiesInterface;

use App\Events\ProfileDelete;
use App\Events\ProfileActivate;
use App\Events\ProfileSuspend;

use Exception;

class ProfilePostService
{
    private $profilePostRepository;
    private $userConnectionsRepository;
    private $messageRepository;
    private $reportRepository;
    private $reportUserRepository;
    private $jobTypeRepository;
    private $specialitiesRepository;

    public function __construct(
        ProfilePostInterface $profilePostRepository,
        UserConnectionsInterface $userConnectionsRepository,
        MessageInterface $messageRepository,
        ReportInterface $reportRepository,
        ReportUserInterface $reportUserRepository,
        JobTypesInterface $jobTypeRepository,
        SpecialitiesInterface $specialitiesRepository
    ) {
        $this->profilePostRepository = $profilePostRepository;
        $this->userConnectionsRepository = $userConnectionsRepository;
        $this->messageRepository = $messageRepository;
        $this->reportRepository = $reportRepository;
        $this->reportUserRepository = $reportUserRepository;
        $this->jobTypeRepository = $jobTypeRepository;
        $this->specialitiesRepository = $specialitiesRepository;
    }

    public function getAllProfile()
    {
        return $this->profilePostRepository->getAll();
    }

    public function getCountByCategorty()
    {
        return $this->profilePostRepository->getCountByCategorty();
    }

    public function getCountProviderWithoutWorkProfile()
    {
        return $this->profilePostRepository->getCountProviderWithoutWorkProfile();
    }

    public function getEmailByCategorty(array $categories)
    {
        return $this->profilePostRepository->getEmailByCategorty($categories);
    }

    public function getEmailsProviderWithoutWorkProfile()
    {
        return $this->profilePostRepository->getEmailsProviderWithoutWorkProfile();
    }

    public function deleteProfile($profileId, $reportCheck)
    {
        $profileDetails = $this->profilePostRepository->getWith($profileId);

        $jobConnections = $this->userConnectionsRepository->getAll($profileId)->toArray();
        foreach ($jobConnections as $jobConnection) {
            $this->messageRepository->delete($jobConnection['id']);
        }

        $this->userConnectionsRepository->delete($profileId);
        $this->profilePostRepository->delete($profileId);

        if ($reportCheck) {
            if ($profileId != '') {
                $report = $this->reportRepository->updateStatus($profileId, 0);
                $this->reportUserRepository->updateStatus($report->id, 0);
            } else {
                throw new Exception('Something went wrong, report user');
                // return false;
            }
        }
        event(new ProfileDelete($profileDetails));
    }

    public function getOnlyProfile($profileId)
    {
        return $this->profilePostRepository->get($profileId);
    }

    public function getProfile($profileId)
    {
        $profilePost = $this->profilePostRepository->getWith($profileId);

        $jobtypes = explode(',', $profilePost->jobtypes);
        $workwiths = explode(',', $profilePost->workwith);

        $allJobTypes = implode(',', $this->jobTypeRepository->getValuesForIds($jobtypes));
        $allWorkWith = implode(',', $this->specialitiesRepository->getValuesForIds($workwiths));

        return [$profilePost, $allJobTypes, $allWorkWith];
    }

    public function profileExists($profilePostId)
    {
        $profile_post = $this->profilePostRepository->get($profilePostId);

        if ($profile_post === null) {
            return false;
        } else {
            return true;
        }
    }

    public function profileAssigned($profilePostId)
    {
        $profile_post = $this->profilePostRepository->get($profilePostId);

        if ($profile_post->assigned_user_id !== null) {
            return false;
        } else {
            return true;
        }
    }

    public function assignAdmin($profilePostId, $adminId)
    {
        $this->profilePostRepository->assignAdmin($profilePostId, $adminId);
    }

    public function updateNotes($profilePostId, $notes)
    {
        $this->profilePostRepository->updateNotes($profilePostId, $notes);
    }

    public function suspendActivateProfile($profileId, $setStatus, $suspendedBy, $reportCheck)
    {
        $this->profilePostRepository->suspendActivate($profileId, $setStatus, $suspendedBy);

        if ($reportCheck) {
            $report = $this->reportRepository->updateStatus($profileId, 0);
            $this->reportUserRepository->updateStatus($report->id, 0);
        }

        $profileDetails = $this->profilePostRepository->getWith($profileId);
        //Send mail to user when job post status changed to suspend/pause (0)
        if ($setStatus == 0) {
            event(new ProfileSuspend($profileDetails));
        } else {
            event(new ProfileActivate($profileDetails));
        }
    }

    public function countSelectedProfiles($profileId)
    {
        $profile = $this->profilePostRepository->get($profileId);
        return $this->profilePostRepository->selectedProfileCount($profile->profile_category_id);
    }

    public function updateSelectProfile($profileId, $select)
    {
        $this->profilePostRepository->updateSelectProfile($profileId, $select);
    }

    public function delete($user)
    {
        $this->profilePostRepository->updateEducationDesc($user->id);

        foreach ($user->profileposts as $profile) {
            $reports = $profile->reports;
            foreach ($reports as $report) {
                $report->reportUsers()->delete();
            }
            $profile->reports()->delete();
        }
        $this->profilePostRepository->deleteProviderId($user->id);
    }
}
