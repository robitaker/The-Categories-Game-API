<?php

class DB
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Conn::getInstance();
    }

    public function getThemes()
    {

        try {
            $sql = "SELECT * FROM themes";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            //print_r($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function checkAnswer($arr)
    {
        
        $minimum = 3;
        $response = [];

        try {
            foreach ($arr as $key => $answer) {

                $table = Themes::getTableName($answer["theme_id"]);
                
                if (!$table) {
                    $response[] = false;
                    continue;
                }

                if (strlen($answer["answer"]) < $minimum) {
                   $response[] = false;
                   continue;
                }

                if (substr($answer["answer"], 0, 1) != $answer["letter"]) {
                    $response[] = false;
                    continue;
                }

                $exactAnswer = $this->checkExactAnswer($table, $answer["answer"]);
                if ($exactAnswer["exist"]) {
                    $response[] = $answer["answer"];
                    continue;
                }


                $sql = "SELECT answer FROM $table WHERE id_theme = ? AND answer LIKE ? LIMIT 1";
                $stmt = $this->pdo->prepare($sql);

                $stmt->execute([
                    $answer["theme_id"],
                    '%'.$answer["answer"].'%'
                ]);

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($data) {
                    $response[] = $data["answer"];
                } else {
                    $response[] = false;
                }
            }

            return $response;

        } catch (PDOException $e) {
            //print_r($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function checkExactAnswer($table, $answer)
    {
        try {
            $sql = "SELECT EXISTS(SELECT 1 FROM $table WHERE answer = ?) AS exist;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$answer]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            //print_r($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }


}
