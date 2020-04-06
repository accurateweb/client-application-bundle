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

namespace Accurateweb\ClientApplicationBundle\Twig;

use AccurateCommerce\DataAdapter\ClientApplicationModelCollection;
use Accurateweb\ClientApplicationBundle\DataAdapter\ClientApplicationModelAdapterManagerInterface;

class ClientApplicationExtension extends \Twig_Extension
{
  private $manager;

  public function __construct (ClientApplicationModelAdapterManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function getFunctions ()
  {
    return array(
      new \Twig_SimpleFunction(
        'clientModelCollection',
        array($this, 'getRawClientModelCollection')
      ),
    );
  }

  public function getFilters()
  {
    return array(
      new \Twig_SimpleFilter(
        'client_model',
        array($this, 'getClientModel'),
        array('is_safe' => array('html'))
      ),
      new \Twig_SimpleFilter(
        'client_model_collection',
        array($this, 'getClientModelCollection'),
        array('is_safe' => array('html'))
      )
    );
  }

  /**
   * @param $subject
   * @param $adapter string
   * @param array $options
   * @param null|string $model_name
   * @return string
   * @throws \Accurateweb\ClientApplicationBundle\Exception\NotFoundClientApplicationModelAdapterException
   * @throws \Exception
   */
  public function getClientModel($subject, $adapter, $options=array(), $model_name = null)
  {
    $adapter = $this->manager->getModelAdapter($adapter);

    if (!$adapter->supports($subject))
    {
      throw new \Exception(sprintf('Adapter not support %s', get_class($subject)));
    }

    $script = sprintf(<<<EOF
<script type="text/javascript">
    if ('undefined' === typeof ObjectCache) {
      ObjectCache = {};
    }
    ObjectCache['%s'] = %s;
</script>  
EOF
,
      is_null($model_name)?$adapter->getModelName():$model_name,
    json_encode($adapter->transform($subject, $options))
    );

    return $script;
  }

  /**
   * @param $subjects array
   * @param $adapter string
   * @param $collectionName string
   * @param array $options
   * @return string
   * @throws \Accurateweb\ClientApplicationBundle\Exception\NotFoundClientApplicationModelAdapterException
   * @throws \Exception
   */
  public function getClientModelCollection($subjects, $adapter, $collectionName, $options=array())
  {
    $adapter = $this->manager->getModelAdapter($adapter);
    $data = array();

    foreach ($subjects as $subject)
    {
      if (!$adapter->supports($subject))
      {
        throw new \Exception(sprintf('Adapter not support %s', get_class($subject)));
      }

      $item = $adapter->transform($subject, $options);

      if (!is_null($item))
      {
        $data[] = $item;
      }
    }


    $script = sprintf(<<<EOF
<script type="text/javascript">
    if ('undefined' === typeof ObjectCache) {
      ObjectCache = {};
    }
    ObjectCache['%s'] = %s;
</script>  
EOF
      ,
      $collectionName,
      json_encode($data)
    );

    return $script;
  }

  public function getRawClientModelCollection($subjects, $adapter, $options=array())
  {
    $adapter = $this->manager->getModelAdapter($adapter);
    $data = array();

    foreach ($subjects as $subject)
    {
      if (!$adapter->supports($subject))
      {
        throw new \Exception(sprintf('Adapter not support %s', get_class($subject)));
      }

      $data[] = $adapter->transform($subject, $options);
    }

    return $data;
  }
}