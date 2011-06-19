<?php
namespace modules\group\forms;
use
  Equ\Form\IMappedType,
  Equ\Form\IBuilder,
  Equ\Form\OptionFlags;

class Create implements IMappedType {
  
  public function buildForm(IBuilder $builder) {
    $builder
      ->add('name')
      ->add('parent');
  }
  
  public function getObjectClass() {
    return 'entities\UserGroup';
  }
}
