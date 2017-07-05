<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Manager;

use Claroline\CoreBundle\Entity\Resource\ResourceEvaluation;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Claroline\CoreBundle\Entity\Resource\ResourceUserEvaluation;
use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("claroline.manager.resource_evaluation_manager")
 */
class ResourceEvaluationManager
{
    private $om;

    /**
     * @DI\InjectParams({
     *     "om" = @DI\Inject("claroline.persistence.object_manager")
     * })
     *
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;

        $this->resourceUserEvaluationRepo = $om->getRepository('ClarolineCoreBundle:Resource\ResourceUserEvaluation');
        $this->resourceEvaluationRepo = $om->getRepository('ClarolineCoreBundle:Resource\ResourceEvaluation');
    }

    public function getResourceUserEvaluation(ResourceNode $node, User $user)
    {
        $evaluation = $this->resourceUserEvaluationRepo->findOneBy(['resourceNode' => $node, 'user' => $user]);

        if (empty($evaluation)) {
            $evaluation = $this->createResourceUserEvaluation($node, $user);
        }

        return $evaluation;
    }

    public function persistResourceUserEvaluation(ResourceUserEvaluation $evaluation)
    {
        $this->om->persist($evaluation);
        $this->om->flush();
    }

    public function createResourceUserEvaluation(ResourceNode $node, User $user)
    {
        $evaluation = new ResourceUserEvaluation();
        $evaluation->setResourceNode($node);
        $evaluation->setUser($user);
        $this->persistResourceUserEvaluation($evaluation);

        return $evaluation;
    }

    public function persistResourceEvaluation(ResourceEvaluation $evaluation)
    {
        $this->om->persist($evaluation);
        $this->om->flush();
    }

    public function createResourceEvaluation(
        ResourceNode $node,
        User $user,
        \DateTime $date = null,
        $status = null,
        $score = null,
        $scoreMin = null,
        $scoreMax = null,
        $customScore = null,
        $duration = null,
        $comment = null,
        $data = null
    ) {
        $this->om->startFlushSuite();
        $resourceUserEvaluation = $this->getResourceUserEvaluation($node, $user);
        $evaluation = new ResourceEvaluation();
        $evaluation->setResourceUserEvaluation($resourceUserEvaluation);
        $evaluationDate = $date ? $date : new \DateTime();
        $evaluation->setDate($evaluationDate);
        $evaluation->setStatus($status);
        $evaluation->setScore($score);
        $evaluation->setScoreMin($scoreMin);
        $evaluation->setScoreMax($scoreMax);
        $evaluation->setCustomScore($customScore);
        $evaluation->setDuration($duration);
        $evaluation->setComment($comment);
        $evaluation->setData($data);
        $this->persistResourceEvaluation($evaluation);
        $this->updateResourceUserEvaluation($evaluation);
        $this->om->endFlushSuite();

        return $evaluation;
    }

    private function updateResourceUserEvaluation(ResourceEvaluation $evaluation)
    {
        $reu = $evaluation->getResourceUserEvaluation();
        $reu->setDate($evaluation->getDate());
        $duration = $evaluation->getDuration();
        $score = $evaluation->getScore();

        if (!empty($duration)) {
            $reuDuration = $reu->getDuration() ? $reu->getDuration() : 0;
            $reuDuration += $duration;
            $reu->setDuration($reuDuration);
        }
        if (!empty($score)) {
            $scoreMax = $evaluation->getScoreMax();
            $newScore = empty($scoreMax) ? $score : $score / $scoreMax;

            $reuScore = $reu->getScore() ? $reu->getScore() : 0;
            $reuScoreMax = $reu->getScoreMax();
            $oldScore = empty($reuScoreMax) ? $reuScore : $reuScore / $reuScoreMax;

            if ($newScore >= $oldScore) {
                $reu->setScore($score);
                $reu->setScoreMax($scoreMax);
                $reu->setScoreMin($evaluation->getScoreMin());
            }
        }
        if (($evaluation->isSuccessful() && !$reu->isSuccessful()) ||
            ($evaluation->isTerminated() && !$reu->isTerminated() && !$reu->isSuccessful()) ||
            empty($reu->getStatus())
        ) {
            $reu->setStatus($evaluation->getStatus());
        }
        $this->persistResourceUserEvaluation($reu);
    }
}
