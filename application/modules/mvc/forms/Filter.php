<?php
namespace modules\mvc\forms;
use
  Equ\Form\IMappedType,
  Equ\Form\IBuilder,
  Equ\Form\OptionFlags;

class Filter extends Create {
  
  public function buildForm(IBuilder $builder) {
    $builder->setOptionFlags(new OptionFlags(
       OptionFlags::ALL & ~OptionFlags::IMPLICIT_VALIDATORS & ~OptionFlags::EXPLICIT_VALIDATORS
    ));
    
   $builder
      ->add('module')
      ->add('controller')
      ->add('action')
      ->add('parent');
  }
}
