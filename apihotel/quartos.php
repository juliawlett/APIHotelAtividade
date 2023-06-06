<?php
header('Access-Control-Allow-Origin: *');//permite acesso de todas as origins

header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');//permite acesso dos metodos
//PUT é utilizado para fazer um UPDATE no banco
//DELETE é utilizado para deletar algo do banco
header('Access-Control-Allow-Headers: Content-Type');//permite com que qualquer header consiga acessar o sitema

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}

include 'conexao.php';
//inclui os dados de conexao com o banco de dados no sistema abaixo


//rota para obter todos os livros utilizando o get
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM quartos");
    $stmt -> execute();
    $quartos = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($quartos);
    //converter dados em json
}


//Utilizando o Post

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $disponivel = $_POST['disponivel'];

    $stmt = $conn->prepare("INSERT INTO quartos (numero, tipo, disponivel) values 
    (:numero, :tipo, :disponivel)");

    $stmt -> bindParam(':numero', $numero);
    $stmt -> bindParam(':tipo', $tipo);
    $stmt -> bindParam(':disponivel', $disponivel);

    if($stmt->execute()){
        echo 'Quarto adicionado com sucesso!';
    }else{
        echo 'erro ao adicionar o quarto';
    }
}




//rota para atualizar um livro existente

if($_SERVER['REQUEST_METHOD']==='PUT' && isset($_GET['id'])){
    //convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);


    $id = $_GET['id'];
    $novoNumero = $_PUT['numero'];
    $novoTipo = $_PUT['tipo'];
    $novoDisponivel = $_PUT['disponivel'];

    $stmt = $conn->prepare("UPDATE quartos SET numero = :numero, tipo = :tipo, disponivel = :disponivel WHERE id = :id");
    $stmt->bindParam(':numero', $novoNumero);
    $stmt->bindParam(':tipo', $novoTipo);
    $stmt->bindParam(':disponivel', $novoDisponivel);
    $stmt->bindParam(':id', $id);


    if($stmt->execute()){
        echo "quarto atualizado com sucesso!!";

    } else{
        echo "erro ao atualizar quarto :(";
    }

}

if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM quartos WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Quarto excluido com sucesso!!";
    } else {
        echo "erro ao excluir quarto";
    }
}


?>