<?php

function getAll($tbl){
    $pdo = Database::getInstance()->getConnection();
    $queryALL = 'SELECT * FROM ' .$tbl;
    $results = $pdo->query($queryALL);
    //var_dump($queryALL);exit;

    if($results){
        return $results;
    }else{
        return 'There was a problem accessing info';
    
    }
}

function getSingleMovie($tbl, $col, $id){
    //TO DO: finish the function based on getAll. this time only return
    // one movie's field

    $pdo = Database::getInstance()->getConnection();
    $query = "SELECT * FROM $tbl WHERE $col = $id";
    $results = $pdo->query($query);

    if($results){
        return $results;
    }else{
        return 'There was a problem accessing info';
    
    }


}

function getMoviesByFilter($args){
    $pdo = Database::getInstance()->getConnection();

    $filterQuery = 'SELECT * FROM '.$args['tbl'].' AS t, '.$args['tbl2'].' AS t2, '.$args['tbl3'] .' AS t3';
    $filterQuery .= ' WHERE t.'.$args['col'].' = t3.'.$args['col'];
    $filterQuery .= ' AND t2.'.$args['col2'].' = t3.'.$args['col2'];
    $filterQuery .= ' AND t2.'.$args['col3'].' = "'.$args['filter'].'"';




    $results = $pdo->query($filterQuery);

    // var_dump($filterQuery);exit;

    if($results){
        return $results;
    }else{
        return 'There was a problem accessing info';
    
    }


}


