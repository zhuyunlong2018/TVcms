<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/24
 * Time: 13:39
 */

namespace app\lib;


/**
 *
 * @description: 正则表达式匹配
 */

class Regex
{

    /**
     *
     * @手机号
     */
    public static function Phone($subject)
    {
        $pattern = '/^(0|86|17951)?(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @匹配正则公共方法
     */
    public static function PublicMethod($pattern, $subject)
    {
        if (preg_match($pattern, $subject)) {
            return true;
        }
        return false;
    }

    /**
     *
     * @数字
     */
    public static function Number($subject)
    {
        $pattern = '/^[0-9]+$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @年份 格式：yyyy
     */
    public static function Year($subject)
    {
        $pattern = '/^(\d{4})$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @月份 格式:mm
     */
    public static function Month($subject)
    {
        $pattern = '/^0?([1-9])$|^(1[0-2])$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @日期 格式：yyyy-mm-dd
     */
    public static function Day($subject)
    {
        $pattern = '/^(\d{4})-(0?\d{1}|1[0-2])-(0?\d{1}|[12]\d{1}|3[01])$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @日期时间 格式：yyyy-mm-dd hh:ii:ss
     */
    public static function DateTime($subject)
    {
        $pattern = '/^(\d{4})-(0?\d{1}|1[0-2])-(0?\d{1}|[12]\d{1}|3[01])\s(0\d{1}|1\d{1}|2[0-3]):[0-5]\d{1}:([0-5]\d{1})$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @邮箱
     */
    public static function Email($subject)
    {
        $pattern = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @邮编
     */
    public static function Postcode($subject)
    {
        $pattern = '/[1-9]\d{5}(?!\d)/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @有效图片地址
     */
    public static function Photo($subject)
    {
        $pattern = '/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @URL地址
     */
    public static function UrlAddress($subject)
    {
        $pattern = '/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @有效HTTP地址
     */
    public static function EffectiveHttp($subject)
    {
        $pattern = '/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/';
        return Regex::PublicMethod($pattern, $subject);

    }

    /**
     *
     * @身份证
     */
    public static function Identity($subject)
    {
        $pattern = '/(^\d{15}$)|(^\d{17}([0-9]|X)$)/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @IPv4
     */
    public static function Ipv4($subject)
    {
        $pattern = '/^(((\d{1,2})|(1\d{2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{2})|(2[0-4]\d)|(25[0-5]))$/';
        return Regex::PublicMethod($pattern, $subject);
    }

    /**
     *
     * @IPv6
     */
    public static function Ipv6($subject)
    {
        $pattern = '/^([\da-fA-F]{1,4}:){7}[\da-fA-F]{1,4}$/';
        return Regex::PublicMethod($pattern, $subject);
    }
}