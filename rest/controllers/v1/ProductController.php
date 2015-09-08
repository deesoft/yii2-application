<?php

namespace rest\controllers\v1;

use Yii;
use rest\classes\AdvanceController;
use yii\data\ActiveDataProvider;

/**
 * Description of ProductController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ProductController extends AdvanceController
{
    public $modelClass = 'rest\models\master\Product';

    /**
     *
     * @param \dee\base\Event $event
     */
    protected function eQuery($event)
    {
        /* @var $provider ActiveDataProvider */
        $provider = $event->params[0];
        $query = $provider->query;
        $query->joinWith(['group', 'category']);

        $q = Yii::$app->getRequest()->get('q');
        if (!empty($q)) {
            $query->andWhere(['or',
                ['like', 'product.code', $q],
                ['like', 'product.name', $q],
                ['like', 'category.name', $q],
                ['like', 'product_group.name', $q],
            ]);
        }
    }
}
