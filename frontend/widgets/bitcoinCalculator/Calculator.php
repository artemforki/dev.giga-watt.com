<?php

namespace frontend\widgets\bitcoinCalculator;


use Codeception\Exception\ConfigurationException;
use yii\base\Component;
use yii\base\ErrorException;
use Yii;

class Calculator extends Component
{
    public $servers = [];
    public $exchangeRateURLs = [];
    public $currency = 'BTC/USD';

    private $exchangeRate;

    public function init()
    {
        if (empty($this->exchangeRateURLs)) {
            throw new ConfigurationException("Empty exchange rate URLs");
        }
        parent::init();
    }

    public function getExchangeRate($currency = 'USD')
    {
        if ($this->exchangeRate === null) {
            $data = $this->getCurrencyGroup($currency);
            if (empty($data) || empty($data['group'])) {
                throw new ErrorException('Exchange rate error');
            }
            $this->exchangeRate = round(
                array_sum(
                    array_map(
                        function ($item) {
                            return $item['rate'];
                        }, $data['group'])) / count($data['group']), 2);
        }
        return $this->exchangeRate;
    }

    public function getCurrencyGroup($currency = 'USD')
    {
        $key = md5(implode(',', $this->exchangeRateURLs) . '-' . $currency . '-' . count($this->exchangeRateURLs));
        $history = Yii::$app->fileCache->get($key);

        if ($history !== false) {
            if (isset($history['ts']) && $history['ts'] > time()) {
                return $history;
            }
        }

        $group = [];
        foreach ($this->exchangeRateURLs as $name => $url) {
            $content = file_get_contents($url);
            preg_match('#>' . $this->currency . '.+?num">([\d,\.]+)\s+' . $currency . '#si', $content, $match);
            if (isset($match[1])) {
                $rate = (float)str_replace(',', '', $match[1]);
                if ($rate > 0) {
                    $dynamic = 0.00;
                    if ($history !== false && isset($history['group'][$name])) {
                        $dynamic = round(
                            ($rate - $history['group'][$name]['rate']) * 100.00 / $history['group'][$name]['rate'], 4);
                    }
                    $group[$name] = [
                        'url' => $url,
                        'rate' => $rate,
                        'dynamic' => $dynamic
                    ];
                }
            }
        }
        if ($group === [] && $history !== false) {
            $data = $history;
            $data['ts'] = time() + 24 * 3600;
        } else {
            $data = ['group' => $group, 'ts' => time() + 24 * 3600];
        }
        Yii::$app->fileCache->set($key, $data);

        return $data;
    }

    public static function getVolume()
    {
        $key = md5('Bitcoin Difficulty');
        if (($difficulty = Yii::$app->fileCache->get($key)) === false) {
            $data = file_get_contents('https://bitcoinwisdom.com/bitcoin/difficulty');
            if (!empty($data)) {
                $difficulty = (int)str_replace(
                    ',', '', preg_replace('/.+?Bitcoin Difficulty:[^,\d]+([,\d]+).+/is', '$1', $data));
            }
            if (empty($difficulty) || !($difficulty > 0)) {
                $difficulty = 499635929817;
            }
            Yii::$app->fileCache->set($key, $difficulty, 3600 * 24);
        }

        return $difficulty;

    }

    public function getIdentity($server, $settings = [])
    {
        $server = strtolower($server);
        if (!isset($this->servers[$server])) {
            throw new ErrorException("В конфигурации нет сервера: $server");
        }
        if ($settings !== []) {
            if (isset($settings['class'])) {
                unset($settings['class']);
            }
            $settings = array_merge($this->servers[$server], $settings);
        } else {
            $settings = $this->servers[$server];
        }
        $identity = \Yii::createObject($settings);
        return $identity;
    }

}