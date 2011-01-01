<?php
namespace entities;

/**
 * User entity
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        $Link$
 * @since       2.0
 * @version     $Revision$
 * @author      Szurovecz János <szjani@szjani.hu>
 *
 * @Entity(repositoryClass="Gedmo\Tree\Repository\TreeNodeRepository")
 * @Table(name="`user`")
 */
class User extends Role {
  
  const PASSWORD_SALT = 'dfJko$~346958rg!DFT]AEtzserf9giq)3/TAeg;aDFa43';

//  /**
//   * @Column(name="id", type="integer")
//   * @Id
//   * @GeneratedValue
//   * @var int
//   */
//  private $id;

  /**
   * @Column(name="email", type="string", unique="true")
   * @var string
   */
  private $email;

  /**
   * @Column(name="password_hash", type="string", length=32)
   * @var string
   */
  private $passwordHash;

  /**
   * @Column(name="activation_code", type="string", length=12)
   * @var string
   */
  private $activationCode;

  /**
   * @param string $email
   * @param string $password
   */
  public function __construct($email, $password) {
    parent::__construct();
    $this
      ->setEmail($email)
      ->setPassword($password);
  }
  
  public function init() {
    $emailValidator = new \Zend_Validate_EmailAddress();
    try {
      $emailValidator->setValidateMx(true);
    } catch (\Zend_Validate_Exception $e) {}
    
    $this
      ->setActivationCode($this->generateString(12))
      ->addFieldValidator('email', $emailValidator);
  }

  /**
   * @return string
   */
  public function getRoleId() {
    return $this->email;
  }

    /**
   * Generates a random password
   *
   * @param int $length
   * @return string
   */
  public function generateString($length = 8) {
    $length = (int) $length;
    if ($length < 0) {
      throw new Exception("Invalid password length '$length'");
    }
    $set = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = strlen($set);
    $ret = '';
    for ($i = 0; $i < $length; $i++) {
      $ret .= $set[rand(0, $num - 1)];
    }
    return $ret;
  }

  /**
   * Generates a password hash
   *
   * @param string $password
   * @return string
   */
  public function generatePasswordHash($password) {
    return md5($password . self::PASSWORD_SALT);
  }

//  /**
//   * @return int
//   */
//  public function getId() {
//    return $this->id;
//  }

  /**
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * @param string $email
   * @return User
   */
  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }

  /**
   * @return string
   */
  public function getPasswordHash() {
    return $this->passwordHash;
  }

  /**
   * @param string $password
   * @return User
   */
  public function setPassword($password) {
    $this->passwordHash = $this->generatePasswordHash(trim($password));
    return $this;
  }

  /**
   * @return string
   */
  public function getActivationCode() {
    return $this->activationCode;
  }

  /**
   * @param string $activationCode
   * @return User
   */
  public function setActivationCode($activationCode) {
    $this->activationCode = $activationCode;
    return $this;
  }

}