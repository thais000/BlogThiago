<?php
include_once("../lib/includes.php");?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="<?php echo url_site;?>">
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="dist/ui/trumbowyg.min.css">

    <title><?php echo titulo_site;?></title>
  </head>
  <body>
  <br>

  <div class="container">
    <div class="row">
    <?php if(isset($_SESSION['admLogin'])){  ?>
    <div class="col-sm-4">
        <div class="menu">
          <div class="title-menu">Menu</div>
          <ul>
            <li class="blue"><a href="admin/#" class="category"> Publicações </a>
              <ul>
                <li><a href="admin/publicar"><i class="fas fa-plus"></i> Cadastrar</a></li>
                <li><a href="admin/gerenciar-post"><i class="fas fa-bars"></i> Gerenciar</a></li>
              </ul>
            </li>
            

            <li class="cyn2"><a href="admin/" class="category"> categorias</a>
            <ul>
              <li><a href="admin/gerenciar-categorias"><i class="fas fa-bars"></i>Gerenciar Categoria</a></li>
            </ul>
              </li>
            

            <li class="cyan"><a href="admin/" class="category"> Comentários</a>
              <ul>
                <li><a href="admin/gerenciar-comentarios"><i class="fas fa-bars"></i> Gerenciar Comentários</a></li>
              </ul>
            </li>

              <?php if ("getDadosUser") == 1){ ?>
            <li class="red"><a href="#" class="category"> Administradores</a>
              <ul>
                <li><a href="admin/gerenciar-administradores"><i class="fas fa-users"></i> Gerenciar Administradores</a></li>
              </ul>
            </li>
            <?php} ?>
            
            <li class="green"><a href="admin/" class="category"> Meus Dados</a>
              <ul>
                <li><a href="admin/me"><i class="fas fa-user"></i> Editar Dados</a></li>
              </ul>
            </li>

            <li class="purple"><a href="admin/sair"><i class="fas fa-user"></i> Sair</a></li>
          </ul>
        </div>
    </div>
    <?php }?>
      <div class="col-sm">
        <?php echo paginacao_adm();?>
      </div>
    </div>
  </div>

  <footer><?php echo titulo_site; ?> &copy; Criado por <b>Tutoriais e Informática</b></footer>

  <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/97bdcc5c17.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="dist/trumbowyg.min.js"></script>
    <script type="text/javascript">$('#post').trumbowyg();</script>
  </body>
</html>