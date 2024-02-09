<?php

    class Tools {


        public static function getDate($time, $uni = "hours") {
            return date("Y-m-d H:i:s", strtotime("+". $time ." ". $uni));
        }

        public static function prepareString($string) {
            $string = trim($string);
            $string = strtolower($string);
            $string = preg_replace('/[^\p{L}0-9\s]/u', '', $string);
            $normalized = Normalizer::normalize($string, Normalizer::NFD);
            return preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);

        }

        public static function removeAccents($string) {
            $normalized = Normalizer::normalize($string, Normalizer::NFD);
            return preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);
        }


        public static function somePontuation($answered, $correct) {
            $distance = levenshtein($answered, $correct);
            $maxTamanho = max(strlen($answered), strlen($correct));
            $similaridade = 1 - ($distance / $maxTamanho);
            $pontuacao = $similaridade * 10;
            return floor($pontuacao);
        }

    }

?>