<?php
function pdo(){
    $db_host= db_host;
    $db_usuario= db_usuario;
    $db_senha= db_senha;
    $db_banco= db_banco;
    try{
        return $pdo = new PDO("mysql:host={$db_host};dbname={$db_banco}", $db_usuario, $db_senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        exit("Erro ao conectar-se ao banco:".$e->getMessage());
    }
}
function paginacao_adm(){
    $url=(isset($_GET['pagina']))?$_GET['pagina']:'dashboard';
    //se existtir uma GET pagina ele vai receber o valor da get pagina
    //se não ele vai receber login/dashboard
    $explode =explode('/',$url);//vai transformar em um array
    $dir='pags/php/';
    $ext='.php';
    if(file_exists($dir.$explode[0].$ext) && isset($_SESSION['admLogin'])){
        include($dir.$explode[0].$ext);
    }else{
        include($dir. "login" .$ext);
    }

}
function alerta($tipo, $mensagem){
    echo "<div class='alert alert-{$tipo}'>{$mensagem}</div>";
}
function logIn(){
    if(isset($_POST['log']) && $_POST['log'] == "in"){
        $pdo = pdo();
        $stmt= $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $_POST['usuario']]);
        $total= $stmt->rowCount();
        if($total > 0){
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($_POST['senha'], $dados['senha'])){
               $_SESSION['admLogin']=$dados['usuario'];
               header('Location:dashboard');
            }
            else{
               alerta("danger", "Usuario ou senha invalidos");
            }
        }

    }
}
function verificaLogin(){
    if(isset($_SESSION['admLogin'])){
        header('Location:dashboard');
        exit();
    }
}
//vai pegar os dados do login do adm para colocar o nome de usuario dele no dashboard
function getDadosUser($var){
    if(isset($_SESSION['admLogin'])){
        $pdo=pdo();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario");
        $stmt->execute([':usuario' => $_SESSION['admLogin']]);
        $dados= $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados[$var];
    }
}
//listar categorias
function get_categorias(){
    $pdo= pdo();
    $stmt=$pdo->prepare("SELECT * FROM categorias ORDER BY categoria ASC");
    $stmt->execute();
    $total= $stmt->rowCount();
    if($total>0){
        while($dados = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='{$dados['id']}'>{$dados['categoria']}</option>";

        }
    }
}
//tirar acentos

