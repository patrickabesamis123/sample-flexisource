<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface JobApplicationQuestionsInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface JobApplicationQuestionsInterface extends PrettusInterface
{
    public function getQuestionsByJobObjectId($jobObjectId);

}
