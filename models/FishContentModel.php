<?php

namespace fishContentApiClient\models;

use fishContentApiClient\exceptions\FishContentErrorException;
use fishContentApiClient\exceptions\FishContentInvalidParamException;

/**
 * Class FishContentModel
 * @package fishContentApiClient\models
 */
class FishContentModel {
    /**
     * @var
     */
    public $text;
    public $images;
    public $image;

    /**
     * @var
     */
    protected $_loadImagePath;

    /**
     * @var bool
     */
    protected $_loadImage = false;

    /**
     * FishContentModel constructor.
     * @param bool $loadImage
     * @param null $loadImagePath
     */
    public function __construct($loadImage = false, $loadImagePath = null) {
        if($loadImage && empty($loadImagePath)) {
            throw new FishContentInvalidParamException();
        }
        $this->setLoadImage($loadImage);
        $this->setLoadImagePath($loadImagePath);
    }

    /**
     * @param $attributes
     */
    public function setAttributes($attributes) {
        foreach($attributes as $attribute => $value) {
            if(property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
        $this->loadImages();
    }

    /**
     * @throws FishContentErrorException
     */
    protected function loadImages() {
        if(!$this->isLoadImage()) {
            return;
        }
        if(is_array($this->images)) {
            foreach($this->images as &$image) {
                $image = $this->loadImage($image);
            }
        }
        if(!empty($this->image)) {
            $this->image = $this->loadImage($this->image);
        }
    }

    /**
     * @param $imageUrl
     * @return string
     * @throws FishContentErrorException
     */
    protected function loadImage($imageUrl) {
        $imagePath = $this->getImagePathFromUrl($imageUrl);
        try {
            file_put_contents($imagePath, file_get_contents($imageUrl));
        }catch(\Exception $exception) {
            throw new FishContentErrorException('Ошибка при сохранении файла: ' . $exception->getMessage(), 500);
        }
        return $imagePath;
    }

    /**
     * @param $imageUrl
     * @return string
     */
    protected function getImagePathFromUrl($imageUrl) {
        $imageUrlPart = explode('/', $imageUrl);
        $imageName = end($imageUrlPart);
        return $this->getLoadImagePath() . DIRECTORY_SEPARATOR . $imageName;
    }

    /**
     * @return mixed
     */
    public function getLoadImagePath() {
        return $this->_loadImagePath;
    }

    /**
     * @param $LoadImagePath
     */
    public function setLoadImagePath($LoadImagePath) {
        $this->_loadImagePath = $LoadImagePath;
    }

    /**
     * @return bool
     */
    public function isLoadImage() {
        return $this->_loadImage;
    }

    /**
     * @param $LoadImage
     */
    public function setLoadImage($LoadImage) {
        $this->_loadImage = $LoadImage;
    }
}