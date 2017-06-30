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

use Claroline\CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="claro_resource_user_evaluation",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="resource_user_evaluation",
 *             columns={"resource_node", "user_id"}
 *         )
 *     }
 * )
 * @DoctrineAssert\UniqueEntity({"resourceNode", "user"})
 */
class ResourceUserEvaluation
{
    const STATUS_PASSED = 'passed';
    const STATUS_FAILED = 'failed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_NOT_ATTEMPTED = 'not_attempted';
    const STATUS_UNKNOWN = 'unknown';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\Resource\ResourceNode")
     * @ORM\JoinColumn(name="resource_node", onDelete="CASCADE")
     */
    protected $resourceNode;

    /**
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\Column(name="user_name")
     */
    protected $userName;

    /**
     * @ORM\Column(name="lastest_date", type="datetime")
     */
    protected $latestDate;

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
     * @ORM\OneToMany(
     *     targetEntity="Claroline\CoreBundle\Entity\Resource\ResourceEvaluation",
     *     mappedBy="resourceUserEvaluation"
     * )
     */
    protected $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getResourceNode()
    {
        return $this->resourceNode;
    }

    public function setResourceNode(ResourceNode $resourceNode)
    {
        $this->resourceNode = $resourceNode;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->setUserName($user->getFirstName().' '.$user->getLastName());
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getLatestDate()
    {
        return $this->latestDate;
    }

    public function setLatestDate(\DateTime $latestDate = null)
    {
        $this->latestDate = $latestDate;
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

    public function getEvalations()
    {
        return $this->evaluations->toArray();
    }

    public function isTerminated()
    {
        return $this->status !== self::STATUS_NOT_ATTEMPTED &&
            $this->status !== self::STATUS_INCOMPLETE &&
            $this->status !== self::STATUS_UNKNOWN;
    }

    public function isSuccessful()
    {
        return $this->status === self::STATUS_PASSED || $this->status === self::STATUS_COMPLETED;
    }
}
