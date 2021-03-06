<?php

use fishContentApiClient\FishContentApiClient;

$fishText = (new FishContentApiClient('api_key'))->getText(3, 2, 600, 2, FishContentApiClient::TEXT_FORMAT_HTML);

var_dump($fishText);

$fishImage = (new FishContentApiClient('api_key'))->getImage(3, 2, FishContentApiClient::IMAGE_SIGE_LARGE, null, null);

var_dump($fishImage);

$fishContent = (new FishContentApiClient('api_key'))->getContent(3, 2, 300, 2, 5, FishContentApiClient::IMAGE_SIGE_LARGE);

var_dump($fishContent);