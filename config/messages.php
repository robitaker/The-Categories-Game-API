<?php

    
    class resMessages {

        public static function messages ($code) {

            $messages = [
                //API
                "generic" => [
                    "code" => 400,
                    "message" => "Something went wrong."
                ],
                "unauthorized" => [
                    "code" => 401,
                    "message" => "unauthorized"
                ],
                "themes_not_found" => [
                    "code" => 400,
                    "message" => "No themes were found."
                ],
                "invalid_content_type" => [
                    "code" => 400,
                    "message" => "Invalid content type."
                ],

                "answers_not_found" => [
                    "code" => 400,
                    "message" => "No answer was sent to the request."
                ],
                "answers_too_many" => [
                    "code" => 400,
                    "message" => "The maximum number of answers is 10."
                ],
                "theme_id_not_found" => [
                    "code" => 400,
                    "Error in one or more questions, index not found: theme_id"
                ],
                "answer_not_found" => [
                    "code" => 400,
                    "Error in one or more questions, index not found: answer"
                ],
                "invalid_theme_id" => [
                    "code" => 400,
                    "Error in one or more questions, theme_id must be an integer."
                ],
                "letter_not_found" => [
                    "code" => 400,
                    "Error in one or more questions, index not found: letter"
                ],
                "invalid_letter" => [
                    "code" => 400,
                    "Error in one or more questions in the index letter: It must be only one alphabetical letter"
                ]

            ];

            if (array_key_exists($code, $messages)) {
                return $messages[$code];
            } else {
                return $messages["generic"];
            }
        }
    }


?>