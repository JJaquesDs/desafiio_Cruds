// Pacote principal do projeto. Porta de entrada da aplicação
package main

import (
	"log" // Comando para logs de erros fatais

	"github.com/gin-gonic/gin"                                 // Comando que importa o gin, após instala-lo
	"github.com/yurimatsuzaki/api-go-desafio-ToDo/handlers"    // Comando que importa o pacote handlers
	"github.com/yurimatsuzaki/api-go-desafio-ToDo/persistence" // Comando que importa o pacote persistence
)

func main() {
	// Teste de importação das tarefas salvas no arquivo JSON. Usando a função LoadTaskFromFile()
	if err := persistence.LoadTaskFromFile(); err != nil {
		// Caso o retorno seja um erro, ele aprensenta essa mensagem de erro fatal do sitema. Algo mais bonito e apresentável
		log.Fatalf("Erro critico ao carregar dados iniciais: %v", err)
	}

	// motor do Gin, equivalente a variável app que recebe express() em JavaScript
	router := gin.Default()

	// Rotas da API, primeiro passa o caminho e depois as funções de ação. Nesse caso, ele importa as funções do pacote handlers
	router.GET("/tarefas", handlers.GetTasks)
	router.POST("/tarefas", handlers.CreateTasks)
	router.PUT("/tarefas/:id", handlers.UpdateTask)
	router.DELETE("/tarefas/:id", handlers.DeleteTask)

	// Define a porta que a aplicação irá rodar
	router.Run(":8080")
}
