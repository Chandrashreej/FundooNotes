<?php

namespace Entity;

/**
 * DocNotes Model
 *
 * @Entity
 * @Table(name="DocNotes")
 */
class DocNotes
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
	 * @Column(type="string", length=255, unique=false, nullable=false)
	 */
    protected $email;
    
	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
    protected $password;
    
    /**
     * Initialize any collection properties as ArrayCollections
     *
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html#initializing-collections
     *
     */
    public function __construct()
    {
        $this->users = new ArrayCollection;
    }







	/**
	 * Encrypt the password before we store it
	 *
	 * @param	string	$password
	 * @return	void
	 */
	public function setPassword($password)
	{
		$this->password = $this->hashPassword($password);
	}

	/**
	 * Encrypt a Password
	 *
	 * @param	string	$password
	 * @return	string
	 */
	public function hashPassword($password)
	{
		if ( ! $this->firstname)
		{
			throw new \Exception('The firstname must be set before the password can be hashed.');
		}

		return hash('sha256', $password . $this->firstname);
	}






	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

    public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
    }
    
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
    }
    public function setPhonenum()
	{
		return $this->phonenum;
    }

	public function getId()
	{
		return $this->id;
	}

	public function getFirstname()
	{
		return $this->firstname;
    }
    

	public function getPhonenum()
	{
		return $this->phonenum;
    }
    public function getLastname()
	{
		return $this->lastname;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}


}
