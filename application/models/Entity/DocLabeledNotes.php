<?php

namespace Entity;

/**
 * DocLabeledNotes Model
 *
 * @Entity
 * @Table(name="doc_labeled_notes")
 * 
 */
class DocLabeledNotes
{

	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @Column(type="string", length=100, unique=false, nullable=false)
	 */
    protected $title;
    /**
	 * @Column(type="string", length=100, unique=false, nullable=false)
	 */
	protected $takeANote;

    /**
	 * @Column(type="string", length=100, unique=false, nullable=false)
	 */
	protected $dateAndTime;



	/**
	 * @ManyToOne(targetEntity="DocLabel")
	 * @JoinColumn(name="doc_label", referencedColumnName="id")
	 */
	protected $docLabel;

	/**
	 * Assign the doc_labeled_notes to a docLabel
	 *
	 * @param	Entity\DocLabel	$docLabel
	 * @return	void
	 */
	public function setDocLabel(DocLabel $docLabel)
	{
		$this->docLabel = $docLabel;

		// The association must be defined in both directions
		if ( ! $docLabel->getDoc_labeled_notes()->contains($this))
		{
			$docLabel->addDoc_labeled_notes($this);
		}
	}


	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function setTakeANote($takeANote)
	{
		$this->takeANote = $takeANote;
		return $this;
	}
	public function setDateAndTime($dateAndTime)
	{
		$this->dateAndTime = $dateAndTime;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getTakeANote()
	{
		return $this->takeANote;
	}

	public function getDateAndTime()
	{
		return $this->dateAndTime;
	}

	/**
	 * Get docLabel
	 *
	 * @return Entity\DocLabel
	 */
	public function getDocLabel()
	{
		return $this->docLabel;
	}

}
