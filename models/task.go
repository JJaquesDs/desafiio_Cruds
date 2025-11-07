package models

// Definindo a estrutura dos dados trabalahdos na API, criando um novo tipo de dados para comportar minhas necessidades do projeto
type Tarefa struct {
	ID     string `json:"id"`                        // Padroniza os campos JSON, já que o padrão são letras minúsculas
	Titulo string `json:"titulo" binding:"required"` // Área que diz que o campo não pode ser enviado vazio (not null)
	Status string `status:"status"`
}
