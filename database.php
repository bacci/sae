<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

# Um simples objeto
class Insere (
    $ nome pública;
    public $ addr;
    $ cidade público;

    $dsn = 'mysql:host=localhost;port=3306;dbname=bd';
    $usuario = 'root';
    $senha = 'joselito';
    $opcoes = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_CASE => PDO::CASE_LOWER
    );

    try {
        $pdo = new PDO($dsn, $usuario, $senha, $opcoes);
    } catch (PDOException $e) {
        echo 'Erro: '.$e->getMessage();
    }
    STH = $ dbh-> ("INSERT INTO pessoas (nome, end, cidade) (valor: Nome: addr: cidade)");

    bindParam $ sth-> (1, $ name);
    bindParam $ sth-> (2, $ addr);
    bindParam $ sth-> (3, $ cidade);

    $ nome = "Daniel"
    $ addr = "1 Wicked Way";
    $ cidade = "Arlington Heights";
    $ Sth-> execute ();

    função __construct ($ n, $ a, $ c) (
        $ This-> nome = $ n;
        $ This-> end = $ a;
        $ This-> $ cidade = c;
    )
    # Etc ...
)









?>
