<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/05/19
 * Time: 00:09
 */

namespace OpenTechiz\AdminNote\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class GoPathAction extends Column
{

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var string
     */
    private $viewUrl;
    /**
     * Initialize dependencies
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['path'])) {
                    $item[$name]['path'] = [
                        'href' => $this->urlBuilder->getUrl( $item['path']),
                        'label' => __('View')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
