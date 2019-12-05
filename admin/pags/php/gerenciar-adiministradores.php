<?php blockAcesso();?>
<div class="col-sm">
        <div class="panel-content">
         <h4 class="titulo">Gerenciar Administradores</h4>
         <br>

          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <h4>Adicionar</h4>
                <hr>
                <form method="POST">
                  <label>Nome</label>
                  <input type="text" name="nome" class="form-control"><br>

                  <label>Usuário</label>
                  <input type="text" name="usuario" class="form-control"><br>

                  <label>Senha</label>
                  <input type="password" name="senha" class="form-control"><br>

                  <label>É super admin?</label>
                  <input type="checkbox" name="superadm"><br><code>Superadimin pode deletar outros administradores</code><br><br>

                  <p align="right"><input type="submit" value="Cadastrar" class="btn btn-primary btn-lg btn-block"></p>
                  <input type="hidden" name="env" value="adm">
                </form>
                <?php cadastrarAdm();?>
              </div>

              <div class="col-sm-4">
        <div class="menu">
          <div class="title-menu">Menu</div>
          <ul>
            <li class="blue"><a href="#" class="category"> Publicações</a>
              <ul>
                <li><a href="#"><i class="fas fa-plus"></i> Cadastrar</a></li>
                <li><a href="#"><i class="fas fa-bars"></i> Gerenciar</a></li>
              </ul>
            </li>

            <li class="cyan"><a href="#" class="category"> Comentários</a>
              <ul>
                <li><a href="#"><i class="fas fa-bars"></i> Gerenciar Comentários</a></li>
              </ul>
            </li>

            <li class="red"><a href="#" class="category"> Administradores</a>
              <ul>
                <li><a href="#"><i class="fas fa-users"></i> Gerenciar Administradores</a></li>
              </ul>
            </li>

            <li class="green"><a href="#" class="category"> Meus Dados</a>
              <ul>
                <li><a href="#"><i class="fas fa-user"></i> Editar Dados</a></li>
              </ul>
            </li>

            <li class="purple"><a href="#"><i class="fas fa-user"></i> Sair</a></li>
          </ul>
        </div>
    </div>