<?php

namespace fishContentApiClient;

use fishContentApiClient\exceptions\FishContentErrorException;
use fishContentApiClient\exceptions\FishContentResponseException;
use fishContentApiClient\models\FishContentModel;

/**
 * Class FishContentApiClient
 * @package fishContentApi
 */
class FishContentApiClient {
    /**
     * Url API хоста
     */
    const API_HOST = 'http://api.fishcontent.ru/';

    /**
     * Url получения текстов
     */
    const URL_GET_TEXT = 'get/text';

    /**
     * Url получения изображений
     */
    const URL_GET_IMAGE = 'get/image';

    /**
     * Url получения контента
     */
    const URL_GET_CONTENT = 'get/content';

    /**
     * Формат выдаваемого текста - string или HTML
     */
    const TEXT_FORMAT_HTML = 'html';
    const TEXT_FORMAT_STRING = 'string';

    /**
     * Размер выдаваемого изображения:
     * large - Большой
     * medium - Средний
     * small - Маленький
     * eq - Другой
     */
    const IMAGE_SIGE_LARGE = 'large';
    const IMAGE_SIGE_MEDIUM = 'medium';
    const IMAGE_SIGE_SMALL = 'small';
    const IMAGE_SIGE_CUSTOM = 'eq';

    /**
     * Ориентация выдаваемого изображения:
     * horizontal - Горизонтальная
     * vertical - Вертикальная
     * square - Квадратная
     */
    const IMAGE_ORIENT_HORIZONTAL = 'horizontal';
    const IMAGE_ORIENT_VERTIACAL = 'vertical';
    const IMAGE_ORIENT_SQUARE = 'square';

    /**
     * Тип выдаваемого изображения:
     * photo - Фото
     * clipart - С белым фоном
     * lineart - Рисунки и чертежи
     * face - Лица
     * demotivator - Демотиваторы
     */
    const IMAGE_TYPE_PHOTO = 'photo';
    const IMAGE_TYPE_CLIPART = 'clipart';
    const IMAGE_TYPE_LINEPART = 'lineart';
    const IMAGE_TYPE_FACE = 'face';
    const IMAGE_TYPE_DEMOTIVATOR = 'demotivator';

    /**
     * Цвет выдаваемого изображения:
     * color - Цветной
     * gray - Черно-белый
     * red - Красный
     * orange - Оранжевый
     * yellow - Желтый
     * cyan - Голубой
     * green - Зеленый
     * blue - Синий
     * violet - Фиолетовый
     * white - Белый
     * black - Черный
     */
    const IMAGE_COLOR_COLOR = 'color';
    const IMAGE_COLOR_GRAY = 'gray';
    const IMAGE_COLOR_RED = 'red';
    const IMAGE_COLOR_ORANGE = 'orange';
    const IMAGE_COLOR_YELLOW = 'yellow';
    const IMAGE_COLOR_CYAN = 'cyan';
    const IMAGE_COLOR_GREEN = 'green';
    const IMAGE_COLOR_BLUE = 'blue';
    const IMAGE_COLOR_VIOLET = 'violet';
    const IMAGE_COLOR_WHITE = 'white';
    const IMAGE_COLOR_BLACK = 'black';

    /**
     * Тип файла выдаваемого изображения:
     * jpg - JPG
     * png - PNG
     * gif - GIF
     */
    const IMAGE_FILE_JPG = 'jpg';
    const IMAGE_FILE_PNG = 'png';
    const IMAGE_FILE_GIF = 'gif';

    /**
     * @var string
     * API ключ, идентифицирующий Ваш аккаунт. Параметр можно найти в профиле пользователя
     */
    protected $_apiKey;

    /**
     * @var
     */
    protected $_loadImagePath;

    /**
     * FishContentApi constructor.
     * @param $apiKey string
     */
    public function __construct($apiKey) {
        $this->setApiKey($apiKey);
    }

    /**
     * Значения $params:
     * int $count Количество выдаваемых текстов
     * int $paragraphs Количество параграфов в одном тексте
     * int $symbols Ориентировочное количество символов в одном параграфе
     * int $category Категория содержимого выдаваемого текста
     * string $textFormat Формат выдаваемого текста - string или HTML
     *
     * @param array $params
     * @return string Json с текстами
     */
    public function getText($params = []) {
        $params = array_merge($this->getDefaultTextParams(), $params);
        $response = $this->response(
            $this->createUrl(self::URL_GET_TEXT, [
                'category' => $params['category'],
                'text_format' => $params['textFormat'],
                'paragraphs' => $params['paragraphs'],
                'symbols' => $params['symbols'],
                'count' => $params['count'],
            ])
        );
        return $this->createCollection($response);
    }

