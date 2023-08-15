<?php


namespace OpenTechiz\AdminNote\Block;


use Magento\Framework\View\Element\Template;

class CheckFrontend extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'OpenTechiz_AdminNote::check-frontend.phtml';
    protected $ditmemay;
    public function __construct(Template\Context $context, array $data = [])
    {
        if (isset($data['ditmemay'])) {
            $this->ditmemay = $data['ditmemay'];
            unset($data['ditmemay']);
        }
        parent::__construct($context, $data);
    }

    public function getTestArgument()
    {
        var_dump($this->ditmemay);
    }
}
