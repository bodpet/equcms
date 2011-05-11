<?php
use Equ\Crud\AbstractController;

/**
 * Mvc controller. You can manage module/controller/action records.
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        $Link$
 * @since       0.1
 * @version     $Revision$
 * @author      Szurovecz János <szjani@szjani.hu>
 */
class Mvc_AdminController extends AbstractController {

  /**
   * @var array
   */
  protected $ignoredFields = array('lft', 'rgt', 'lvl', 'resource');

  public function init() {
    parent::init();
    $mainFormBuilder = $this->getMainFormBuilder();
    $mainFormBuilder->setIgnoredFields($this->ignoredFields);
    $this->setFilterFormBuilder($mainFormBuilder);
  }

  protected function getEntityClass() {
    return 'entities\Mvc';
  }

}