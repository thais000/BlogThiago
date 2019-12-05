create database blog;
show databases;
use blog;




create table usuarios(
id_usuario int auto_increment primary key,
nome varchar(40),
usuario varchar(40),
sexo char(1),
email varchar (40),
senha varchar(60),
nivel_usuario varchar(40)
);
create table categorias (
id int auto_increment primary key,
categoria varchar (40)
);
create table posts(
id int auto_increment primary key,
titulo varchar(40),
subtitulo varchar(40),
postagem text(1000),
imagem varchar(200),
data_postagem varchar(200),
categoria varchar(100),
id_postador varchar (100)

);
create table comentarios(
id int auto_increment primary key,
id_post varchar(200),
nome varchar (200) ,
comentario text (600),
data_postagem varchar (200)
);


/*ALTER TABLE `posts` ADD CONSTRAINT `fk_categorias` FOREIGN KEY ( `id` ) REFERENCES `categoria` ( `id` ) ;
ALTER TABLE `posts` ADD CONSTRAINT `fk_usuarios` FOREIGN KEY ( `id_usuario` ) REFERENCES `usuarios` ( `id_usuario` ) ;
describe comentario;
ALTER TABLE `comentario` ADD CONSTRAINT `fk_usuarios` FOREIGN KEY ( `id_usuario` ) REFERENCES `usuarios` ( `id_usuario` ) ;
ALTER TABLE `comentario` ADD CONSTRAINT `fk_postagens` FOREIGN KEY ( `id` ) REFERENCES `posts` ( `id` ) ;*/
select*from categorias;

insert into usuarios (nome,usuario,sexo,email,senha,nivel_usuario)
value ("Mariane Daniele","MarianeMaravilhosa","m","mdaniele2411@gmail.com","$2y$10$OKaSyuYlzeHZQ.5njwiiU.n1Aj1a16vUct0iWjJTx6YlBRjo4jNti","adm");
insert into categorias (categoria)
value ("Doce");
insert into categorias (categoria)
value ("Azeda");
select * from posts;
/*INSERT INTO posts (titulo,subtitulo,postagem,data_postagem,id_categoria,id_usuario)
 VALUES (titulo,subtitulo,postagem,data_postagem,id_categoria,id_usuario);*/
 describe posts;
 INSERT INTO comentarios(nome,comentario,data_postagem)
 VALUES ("MarianeMaravilhosa","Que blog lindo, merece mb", "05/03/02 10:50:11");
 
