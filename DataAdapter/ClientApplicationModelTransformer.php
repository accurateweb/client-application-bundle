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

use Symfony\Component\Stopwatch\Stopwatch;

class ClientApplicationModelTransformer
{
  /**
   * @var ClientApplicationModelAdapterManagerInterface
   */
  private $manager;
  private $stopwatch;

  public function __construct (
    ClientApplicationModelAdapterManagerInterface $manager,
    Stopwatch $stopwatch=null
  )
  {
    $this->manager = $manager;
    $this->stopwatch = $stopwatch;
  }

  /**
   * @param $subject
   * @param $adapter
   * @return array
   * @throws \Accurateweb\ClientApplicationBundle\Exception\NotFoundClientApplicationModelAdapterException
   * @throws \Exception
   */
  public function getClientModelData($subject, $adapter, $options=array())
  {
    $adapter = $this->manager->getModelAdapter($adapter);

    if (!$adapter->supports($subject))
    {
      throw new \Exception(sprintf('Adapter not support %s', get_class($subject)));
    }

    if ($this->stopwatch)
    {
      $this->stopwatch->start(sprintf('Hydrate %s', $adapter->getName()), 'ClientApplication');
    }

    $data = $adapter->transform($subject, $options);

    if ($this->stopwatch)
    {
      $this->stopwatch->stop(sprintf('Hydrate %s', $adapter->getName()));
    }

    return  $data;
  }

  /**
   * @param $subjects
   * @param  $adapter
   * @return array
   * @throws \Accurateweb\ClientApplicationBundle\Exception\NotFoundClientApplicationModelAdapterException
   * @throws \Exception
   */
  public function getClientModelCollectionData($subjects, $adapter, $options=array())
  {
    $data = array();

    if ($this->stopwatch)
    {
      $this->stopwatch->start(sprintf('Hydrate collection %s', $adapter), 'ClientApplication');
    }

    foreach ($subjects as $subject)
    {
      $item = $this->getClientModelData($subject, $adapter, $options);

      if (!is_null($item))
      {
        $data[] = $item;
      }
    }

    if ($this->stopwatch)
    {
      $this->stopwatch->stop(sprintf('Hydrate collection %s', $adapter));
    }

    return  $data;
  }
}