    /**
     * Значения $params:
     * int $count
     * int $paragraphs
     * int $symbols
     * null $category
     * int $imageCount
     * null $imageSize
     * null $imageSizeW
     * null $imageSizeH
     * null $imageOrient
     * null $imageType
     * null $imageColor
     * null $imageFileType
     * string $textFormat
     *
     * @param array $params
     * @return array
     * @throws FishContentErrorException
     * @throws FishContentResponseException
     */
    public function getContent($params = []) {
        $params = array_merge($this->getDefaultTextParams(), $this->getDefaultImageParams(), $params);
        $response = $this->response(
            $this->createUrl(self::URL_GET_IMAGE, [
                'category' => $params['category'],
                'text_format' => $params['textFormat'],
                'paragraphs' => $params['paragraphs'],
                'symbols' => $params['symbols'],
                'count' => $params['count'],
                'image_count' => $params['imageCount'],
                'image_size' => $params['imageSize'],
                'image_size_w' => $params['imageSizeW'],
                'image_size_h' => $params['imageSizeH'],
                'image_file_type' => $params['imageFileType'],
                'image_color' => $params['imageColor'],
                'image_orient' => $params['imageOrient'],
                'image_type' => $params['imageType'],
            ])
        );
        return $this->createCollection($response);
    }

    /**
     *
     * Значения $params:
     * int $imageCount
     * null $category
     * null $imageSize
     * null $imageSizeW
     * null $imageSizeH
     * null $imageOrient
     * null $imageType
     * null $imageColor
     * null $imageFileType
     *
     * @param array $params
     * @return array
     * @throws FishContentErrorException
     * @throws FishContentResponseException
     */
    public function getImage($params = []) {
        $params = array_merge($this->getDefaultImageParams(), $params);
        $response = $this->response(
            $this->createUrl(self::URL_GET_IMAGE, [
                'category' => $params['category'],
                'image_count' => $params['imageCount'],
                'image_size' => $params['imageSize'],
                'image_size_w' => $params['imageSizeW'],
                'image_size_h' => $params['imageSizeH'],
                'image_file_type' => $params['imageFileType'],
                'image_color' => $params['imageColor'],
                'image_orient' => $params['imageOrient'],
                'image_type' => $params['imageType'],
            ])
        );
        return $this->createCollection($response);
    }

    /**
     * @return array
     */
    public function getDefaultTextParams(){
        return [
            'count' => 1,
            'paragraphs' => 1,
            'symbols' => 600,
            'category' => null,
            'textFormat' => self::TEXT_FORMAT_HTML
        ];
    }

    /**
     * @return array
     */
    public function getDefaultImageParams(){
        return [
            'imageCount' => '1',
            'category' => null,
            'imageSize' => null,
            'imageSizeW' => null,
            'imageSizeH' => null,
            'imageOrient' => null,
            'imageType' => null,
            'imageColor' => null,
            'imageFileType' => null
        ];
    }

    /**
     * @param $items array
     * @return array
     */
    protected function createCollection($items) {
        $collection = [];
        foreach($items as $item) {
            $model = new FishContentModel();
            $model->setAttributes($item);
            $collection[] = $model;
        }
        return $collection;
    }

    /**
     * @param $urlGet
     * @param array $params
     * @return string
     */
    protected function createUrl($urlGet, $params = []) {
        $params = array_merge($this->getDefaultParams(), $params);
        return self::API_HOST . $urlGet . '?' . urldecode(http_build_query($params));
    }

    /**
     * @return array
     */
    protected function getDefaultParams() {
        return [
            'api_key' => $this->getApiKey()
        ];
    }

    /**
     * @param $url
     * @return mixed
     * @throws FishContentErrorException
     * @throws FishContentResponseException
     */
    protected function response($url) {
        try {
            $response = json_decode(file_get_contents($url));
        }catch(\Exception $exception) {
            throw new FishContentErrorException('Ошибка соединения: ' . $exception->getMessage(), 500);
        }
        if(!is_array($response)) {
            throw new FishContentResponseException('Неверный формат ответа!', 500);
        }
        return $response;
    }

    /**
     * @return string
     */
    public function getApiKey() {
        return $this->_apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey) {
        $this->_apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getLoadImagePath() {
        return $this->_loadImagePath;
    }

    /**
     * @param mixed $loadImagePath
     */
    public function setLoadImagePath($loadImagePath) {
        $this->_loadImagePath = $loadImagePath;
    }
}