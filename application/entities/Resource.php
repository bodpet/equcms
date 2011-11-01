<?php
namespace entities;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Resource entity
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        $Link$
 * @since       2.0
 * @version     $Revision$
 * @author      Szurovecz János <szjani@szjani.hu>
 *
 * @Gedmo\Tree(type="nested")
 * @Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @Table(name="`resource`", indexes={
 *   @index(name="resource_resource_idx", columns={"resource"}),
 *   @index(name="resource_lft_idx", columns={"lft"}),
 *   @index(name="resource_rgt_idx", columns={"rgt"}),
 *   @index(name="resource_lvl_idx", columns={"lvl"})
 * })
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"mvc" = "Mvc"})
 */
abstract class Resource extends \Equ\Entity implements \Zend_Acl_Resource_Interface, \Serializable {

  /**
   * @Column(name="id", type="integer")
   * @Id
   * @GeneratedValue
   * @var int
   */
  protected $id;

  /**
   * @Gedmo\TreeParent
   * @ManyToOne(targetEntity="Resource", inversedBy="children")
   * @JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
   * @var Resource
   */
  protected $parent;

  /**
   * @OneToMany(targetEntity="Resource", mappedBy="parent")
   * @var Doctrine\Common\Collections\ArrayCollection
   */
  protected $children;

  /**
   * @Gedmo\TreeLeft
   * @Column(name="lft", type="integer")
   */
  protected $lft;

  /**
   * @Gedmo\TreeRight
   * @Column(name="rgt", type="integer")
   */
  protected $rgt;

  /**
   * @Gedmo\TreeLevel
   * @Column(name="lvl", type="integer")
   */
  protected $lvl;

  /**
   * @Column(name="resource", type="string", length=255, nullable=false)
   * @var string
   */
  protected $resource;
  
  /**
   * @OneToMany(targetEntity="RoleResource", mappedBy="resource")
   * @var ArrayCollection
   */
  protected $roleResources;

  public function __construct() {
    $this->roleResources = new ArrayCollection();
    $this->children      = new ArrayCollection();
  }

  /**
   * @return Resource
   */
  public function getParent() {
    return $this->parent;
  }

  /**
   * @param Resource $parent
   * @return Resource
   */
  public function setParent(Resource $parent = null) {
    $this->parent = $parent;
    return $this;
  }

  /**
   * @return ArrayCollection
   */
  public function getRoleResources() {
    return $this->roleResources;
  }

  public function getResourceId() {
    return $this->resource;
  }

  protected function setResourceId($resource) {
    $this->resource = (string)$resource;
    return $this;
  }

  public function __toString() {
    return $this->getResourceId();
  }

  public function getId() {
    return $this->id;
  }

  public function serialize() {
    return \serialize(array(
      'id' => $this->getId(),
      'lft' => $this->lft,
      'rgt' => $this->rgt,
      'lvl' => $this->lvl,
      'resource' => $this->resource
    ));
  }

  public function unserialize($serialized) {
    $serialized = \unserialize($serialized);
    $this->id = $serialized['id'];
    $this->lft = $serialized['lft'];
    $this->rgt = $serialized['rgt'];
    $this->lvl = $serialized['lvl'];
    $this->resource = $serialized['resource'];
    $this->roleResources = new ArrayCollection();
    $this->children      = new ArrayCollection();
  }


}