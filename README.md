
# API for the game: Categories game or (Scattergories, City Country River, Stop)

I have developed this small application as a basis for creating a game. Its main functionality is to list all available themes and evaluate responses, assigning a score from 0 to 10 based on the accuracy of the answers provided.

The database currently encompasses 12 themes and 106,435 possible responses. The project was primarily crafted with a focus on English, Portuguese, and Spanish languages. However, it also includes responses in various other languages.

Technologies used: PHP and MySQL
## Composer


```bash
  composer install
```


## Installation

- Configure the database connection file `config/db.php`
- You can create all tables and insert data with the command:

```bash
  php install.php
```

The output should be something like:
```txt
Creating 'themes' table...
Creating 'theme_cities' table...
Creating 'theme_countries' table...
Creating 'theme_states_br' table...
Creating 'theme_capitals_br' table...
Creating 'theme_movies_br' table...
Creating 'theme_movies_en' table...
Creating 'theme_names' table...
Creating 'theme_fruits' table...
Creating 'theme_colors' table...
Creating 'theme_cars' table...
Creating 'theme_animals' table...
Creating 'theme_sports' table...
Tables created! starting data recording...
Starting to read and insert records, this may take a while...
Waiting...
56459 rows inserted in theme_cities table
Waiting...
240 rows inserted in theme_countries table
Waiting...
27 rows inserted in theme_states_br table
Waiting...
27 rows inserted in theme_capitals_br table
Waiting...
13680 rows inserted in theme_movies_br table
Waiting...
8724 rows inserted in theme_movies_en table
Waiting...
21982 rows inserted in theme_names table
Waiting...
261 rows inserted in theme_fruits table
Waiting...
349 rows inserted in theme_colors table
Waiting...
931 rows inserted in theme_cars table
Waiting...
712 rows inserted in theme_animals table
Waiting...
3043 rows inserted in theme_sports table
Finish! 106435 records were counted in all themes!
```
- Or you can configure manually by uploading the file  `stop.sql`
## Add and remove themes

Remove and add new themes at any time just by editing the file: `config/themes.php`



#### Example

```php
$themes = [
    [
        "id" => 1, // ID that will be referenced
        "theme" => "Cities", // Theme title
        "language" => "all", //What language are the answers in.
        "description" => "Cities all over the world.", // Theme description
        "table" => "theme_cities", // Name of the table that will be created in the DB
        "file" => "theme_cities.txt" // File containing the answers
    ]
];
```

- Create a txt file with all responses to be included in the database in the folder `config/data/`
- The file name must be the same as that referenced in the parameter `file`

### Example
- theme_fruits.txt
```txt
apple
apricot
avocado
banana
bell pepper
bilberry
blackberry
blackcurrant
blood orange
blueberry
```
- Run the `php install.php` command again to add the new data.



## API documentation

#### Returns the list of all themes

```http
  GET /api/themes
```
#### Response:
```json
[
    {
        "id": "1",
        "title": "Cities",
        "language": "all",
        "description": "Cities all over the world.",
        "quantity": "56459"
    },
    {
        "id": "2",
        "title": "Countries",
        "language": "all",
        "description": "Any country in the world.",
        "quantity": "240"
    },
    {
        "id": "3",
        "title": "Brazil states",
        "language": "pt_br",
        "description": "A Brazilian state.",
        "quantity": "27"
    },
    {
        "id": "4",
        "title": "Capitals of Brazil",
        "language": "pt_br",
        "description": "A capital in Brazil.",
        "quantity": "27"
    },
    {
        "id": "5",
        "title": "Movies and series (Brazilian)",
        "language": "pt_br",
        "description": "Films and series all over the world, but written in Portuguese.",
        "quantity": "13680"
    },
    {
        "id": "6",
        "title": "Movies and series (U.S)",
        "language": "en_us",
        "description": "Films and series all over the world, but written in English.",
        "quantity": "8724"
    },
    {
        "id": "7",
        "title": "Personal names",
        "language": "all",
        "description": "Personal first name.",
        "quantity": "21982"
    },
    {
        "id": "8",
        "title": "Fruits",
        "language": "all",
        "description": "Name of a fruit.",
        "quantity": "261"
    },
    {
        "id": "9",
        "title": "Colors",
        "language": "all",
        "description": "Name of a color.",
        "quantity": "349"
    },
    {
        "id": "10",
        "title": "Cars and brands",
        "language": "all",
        "description": "Name of automotive brands or car models.",
        "quantity": "931"
    },
    {
        "id": "11",
        "title": "Animals",
        "language": "all",
        "description": "Any type of animals",
        "quantity": "712"
    },
    {
        "id": "12",
        "title": "Sports",
        "language": "all",
        "description": "Sports from around the world.",
        "quantity": "3043"
    }
]
```

#### Correct your answers

- Content-Type: application/json

```http
  POST /api/answers
```
| Parameter   | Type       | Description                                   |
| :---------- | :--------- | :------------------------------------------ |
| `answers`      | `json` | **Mandatory**. Questions to be corrected |

#### Request:
```json
{
    "answers": [
            {
                "theme_id": 8,
                "letter": "a",
                "answer": "apple"
            },
            {
                "theme_id": 9,
                "letter": "w",
                "answer": "whit"
            }
    ]
}
```
#### Response:
```json
{
    "code": 200,
    "results": [
        {
            "found": true,
            "theme_id": 8,
            "answered": "apple",
            "correct": "apple",
            "letter": "a",
            "pontuation": 10
        },
        {
            "found": true,
            "theme_id": 9,
            "answered": "whit",
            "correct": "white",
            "letter": "w",
            "pontuation": 8
        }
    ]
}
```

## Finishing

I hope this repository serves your purpose. You are welcome to contribute in any way you want.