function tirarAcentos($string){
    return strtolower(str_replace(" ","-", preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(Ç)/","/(#)/"),explode(" ","a A e E i I o O u U n N C  "),$string)));

}
function getData(){
    date_default_timezone_set('America/Sao_Paulo');
    return date('d-m-Y H:i:s');
}

function enviarPost(){
    if(isset($_POST['env'])&& $_POST['env'] == "post" ){
       $pdo=pdo();
       $subtitulo= tirarAcentos($_POST['titulo']);
       $data= getData();
      //print_r($_POST);

      //upload das imagens
      $uploaddir = '../images/uploads/';
      $uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

      $uploaddir2 = 'images/uploads/';
      $uploadfile2 = $uploaddir2.basename($_FILES['userfile']['name']);
      if($_FILES['userfile']['size']>0){
        $stmt = $pdo->prepare("INSERT INTO posts (
            titulo,
            subtitulo,
            postagem,
            imagem,
            data_postagem,
            categoria,
            id_postador) VALUES (
            :titulo,
            :subtitulo,
            :postagem,
            :imagem,
            :data_postagem,
            :categoria,
            :id_postador)");


$stmt->execute([':titulo'=> $_POST['titulo'],
          ':subtitulo'=> $subtitulo,
          ':postagem'=> $_POST['post'],
          ':imagem'=> $uploadfile2,
          ':data_postagem'=> $data,
          ':categoria'=> $_POST['categoria'],
          ':id_postador'=> $_SESSION['admLogin']]);
          $total = $stmt->rowCount();
          if($total>0){
            move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
            alerta("sucess","Publicação cadastrada com sucesso");
          }else{
            alerta("danger","Erro ao enviar a publicação");
        }
        }else{
            alerta("danger","INSIRA UMA IMAGEM!");
      }
    }
}
    function getNomeCategoria($id){
        $pdo =  pdo();

        $stmt = $pdo->prepare("SELECT categoria FROM categorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados['categoria'];
    }

    function getDadosPost($id, $val){
        $pdo =  pdo();

        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id= :id");
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados[$val];
        //print_r($dados);
    }
     function getPostsAdmin(){
        $pdo =  pdo();
         $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
         $stmt->execute();
         $total = $stmt->rowCount();

         if($total > 0):
            while($dados = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>
                <td>{$dados['id']}</td>
                <td>{$dados['titulo']}</td>
                <td><span class='badge badge-primary'>".getNomeCategoria($dados['categoria'])."</span></td>
                <td>
                    <button id='btnGroupDrop1' type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Gerenciar</button>
                    <div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
                        <a class='dropdown-item bg-dark text-light' href='{$dados['subtitulo']} '>Ver Publicação</a>
                        <a class='dropdown-item bg-info text-light' href='admin/editar-post/{{$dados['id']}' target='_blank'>Editar Publicação</a>
                        <a class='dropdown-item bg-danger text-light' href='admin/deletar-post{$dados['id']}'>Deletar Publicação</a>
                     </div>
                 </td>
             </tr>";
                     }
        endif;
    }
    //function getPost(){

    //}


	function calculaDias($diaX,$diaY){
		$data1 = new DateTime($diaX); //Dia X é a data atul
		$data2 = new DateTime($diaY); //Dia Y é o dia da publicação ou notícia

		//Calcula a diferença entre duas datas com a função diff
		$intervalo = $data1->diff($data2); //A variável intervalo vai receber a diferença entre a data1 e a data2


		if($intervalo->y > 1){ // se o ano for maior que 1 ele recebe x anos

            return $intervalo->y." Anos atrás";
		}elseif($intervalo->y == 1){ // se o ano for igual a 1 ele recebe 1 ano
            return $intervalo->y." Ano atrás";
		}elseif($intervalo->m > 1){ // E a lógica segue a mesma para todo else if
            return $intervalo->m." Meses atrás";
		}elseif($intervalo->m == 1){
            return $intervalo->m." Mês atrás";
		}elseif($intervalo->d > 1){
            return $intervalo->d." Dias atrás";
		}elseif($intervalo->d > 0){
            return $intervalo->d." Dia atrás";
		}elseif($intervalo->h > 0){
            return $intervalo->h." Horas atrás";
		}elseif($intervalo->i > 1 && $intervalo->i < 59){
            return $intervalo->i." Minutos atrás";
		}elseif($intervalo->i == 1){
            return $intervalo->i." Minuto atrás";
		}elseif($intervalo->s < 60 && $intervalo->i <= 0){
            return $intervalo->s." Segundo atrás";
		}
	}

    function lauchModal($id,$nome,$mensagem){
      echo " <div class='modal fade' id='exampleModalCenter{$id}' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>{$nome} Comentou</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
           {$mensagem}
          </div>

        </div>
      </div>
    </div>";
    }
    function selecionaComentariosAdm(){

        $pdo= pdo();
        $dataAtual = getData();
        $stmt= $pdo->prepare("SELECT * FROM comentarios ORDER BY id DESC LIMIT 30 ");
        $stmt->execute();
        $total= $stmt->rowCount();

        if($total>0){
            while($dados = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>
                <td>{$dados['id']}</td>
                <td>{$dados['nome']}</td>
                <td>".calculaDias($dados['data_postagem'], $dataAtual)."</td>
                <td>
                  <button  id='btnGroupDrop1' type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Gerenciar</button>
                  <div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
                    <a class='dropdown-item bg-dark text-light' data-toggle='modal' data-target='#exampleModalCenter{$dados['id']}'>Ver Comentário</a>
                    <a class='dropdown-item bg-success text-light' href='{$dados['id_post']}' target='_blank'>Ver publicação</a>
                    <a class='dropdown-item bg-danger text-light' href='admin/deletar-comentario/{$dados['id']}'>Deletar Comentário</a>
            </div>
                </td>
        </tr>";
        lauchModal($dados['id'],$dados['nome'],$dados['comentario']);

            }
        }
    }
function blockAcesso(){
    if ("getDadosUser") != 1){
        redireciona(0,"admin/dasshboar");
        exit();
     
    }
}
    function cadastrarAdm(){
        if(isset($_POST['env']) && $_POST['env']=="adm"){
            $pdo = pdo();
            $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

            $stmt= $pdo->prepare("INSERT INTO usuario (nome, usuario, :superadmin");
            $stm->execute(
                [':nome' => $_POST['nome'],
                ':usuario' => $_POST['usuario'],
                ':senha' => $_POST['senha'],
                ':superadmin' => $_POST['superadmin'],
                ]);

                $total = stmt->rowCout();
                if($total >0{
                    alerta("success","Admistrador cadastrado com sucesso!");
                }else{
                    alerta("danger","Admistrador cadastrado com sucesso!");
                    
                }
            
        }

    }

?>
