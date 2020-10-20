# O que é o SISCONEVE?

***

É uma paltaforma online construída para facilitar organização de **inscrições, palestras, minicursos, workshops, cursos, entre outras** atividades de eventos técnicos e científicos de nível médio e superior.

Este sistema foi projetado para atender as demandas dos **eventos** realizados dentro do *IFSULDEMINAS - Campus Machado*. A plataforma permite a automatização de processos que simplificam a forma de administrar todas as etapas do eventos.

## O projeto no GitHub

***

>Nesta tabela estão a versão anterior do projeto assim como a mais recente.

Versão antiga | Versão atualizada
--------------|------------------
[Sisconeve old](https://github.com/originwolf/projeto-desenvolvimento/tree/1a149191c34300dc72a642542d6a3bfccde42887 "Veja a primeira versão no GitHub")|[Sisconeve atualizado](https://github.com/originwolf/projeto-desenvolvimento "Veja o projeto atualizado no GitHub")

## Executando a aplicação em seu ambiente

***

Após selecionada a versão desejada da aplicação você pode seguir para a execução em seu ambiente de desenvolvimento ou de produção.

>Para executar a aplicação, certifique-se de possuir as dependências necessárias para a execução do framework.

>Lembre-se que a aplicação foi desenvolvida com o uso do MySQL, e a utilização de outra database pode implicar na reescrita do código do banco de dados e da adaptação da aplicação.

[CodeIgniter 3 Requirements](https://codeigniter.com/userguide3/general/requirements.html "Veja os requisitos do framework")

>Lembrando também que gerenciadores como XAMPP ou WAMPP também são compatíveis, mas observando as versões compatíveis do PHP e MySQL.

1. Tendo instalado as **dependências necessárias**, você deve mover os arquivos da aplicação para a pasta que contém seu “**localhost**”;
2. Executar o arquivo **.sql** que contém os dados de criação das tabelas. Lembrando que esse arquivo pode ou não conter os dados presentes nessas tabelas;
3. Caso julgue necessário, você pode através de uma query sql **criar seu usuário** com o nível de acesso desejado. **(2047 para Administrador do sistema, 4095 para Super Administrador)**;
4. Com o banco criado, atualize a lista no seu gerenciador de bancos de preferência e **acesse a tela de criação de usuários**;
5. Para a criação, o **“username” será “compServer”**, e o __“password” será “compServer987*”__. Certifique-se de liberar para esse usuário as **permissões necessárias** no banco de dados da aplicação;
6. Para a **alteração** do “username” e do “password” que a aplicação usa para se comunicar com o banco de dados, você deverá acessar os arquivos da aplicação no seguinte caminho: **“aplication/config/database.php”** Dentro da array **“$db”** você encontrará os campos que devem ser alterados;
7. Com todas estas etapas cumpridas, basta abrir o navegador de sua preferência e acessar o endereço **“http://localhost/sisconeve/”**, e a aplicação já estará acessível.

>Para hospedagem em serviços da web consulte a documentação das mesmas para saber a maneira correta de realizar as ações.

>Você deverá verificar a cada novo ambiente se a variável **'base_url'** está apontando para o caminho certo.
>Acesse o caminho **"application/config/config.php"** e verifique a mesma, que deve apontar sempre para o index da aplicação.
>Algumas plataformas online acessam o banco de dados de uma maneira diferente. Caso a aplicação não execute, acesse **“aplication/config/database.php”** e altere o parametro de **"Stricton"** para **TRUE**.

## Possíveis problemas

***

#### Minha conta é listada como administradora no banco de dados, mas vejo apenas o painel de um usuário comum

>1. Tenha certeza de que a aplicação está aceesando o **banco correto**, e não uma **cópia** dele.
>2. **Limpe o cachê do navegador** ou mesmo tente acessar de um **outro navegador**.

#### Ao abrir a aplicação no navegador ela exibe diversos erros no lugar da aplicação

>1. Tenha certeza de que está usando a **versão correta do PHP e do MySQL**. Acesse **"http://localhost/dashboard/phpinfo.php"** e verifique estas informações.
>2. Certifique-se de ter cumprido **todas as etapas** descritas acima.
>3. **Leia o erro apresentado** e busque uma solução específica para ele. Caso tudo esteja certo com os pontos citados acima pode ser um **problema com seu ambiente local**.

#### Ao usar a aplicação eu apaguei um dado importante sem querer

>1. A aplicação **não permite a exclusão de dados que contenham dependências**, como um outro lugar usando aquele valor específico.
>2. Caso um dado não tenha dependências, ela poderá ser excluído, e **sua recuperação só será possível caso haja um backup dos dados da database**.

#### Como realizar alguma tarefa usando a aplicação?

>1. Para dúvidas específicas, você pode solicitar o arquivo da documentação do projeto, que contém diversas informações e tutoriais que podem ser úteis e responder o que você necessita saber.
>2. Caso a informação não esteja na documentação, você pode contatar os administradores da aplicação.

***
**Documentação em progresso**
***