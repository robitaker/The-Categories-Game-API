<?php

class MainController
{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function Themes($request, $response, $args)
    {

        try {

            $message = [];
            $themes = $this->db->getThemes();

            if (count($themes) > 0) {
                $message = $themes;
            } else {
               throw new Exception("themes_not_found");
            }

            return ContentRenderer::renderJSON($response, $message);

        } catch (Exception $e) {
            return ContentRenderer::renderJSON($response, resMessages::messages($e->getMessage()));
        }

    }

    public function Answers($request, $response, $args)
    {

        try {

            $message = ["code" => 200];
            $answers = Validator::validRequestAnswers($request);

            $resultsDB = $this->db->checkAnswer($answers);
            $results = [];

            foreach ($resultsDB as $key => $value) {
                if ($value) {
                    $answered = $answers[$key]["answer"];
                    $results[] = [
                        "found" => true,
                        "theme_id" => $answers[$key]["theme_id"],
                        "answered" => $answered,
                        "correct" => $value,
                        "letter" => $answers[$key]["letter"],
                        "pontuation" => Tools::somePontuation($answered, $value)
                    ];
                } else {
                    $results[] = [
                        "found" => false,
                        "theme_id" => $answers[$key]["theme_id"],
                        "answered" => $answers[$key]["answer"],
                        "correct" => null,
                        "letter" => $answers[$key]["letter"],
                        "pontuation" => 0
                    ];
                }
            }

            $message["results"] = $results;
            

            return ContentRenderer::renderJSON($response, $message);

        } catch (Exception $e) {
            return ContentRenderer::renderJSON($response, resMessages::messages($e->getMessage()));
        }

    }



    public function unauthorized($request, $response, $args)
    {
        return ContentRenderer::renderJSON($response, resMessages::messages("unauthorized"));
    }

}
