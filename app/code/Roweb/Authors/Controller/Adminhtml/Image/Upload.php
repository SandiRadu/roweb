<?php
declare(strict_types=1);

namespace Roweb\Authors\Controller\Adminhtml\Author;

use Codeception\Util\FileSystem;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

class Upload extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Roweb_Authors::authors';

    private WriteInterface $mediaDirectory;
    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        FileSystem $fileSystem,
        private UploaderFactory $uploaderFactory,
        private StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->mediaDirectory = $fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
    }


    public function execute(): ResultInterface
    {
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $fileUploader = $this->uploadFactory->create(['fieldId' => 'feature_image']);
            $fileUploader->setAllowedExtension('jpg', 'jpeg', 'png');
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowCreateFolders(true);
            $fileUploader->setFilesDispersion(false);

            $imgPath = 'tmp/imageUploader/images';
            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath($imgPath));

            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $fileName = ltrim(str_replace('\\', '/', $result['file'], '/'));

            $result['url'] = $mediaUrl . $imgPath . $fileName;

            return $jsonResult->setData($result);
        } catch (LocalizedException $exception) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => $exception->getMessage()]);
        } catch (\Exception $e) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => __('An error occured, please try again later!')]);
        }
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
