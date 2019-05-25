<?php

declare(strict_types=1);

namespace app\model;

use app\entity\DateDto;
use app\model\Groups as MGroups;
use app\model\Langs as MLangs;
use app\model\Levels as MLevels;
use app\model\Students as MStudents;
use app\model\Courses as MCourses;

class Docs extends Base
{

    public function getDataStudentContract(int $studentId, int $groupId): array
    {
        $student = (new MStudents)->getItem($studentId);

        $mGroups = new MGroups();
        $group = $mGroups->getItem($groupId);
        $membersCount = (new MGroups())->getMembersCount($groupId);

        $lang = (new MLangs())->getItem($group->lang_id);
        $level = (new MLevels)->getItem($group->level_id);

        $course = (new MCourses())->getCourse($group->course_id);

        $price = $course->total_price;

        $hours = $course->lessons * 2;

        return [
            'date' => "'9' декабря",
            'customerName' => $student->name,
            'langNameDative' => $lang->name_dative,
            'docNumber' => $this->getStudentContractNumber($studentId, $groupId) . '/' . date('d.m.Y'),
            'year' => date('Y'),
            'level' => $level->name,
            'dateStart' => $this->dateStringFromDto($group->date_start),
            'dateEnd' => $this->dateStringFromDto($group->date_end),
            'groupTypeGenitive' => $mGroups->getTypeVisitNameGenitive($group->type_visit),
            'membersCount' => $membersCount,
            'scheduleString' => $group->note,
            'address' => $group->address,
            'price' => $price,
            'priceString' => $this->num2str($price),
            'customerPhone' => $student->phone ? $student->phone : '_____________________________',
            'customerEmail' => $student->email,
            'customerAddress' => $student->address,
            'hours' => $hours,
            'hoursString' => $this->getAcademicHoursString($hours),
            'description' => $course->description
        ];
    }

    private function getStudentContractNumber(int $studentId, int $groupId): int
    {
        $uuid = $studentId . "-" . $groupId;
        $row = $this->db->selectRow("select * from docs where `type` = 'student_contract' && entity_id=?", $uuid);
        if ($row) {
            return (int) $row['id'];
        } else {
            return $this->updateObject('docs', [
                'type' => 'student_contract',
                'entity_id' => $uuid
            ]);
        }
    }

    private function dateStringFromDto(DateDto $date): string
    {
        return '«' . $date->day . '» ' . $this->getMonth($date->month) . ' ' . $date->year;
    }

    private function getMonth(int $month): string
    {
        $months = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];
        return $months[$month - 1];
    }

    private function num2str($num)
    {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array( // Units
            array('копейка', 'копейки', 'копеек', 1),
            array('рубль', 'рубля', 'рублей', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = $this->plural($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        // Рублей
        // $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        // Копеек
        // $out[] = $kop . ' ' . $this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    private function getAcademicHoursString(int $hours): string
    {
        return $this->plural($hours, 'академический', 'академических', 'академических')
            . ' '
            . $this->plural($hours, 'час', 'часа', 'часов');
    }

    private function plural($n, $f1, $f2, $f5): string
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }

}