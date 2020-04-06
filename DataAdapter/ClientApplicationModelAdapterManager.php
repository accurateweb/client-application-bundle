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

use Accurateweb\ClientApplicationBundle\Exception\NotFoundClientApplicationModelAdapterException;

class ClientApplicationModelAdapterManager implements ClientApplicationModelAdapterManagerInterface
{
  private $adapters;

  public function addModelAdapter(ClientApplicationModelAdapterInterface $adapter)
  {
    $this->adapters[$adapter->getName()] = $adapter;
  }

  /**
   * @param $alias
   * @return mixed
   * @throws NotFoundClientApplicationModelAdapterException
   */
  public function getModelAdapter($alias)
  {
    if (!isset($this->adapters[$alias]))
    {
      throw new NotFoundClientApplicationModelAdapterException(sprintf('Not found ModelAdapter with alias %s', $alias));
    }

    return $this->adapters[$alias];
  }

  //@TODO нужен ли метод для поиска первого попавшегося адаптера через supports?
}