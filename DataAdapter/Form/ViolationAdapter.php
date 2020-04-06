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
use Symfony\Component\Validator\ConstraintViolation;

class ViolationAdapter implements ClientApplicationModelAdapterInterface
{
  /**
   * @param ConstraintViolation $subject
   * @param array $options
   * @return string
   */
  public function transform ($subject, $options = array())
  {
    return $subject->getMessage();
//    return [
//      'message' => $subject->getMessage(),
//      'code' => $subject->getCode(),
//    ];
  }

  public function getModelName ()
  {
    return 'Error';
  }

  public function supports ($subject)
  {
    return $subject instanceof ConstraintViolation;
  }

  public function getName ()
  {
    return 'violation';
  }

}