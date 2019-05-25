<?php

namespace app\entity;

class Base
{
    protected $types = [];

    public function __construct(array $args = [], $strict = false)
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $value = $this->setType($key, $value);
                $this->$key = $value;
            } else {
                if ($strict)
                    throw new \Exception('Недопустимое свойство ' . $key);
            }
        }
    }

    private function setType($key, $value)
    {
        if ($this->types[$key]) {
            switch ($this->types[$key]) {
                case 'integer':
                    return $this->stringToInt($value);
                    break;

                case 'real':
                    return $this->stringToFloat($value);
                    break;

                case 'date':
                    if ($value instanceof DateDto) {
                        return $value;
                    } else {
                        return $this->stringToDate($value);
                    }
                    break;

                case 'time':
                    if ($value instanceof TimeDto) {
                        return $value;
                    } else {
                        return $this->stringToTime($value);
                    }
                    break;

                case 'date-time':
                    return $this->stringToDateTime($value);
                    break;

                case 'boolean':
                    return $this->stringToBoolean($value);
                    break;

                case 'ids':
                    return $this->stringToIds($value);
                    break;
            }
        } else {
            return $value;
        }
    }

    private function typeToString($key, $value)
    {
        if ($this->types[$key]) {
            switch ($this->types[$key]) {
                case 'integer':
                    return $this->stringToInt($value);
                    break;

                case 'real':
                    return $this->stringToFloat($value);
                    break;

                case 'date':
                    return $this->dateToString($value);
                    break;

                case 'time':
                    return $this->timeToString($value);
                    break;

                case 'date-time':
                    return $this->dateTimeToString($value);
                    break;

                case 'boolean':
                    return $this->booleanToString($value);
                    break;

                case 'ids':
                    return $this->idsToString($value);
                    break;

                default:
                    return $value;
                    break;
            }
        } else {
            return $value ? $value : NULL;
        }
    }

    protected function stringToDate($date): ?DateDto
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            list($year, $month, $day) = explode('-', $date);
        } else {
            list($year, $month, $day) = [$date['year'], $date['month'], $date['day']];
        }
        return new DateDto([
            'year' => $year,
            'month' => $month,
            'day' => $day
        ]);
    }

    private function stringToInt($value): ?int
    {
        return ($value || $value === '0' || $value === 0) ? (int) $value : null;
    }

    private function stringToFloat($value): ?float
    {
        $value = str_replace(',', '.', (string)$value);
        return ($value || $value === '0' || $value === 0) ? (float) $value : null;
    }

    private function stringToTime($time): ?TimeDto
    {
        if (!$time) {
            return null;
        }

        if (is_string($time)) {
            list($hour, $minute) = explode(':', $time);
        } else {
            list($hour, $minute) = [$time['hour'], $time['minute']];
        }
        return new TimeDto([
            'hour' => $hour,
            'minute' => $minute
        ]);
    }

    private function stringToDateTime($dateTime): ?DateTimeDto
    {
        if (!$dateTime) {
            return null;
        }
        if (is_string($dateTime)) {
            list($date, $time) = explode(" ", $dateTime);
        } else {
            $date = $dateTime;
            $time = $dateTime;
        }

        $dateDto = $this->stringToDate($date);
        $timeDto = $this->stringToTime($time);

        return new DateTimeDto(array_merge((array)$dateDto, (array)$timeDto));
    }

    private function stringToIds($data): ?array
    {
        if (!$data) {
            return null;
        }
        if (is_string($data)) {
            $ids = array_map("intval",
                explode(',', $data)
            );
        } else {
            $ids = array_map("intval", $data);
        }
        return $ids;
    }

    private function idsToString($ids)
    {
        return implode(',', $ids);
    }

    private function stringToBoolean($value)
    {
        return $value ? true : false;
    }

    protected function dateToString(?DateDto $date)
    {
        if (!$date) {
            return null;
        }
        $month = str_pad($date->month, 2, "0", STR_PAD_LEFT);
        $day = str_pad($date->day, 2, "0", STR_PAD_LEFT);
        return "{$date->year}-{$month}-{$day}";
    }

    protected function timeToString(?TimeDto $time)
    {
        if (!$time) {
            return null;
        }
        $hour = str_pad($time->hour, 2, "0", STR_PAD_LEFT);
        $minute = str_pad($time->minute, 2, "0", STR_PAD_LEFT);
        return "{$hour}:{$minute}:00";
    }

    private function dateTimeToString(?DateTimeDto $dateTime)
    {
        if (!$dateTime) {
            return null;
        }

        $date = new DateDto([
            'year' => $dateTime->year,
            'month' => $dateTime->month
        ]);

        $time = new TimeDto([
            'hour' => $dateTime->hour,
            'minute' => $dateTime->minute
        ]);
        return $this->dateToString($date) . ' ' . $this->timeToString($time);
    }

    private function booleanToString($value)
    {
        if ($value) {
            return 1;
        } else {
            return 0;
        }
    }

    public function serializeToBd()
    {
        $reflect = new \ReflectionClass($this);
        $public = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        $list = [];

        foreach ($public as $item) {
            $key = $item->name;
            $value = $this->{$key};
            $list[$key] = $this->typeToString($key, $value);
        }
        if (property_exists($this, 'password') && $this->password) {
            $list['password'] = md5($this->password);
        }
        unset ($list['id']);
        return $list;
    }

}