<?php

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $strcon = mysqli_connect('localhost','root','vertrigo','bancozem') or die('Erro ao conectar ao banco de dados');
    $sql = "INSERT INTO contato VALUES ";

    $sql .= "('$nome', '$telefone', '$email', '$assunto', '$mensagem')"; 
    mysqli_query($strcon,$sql) or die("Erro ao tentar cadastrar registro");
    mysqli_close($strcon);

    echo "Cliente cadastrado com sucesso!";
?>
