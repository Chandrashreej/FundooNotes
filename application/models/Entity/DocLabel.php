<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * DocLabel Model
 *
 * @Entity
 * @Table(name="doc_label")
 *
 */
class DocLabel
{

    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @userId
     * @Column(type="integer",length=32, nullable=false)
     * 
     */
    protected $userId;
    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $labelname;

    /**
     * @OneToMany(targetEntity="DocLabeledNotes", mappedBy="doc_label")
     */
    protected $doc_labeled_notes;

    /**
     * Initialize any collection properties as ArrayCollections
     *
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html#initializing-collections
     *
     */
    public function __construct()
    {
        $this->doc_labeled_notes = new ArrayCollection;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->userId;
    }
    /**
     * Set labelname
     *
     * @param string $labelname
     * @return DocLabel
     */
    public function setLabelName($labelname)
    {
        $this->labelname = $labelname;
        return $this;
    }

    /**
     * Get labelname
     *
     * @return string
     */
    public function getLabelName()
    {
        return $this->labelname;
    }

    /**
     * Add doc_labeled_notes
     *
     * @param Entity\DocLabeledNotes $doc_labeled_notes
     * @return DocLabel
     */
    public function addDoc_labeled_notes(\Entity\DocLabeledNotes $doc_labeled_notes)
    {
        $this->doc_labeled_notes[] = $doc_labeled_notes;
        return $this;
    }

    /**
     * Get doc_labeled_notes
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDoc_labeled_notes()
    {
        return $this->doc_labeled_notes;
    }

}
