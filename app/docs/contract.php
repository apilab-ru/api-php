<?php
// $date "20" сентября
// $customerName
// $langNameDative английскому
// $docNumber 5/12.09.2018
// $year 2018
// $level А2
// $dateStart «5» сентября 2017
// $dateEnd «24» ноября 2017
// $groupTypeGenitive вечерней
// $membersCount 10
// $scheduleString с 18 ч 00 мин до 19 ч 30 мин во вторник и пятницу
// $address пр-т Победы, 15, оф. 299.
// $price
// $priceString
// $customerPhone
// $customerEmail
// $hours 48
// $hoursString академических часов
// $description
?>
<!DOCTYPE html>
<html>
<body>
<style>
    p {
        margin: 0;
        direction: ltr;
        widows: 2;
        orphans: 2;
        text-align: justify;
    }

    * {
        font-family: 'Times New Roman', serif;
        font-size: 1em;
    }

    .requisites p {
        margin-top: 0;
        text-align: left;
        font-family: 'Times New Roman', serif;
        line-height: 1em;
    }

    h4 {
        text-align: center;
        margin-top: 2em;
    }

    .main-title {
        text-align: center;
        margin-bottom: 0;
        margin-top: 0;
    }

    .sub-title {
        text-align: center;
        font-family: 'Times New Roman', serif;
    }

    .date {
        text-align: right;
    }

    .text {
        font-family: 'Times New Roman', serif;
    }
</style>
<h4 class="main-title">
    ДОГОВОР № <?= $docNumber ?>
</h4>
<p class="sub-title">
    о платных услугах в сфере образования
</p>

<p class="date">
    <?= $date ?> <?= $year ?> г., Витебск
</p>
<br>

<p>
    Образовательный центр «Леон», в лице индивидуального предпринимателя Чечельницкой Елизаветы Михайловны,
    действующего на основании Свидетельства о государственной регистрации индивидуального предпринимателя
    № 0627176, выданного Администрацией Первомайского района г. Витебска 26 октября 2016 года,
    регистрационный номер 391686279, именуемый в дальнейшем «Исполнитель»,
    с одной стороны, и <?= $customerName ?>, именуемый в дальнейшем «Заказчик», с другой стороны,
    заключили настоящий договор о нижеследующем:
</p>
<h4>1. ПРЕДМЕТ ДОГОВОРА</h4>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    1.1. Исполнитель принимает на себя обязательства
    по предоставлению Заказчику образовательных
    услуг (репетиторство) по <?= $langNameDative ?> языку.
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    1.2. Образовательные услуги оказываются в
    соответствии с расписанием занятий,
    которое содержится в п. 2.5 настоящего
    Договора.
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    1.3. Заказчик обязуется оплатить Исполнителю
    данные услуги в порядке и на условиях,
    установленных настоящим Договором.
</p>

<h4>2. УСЛОВИЯ ОБУЧЕНИЯ</h4>

<p align=justify style="margin-bottom: 0in; line-height: 100%">
    2.1. Обучение проводится по авторской программе Исполнителя Leon
    <?= $description ?>. Программа курса рассчитана на <?= $hours ?> <?= $hoursString ?> (1 час -45 минут). Уровень <?= $level ?>.
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    2.2. Начало второго этапа курса: <?= $dateStart ?> года.
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">2.3.
    Окончание курсов: <?= $dateEnd ?> года.
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">2.4.
    Занятия проходят в <?= $groupTypeGenitive ?> группе численностью <?= $membersCount ?> человек.</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">2.5.
    Время проведения занятий: <?= $scheduleString ?>.</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">2.5.
    Место проведения занятий: г. Витебск, <?= $address ?>
</p>

<h4>3. ПРАВА И ОБЯЗАННОСТИ СТОРОН</h4>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    3.1. Исполнитель обязуется:
</p>
<p align=justify style="margin-left: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.1.1. Организовать
    и обеспечить надлежащее оказание услуг,
    предусмотренных п. 1.1 настоящего Договора.</p>
<p align=justify style="margin-left: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.1.2. Организовать материально-техническое обеспечение образовательного процесса
    в соответствии с установленными санитарными нормами, правилами и гигиеническими нормативами;
