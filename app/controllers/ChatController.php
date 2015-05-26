<?php

namespace app\controllers;

use Yii;
use app\models\Chat;
use app\models\ChatAccount;
use yii\helpers\Url;
use app\components\SSE;

/**
 * Description of ChatController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ChatController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionChat()
    {
        Yii::$app->response->format = 'json';
        $post = Yii::$app->request->post();
        $chat = new Chat([
            'from' => $post['from'],
            'to' => $post['to'],
            'time' => time(),
            'message' => $post['message'],
        ]);
        $chat->save(false);

        $acc = ChatAccount::findOne($post['from']);
        if ($acc) {
            $acc->last_actifity = time();
            $acc->save();
        }
        return true;
    }

    public function actionNewAccount()
    {
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->post('name');
        $acc = ChatAccount::findOne(['name' => $name]);
        if ($acc === null) {
            $acc = new ChatAccount([
                'name' => $name,
                'last_actifity' => time()
            ]);
            $acc->save(false);
        } else {
            $acc->last_actifity = time();
            $acc->save(false);
        }
        return [
            'id' => $acc->id,
            'name' => $name,
            'url' => Url::to(['message', 'id' => $acc->id]),
        ];
    }

    public function actionMarkRead()
    {
        Yii::$app->response->format = 'json';
        $post = Yii::$app->request->post();
        Chat::updateAll(['read' => 1], [
            'and', [
                'from' => $post['from'],
                'to' => $post['to']
            ], ['<=', 'time', $post['time']]
        ]);

        $acc = ChatAccount::findOne($post['from']);
        if ($acc) {
            $acc->last_actifity = time();
            $acc->save();
        }
        return true;
    }

    /**
     * Removes older char.
     */
    protected function gc()
    {
        $SAVE_HISTORY = 1 * 24 * 3600; // delete chat with age more 1 day(s)
        $probability = 100; // 1%

        if (mt_rand(0, 1000000) < $probability) {
            Chat::deleteAll('[[time]] < :time', [':time' => time() - $SAVE_HISTORY]);
            ChatAccount::deleteAll('[[last_actifity]] < :time', [':time' => time() - $SAVE_HISTORY]);
        }
    }

    public function actionMessage($id)
    {
        $MAX_CONN = 15; // 15 second

        $begin = time();
        $idleTime = $begin - 60;
        $sse = new SSE();

        $chatTime = Yii::$app->request->headers->get('last-event-id', 0);
        $lastCheck = 0;

        $otherAccs = ChatAccount::find()
            ->where(['<>', 'id', $id]);
        $chat = Chat::find()
                ->where(['or', ['to' => $id], ['from' => $id]])->andWhere('[[time]]>:time')
                ->orderBy(['time' => SORT_DESC])->limit(128);
        $notif = Chat::find()
            ->select(['from', 'notif' => 'count([[id]])'])
            ->where(['to' => $id, 'read' => 0])
            ->groupBy('from');

        // remove older chat
        $this->gc();
        while (time() - $begin < $MAX_CONN) {
            // get all account
            $last = $otherAccs->max('last_actifity');
            if ($last > $lastCheck) {
                $accs = $otherAccs->asArray()->all();
                foreach ($accs as &$acc) {
                    if ($acc['last_actifity'] < $idleTime) {
                        $acc['idle'] = true;
                    } else {
                        $acc['idle'] = false;
                    }
                }
                $lastCheck = time();
                $sse->event('account', $accs);
            }

            // get chat
            $rows = $chat->params([':time' => $chatTime])->all();
            if (count($rows)) {
                $rows = array_reverse($rows);
                $messages = [];
                foreach ($rows as $row) {
                    $stime = date('d-m-Y H:i:s', $row['time']);
                    if ($row['from'] == $id && $row['to'] == $id) {
                        $messages[$id][] = [true, $row['message'], $stime];
                        $messages[$id][] = [false, $row['message'], $stime];
                    } elseif ($row['from'] == $id) {
                        $messages[$row['to']][] = [true, $row['message'], $stime];
                    } else {
                        $messages[$row['from']][] = [false, $row['message'], $stime];
                    }
                }
                $chatTime = time();
                $sse->event('chat', ['time' => $chatTime, 'msgs' => $messages]);
            }

            // get unread message
            $rows = $notif->asArray()->all();
            if (count($rows)) {
                $sse->event('notif', $rows);
            }

            // send event to buffer
            $sse->flush();
            sleep(1);
        }
        $sse->id(time());
        exit();
    }
}