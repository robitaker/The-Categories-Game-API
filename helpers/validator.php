<?php

class Validator
{

    public static function validRequestAnswers($request)
    {
        $content_type = $request->getHeaderLine('Content-Type');

        if (strtolower($content_type) != 'application/json') {
            throw new Exception("invalid_content_type");
        }

        $data = json_decode($request->getBody(), true);
        $answers = isset($data["answers"]) ? $data["answers"] : [];
        
        if (count($answers) == 0) {
            throw new Exception("answers_not_found");
        } else if (count($answers) > 10) {
            throw new Exception("answers_too_many");
        }

        $theme_ids = [];
        $newData = [];

        foreach ($answers as $answer) {
            if (!isset($answer["theme_id"])) {
                throw new Exception("theme_id_not_found");
            }

            if (!self::validNum($answer["theme_id"])) {
                throw new Exception("invalid_theme_id");
            }

            if (!isset($answer["letter"])) {
                throw new Exception("letter_not_found");
            }

            if (!self::validLetter($answer["letter"]) || strlen($answer["letter"]) != 1) {
                throw new Exception("invalid_letter");
                
            }

            
            if (!isset($answer["answer"])) {
                throw new Exception("answer_not_found");
            }

            //$theme_ids[] = $answer["theme_id"];
            $newData[] = [
                "theme_id" => $answer["theme_id"],
                "letter" => strtolower($answer["letter"]),
                "answer" => Tools::prepareString($answer["answer"])
            ];
        }


        return $newData;

    }

    public static function validNum($num) {
        return preg_match('/^[0-9]+$/', $num) === 1;
    }

    public static function validLetter($letter) {
        return preg_match('/^[a-zA-Z]+$/', $letter) === 1;
    }


}
