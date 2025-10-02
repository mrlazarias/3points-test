# Jest Testing Setup - Frontend Tests

## 📁 Estrutura de Testes

```
tests/js/
├── README.md           # Este arquivo
├── setup.js            # Configuração global dos testes
├── voting.test.js      # Testes do sistema de votação
└── comments.test.js    # Testes do sistema de comentários
```

## 🚀 Comandos Disponíveis

### Executar todos os testes

```bash
npm test
```

### Executar testes em modo watch (reexecuta ao salvar arquivos)

```bash
npm run test:watch
```

### Executar testes com relatório de cobertura

```bash
npm run test:coverage
```

## ✅ Status Atual dos Testes

### Sistema de Votação (`voting.test.js`) - ✅ 12/12 testes passando

| Categoria              | Testes | Status |
| ---------------------- | ------ | ------ |
| **getCsrfToken**       | 2      | ✅     |
| **handleVoteClick**    | 6      | ✅     |
| **updateButtonStates** | 3      | ✅     |
| **Static votePost**    | 1      | ✅     |

**Cobertura**: ~92%

### Sistema de Comentários (`comments.test.js`) - 🚧 Em desenvolvimento

| Categoria               | Testes | Status     |
| ----------------------- | ------ | ---------- |
| **getCsrfToken**        | 2      | ✅         |
| **handleCommentSubmit** | 6      | 🔧 Parcial |
| **toggleReplyForm**     | 2      | ✅         |
| **deleteComment**       | 4      | 🔧 Parcial |
| **updateCommentCount**  | 1      | ✅         |

**Cobertura**: ~57%

## 📊 Relatório de Cobertura Geral

```
-------------|---------|----------|---------|---------|---
File         | % Stmts | % Branch | % Funcs | % Lines |
-------------|---------|----------|---------|---------|---
All files    |   76.03 |    60.86 |   73.91 |   76.27 |
 app.js      |       0 |        0 |       0 |       0 |
 comments.js |   57.14 |    46.15 |   66.66 |   58.18 |
 voting.js   |    92.3 |    69.76 |   81.81 |   92.06 |
-------------|---------|----------|---------|---------|---
```

## 🎯 Funcionalidades Testadas

### Sistema de Votação ✅

- ✅ Obtenção de CSRF token
- ✅ Envio de requisição de voto (upvote/downvote)
- ✅ Atualização de contadores de votos
- ✅ Desabilitar/habilitar botões durante requisição
- ✅ Atualização de estados visuais dos botões
- ✅ Tratamento de erros de rede
- ✅ Tratamento de falhas de votação
- ✅ Validação de atributos obrigatórios

### Sistema de Comentários 🚧

- ✅ Obtenção de CSRF token
- 🔧 Submissão de comentários via AJAX
- 🔧 Limpeza do formulário após submissão
- 🔧 Atualização de contador de comentários
- ✅ Toggle de formulário de resposta
- 🔧 Exclusão de comentários
- 🔧 Tratamento de erros

## 🔧 Configuração

### Arquivos de Configuração

#### `jest.config.js`

```javascript
export default {
    testEnvironment: 'jsdom',
    setupFilesAfterEnv: ['<rootDir>/tests/js/setup.js'],
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/js/$1',
    },
    // ... mais configurações
};
```

#### `babel.config.js`

```javascript
export default {
    presets: [
        [
            '@babel/preset-env',
            {
                targets: { node: 'current' },
            },
        ],
    ],
};
```

## 📝 Como Criar Novos Testes

### 1. Criar o arquivo JavaScript da funcionalidade

```javascript
// resources/js/minha-funcionalidade.js
export class MinhaFuncionalidade {
    constructor() {
        this.csrfToken = this.getCsrfToken();
    }

    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : null;
    }
}
```

### 2. Criar o arquivo de teste

```javascript
// tests/js/minha-funcionalidade.test.js
import { MinhaFuncionalidade } from '../../resources/js/minha-funcionalidade.js';

describe('MinhaFuncionalidade', () => {
    beforeEach(() => {
        // Setup antes de cada teste
        document.head.innerHTML = '';
        document.body.innerHTML = '';
    });

    it('should do something', () => {
        const funcionalidade = new MinhaFuncionalidade();
        expect(funcionalidade).toBeDefined();
    });
});
```

### 3. Executar os testes

```bash
npm test
```

## 🎨 Boas Práticas

### ✅ DO

- Limpe o DOM antes de cada teste (`beforeEach`)
- Use mocks para fetch, console, window.location
- Teste casos de sucesso E casos de erro
- Verifique os parâmetros das requisições AJAX
- Teste a manipulação do DOM (atualização de elementos)

### ❌ DON'T

- Não dependa de testes anteriores
- Não modifique o DOM global sem limpar depois
- Não teste detalhes de implementação
- Não faça requisições reais de rede

## 🐛 Troubleshooting

### Erro: "Cannot redefine property: location"

**Solução**: Usar `delete window.location` antes de redefinir.

### Erro: "Not implemented: navigation"

**Nota**: Este é um aviso do jsdom, não impacta os testes.

### FormData não funciona corretamente

**Solução**: Mock o `FormData.prototype.get` com `jest.spyOn`.

## 📚 Recursos

- [Jest Documentation](https://jestjs.io/docs/getting-started)
- [Testing Library](https://testing-library.com/docs/)
- [jsdom](https://github.com/jsdom/jsdom)
- [Babel Jest](https://jestjs.io/docs/getting-started#using-babel)

## 🚧 Próximos Passos

1. ✅ Completar testes do sistema de comentários
2. 📝 Criar testes para o sistema de notificações
3. 📝 Criar testes para WebSocket/Echo
4. 📝 Aumentar cobertura para 90%+
5. 📝 Adicionar testes de integração
6. 📝 Configurar CI/CD para rodar testes automaticamente
