<?php 
include('conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="clientes-css.css">
    
</head>
<body>
    <h1>Lista de Clientes</h1>
    <a href="cadastrar_cliente.php" class="a1">Cadastre mais clientes</a>
    <p>Esses são os clientes cadastrados no seu sistema:</p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                
                <tr>
                <td colspan="7"> Nenhum cliente cadastrado</td>
                </tr>


            <?php } else {
                while($clientes = $query_clientes->fetch_assoc()) {
                $telefone="";
                    if(!empty($clientes['telefone'])){
                    $ddd= substr ($clientes['telefone'],0,2);
                    $parte1= substr ($clientes['telefone'],2,5);
                    $parte2= substr ($clientes['telefone'],7);
                    $telefone = "($ddd) $parte1-$parte2 ";
                }

                $data_cadastro = date("d/m/y H:i", strtotime($clientes['data']));    
                $nascimento ='não informada';
                if(!empty($clientes['nascimento'])){
                    $nascimento= implode('/',array_reverse(explode('-', $clientes['nascimento'])));
                }
                if ($clientes['nascimento'] === '0000-00-00') {
                    $nascimento = 'Nascimento não informado';
                }
                
                    ?>
               
              
            <tr>
                <td><?php echo $clientes['id']; ?></td>
                <td><?php echo $clientes['nome']; ?></td>
                <td><?php echo $clientes['email']; ?></td>
                <td><?php echo $telefone; ?></td>
                <td><?php echo $nascimento; ?></td>
                <td><?php echo $data_cadastro; ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $clientes['id']?>">Editar</a>
                    <a href="deletar_cliente.php?id=<?php echo $clientes['id']?>">Deletar</a>
                </td>
              
            </tr>
            <?php 
                 }
                 } ?>
        </tbody>
    </table>
</body>
</html>