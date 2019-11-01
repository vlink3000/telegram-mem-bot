<?php

include('Bot/Interface/StrategyInterface.php');
include('Bot/Factory/StrategyFactory.php');
include('Bot/Context/StrategyContext.php');
include('Bot/Strategy/Start.php');
include('Bot/Strategy/Info.php');
include('Bot/Strategy/Random.php');
include('Bot/Strategy/Custom.php');
include('Bot/Http/Curl/CallTelegramApi.php');
include('Bot/Http/Curl/DownloadImage.php');
include('Bot/Converter/RequestConverter.php');