</p>
<p align=justify style="text-indent: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.1.3. Обеспечить Учеников учебно-методическими материалами и литературой.
</p>
<p align=justify style="margin-left: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.1.4. Провести тестирование Учеников по итогам обучения и результаты довести до сведения Заказчика.
</p>
<p align=justify style="text-indent: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.1.5. Провести 3 бесплатных отработки с учеником при пропуске занятий по обоюдной договоренности.
</p>
<p align=justify style="text-indent: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.2. Заказчик обязуется:
</p>
<p align=justify style="text-indent: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.2.1. Посещать все занятия курса и выполнять рекомендации преподавателя надлежащим образом.
</p>
<p align=justify style="text-indent: 0.1in; margin-bottom: 0in; line-height: 100%">
    3.2.2. Предупредить преподавателя о намерении пропустить занятие за 3 часа до начала урока.
</p>

<h4>4. РАЗМЕР И ПОРЯДОК ОПЛАТЫ УСЛУГ ИСПОЛНИТЕЛЯ</h4>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    4.1. Стоимость обучения за курс по программе, указанной в п. 2.1 настоящего Договора
    составляет <?= $price ?>(<?= $priceString ?>) белорусских рублей.
</p>
<div style="background: yellow">
    <p align=justify style="margin-bottom: 0in; line-height: 100%">
        4.2. Оплата услуг Исполнителя производится ежемесячно в размере
        100 (сто) белорусских рублей и осуществляется в следующие сроки:
    </p>
    <p align=justify style="margin-bottom: 0in; line-height: 100%">
        первая часть оплаты - до 15 сентября 2017г.;
    </p>
    <p align=justify style="margin-bottom: 0in; line-height: 100%">
        вторая часть оплаты – до 5 октября 2017 г.;
    </p>
    <p align=justify style="margin-bottom: 0in; line-height: 100%">
        третья часть оплаты – до 5 ноября 2017 г.
    </p>
</div>

<p style="margin-bottom: 0in; line-height: 100%">
    4.3. Оплата за обучение на основании настоящего договора осуществляется
    Заказчиком на текущий <b>(расчетный) счет Исполнителя BY02ALFA30132169240130270000 в
        ЗАО «АЛЬФА-БАНК» 220013 г. Минск, ул. Сурганова 43-47,БИК ALFABY2X.</b>
</p>

<h4>5.ОТВЕТСТВЕННОСТЬ СТОРОН</h4>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    5.1. За неисполнение или ненадлежащее исполнение своих обязательств по
    настоящему договору стороны несут ответственность в соответствии с законодательством Республики Беларусь;
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    5.2. При нарушении сроков оплаты, предусмотренных пунктом 4.2 настоящего
    договора, Плательщик выплачивает пеню в размере 0,1% от суммы просроченных
    платежей за каждый день просрочки. Пеня начисляется со следующего дня после истечения срока оплаты.
</p>

<h4>6.ЗАКЛЮЧИТЕЛЬНЫЕ ПОЛОЖЕНИЯ</h4>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    6.1. Настоящий договор составлен в 2 экземплярах, имеющих одинаковую
    юридическую силу, по одному для каждой из сторон;
</p>
<p align=justify style="margin-bottom: 0in; line-height: 100%">
    6.2. Договор вступает в силу со дня его подписания сторонами и действует до
    исполнения сторонами своих обязательств.
</p>

<h4>7. АДРЕСА, РЕКВИЗИТЫ И ПОДПИСИ СТОРОН:</h4>
<table class="requisites" align="top">
    <tr>
        <td style="vertical-align: top;">
            <p class="text">
                ИСПОЛНИТЕЛЬ:
            </p>
            <br>
            <p class="text">
                ИП Чечельницкая Е.М.
            </p>
            <p class="text">
                г. Витебск, ул. Чкалова, 56-106
            </p>
            <p class="text">
                УНП 391686279<BR>
                BY02ALFA30132169240130270000
            </p>
            <p class="text">
                в ЗАО «АЛЬФА-БАНК» 220013 г. Минск, <BR>
                ул.Сурганова 43-47, БИКALFABY2X,
            </p>
            <p class="text">
                Тел: +375 29 8944999
            </p>
            <p class="text">
                Индивидуальный предприниматель
            </p>
        </td>
        <td></td>
        <td style="vertical-align: top;">
            <p class="text">
                ЗАКАЗЧИК:
            </p>
            <br>
            <p class="text">
                ФИО: <?= $customerName ?>
            </p>
            <p class="text">
                Тел.: <?= $customerPhone ?>
            </p>
            <p class="text">
                E-Mail: <?= $customerEmail ?>
            </p>
            <p class="text">
                Адрес: <?= $customerAddress ?>
            </p>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: top;">
            <p>
                _________________________/
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
            </p>
            <p class="text">
                б.п.
            </p>
        </td>
        <td></td>
        <td style="vertical-align: top;">
            <p>
                _________________________/
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
            </p>
        </td>
    </tr>
</table>
</body>
</html>