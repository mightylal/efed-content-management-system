<?php

namespace Efed\Services\Admin;

use Efed\Contracts\Repositories\WrestlerRepository;
use Efed\Validation\ApplicationsValidator;

class ApplicationService
{

    /**
     * @var WrestlerRepository
     */
    private $wrestlerRepo;

    /**
     * Start new ApplicationService.
     *
     * @param WrestlerRepository $wrestlerRepo
     */
    public function __construct(WrestlerRepository $wrestlerRepo)
    {
        $this->wrestlerRepo = $wrestlerRepo;
    }

    /**
     * Accept or decline applicant(s).
     *
     * @param array $input
     * @return string
     */
    public function task($input)
    {
        $input['id'] = array_map('trim', $input['id']);
        (new ApplicationsValidator)->validateApplicant($input);
        if ($input['decide'] == 'accept') {
            $this->accept($input['id']);
            $message = 'Applications accepted successfully.';
        } else {
            $this->decline($input['id']);
            $message = 'Applications declined successfully.';
        }
        return $message;
    }

    /**
     * Accept the applicant(s).
     *
     * @param array $applicants
     */
    private function accept($applicants)
    {
        foreach ($applicants as $applicant) {
            $this->wrestlerRepo->update($applicant, ['activated' => 1]);
        }
    }

    /**
     * Decline the applicant(s).
     *
     * @param array $applicants
     */
    private function decline($applicants)
    {
        foreach ($applicants as $applicant) {
            $this->wrestlerRepo->delete($applicant);
        }
    }

}