<?php
if(isset($_POST['sim'])){ // Correção aqui: $_POST['sim']
    include("conexao.php");
    $id = intval($_GET['id']);
    $sql_code = "DELETE FROM clientes WHERE id='$id'";
    $sql_query = $mysqli->query($sql_code) or die ($mysqli->error);

    if($sql_query){ ?>
        <h1>Cliente deletado com sucesso!</h1>
        <a href="clientes.php" style="text-decoration:none;">Clique aqui para voltar para a lista de clientes.</a>
<?php 
die();   
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
</head>
<body>
    <h1>Deseja Deletar esse Cliente?</h1>
    
    <form action="" method="post">
        <a href="clientes.php">Não</a>
        <button name="sim" value="1" type="submit">Sim</button>
    </form>
</body>
</html>