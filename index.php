<?php
    header('Content-Type: application/JSON');
    $metodo=$_SERVER['REQUEST_METHOD'];

    switch($metodo){
        case 'GET':
            if($_GET['accion']=='persona'){
                try {
                    $DBH = new PDO( "mysql:host=localhost;dbname=mitiendita", "root", "" );
                } catch ( PDOException $e ) {
                    echo $e->getMessage ();
                }
                if (isset( $_GET ['id'] )) { // muestra el registro con id
                    $resultado = $DBH->prepare( 'SELECT * FROM persona WHERE idpersona = :p');
                    $resultado->bindParam ( ':p', $_GET ['id'] );
                    $resultado->execute();
                    $response = $resultado->fetchALL( PDO::FETCH_ASSOC );
                    echo json_encode( $response, JSON_PRETTY_PRINT );
                } else { // muestra todos los registros
                    $resultado = $DBH->prepare( 'SELECT * FROM persona' );
                    $resultado->execute();
                    $response = $resultado->fetchALL( PDO::FETCH_ASSOC );
                    echo json_encode( $response, JSON_PRETTY_PRINT );
                }
            }
            break;
        case 'POST': //Create
            if($_GET['accion']=='insertPersona'){
                try {
                    $DBH = new PDO( "mysql:host=localhost;dbname=mitiendita", "root", "");
                } catch ( PDOException $e ) {
                    echo $e->getMessage ();
                }
                if (isset( $_GET ['name'] )) { 
                    $resultado = $DBH->prepare('INSERT INTO persona (name) VALUES (:p)');
                    $resultado->bindParam ( ':p', $_GET ['name']);
                    if($resultado->execute()){
                        echo 'Se ha insertado la persona';
                    }else{
                        echo 'No se ha podido realizar la insercción';
                    }
                }else{ 
                    $resultado = $DBH->prepare('INSERT INTO persona (name) VALUES ("Vanessa")');
                    if($resultado->execute()){
                        echo 'La persona ha sido insertada';
                    }else{
                        echo 'No se ha podido insertar a la persona';
                    }
                }
            }
            break;
        case 'PUT': //Update
            if($_GET['accion']=='updatePersona'){
                try {
                    $DBH = new PDO( "mysql:host=localhost;dbname=mitiendita", "root", "");
                } catch ( PDOException $e ) {
                    echo $e->getMessage ();
                }
                if (isset( $_GET ['id'] ) && isset( $_GET ['name'] )) { //Se manda el id y el nombre
                    $resultado = $DBH->prepare('UPDATE persona SET name= :n WHERE idPersona = :i');
                    $resultado->bindParam ( ':n', $_GET ['name']);
                    $resultado->bindParam ( ':i', $_GET ['id']);
                    if($resultado->execute()){
                        echo 'Actualización exitosa';
                    }else{
                        echo 'Falló al actualizar a la persona';
                    }
                }
            }
            break;
        case 'DELETE':
            if($_GET['accion']=='deletePersona'){
                try {
                    $DBH = new PDO( "mysql:host=localhost;dbname=mitiendita", "root", "");
                } catch ( PDOException $e ) {
                    echo $e->getMessage ();
                }
                if (isset( $_GET ['id'] )) { //Esta mandando el id
                    $resultado = $DBH->prepare('DELETE FROM persona WHERE idPersona = :i');
                    $resultado->bindParam ( ':i', $_GET ['id']);
                    if($resultado->execute()){
                        echo 'La persona ha sido eliminada';
                    }else{
                        echo 'No se pudo eliminar a la persona';
                    }
                }
            }
            break;
        default:
            echo 'Método no soportado';
            break;
    }

?>