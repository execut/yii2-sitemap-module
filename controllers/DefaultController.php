<?php
/**
 * @link https://github.com/himiklab/yii2-sitemap-module
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace assayerpro\sitemap\controllers;

use Yii;
use yii\web\Controller;

/**
 * @author HimikLab
 * @package himiklab\sitemap
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index', 'robots-txt'],
                'duration' => \Yii::$app->params['cacheExpire'],
            ],
        ];
    }

    public function actionIndex()
    {
        /** @var \himiklab\sitemap\Sitemap $module */
        $module = Yii::$app->sitemap;

        $sitemapData = $module->buildSitemap();

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/xml');
        if ($module->enableGzip) {
            $sitemapData = gzencode($sitemapData);
            $headers->add('Content-Encoding', 'gzip');
            $headers->add('Content-Length', strlen($sitemapData));
        }
        return $sitemapData;
    }

    public function actionRobotsTxt()
    {
        \Yii::$app->response->format = 'txt';
        return $this->renderPartial('robots-txt', [
            'host' => \Yii::$app->request->serverName,
            'sitemap' => \Yii::$app->urlManager->createAbsoluteUrl([$this->module->id.'/'. $this->id .'/index']),
        ]);
    }
}
