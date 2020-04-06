<?php
/**
 *  (c) 2019 Общество с ограниченной ответственностью "Экьюрейт Веб". Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ООО "Экьюрейт Веб"
 *  (ОГРН 1186658025289, ИНН 6683013910).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ООО "Экьюрейт Веб". Любое их использование без согласия ООО "Экьюрейт Веб" рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\ClientApplicationBundle\DataAdapter;

interface ClientApplicationModelAdapterInterface
{
  /**
   * @param $object
   * @param $options
   * @return array
   */
  public function transform($subject, $options=array());

  /**
   * @return string
   */
  public function getModelName();

  /**
   * @param $subject
   * @return boolean
   */
  public function supports($subject);

  /**
   * Adapter name
   * @return string
   */
  public function getName ();
}