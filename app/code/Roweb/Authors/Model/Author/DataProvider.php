<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Model\Author;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Roweb\Authors\Model\ResourceModel\Author\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    private ReadInterface $mediaDirectory;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        private StoreManagerInterface $storeManager,
        private FileSystem $fileSystem,
        private Mime $mime,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }

        $data = $this->dataPersistor->get('roweb_authors_author');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('roweb_authors_author');
        }

        // dd($items);

        $loadedData = $model->getData();
        $image = $loadedData['feature_image'];

        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $imgPath = 'tmp/imageUploader/images';
        $fullImagePath = $this->mediaDirectory->getAbsolutePath($imgPath) . '/' . $image;

        $imageUrl = $baseUrl . $imgPath . '/' . $image;
        $stat = $this->mediaDirectory->stat($fullImagePath);

        $loadedData['feature_image'] = null;
        $loadedData['feature_image'][0]['url'] = $imageUrl;
        $loadedData['feature_image'][0]['name'] = $image;
        $loadedData['feature_image'][0]['size'] = $stat['size'];
        $loadedData['feature_image'][0]['type'] = $this->mime->getMimeType($fullImagePath);

        return $this->loadedData;
    }
}

