<?php 
error_reporting( E_ALL );
ini_set('display_errors', '1');

class Books {
    public function insert($conn, $books) {

        $sql = "INSERT INTO books (
                    title,
                    author,
                    genre,
                    kind,
                    epoch,
                    url,
                    slug
                ) VALUES (
                    :title,
                    :author,
                    :genre,
                    :kind,
                    :epoch,
                    :url,
                    :slug
                )";

        try {
            $stmt = $conn -> prepare($sql);
            
            $stmt -> bindValue(":title", $books["title"], PDO::PARAM_STR);
            $stmt -> bindValue(":author", $books["author"], PDO::PARAM_STR);
            $stmt -> bindValue(":genre", $books["genre"], PDO::PARAM_STR);
            $stmt -> bindValue(":kind", $books["kind"], PDO::PARAM_STR);
            $stmt -> bindValue(":epoch", $books["epoch"], PDO::PARAM_STR);
            $stmt -> bindValue(":url", $books["url"], PDO::PARAM_STR);
            $stmt -> bindValue(":slug", $books["slug"], PDO::PARAM_STR);
            
            $stmt -> execute();
        } catch (PDOException $e) { 
            print "". $e -> getMessage() ."";
        }

        // binding inserting Values
    }

    public function getAllBooks($conn) {

        $sql = "SELECT *
                FROM books";
        
        $stmt = $conn -> prepare($sql);

        if ( $stmt -> execute() ) {

            //! to return an assosiative array
            //! returns false if not found
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getPages($conn, $limit, $offset, $order, $type) {

        if ($order == "not") {
            
            $sql = "SELECT *
                FROM books
                LIMIT :limit
                OFFSET :offset";
        
            $stmt = $conn -> prepare($sql);

            $stmt -> bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt -> bindValue(":offset", $offset, PDO::PARAM_INT);


            if ( $stmt -> execute() ) {
                return $stmt -> fetchAll(PDO::FETCH_ASSOC);
            }

        } else {

            $sql = "SELECT *
                FROM books
                ORDER BY $order 
                $type
                LIMIT :limit
                OFFSET :offset";

            $stmt = $conn -> prepare($sql);

            $stmt -> bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt -> bindValue(":offset", $offset, PDO::PARAM_INT); 

            if ( $stmt -> execute() ) {
                return $stmt -> fetchAll(PDO::FETCH_ASSOC);
            }
        }

    }

    public function getTotalRecords($conn) {

        $sql = "SELECT COUNT(*)
                FROM books";

        return $conn->query($sql) -> fetchColumn();

    }

}