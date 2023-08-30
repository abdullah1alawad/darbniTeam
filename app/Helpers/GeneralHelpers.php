<?php


if (!function_exists('exams_date')) {
    function exams_date($month, $year): string
    {
        switch ($month) {
            case 1:
                return "$year " . "دورة" . "يناير";
            case 2:
                return "$year" . 'دورة' . "فبراير";
            case 3:
                return "$year " . "دورة" . "مارس";
            case 4:
                return "$year" . 'دورة' . "إبريل";
            case 5:
                return "$year " . "دورة" . "مايو";
            case 6:
                return "$year" . 'دورة' . "يونيو";
            case 7:
                return "$year " . "دورة" . "يوليو";
            case 8:
                return "$year" . 'دورة' . "أغسطس";
            case 9:
                return "$year " . "دورة" . "سبتمبر";
            case 10:
                return "$year" . 'دورة' . "أكتوبر";
            case 11:
                return "$year" . 'دورة' . "نوفمبر";
            case 12:
                return "$year" . 'دورة' . "ديسمبر";
            default:
                return 'no kidding';

        }
    }
}

if (!function_exists('addPhoto')) {
    function    addPhoto($photo, $folder): string
    {
        $photoName = $photo;
        $fileName = time() . '.' . $photoName->getClientOriginalExtension();
        $photoName->move(public_path($folder), $fileName);

        return $fileName;
    }
}
