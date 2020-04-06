<?php
/**
 *  (c) 2019 ИП Рагозин Денис Николаевич. Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ИП Рагозиным Денисом Николаевичем
 *  (ОГРНИП 315668300000095, ИНН 660902635476).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ИП Рагозина Денис Николаевича. Любое их использование без согласия ИП Рагозина Денис Николаевича рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\ClientApplicationBundle\DataAdapter\Form;

use Accurateweb\ClientApplicationBundle\DataAdapter\ClientApplicationModelAdapterInterface;
use Symfony\Component\Form\FormInterface;

class FormErrorAdapter implements ClientApplicationModelAdapterInterface
{
  /**
   * @param $form FormInterface
   * @param array $options
   * @return array
   */
  public function transform ($form, $options = array())
  {
    $errors = array();

    foreach ($form->getErrors() as $key => $error)
    {
      if ($form->isRoot())
      {
        $errors[$error->getOrigin()?$error->getOrigin()->getName():'#'][] = $error->getMessage();
      }
      else
      {
        $errors[] = $error->getMessage();
      }
    }

    foreach ($form->all() as $child)
    {
      if (!$child->isValid())
      {
        $errors[$child->getName()] = $this->transform($child);
      }
    }

    return $errors;
  }

  public function getModelName ()
  {
    return 'FormErrors';
  }

  public function supports ($subject)
  {
    return $subject instanceof FormInterface;
  }

  public function getName ()
  {
    return 'form.errors';
  }
}