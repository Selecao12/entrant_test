<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 20.05.2019
 * Time: 1:16
 */

class Test
{

    /**
     * Check uploaded test format and returns formatted test
     *
     * @param string $uploadedTest
     * @return false|string
     */
    public static function formatTest($uploadedTest) {

        $uploadedTestArray = explode("\n", $uploadedTest);

        $formattedTest = [];

        $questionCount = 0;

        foreach ($uploadedTestArray as $string) {

            // выделить из строки часть, идущую до закрывающей скобки
            $caption = mb_strstr($string, ')', true);

            // если часть до скобки - число, то это вопрос
            if (is_numeric($caption)) {

                $formattedTest[] = [
                    'question' => trim(mb_substr(mb_strstr($string, ')', false), 1)),
                    'true' => [],
                    'false' => []
                ];
                $questionCount++;

                continue;
            }

            // если часть до скобки - не число, то это вариант ответа
            if (!is_numeric($caption)) {

                // если счетчик вопросов на нуле, то возвращаем ошибку
                if ($questionCount == 0) {
                    return false;
                }

                // если в варианте ответа есть плюс, то помещаем в подмассив true
                if (mb_substr($caption, 0, 1) === '+') {
                    $formattedTest[$questionCount - 1]['true'][] = trim(mb_substr(mb_strstr($string, ')', false), 1));
                    continue;
                }

                // если в варианте ответа нет плюса, то помещаем в подмассив false
                if (mb_substr($caption, 0, 1) !== '+') {
                    $formattedTest[$questionCount - 1]['false'][] = trim(mb_substr(mb_strstr($string, ')', false), 1));
                    continue;
                }
            }
        }

        $formattedTest = json_encode($formattedTest);

        return $formattedTest;
    }


    /**
     * Return formatted test for preview
     *
     * @param string $uploadedTest
     * @return mixed formattedTest
     */
    public static function previewFormattedTest($uploadedTest)
    {
        // отформатировать загруженный тест
        $formattedTest = self::formatTest($uploadedTest);

        // представить

        return $formattedTest;
    }
}