<div class="panel-content">
          <h4 class="titulo">PUBLICAR</h4>

          <form method="POST" enctype="multipart/form-data">
            <p><label for="titulo">Titulo</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </p>

            <p><label for="titulo">Imagem</label>
              <input type="file" class="form-control" id="titulo" name="userfile">
            </p>

            <p>
             <textarea class="form-control" id="post" name="post" rows="5" required></textarea>
            </p>

            <p><label>Categoria</label>
              <select class="form-control" name="categoria">
              <?php  get_categorias();  ?>
              </select>
            </p>

            <p><input type="submit" value="Publicar" class="btn btn-primary btn-lg btn-block"></p>
            <p>  <input type="hidden" name="env" value="post"></p>
            <?php enviarPost(); ?>
          </form>

        </div>
