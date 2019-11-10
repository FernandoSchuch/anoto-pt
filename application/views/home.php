<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Pesquisa</title>
    <link rel="stylesheet" href="<?php echo base_url()?>assests/dist/themes/default/style.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/extra/estilos.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>assests/images/favicon.ico" />
    <style>
        body {
            background-color: #ecebe8;
        }
    </style>
    
</head>
<body>
    <?php if ($_GET['incluindo'])
        echo '<h4>Registro de novos voluntários</h4> 
             <form action="' . base_url() . 'index.php/Busca/adicionaVoluntario" id="formVol" method="post">
                <input type="text" name="edAddQuant" id="edAddQuant" class="form-control" style="width:150px; display: inline-block" placeholder="Quantidade" />
                <input type="text" name="edAddEmail" id="edAddEmail" class="form-control" style="width:300px; display: inline-block" placeholder="E-mail" />
                <button type="submit" class="btn btn-success" style="vertical-align: top">Adicionar</button>
             </form>
             <br><br>
             <h4>Vínculo de e-mail à um novo grupo</h4> 
             <form action="' . base_url() . 'index.php/Busca/vinculaVoluntario" id="formVinc" method="post" >
                <input type="text" name="edNovoQuant" id="edVincGrupo" class="form-control" style="width:150px; display: inline-block" placeholder="Grupo" />
                <input type="text" name="edNovoEmail" id="edVincEmail" class="form-control" style="width:300px; display: inline-block" placeholder="E-mail" />
                <button type="submit" class="btn btn-success" style="vertical-align: top">Vincular</button>
             </form>';
    elseif ($_GET['resultados']) {
        echo '<div id="divResultados">
                <button type="submit" class="btn btn-success" id="btnResultados" style="vertical-align: top" livesite="' . base_url() . 'index.php/Busca/getResultados">Mostrar resultados</button>
                <div id="resultados"></div>
            </div>';
    } else {        
        echo '<input type="hidden" id="emailAtual" value="" />
        <div id="principal" class="container main-div rounded">
            <div id="conteudo" style="padding-top: 10px">
                <h3 style="float: center">Bem-vindo à Anoto-PT</h3>
                <p>
                   <br>
                   Muito prazer em conhecê-lo. Me chamo Fernando Schuch e preciso da tua ajuda com meu Trabalho de Conclusão, no curso de Sistemas de Informação da Universidade Feevale.
                   <br><br>
                   Se você já pesquisou na Internet por opiniões de outras pessoas antes de comprar um produto, deve saber que existem muitas avaliações irrelevantes para nós. Usuários se manifestam sem ter tido experiência com os produtos.
                   <br>
                   <!--<div class="card">
                       <div class="card-header">
                           <p><b>Smartphone XYZ</b></p>
                       </div>
                       <div class="card-body">
                           <p> "Eu quero muito esse celular. Ele me parece muito bom e muito bonito!!!" </p>
                       </div>                

                   </div>-->
                   <br>
                   Opiniões como essas podem influenciar na decisão de compra de outros consumidores. O meu objetivo é detectá-las automaticamente, utilizando técnicas de Inteligência Artificial. Mas para isso, eu preciso que tu me ajude a classificar algumas avaliações sobre mercadorias (atividade conhecida também como <b>anotação!</b>).<br>
                   <br><b>Para contribuir, entre em contato comigo através do meu e-mail que está no rodapé da página.</b></a>
                   <br><br>
                   Se você já conversou comigo e está liberado para participar, digite o teu e-mail abaixo.  
                </p>
                <form action="' . base_url() . 'index.php/Busca/getInstrucoes" id="formEmail" method="post">
                    <div class="form-group">
                        <input type="text" name="edEmail" id="edEmail" class="form-control" style="width:300px; display: inline-block" placeholder="E-mail" />
                        <button type="submit" class="btn btn-success" style="vertical-align: top">Continuar</button>
                    </div>
                </form>
            </div>
            <div><br><br>
                 <p class="texto-centralizado">
                     Você pode entrar em contato comigo através do e-mail: <a href="mailto:f.schuch@hotmail.com">f.schuch@hotmail.com</a>
                 </p>
            </div>
        </div>'; }  
    ?>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/jquery.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/opiniao.js" ></script>
</body>
</html>