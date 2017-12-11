<?php
/**
 * Sitemap module
 *
 * @author Serge Larin <serge.larin@gmail.com>
 * @link http://assayer.pro/
 * @copyright 2015 Assayer Pro Company
 * @license http://opensource.org/licenses/LGPL-3.0
 */


namespace assayerpro\sitemap;
use yii\base\Exception;
use yii\console\Application;

/**
 * Class Module for sitemap
 *
 * @author Serge Larin <serge.larin@gmail.com>
 * @package app\modules\webmaster
 */
class Module extends \yii\base\Module
{
    const CONSOLE_CONTROLLER_MAP = [
        'create' => [
            'class' => 'assayerpro\sitemap\console\CreateController',
        ],
    ];
    /**
     * The namespace that controller classes are in.
     *
     * @var string
     * @access public
     */
    public $controllerNamespace = 'assayerpro\sitemap\controllers';

    public function init()
    {
        parent::init();
        if (\yii::$app instanceof Application) {
            $this->controllerMap = self::CONSOLE_CONTROLLER_MAP;
        }
    }

    public function getComponent() {
        if (!empty(\yii::$app->components['sitemap'])) {
            $component = \yii::$app->components['sitemap'];
        } else if (!($component = $this->get('sitemap', false))) {
            throw new Exception('Component for sitemap module is required. Define it via application components '
                . 'or module components');
        }

        $component->moduleId = $this->uniqueId;

        return $component;
    }
}
