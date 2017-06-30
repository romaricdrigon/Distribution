<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Entity\Resource;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="claro_resource_evaluation")
 */
class ResourceEvaluation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\Resource\ResourceUserEvaluation")
     * @ORM\JoinColumn(name="resource_user_evaluation", onDelete="CASCADE")
     */
    protected $resourceUserEvaluation;

    /**
     * @ORM\Column(name="evaluation_date", type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(name="evaluation_status", nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $duration;

    /**
     * @ORM\Column(name="score", type="float", nullable=true)
     */
    protected $score;

    /**
     * @ORM\Column(name="score_min", type="float", nullable=true)
     */
    protected $scoreMin;

    /**
     * @ORM\Column(name="score_max", type="float", nullable=true)
     */
    protected $scoreMax;

    /**
     * @ORM\Column(name="custom_score", nullable=true)
     */
    protected $customScore;

    /**
     * @ORM\Column(type="text", name="evaluation_comment", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(name="more_data", type="json_array", nullable=true)
     */
    protected $data;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getResourceUserEvaluation()
    {
        return $this->resourceUserEvaluation;
    }

    public function setResourceUserEvaluation(ResourceUserEvaluation $resourceUserEvaluation)
    {
        $this->resourceUserEvaluation = $resourceUserEvaluation;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getScoreMin()
    {
        return $this->scoreMin;
    }

    public function setScoreMin($scoreMin)
    {
        $this->scoreMin = $scoreMin;
    }

    public function getScoreMax()
    {
        return $this->scoreMax;
    }

    public function setScoreMax($scoreMax)
    {
        $this->scoreMax = $scoreMax;
    }

    public function getCustomScore()
    {
        return $this->customScore;
    }

    public function setCustomScore($customScore)
    {
        $this->customScore = $customScore;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function isTerminated()
    {
        return $this->status !== ResourceUserEvaluation::STATUS_NOT_ATTEMPTED &&
            $this->status !== ResourceUserEvaluation::STATUS_INCOMPLETE &&
            $this->status !== ResourceUserEvaluation::STATUS_UNKNOWN;
    }

    public function isSuccessful()
    {
        return $this->status === ResourceUserEvaluation::STATUS_PASSED ||
            $this->status === ResourceUserEvaluation::STATUS_COMPLETED;
    }
}
