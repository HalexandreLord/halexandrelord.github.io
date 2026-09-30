# Prova Online — HTML + CSS + JavaScript + PHP

## O que o projeto possui
- 10 questões de múltipla escolha.
- Exatamente 5 alternativas por questão.
- Cronômetro configurável; padrão de 120 minutos.
- O aluno não consegue enviar a prova com questão em branco enquanto estiver dentro do tempo.
- Quando o tempo termina, a prova é enviada automaticamente.
- Resultado exibido somente ao próprio aluno ao finalizar.
- Área do professor protegida por senha.
- Professor pode editar as 10 questões e indicar a alternativa correta.
- Professor consegue consultar a pontuação de cada aluno.
- O aluno pode usar "Gerar PDF da prova", que abre a impressão do navegador e permite escolher "Salvar como PDF".
- Dados dos resultados não são entregues à área do aluno.
- O servidor é responsável pela correção.

## Instalação

1. Copie os arquivos para uma hospedagem que execute PHP 8+.
2. Abra `config.php`.
3. Troque `ADMIN_PASSWORD = 'TroqueEstaSenha123!'` por uma senha forte.
4. Garanta permissão de escrita na pasta `data/`.
5. Acesse `professor.html`, entre com a senha e cadastre as questões.
6. Os alunos usam `index.html`.

## Importante sobre GitHub Pages

GitHub Pages hospeda arquivos estáticos e não executa PHP. Portanto, este projeto pode ficar no GitHub como código-fonte, mas os arquivos PHP precisam ser executados em uma hospedagem PHP (por exemplo, uma hospedagem tradicional, VPS ou outro serviço que ofereça PHP).

Se quiser usar somente GitHub Pages, será necessário substituir o backend PHP por um serviço de backend/API externo. Não é seguro colocar a senha do professor ou as respostas corretas apenas em JavaScript, porque o aluno poderia inspecionar o código.

## Segurança

Este projeto é uma base funcional para uso didático. Para produção, recomenda-se:
- usar HTTPS;
- armazenar senha com `password_hash()` em banco de dados;
- usar MySQL/MariaDB em vez de JSON;
- usar CSRF tokens;
- limitar tentativas de login;
- separar permissões de professor e aluno;
- registrar auditoria;
- impedir acesso HTTP direto à pasta de dados;
- usar sessões seguras e cookies `HttpOnly`, `Secure` e `SameSite`;
- considerar um identificador único do aluno em vez de confiar somente no código digitado.

## PDF

O botão usa a função de impressão do navegador (`window.print()`), permitindo "Salvar como PDF". Isso evita dependências como Composer/DOMPDF e funciona em hospedagens PHP simples.
