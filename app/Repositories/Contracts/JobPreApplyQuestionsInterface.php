<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface JobPreApplyQuestionsInterface.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface JobPreApplyQuestionsInterface extends PrettusInterface
{
    public function getQuestionsByJobObjectId($jobObjectId);

}
