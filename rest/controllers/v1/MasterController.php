<?php

namespace rest\controllers\v1;

use Yii;
use yii\helpers\Json;
use rest\models\master\Product;
use rest\models\master\ProductUom;
use rest\models\master\Uom;
use rest\models\master\ProductChild;
use rest\models\master\PriceCategory;
use rest\models\master\Price;
use rest\models\master\Customer;
use rest\models\master\Supplier;
use rest\models\master\ProductSupplier;
use rest\models\master\ProductStock;
use rest\models\accounting\Coa;
use rest\models\master\Branch;
use rest\models\master\Warehouse;
use yii\web\Controller;

/**
 * Description of MasterController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class MasterController extends Controller
{

    public function actionIndex()
    {

        Yii::$app->response->format = 'raw';
        Yii::$app->response->getHeaders()->set('Content-Type', 'text/javascript; charset=UTF-8');
        $script = 'var MASTERS = ' . Json::htmlEncode($this->getMasters()) . ';';
        return $script;
    }

    public function getMasters()
    {
        $result = [];
        // master product
        $query_product = Product::find()
            ->select(['id', 'code', 'name'])
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->indexBy('id')
            ->asArray();

        $result['products'] = $query_product->all();


        // uoms
        $_uoms = Uom::find()->indexBy('id')->asArray()->all();
        $uoms = [];
        foreach (ProductUom::find()->asArray()->all() as $row) {
            $uoms[$row['product_id']][] = [
                'id' => $row['uom_id'],
                'name' => $_uoms[$row['uom_id']]['name'],
                'isi' => $row['isi']
            ];
        }
        $result['product_uoms'] = $uoms;

        // barcodes
        $barcodes = [];
        $query_barcode = ProductChild::find()
            ->select(['barcode', 'id' => 'product_id'])
            ->union(Product::find()->select(['code', 'id']))
            ->asArray();
        foreach ($query_barcode->all() as $row) {
            $barcodes[strtoupper($row['barcode'])] = $row['id'];
        }
        $result['barcodes'] = $barcodes;


        // price_category
        $price_category = [];
        $query_price_category = PriceCategory::find()->asArray();
        foreach ($query_price_category->all() as $row) {
            $price_category[$row['id']] = $row['name'];
        }
        $result['price_category'] = $price_category;


        // prices
        $prices = [];
        $query_prices = Price::find()->asArray();
        foreach ($query_prices->all() as $row) {
            $prices[$row['product_id']][$row['price_category_id']] = $row['price'];
        }
        $result['prices'] = $prices;


        // customer
        $result['customers'] = Customer::find()
                ->select(['id', 'name'])
                ->asArray()->all();


        // supplier
        $result['suppliers'] = Supplier::find()
                ->select(['id', 'name'])
                ->asArray()->all();


        // product_supplier
        $prod_supp = [];
        $query_prod_supp = ProductSupplier::find()
            ->select(['supplier_id', 'product_id'])
            ->asArray();
        foreach ($query_prod_supp->all() as $row) {
            $prod_supp[$row['supplier_id']][] = $row['product_id'];
        }
        $result['product_supplier'] = $prod_supp;


        // product_stock
        $prod_stock = [];
        $query_prod_stock = ProductStock::find()
            ->select(['warehouse_id', 'product_id', 'qty'])
            ->asArray();
        foreach ($query_prod_stock->all() as $row) {
            $prod_stock[$row['warehouse_id']][$row['product_id']] = $row['qty'];
        }
        $result['product_stock'] = $prod_stock;

        // branch
        $result['branchs'] = Branch::find()->asArray()->all();

        // warehouse
        $warehouses = Warehouse::find()->asArray()->all();
        $result['warehouses'] = [];
        foreach ($warehouses as $warehouse) {
            $result['warehouses'][$warehouse['branch_id']][] = $warehouse;
        }

        //apicode
        $result['mvconfig'] = Yii::$app->bizConfig->movement;
        // coa
        $result['coa'] = Coa::find()
                ->select(['id', 'cd' => 'code', 'text' => 'name', 'label' => 'name'])
                ->asArray()->all();

        return $result;
    }
}