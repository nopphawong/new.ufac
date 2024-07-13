<?php

namespace App\Libraries;

class Formatter
{
    /**
     * Phone number formatter.
     */
    public static function phone_format($input)
    {
        // Keep only be digits.
        $strPhone = preg_replace("[^0-9]", '', $input);
        if (strlen($strPhone) != 10) {
            return $strPhone;
        }

        $strArea = substr($strPhone, 0, 3);
        $strPrefix = substr($strPhone, 3, 3);
        $strNumber = substr($strPhone, 6, 4);

        $strPhone = $strArea . '-' . $strPrefix . '-' . $strNumber;

        return $strPhone;
    }

    /**
     * Bank account number formatter.
     */
    public static function bank_ac_no_format($input)
    {
        // Keep only be digits.
        $strBankNo = preg_replace("[^0-9]", '', $input);
        if (strlen($strBankNo) != 10) return $strBankNo;

        $strFirst = substr($strBankNo, 0, 3);
        $strSecond = substr($strBankNo, 3, 1);
        $strThird = substr($strBankNo, 4, 5);
        $strFourth = substr($strBankNo, 9, 1);

        $strBankNo = $strFirst . '-' . $strSecond . '-' . $strThird . '-' . $strFourth;

        return $strBankNo;
    }

    /**
     * Bank translate formatter.
     */
    public static function bank_name_format($input)
    {
        return lang('Lang.bank_list.' . strtolower($input));
    }

     /**
     * Bank icon.
     */
    public static function bank_icon_format($input)
    {
        return strtolower($input);
    }

    /**
     * Transaction bank.
     */
    public static function transactionBank($input)
    {
        $split = explode('-', $input);
        if (count($split) == 2 || count($split) == 3) {
            $formatter = new Formatter;
            return $formatter->bank_name_format($split[0]);
        } else {
            return '';
        }
    }

    /**
     * Transaction bank account.
     */
    public static function transactionBankAccount($input)
    {
        $split = explode('-', $input);
        if (count($split) == 2 || count($split) == 3) {
            $formatter = new Formatter;
            return $formatter->bank_ac_no_format($split[1]);
        } else {
            return '';
        }
    }

    /**
     * Transaction bank icon.
     */
    public static function transactionBankIcon($input)
    {
        $split = explode('-', $input);
        if (count($split) == 2 || count($split) == 3) {
            $formatter = new Formatter;
            return strtolower($split[0]);
        } else {
            return '';
        }
    }

    /**
     * Transaction type.
     */
    public static function transactionTypeBackground($type)
    {
        switch ($type) {
            case 'ฝาก':
                return 'historyofdps';
            case 'ถอน':
                return 'historyofwd';
            case 'เพิ่มโบนัส':
                return 'historyofdps';
            default:
                return 'historyofwd';
        }
    }

    /**
     * Transaction type icon.
     */
    public static function transctionTypeIcon($type)
    {
        switch ($type) {
            case 'ฝาก':
                return 'fal fa-plus-circle plushis';
            case 'ถอน':
                return 'fal fa-minus-circle minushis';
            case 'เพิ่มโบนัส':
                return 'fal fa-plus-circle plushis';
            default:
                return 'fal fa-minus-circle minushis';
        }
    }

    /**
     * Transaction status.
     */
    public static function transactionStatus($status)
    {
        switch ($status) {
            case 'Y':
                return lang('Lang.history.successful');
            case 'C':
                return lang('Lang.history.cancel');
            default:
                return lang('Lang.history.pending');
        }
    }

    /**
     * Text color.
     */
    public static function colorStatus($status)
    {
        switch ($status) {
            case 'Y':
                return 'background: #619d61;';
            case 'C':
                return 'background: #db1b1b;';
            default:
                return 'background: #c98e15;';
        }
    }
}
