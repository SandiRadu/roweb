<?php
declare(strict_types=1);

namespace Roweb\Authors\Block;

use Magento\Framework\View\Element\Template\Context;
use Roweb\Authors\Model\AuthorFactory;
use Magento\Cms\Model\Template\FilterProvider;

/**
 * Author View block
 */
class AuthorView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Author
     */
    protected $_author;
    public function __construct(
        Context $context,
        AuthorFactory $author,
        FilterProvider $filterProvider
    ) {
        $this->_author = $author;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Author View Page'));

        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $author = $this->_author->create();

        $singleData = $author->load($id);

        if ($singleData->getAuthorId() || $singleData['author_id']) {
            return $singleData;
        } else {
            return false;
        }
    }
}