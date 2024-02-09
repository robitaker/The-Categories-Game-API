<?php

require "./config/db.php";
require "./config/messages.php";
require "./config/themes.php";
require "./helpers/tools.php";

function setup()
{
    $pdo = Conn::getInstance(); // connect to db
    $themes = Themes::setThemes(); // set themes in config
    $directory = "./config/data/"; // data directory

    try {

        echo "Creating 'themes' table..." . PHP_EOL;
        createTableThemes($pdo, "themes");

        foreach ($themes as $key => $value) {
            $table = $value['table'];
            $newTheme = [
                $value['id'],
                $value['theme'],
                $value['language'],
                $value['description'],
                0, // Quantity
            ];

            echo "Creating '$table' table..." . PHP_EOL;
            createTableTheme($pdo, $table);
            insertNewTheme($pdo, $newTheme);
        }

        echo "Tables created! starting data recording..." . PHP_EOL;
        $totalRegisters = 0;
        echo "Starting to read and insert records, this may take a while..." . PHP_EOL;

        foreach ($themes as $key => $value) {

            $id_theme = $value['id'];
            $file = $value['file'];
            $table = $value['table'];
            $totalThisTable = 0;

            if (file_exists($directory . $file)) {
                $readFile = file_get_contents($directory . $file);
                $lines = explode("\n", $readFile);
                if (count($lines) > 1) {

                    echo "Waiting..." . PHP_EOL;

                    foreach ($lines as $key => $value) {
                        if (trim($value) == "") {
                            continue;
                        }
                        insertRegister($pdo, $table, [$id_theme, Tools::prepareString($value)]);
                        $totalThisTable += 1;
                        $totalRegisters += 1;
                    }

                    updateQuantityThemes($pdo, [$totalThisTable, $id_theme]);
                    echo "{$totalThisTable} rows inserted in {$table} table" . PHP_EOL;

                } else {
                    echo "Attention: File {$file} is empty!" . PHP_EOL;
                }
            } else {
                echo "Attention: File {$directory}{$file} not found!" . PHP_EOL;
            }
        }

        echo "Finish! ${totalRegisters} records were counted in all themes!" . PHP_EOL;

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }
}

function createTableThemes($pdo, $table)
{
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100),
            language VARCHAR(15),
            description TEXT,
            quantity INT(10)
        );";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function createTableTheme($pdo, $table)
{
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_theme INT(10),
            answer VARCHAR(100),
            INDEX id_theme_index (id_theme),
            UNIQUE KEY unique_answer (answer)
        );";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

 function updateQuantityThemes($pdo, $params)
{
    try {
        $sql = "UPDATE themes SET quantity = ? WHERE id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function insertNewTheme($pdo, $data)
{
    try {
        $sql = "INSERT IGNORE INTO themes (id, title, language, description, quantity) VALUES (?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

function insertRegister($pdo, $table, $data){
    try {
        $sql = "INSERT IGNORE INTO $table (id_theme, answer) VALUES (?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

// init setup
setup();