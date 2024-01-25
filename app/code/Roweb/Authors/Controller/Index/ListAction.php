<?php
declare(strict_types=1);

namespace Roweb\Authors\Controller\Index;

class ListAction extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     */
    public function execute()
    {
        // die('hereee!');
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
