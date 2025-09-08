# desafiio_Cruds
Esse é um repositório para criarmos CRUD's em linguagens de programação sortidas entre os participantes, nota-se que NÃO deve se usar qlq tipo de IA assistente de código. Apenas documentações ou video aulas.


## Regras ##

- Os participantes devem submeter um CRUD na linguagem que foram sorteados, podendo escolher o framework que deseja trabalhar
- Um forma de verificar que o projeto não foi feito todo em IA será que os participantes não podem enviar um único commit, devendo ser pelo menos 1 commit por serviço do CRUD
Ex.: 1 commit para serviço de criar tarefa, 1 commit para serviço de ler tarefa, etc...
- O banco de dados para persistência dos dados pode ser qualquer um SQL (Não pode ser NoSQL)

**Desafio:**

🔐 **Criar uma API de Gerenciamento de Tarefas (To-Do API)**

📋 **Descrição**

Crie uma API REST simples para gerenciar uma lista de tarefas (to-dos),
com as seguintes funcionalidades:

> 1\. **Criar tarefa**
>
> 2\. **Listar todas as tarefas**
>
> 3\. **Marcar tarefa como concluída**
>
> 4\. **Deletar tarefa**

📦 **Estrutura da Tarefa (modelo de dados)**

| Tarefa(ToDO) | Tipo de Dado |
| :--- | :---: | 
| Id | Long |
| Nome | String |
| Descrição | String |
| Concluida | Boolean |

📌 **Requisitos**

**Rotas** **da** **API:**

● GET /tarefas → Lista todas as tarefas

● POST /tarefas → Cria uma nova tarefa

● PUT /tarefas/{id} → Atualiza uma tarefa (ex: marcar como concluída)

● DELETE /tarefas/{id} → Deleta uma tarefa

**Extras** **opcionais:**

> ● Salvar os dados em arquivo (ex: JSON ou txt)
>
> ● Adicionar validações (ex: título não pode ser vazio)
>
> ● Organizar por data de criação ou status (pendente/concluído)

🚀 **Tecnologias** **/** **Linguagens**

Implemente esse mesmo desafio em:

> ● Java (com ou sem Spring Boot)
>
> ● JavaScript (Node.js com Express, por exemplo)
>
> ● Python (Flask ou FastAPI)
>
> ● Go (net/http ou Gin)
>
> ● C++ (usando REST frameworks como Pistache ou cpp-httplib)
>
> ● PHP (puro ou com Slim)
>
> ● C# (ASP.NET Core)

🎯 **Objetivo** **do** **Desafio**

> ● Praticar **estruturação** **de** **APIs** **REST**
>
> ● Exercitar as **principais** **funcionalidades** **CRUD**
>
> ● Comparar como **diferentes** **linguagens** lidam com a mesma lógica
>
> ● Aprender sobre **frameworks** **web** de cada linguagem (ou usar o
> mínimo possível)

**SEM IA!!** 

## Divisão de Linguagens ##

| Participantes | Linguagem |
| :--- | :---: |
| Averaldo | Python |
| Cauê | C++ |
| Henrique | C# |
| Loraschi | php |
| Opaulin | Go |
| João | JavaSript |
| Yuri | Java |
