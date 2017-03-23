<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: datetime_format_helper.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
//@codeCoverageIgnoreStart
function now($format=SYSTEM_DATE_FORMAT)
{
    $now = new DateTime('now', new DateTimeZone(DATETIME_ZONE));
    return $now->format($format);
}

function today($format=SYSTEM_DATE_FORMAT)
{
    $today = new DateTime('today', new DateTimeZone(DATETIME_ZONE));
    return $today->format($format);
}

function format_system($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format(SYSTEM_DATE_FORMAT);
}

function format_dd_mm_yyyy($datetime_str, $seperator='-')
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('d' . $seperator . 'm' . $seperator . 'Y');
}

function format_mm_dd_yyyy($datetime_str, $seperator='-')
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('m' . $seperator . 'd' . $seperator . 'Y');
}

function format_yyyy_mm_dd($datetime_str, $seperator='-')
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('Y' . $seperator . 'm' . $seperator . 'd');
}

function format_dd_mm_yyyy_hh_ii_ss($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('d-m-Y H:i:s');
}

function format_yyyy_mm_dd_hh_ii_ss($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('Y-m-d H:i:s');
}

function format_dd_mmm_yyyy($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('d M Y');
}

function format_dd_mmm_yyyy_hh_ii_ss($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('d M Y, H:i:s');
}

function format_iso($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('c');
}

function format_rfc($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('r');
}

function format_full_date($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('i, d F Y, H:i:s');
}

function format_migration($datetime_str)
{
    $datetime = new DateTime($datetime_str, new DateTimeZone(DATETIME_ZONE));
    return $datetime->format('YmdHis');
}
//@codeCoverageIgnoreEnd