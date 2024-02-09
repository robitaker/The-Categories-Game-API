<?php

class Themes
{

    public static function setThemes()
    {
        $themes = [
            [
                "id" => 1,
                "theme" => "Cities",
                "language" => "all",
                "description" => "Cities all over the world.",
                "table" => "theme_cities",
                "file" => "theme_cities.txt"
            ],
            [
                "id" => 2,
                "theme" => "Countries",
                "language" => "all",
                "description" => "Any country in the world.",
                "table" => "theme_countries",
                "file" => "theme_countries.txt"
            ],
            [
                "id" => 3,
                "theme" => "Brazil states",
                "language" => "pt_br",
                "description" => "A Brazilian state.",
                "table" => "theme_states_br",
                "file" => "theme_states_br.txt"
            ],
            [
                "id" => 4,
                "theme" => "Capitals of Brazil",
                "language" => "pt_br",
                "description" => "A capital in Brazil.",
                "table" => "theme_capitals_br",
                "file" => "theme_capitals_br.txt"
            ],
            [
                "id" => 5,
                "theme" => "Movies and series (Brazilian)",
                "language" => "pt_br",
                "description" => "Films and series all over the world, but written in Portuguese.",
                "table" => "theme_movies_br",
                "file" => "theme_movies_br.txt"
            ],
            [
                "id" => 6,
                "theme" => "Movies and series (U.S)",
                "language" => "en_us",
                "description" => "Films and series all over the world, but written in English.",
                "table" => "theme_movies_en",
                "file" => "theme_movies_en.txt"
            ],
            [
                "id" => 7,
                "theme" => "Personal names",
                "language" => "all",
                "description" => "Personal first name.",
                "table" => "theme_names",
                "file" => "theme_names.txt"
            ],
            [
                "id" => 8,
                "theme" => "Fruits",
                "language" => "all",
                "description" => "Name of a fruit.",
                "table" => "theme_fruits",
                "file" => "theme_fruits.txt"
            ],
            [
                "id" => 9,
                "theme" => "Colors",
                "language" => "all",
                "description" => "Name of a color.",
                "table" => "theme_colors",
                "file" => "theme_colors.txt"
            ],
            [
                "id" => 10,
                "theme" => "Cars and brands",
                "language" => "all",
                "description" => "Name of automotive brands or car models.",
                "table" => "theme_cars",
                "file" => "theme_cars.txt"
            ],
            [
                "id" => 11,
                "theme" => "Animals",
                "language" => "all",
                "description" => "Any type of animals",
                "table" => "theme_animals",
                "file" => "theme_animals.txt"
            ],
            [
                "id" => 12,
                "theme" => "Sports",
                "language" => "all",
                "description" => "Sports from around the world.",
                "table" => "theme_sports",
                "file" => "theme_sports.txt"
            ]

        ];
        return $themes;
    }

    public static function getTableName($id)
    {
        $themes = self::setThemes();
        foreach ($themes as $theme) {
            if ($theme['id'] == $id) {
                return $theme['table'];
            }
        }

        return false;
    }

}
