<?php
include('conexao.php');

$id = intval($_GET['id']);
$sql_cliente = "SELECT * FROM clientes WHERE id ='$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente= $query_cliente->fetch_assoc();



$error_msg='';
$sucess_msg='';
    if (count($_POST) > 0) {
    $nome = $_POST['nome'];
    $email = $_POST['Email'];
    $telefone = $_POST['Telefone'];
    $dataNascimento = $_POST['Nascimento']; // Aqui é a data original recebida do formulário

    // Verificar se o telefone contém apenas números
    if (!empty($telefone) && !preg_match('/^\d+$/', $telefone)) {
        $error_msg =  "<p>O número de telefone deve conter apenas dígitos.</p>";
    } else {
        $dataFormatada = date("m/d/Y", strtotime(str_replace('-', '/', $dataNascimento)));
        $_POST['NascimentoFormatado'] = $dataFormatada;

        $sql_code = "UPDATE clientes 
        SET
        nome='" . mysqli_real_escape_string($mysqli, $nome) . "',
        email='" . mysqli_real_escape_string($mysqli, $email) . "',
        telefone='" . mysqli_real_escape_string($mysqli, $telefone) . "',
        nascimento='" . mysqli_real_escape_string($mysqli, $dataNascimento) . "'
        WHERE id = '$id'";

        $deucerto = $mysqli->query($sql_code) or die($mysqli->error);
        if ($deucerto) {
            $sucess_msg= "<p>Cliente atualizado com Sucesso!</p>";
            unset($_POST);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="login">
        <h1>Cadastro de Clientes</h1>
        <?php echo $error_msg; ?> <!-- Exibe a mensagem de erro -->
        <?php echo $sucess_msg; ?> <!-- Exibe a mensagem de sucesso -->
        <form method="post">
            <input type="text" value="<?php echo $cliente['nome']?>" name="nome" placeholder="Nome" required="required" />
            <input type="email" value="<?php echo $cliente['email']?>" name="Email" placeholder="Email" required="required" />
            <input type="tel" value="<?php echo $cliente['telefone']?>" name="Telefone" placeholder="Telefone apenas números" />
            <!-- (echo isset($_POST['Nascimento']) ?)= se o campo 'Nascimento' tiver sido enviado pelo formulário, o código seguinte será executado:,,,,Se o campo 'Nascimento' não estiver definido, a segunda parte após : será executada. será exibido um valor vazio, indicado por ''.  -->
            <!--str_replace('-', '/', $_POST['Nascimento']): Substitui os hífens '-' na data (se existirem) por barras '/', para que o PHP possa interpretar corretamente a data. Isso é necessário porque o formato de data padrão do HTML5 para o input do tipo 'date' é 'ano-mês-dia', mas para formatar a data com 'mês/dia/ano', precisamos fazer essa substituição.
            strtotime(...): Converte a string de data em um timestamp (um formato de data/hora padrão do PHP).
            date('m/d/Y', ...): Formata o timestamp resultante do strtotime para o formato desejado, que é "mês/dia/ano". -->
            <!--  -->
            <input type="hidden" name="NascimentoFormatado" value="<?php echo isset($_POST['Nascimento']) ? date('m/d/Y', strtotime(str_replace('-', '/', $_POST['Nascimento']))) : ''; ?>">
            <input type="date"  value="<?php echo $cliente['nascimento']?>"id="dataNascimento" name="Nascimento" placeholder="Data de Nascimento" />

            <button type="submit" class="btn btn-primary btn-block btn-large">Salvar Alterações</button>
            <a href="clientes.php" id="ancora">Veja a  sua lista de clientes</a>
        </form>
    </div>
</body>
</html>