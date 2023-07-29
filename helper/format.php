<?php
function currency_format($number, $suffix = ' ₫')
{
    return number_format($number, '0', ',', '.') . $suffix;
}
