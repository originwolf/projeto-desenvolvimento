<!DOCTYPE html>
<!--DEFINE IDIOMA-->
<html lang="pt-br">
<!--CABEÇALHO INÍCIO-->
  <head>
  <!--METADATA ATRIBUTOS-->  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Controlador de Eventos">
    <meta name="author" content="Denis Antonio Rocha & Jéssica Alves venâncio & Pedro Henrique Martins e Oliveira & Gabrielly de Lima Venâncio">
    <title>Sisconeve</title>
    <!--LINKS BOOSTRAP, JAVA SCRIPT E CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">  
    <link href="<?php echo base_url('assets/css/scrolling-nav.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/all.css')?>" rel="stylesheet"> 
    <link href="<?php echo base_url('assets/css/jquery-te-1.4.0.css')?>" rel="stylesheet">   
    <link href="<?php echo base_url('assets/css/estilo.css')?>" rel="stylesheet">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/favicon/Sisconeve.svg')?>">
    <!-- WEBFONT -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
<!--CABEÇALHO FIM-->
  <body id="topo-pagina">
    <!-- BARRA DE NAVEGAÇÃO -->
    <nav class="navbar navbar-expand-lg navbar-light bg-verde shadow fixed-top" id="mainNav">
      <div class="container">
        <strong><a class="navbar-brand js-scroll-trigger" href="<?php echo base_url('home');?>">IF EVENTOS</a></strong>
        <div>
          <button type="button" onclick="aumentar_fonte()" class="btn btn-outline-success"><span class="fas fa-plus"></span></button>
          <button type="button" onclick="diminuir_fonte()" class="btn btn-outline-success"><span class="fas fa-minus"></span></button>
          <button type="button" onclick="redefinir_fonte()" class="btn btn-outline-success"><span class="fas fa-redo-alt"></span></button>
        </div>
        <!-- MENU DE NAVEGAÇÃO RESPONSIVO INÍCIO-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <?php if (!$this->session->dados_participante['logado']):?>
            <?php if(isset($eventos) && sizeof($eventos) > 0): ?>
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="#eventos">Eventos</a>
              </li>
            <?php endif; ?>
            <li class="menu nav-item">
              <a class="nav-link js-scroll-trigger" href="#sobre">Sobre</a>
            </li>
            <li class="menu nav-item">
              <a class="nav-link js-scroll-trigger" href="#contato">Contato</a>
            </li>            
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('participante/login'); ?>">Entre</a>
              </li> 
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('participante/cadastrar'); ?>">Cadastre-se</a>
              </li>                  
            <?php endif; ?>
            <?php if ($this->session->dados_participante['logado']):?>
              <?php $acesso = $this->session->dados_participante['acesso']; ?>
              <?php if(recupera_permissao($acesso, PARTICIPANTES)): ?>  
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('participante/listar'); ?>">Participantes</a>
              </li>
              <?php endif; ?>
              <?php if(recupera_permissao($acesso, EVENTOS)): ?>
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('evento/listar'); ?>">Eventos</a>
              </li>
              <?php else: ?>
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('home/listar_eventos'); ?>">Eventos</a>
              </li>
              <?php endif; ?>              
              <?php if(recupera_permissao($acesso, CATEGORIAS)): ?>           
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('categoria/listar'); ?>">Categorias</a>
              </li>
              <?php endif; ?>
              <?php if(recupera_permissao($acesso, AREAS)): ?>
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('area/listar'); ?>">Áreas</a>
              </li>
              <?php endif; ?>
              
                <li class="menu nav-item">
                  <a class="nav-link js-scroll-trigger" href="<?php echo base_url('home/listar_inscricoes/' . $this->session->dados_participante['id_participante']); ?>">Minhas Inscrições</a>
                </li>
              
              
                <li class="menu nav-item">
                  <a class="nav-link js-scroll-trigger" href="<?php echo base_url('participante/exibir/' . $this->session->dados_participante['id_participante']); ?>">Meu Perfil</a>
                </li>
            
              <li class="menu nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo base_url('participante/logout'); ?>">Sair</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <!-- MENU DE NAVEGAÇÃO RESPONSIVO INÍCIO FIM-->
    </nav>