<?php
namespace Roweb\Authors\Controller\Index;

use Magento\Framework\Exception\NotFoundException;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     *
     * @var \Roweb\Authors\Block\AuthorView;
     */
    protected $_authorsview;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Roweb\Authors\Block\AuthorView $authorsview
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_authorsview = $authorsview;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     */
    public function execute()
    {
        if (!$this->_authorsview->getSingleData()) {
            throw new NotFoundException(__('Parameter is incorrect.'));
        }

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
