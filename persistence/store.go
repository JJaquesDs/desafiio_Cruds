package persistence

import (
	"encoding/json" // Pacote para trabalhar com conversões de tipos em JSON
	"fmt"
	"github.com/yurimatsuzaki/api-go-desafio-ToDo/models"
	"os"      // Pacote para trbalahar com coisas que envolvem o Sistema Operacional
	"strconv" // Pacote para conversão de tipos de dados para suas representações em String
)

// Criando e inserindo dados em um Slice
var list []models.Tarefa

// Variável que vai definir o início dos próximos IDs
var nextID int64 = 1

// Define o nome do arquivo onde vamos armazenar os dados
const filePath string = "tarefas.json"

// Função que trasnforma os dados Go em um arquivo JSON
func SaveTaskToFile() error { // Função do tipo error pois retorna nil caso tudo dê certo ou o erro em si em caso de falha
	// A função json.MarchalIndent recebe como parâmetro a slice Go e trasnforma em JSON, também recebe espaços para identação e formatação do JSON
	data, err := json.MarshalIndent(list, "", "	")
	if err != nil { // Caso o erro recebido não for nil, ele retorna uma mensagem de erro
		return fmt.Errorf("erro ao transformar a lista em JSON: %w", err)
	}

	// a variável err recebe a transformação do objeto GO em um arquivo na raiz do projeto (nome do arquivo, os dados que serão inseridos no arquivo, código padrão onde o adm tem permissões de modificação e outros apenas de leitura)
	err = os.WriteFile(filePath, data, 0644)
	if err != nil {
		return fmt.Errorf("erro ao escrever no arquivo %s: %w", filePath, err)
	}

	return nil
}

// Função que de pega os registros do arquivo JSON e trasnforma novamente em objetos Go
func LoadTaskFromFile() error {
	// os.ReadFile() Lê o arquivo de nome como parâmetro
	data, err := os.ReadFile(filePath)

	// Se houver erro ele cai aqui
	if err != nil {
		// Caso o erro arquivo não exista, cai nessa mensagem de erro
		if os.IsNotExist(err) {
			fmt.Printf("Aviso: Arquivo de dados %s não encontrado. Iniciando com lista vazia.\n", filePath)
			return nil
		}
		// Caso o arquivo exista e o erro seja de leitura, cai nessa mensagem
		return fmt.Errorf("erro ao ler o arquivo %s: %w", filePath, err)
	}

	// Pega os dados extraidos do documento e tenta alocar no Slice list
	err = json.Unmarshal(data, &list)
	if err != nil {
		return fmt.Errorf("erro ao transformar o JSON em slice: %w", err)
	}

	// Se o tamanho do slice for maior que 0 (ou seja, existir registro)
	if len(list) > 0 {
		// variável que recebe o id do último elemento da lista
		lastIDStr := list[len(list)-1].ID

		// Converte o Id que é string em um inteiro para poder fazer cálculos
		lastID, _ := strconv.ParseInt(lastIDStr, 10, 64)
		// Intera o id para que o próximo registro seja atualizado
		nextID = lastID + 1
	}

	// Caso dê certo, essa é a mensagem enviada
	fmt.Printf("Sucesso: %d tarefas carregados do arquivo %s. \n", len(list), filePath)
	return nil
}

// Função que de fato adiciona as tarefas no slice. Ela devolve a tarefa adicionada
func AddTask(task models.Tarefa) models.Tarefa {
	task.ID = fmt.Sprintf("%d", nextID)
	nextID++

	task.Status = "pendente"

	// Adiciona a tarefa no final do Slice
	list = append(list, task)

	// Salva a tarefa no arquivo via a função SaveTaskToFile() e retorna um erro caso dê errado
	if err := SaveTaskToFile(); err != nil {
		fmt.Printf("ERRO PERSISTÊNCIA: Falha ao salvar no disco: %v\n", err)
	}

	return task
}

// Função que pega e devolve toda a lista de tarefas
func GetAllTasks() []models.Tarefa {
	return list
}

// Função que de fato modifica as tarefas. Ela devolve a tarefa adicionada
func UpdateTask(task models.Tarefa, id string) models.Tarefa {
	// Varre a lista de tarefas e devolve o índice(i) e o item (item)
	for i, item := range list {
		if item.ID == id { // Compara de o Id do item encontrado é igual o Id passado na URL
			task.ID = id             // Insere o mesmo Id na tarefa para que isso não se modifique
			task.Status = "pendente" // deixa o arquivo como pendente
			list[i] = task           // Insere a tarefa novamente dentro da lista na mesma posição

			if err := SaveTaskToFile(); err != nil {
				fmt.Printf("ERRO PERSISTÊNCIA: Falha ao atualizar no disco: %v\n", err)
			}
		}
	}
	return task
}

// Função que deleta tarefas
func DeleteTask(id string) {
	for i, item := range list { // Procura o item novamente
		if item.ID == id {
			// copia a lista do item escolhido para trás e junta com a cópia da lista do item escolhido pra frente, excluindo apenas o ítem desejado
			list = append(list[:i], list[i+1:]...)

			// Atualiza o "bando de dados"
			if err := SaveTaskToFile(); err != nil {
				fmt.Printf("ERRO PERSISTÊNCIA: Falha ao atualizar no disco(tarefa deletada): %v\n", err)
			}
		}
	}
}
