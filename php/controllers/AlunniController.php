<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{

  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE id = " . $args['id']);
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);
    
    
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("INSERT INTO alunni (nome, cognome) VALUES ('" . $body['nome'] . "', '" . $body['cognome'] . "' )");
    
    if($result){
      $response->getBody()->write(json_encode(["message" => "Alunno inserito"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }else{
      $response->getBody()->write(json_encode(["message" => "Errore Inserimento"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
  }

  public function update(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "UPDATE alunni SET nome = '" .$body['nome']. "', cognome = '" .$body['cognome']. "' WHERE id = " .$args['id'];
    $result = $mysqli_connection->query($query);

    if($result){
      $response->getBody()->write(json_encode(["message" => "Alunno aggiornato"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }else{
      $response->getBody()->write(json_encode(["message" => "ID non trovato"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
  }

  public function destroy(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "DELETE FROM alunni WHERE id = " .$args['id'];
    $result = $mysqli_connection->query($query);

    if($result){
      $response->getBody()->write(json_encode(["message" => "Alunno eliminato"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }else{
      $response->getBody()->write(json_encode(["message" => "Alunno non eliminato"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
  }

  public function filtro(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE nome LIKE '%" .$args["key"]. "%' OR cognome LIKE '%" .$args["key"]. "%'");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function riordina(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $found = false;
    $columns = $mysqli_connection->query("describe alunni")->fetch_all(MYSQLI_ASSOC);
    foreach($columns as $col){
      if($col["Field"] == $args["col"]){
        $found = true;
        break;
      }
    }

    if(!$found){
      $response->getBody()->write("colonna non trovata");
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }

    $results = $mysqli_connection->query("SELECT * FROM alunni ORDER BY " .$args["col"]. " DESC")->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show_cert(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni as a JOIN certificazioni as c ON c.alunno_id = a.id WHERE c.alunno_id = " .$args['id']);
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show_cert_specific(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni as a JOIN certificazioni as c ON c.alunno_id = a.id WHERE c.alunno_id = " .$args['id']. " AND c.id = " .$args['id_cert']);
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create_cert(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("INSERT INTO certificazioni (alunno_id, titolo, votazione, ente) VALUES ('" .$args['id']. "', '" .$body['titolo']. "', " .$body['votazione']. ", '" .$body['ente']. "' )");


    if($result){
      $response->getBody()->write(json_encode(["message" => "Certificato Inserito"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }else{
      $response->getBody()->write(json_encode(["message" => "Errore Inserimento Certificazione"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
  }

  public function update_cert(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("UPDATE certificazioni SET titolo = '" .$args['titolo']. "', votazione = " .$args['votazione']. ", ente = " .$args['ente']);


    if($result){
      $response->getBody()->write(json_encode(["message" => "Certificato Inserito"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }else{
      $response->getBody()->write(json_encode(["message" => "Errore Inserimento Certificazione"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
  }
}