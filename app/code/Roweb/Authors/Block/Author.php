<?php
namespace Roweb\Authors\Block;

/**
 * Authors content block
 */
class Author extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Roweb Authors Module'));

        return parent::_prepareLayout();
    }
}

