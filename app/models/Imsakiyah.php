<?php

namespace app\models;

/**
 * Description of Imsakiyah
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Imsakiyah extends \yii\base\Model
{
    // panjang 1 tahun rata-rata dalam detik
    const YEAR_LENGTH = 31557600;

    public $bujur;
    public $lintang;
    public $date;
    public $timestamp;
    public $timeZone;
    public $ketinggian = 100;

    public function rules()
    {
        return[
            [['bujur', 'lintang'], 'required'],
            [['date'], 'default', 'value' => date('d/m/Y')],
            [['date'], 'date', 'format' => 'dd/MM/yyyy', 'timestampAttribute' => 'timestamp'],
            [['lintang'], 'number', 'min' => -90, 'max' => 90],
            [['bujur'], 'number', 'min' => -180, 'max' => 180],
            [['timeZone'], 'default', 'value' => function() {
                return (int) ($this->bujur / 15);
            }],
            [['timeZone'], 'integer', 'min' => -12, 'max' => 12],
        ];
    }

    /**
     * Sudut deklinasi matahari. Satuan derajat.
     * @return float
     */
    public function getDelta()
    {
        $u = ($this->timestamp - ($this->bujur * 240) - 946684800) / self::YEAR_LENGTH;
        $T = 2 * pi() * $u;

        $delta = 0.37877 + 23.264 * SIN($T - 1.38835706) + 0.3812 * SIN(2 * $T - 1.443073132) + 0.17132 * SIN(3 * $T - 1.042345536);
        return $delta;
    }

    /**
     * Equation time. Satuan detik.
     * @return float
     */
    public function getET()
    {
        $u = ($this->timestamp - ($this->bujur * 240) - 946684800) / self::YEAR_LENGTH;

        $l0 = 2 * pi() * (0.779072417 + 1.000021383 * $u);

        $sub1 = -(107.34 + 0.1422 * $u) * SIN($l0) - (428.76 - 0.0372 * $u) * COS($l0);
        $sub2 = (596.04 - 0.0084 * $u) * SIN(2 * $l0) - (1.74 + 0.003 * $u) * COS(2 * $l0);
        $sub3 = (4.44 + 0.006 * $u) * SIN(3 * $l0) + (19.2 - 0.0024 * $u) * COS(3 * $l0);
        $sub4 = - 12.72 * SIN(4 * $l0);

        $et = $sub1 + $sub2 + $sub3 + $sub4;

        return $et;
    }

    /**
     * Menghitung waktu pada saat matahari pada sudut `$angle` dari titik tertinggi.
     * @param float $dzuhur
     * @param float $delta
     * @param float $angle
     * @return float Waktu dalam detik
     */
    public function getTimeOfAngle($dzuhur, $delta, $angle)
    {
        $angle = $angle * pi() / 180;
        $delta = $delta * pi() / 180;
        $lintang = $this->lintang * pi() / 180;
        $cosTeta = (cos($angle) - sin($lintang) * sin($delta)) / (cos($lintang) * cos($delta));
        if ($cosTeta < -1 || $cosTeta > 1) {
            return;
        }
        $teta = acos($cosTeta) * 180 / pi();
        $time = $teta * 240;

        return $angle >= 0 ? $dzuhur + $time : $dzuhur - $time;
    }

    public function getImsakiyah()
    {
        // dzuhur
        $dzuhur = (12 * 3600) + ($this->timeZone * 3600) - ($this->bujur * 240) - $this->getET();
        $delta = $this->getDelta();
        $result = [];

        // $alfa = sudut matahari dari posisi tertinggi
        // fajar, $alfa = -90 - 20
        $alfa = -110;
        $result['fajar'] = $this->getTimeOfAngle($dzuhur, $delta, $alfa);

        // sudut pembiasan
        $sp = 0.833 + 0.0347 * sqrt($this->ketinggian);

        // terbit matahari, $alfa = -90 - sudut pembiasan
        $alfa = -90 - $sp;
        $result['terbit'] = $this->getTimeOfAngle($dzuhur, $delta, $alfa);

        // dhuzur
        $result['dzuhur'] = $dzuhur;

        // ashar, panjang bayangan = panjang benda + panjang bayangan saat dzuhur.
        $aAlfa = 1 + abs(tan(($delta - $this->lintang) * pi() / 180));
        $alfa = atan($aAlfa) * 180 / pi();
        $result['ashar'] = $this->getTimeOfAngle($dzuhur, $delta, $alfa);

        // maghrib, $alfa = 90 + sudut pembiasan
        $alfa = 90 + $sp;
        $result['maghrib'] = $this->getTimeOfAngle($dzuhur, $delta, $alfa);

        // isya', $alfa = 90 + 18
        $alfa = 108;
        $result['isya'] = $this->getTimeOfAngle($dzuhur, $delta, $alfa);
        return $result;
    }
}