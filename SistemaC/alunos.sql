CREATE DATABASE IF NOT EXISTS sistemalunos;
use sistemalunos;

create table alunos(
id int auto_increment primary key,
nome varchar(50) not null,
idade int(3) not null,
email varchar(255),
curso varchar(50));

select * from sistemalunos.alunos;
/*verifica se está sendo inserido dentro da tabela as informações necessárias*/