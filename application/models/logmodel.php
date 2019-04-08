<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="userLabel")
 */
class UserLabel
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @Column(type="string", length=32, unique=true, nullable=false)
	 */
	protected $label;
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
    protected $creationTime;

	public function setUsername($label)
	{
		$this->label = $label;
		return $this;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function setCreationTime()
	{
		 $this->creationTime = new now();
	}
	public function getCreationTime()
	{
		return $this->creationTime;
	}
	/**
	 * Get group
	 *
	 * @return Entity\UserGroup
	 */
	public function getGroup()
	{
		return $this->group;
	}
}