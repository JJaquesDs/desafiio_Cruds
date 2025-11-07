package handlers

import (
	"net/http" // Comando que importa o pacote net/http

	"github.com/gin-gonic/gin"                                 // Comando que importa o pacote do gin
	"github.com/yurimatsuzaki/api-go-desafio-ToDo/models"      // Comando que importa o pacote models
	"github.com/yurimatsuzaki/api-go-desafio-ToDo/persistence" // Comando que importa o pacote persistence
)

// Função de requisição do tipo GET, recebe os dados de outra função presente no pacote persistence
func GetTasks(c *gin.Context /*Parâmetro padrão do Gin que envia e recebe requisições (req,res - do JS)*/) {
	// Status HTTP em GO são definidos pelos termos que a definem, não por números
	c.JSON(http.StatusOK, persistence.GetAllTasks())
}

// Função de requisição do tipo POST, recebe uma nova tarefa e encaminha para a função que vai inseri-la no "banco de dados"
func CreateTasks(c *gin.Context) {
	// Criando uma variável do tipo Tarefa que vai receber a nova tarefa
	var newTask models.Tarefa

	// Testa um possível erro de requisição
	if err := c.BindJSON(&newTask); err != nil {
		return
	}

	// nova tarefa é enviada para a função que vai inseri-la no banco que por sua vez retorna a função inserida caso dê certo
	taskWithID := persistence.AddTask(newTask)

	// Devlve em formato JSON a tarefa e ainda um código HTTP de criado (201)
	c.JSON(http.StatusCreated, taskWithID)
}

// Função de requisição do tipo PUT
func UpdateTask(c *gin.Context) {
	var updatedTask models.Tarefa

	// Pegando o ID da URL
	id := c.Param("id")

	if err := c.BindJSON(&updatedTask); err != nil {
		return
	}

	// Enviando para a função a nova tarefa e o ID da mesma para atualizar
	newTask := persistence.UpdateTask(updatedTask, id)

	c.JSON(http.StatusCreated, newTask)
}

// Função de requisição do tipo DELETE
func DeleteTask(c *gin.Context) {
	id := c.Param("id")

	// Enviando apenas o ID para deletar
	persistence.DeleteTask(id)

	// Mensagem de deletado com sucesso ao invés da tarefa em si
	c.JSON(http.StatusOK, gin.H{"menssangem": "Tarefa deletada com sucesso"})
}
