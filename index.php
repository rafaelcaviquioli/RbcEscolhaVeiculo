<?php
require_once("EscolhaAutomovel.php");
$escolhaAutomovel = new EscolhaAutomovel();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <style>
            table, .panel {
                margin: 20px auto;
                width: 600px !important;
            }
        </style>
    </head>
    <body>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td colspan="3">Valores do banco de dados</td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td>Tipo</td>
                    <td>Motor</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($escolhaAutomovel->getValores() as $valor) {
                    echo <<<EOF
                <tr>
                    <td>{$valor['estado']}</td>
                    <td>{$valor['tipo']}</td>
                    <td>{$valor['motor']}</td>
                </tr>
EOF;
                }
                ?>

            </tbody>
        </table>
        <?php if (isset($_POST['estado']) AND !empty($_POST['estado']) AND !empty($_POST['tipo']) AND !empty($_POST['motor'])) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td colspan="4">Resultados para busca por: <strong><?php echo $_POST['estado'] . " , " . $_POST['tipo'] . " , " . $_POST['motor']; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Estado</td>
                        <td>Tipo</td>
                        <td>Motor</td>
                        <td>Similaridade</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultados = $escolhaAutomovel->procurar($_POST['estado'], $_POST['tipo'], $_POST['motor']);
                    foreach ($resultados as $valor) {
                        echo "
                    <tr>
                        <td>{$valor[0]}</td>
                        <td>{$valor[1]}</td>
                        <td>{$valor[2]}</td>
                        <td>" . number_format($valor[3], 2) . "%</td>
                    </tr>";
                    }
                    ?>

                </tbody>
            </table>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Dados de entrada</strong></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="estado" class="col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">
                            <select class="form-control input-sm" name="estado">
                                <option></option>
                                <option>novo</option>
                                <option>usado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                        <div class="col-sm-10">
                            <select class="form-control input-sm col-sm-10" name="tipo">
                                <option></option>
                                <option>familia</option>
                                <option>esportivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="motor" class="col-sm-2 control-label">Motor</label>
                        <div class="col-sm-10">
                            <select class="form-control input-sm col-sm-10" name="motor">
                                <option></option>
                                <option>1.0</option>
                                <option>1.6</option>
                                <option>2.0</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Calcular</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
