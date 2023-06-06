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
    $stmt = $conn->prepare("SELECT * FROM reserva");
    $stmt -> execute();
    $reserva = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reserva);
    //converter dados em json
}


//Utilizando o Post

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome_cliente = $_POST['nome_cliente'];
    $numero_quarto = $_POST['numero_quarto'];
    $data_check_in = $_POST['data_check_in'];
    $data_check_out = $_POST['data_check_out'];

    $stmt = $conn->prepare("INSERT INTO reserva (nome_cliente, numero_quarto, data_check_in, data_check_out) values 
    (:nome, :numero, :data_check_in,:data_check_out)");

    $stmt -> bindParam(':nome', $nome_cliente);
    $stmt -> bindParam(':numero', $numero_quarto);
    $stmt -> bindParam(':data_check_in', $data_check_in);
    $stmt -> bindParam(':data_check_out', $data_check_out);

    if($stmt->execute()){
        echo 'Reserva feita com sucesso!';
    }else{
        echo 'erro ao fazer a reserva';
    }
}




//rota para atualizar um livro existente

if($_SERVER['REQUEST_METHOD']==='PUT' && isset($_GET['id'])){
    //convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);


    $id = $_GET['id'];
    $novoNome_cliente = $_PUT['nome'];
    $novoNumero_quarto = $_PUT['numero'];
    $novoData_check_in = $_PUT['data_check_in'];
    $novoData_check_out = $_PUT['data_check_out'];

    $stmt = $conn->prepare("UPDATE reserva SET nome = :nome, numero = :numero, data_check_in = :data_check_in,  data_check_out = :data_check_out  WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $novoNome_cliente);
    $stmt->bindParam(':numero', $novoNumero_quarto);
    $stmt->bindParam(':data_check_in', $novoData_check_in);
    $stmt->bindParam(':data_check_out', $novoData_check_out);


    if($stmt->execute()){
        echo "Reserva feita com sucesso!!";

    } else{
        echo "erro ao fazer a reserva :(";
    }

}

if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM reserva WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Reserva excluida com sucesso!!";
    } else {
        echo "erro ao excluir reserva";
    }
}


?>

