<?php
try {
    $pdo = new PDO("mysql:dbname=projeto_filtrotabela;host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erro: " . $ex->getMessage());
}
if (isset($_POST['sexo']) && $_POST['sexo'] != '') {
    $sexo = $_POST['sexo'];
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE sexo = :sexo");
    $sql->bindValue(":sexo", $sexo);
    $sql->execute();
} else {
    $sexo = "";
    $sql = $pdo->prepare("SELECT * FROM usuarios");
    $sql->execute();
}
?>
<form method="POST">
    <select name="sexo">
        <option></option>
        <option value="0" <?php echo ($sexo=='0')? "selected='selected'":""?>>Masculino</option>
        <option value="1" <?php echo ($sexo=='1')? "selected='selected'":""?>>Feminino</option>
    </select>
    <input type="submit" value="Filtrar"/>
</form>
<table border="1" width="100%">
    <tr>
        <th>Nome</th>
        <th>Sexo</th>
        <th>Idade</th>
    </tr>
    <?php
    $sexos = array('0' => "Masculino", '1' => "Feminino");


    if ($sql->rowCount() > 0) {
        foreach ($sql->fetchAll() as $usuario) {
            ?>
            <tr>
                <td><?php echo $usuario['nome']; ?></td>
                <td><?php echo $sexos[$usuario['sexo']]; ?></td>
                <td><?php echo $usuario['idade']; ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>