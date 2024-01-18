<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Controller\Adminhtml;

use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

abstract class Author extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Roweb_Authors::top_level';
    protected $_coreRegistry;

    // protected $directoryList;

    // protected $uploaderFactory;

    // protected $adapterFactory;

    // protected $filesystem;

    // protected $file;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        // DirectoryList $directoryList,
        // UploaderFactory $uploaderFactory,
        // AdapterFactory $adapterFactory,
        // Filesystem $filesystem,
        // \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->_coreRegistry = $coreRegistry;
        // $this->directoryList = $directoryList;
        // $this->uploaderFactory = $uploaderFactory;
        // $this->adapterFactory = $adapterFactory;
        // $this->filesystem = $filesystem;
        // $this->file = $file;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Roweb'), __('Roweb'))
            ->addBreadcrumb(__('Author'), __('Author'));
        return $resultPage;
    }
}