# Annotations - Clone do Reddit - 3Pontos Tech

[//]: # 'Todas suas anotações sobre o projeto. Esse arquivo será mais importante que boa parte do projeto!'

## Visão Geral da Solução

Este projeto é um clone simplificado do Reddit construído com **Laravel 12** + **FilamentPHP 4**, focado nas funcionalidades essenciais de comunidades, postagens, comentários e sistema de votos.

### Arquitetura Escolhida

- **Backend**: Laravel 12 com SQLite (conforme recomendação do README)
- **Admin Panel**: FilamentPHP 4 para gerenciamento dinâmico de subreddits e posts
- **Frontend**: Blade Templates + TailwindCSS v4
- **Database**: SQLite para desenvolvimento (fácil configuração)
- **Testing**: Pest para testes unitários e funcionais

## Principais Decisões Técnicas

### 1. Modelagem de Dados

**Decisão**: Implementei 4 entidades principais com relacionamentos bem definidos:

- **Subreddit**: Comunidades temáticas com slug, cores personalizáveis e controle de ativação
- **Post**: Postagens com suporte a Markdown, diferentes tipos (text/link/image) e cache de scores
- **Comment**: Sistema de comentários aninhados com soft delete para manter threads
- **Vote**: Sistema polimórfico para votar em Posts e Comments

**Justificativa**:

- Cache de vote_score e comment_count para performance
- Soft delete em comentários para manter integridade das threads
- Relacionamentos polimórficos para flexibilidade do sistema de votos
- Índices estratégicos para consultas otimizadas

### 2. Qualidade de Código

**Decisão**: Adotei padrões rigorosos de código:

- `declare(strict_types=1)` em todos os arquivos
- Classes `final` para evitar herança desnecessária
- PHPDoc completo com generics para relacionamentos
- Método `casts()` moderno ao invés de propriedade `$casts`

**Justificativa**: Garante type safety, melhor IDE support e código mais robusto.

### 3. FilamentPHP - Painel Administrativo

**Decisão**: Configurei Resources completos com:

- Formulários dinâmicos com validação em tempo real
- Tabelas com busca, filtros e ordenação
- Campos condicionais (URL só aparece para posts de link/imagem)
- Auto-geração de slugs a partir do nome/título

**Justificativa**: FilamentPHP oferece interface administrativa robusta out-of-the-box, permitindo foco no desenvolvimento das funcionalidades core.

### 4. Sistema de Slugs e URLs

**Decisão**: Implementei auto-geração de slugs únicos para SEO-friendly URLs:

- Subreddits: `r/nome-do-subreddit`
- Posts: `r/subreddit/slug-do-post`

**Justificativa**: Melhora SEO e experiência do usuário com URLs legíveis.

### 5. Seeders com Dados Realistas

**Decisão**: Criei seeders com conteúdo em Markdown sobre programação:

- 5 subreddits de tecnologia (Laravel, PHP, JavaScript, etc.)
- Posts com conteúdo estruturado em Markdown
- Dados realistas para testar funcionalidades

**Justificativa**: Facilita testes e demonstração das funcionalidades.

### 6. Sistema de Autenticação

**Decisão**: Implementei sistema completo de autenticação com:

- **AuthController** centralizado para login, registro e logout
- **Páginas responsivas** com design dark theme consistente
- **Validação robusta** de formulários com tratamento de erros
- **Interface dinâmica** que adapta header baseado no status de login
- **Segurança** com CSRF protection, hash de senhas e validações

**Justificativa**: Base sólida para funcionalidades interativas (votos, comentários) e experiência de usuário personalizada.

### 7. Sistema de Criação de Posts

**Decisão**: Implementei sistema completo de criação de posts com:

- **Formulário dinâmico** com seleção de tipo (texto, link, imagem)
- **Validação condicional** baseada no tipo de post selecionado
- **Interface responsiva** com design dark theme consistente
- **Suporte a Markdown** para posts de texto
- **Validação de URL** para posts de link/imagem

**Justificativa**: Permite flexibilidade na criação de conteúdo, similar ao Reddit original, com validação robusta.

### 8. Sistema de Comentários e Respostas

**Decisão**: Implementei sistema completo de comentários com:

- **Comentários aninhados** com sistema de profundidade
- **Formulários dinâmicos** que aparecem/desaparecem
- **Validação de conteúdo** com limite de caracteres
- **Interface intuitiva** para respostas diretas
- **Sistema de votos** integrado aos comentários

**Justificativa**: Essencial para engajamento da comunidade, permite discussões estruturadas e hierárquicas.

### 9. Sistema de Votos Interativo

**Decisão**: Implementei sistema polimórfico de votos com:

- **Votos em posts e comentários** usando relacionamento polimórfico
- **Interface AJAX** para votação sem reload da página
- **Cache de scores** para performance otimizada
- **Feedback visual** para indicar votos ativos
- **Validação de autenticação** para funcionalidades interativas

**Justificativa**: Sistema central do Reddit, permite ranking de conteúdo por relevância da comunidade.

## Processo de Desenvolvimento

### Etapas Concluídas ✅

1. **Setup inicial** - Configuração do ambiente Laravel + FilamentPHP
2. **Modelagem de dados** - Criação de Models, Migrations e relacionamentos
3. **Painel administrativo** - Resources do Filament configurados
4. **Dados de exemplo** - Seeders com conteúdo realista
5. **Controle de qualidade** - Strict types, PHPDoc, code style
6. **Frontend** - Páginas principais (Home, Subreddit, Post) com design dark theme
7. **Sistema de autenticação** - Login, registro e logout funcionais
8. **Sistema de votos** - Implementação completa de upvote/downvote com AJAX
9. **Sistema de comentários** - Interface para comentários aninhados e respostas
10. **Criação de posts** - Formulário dinâmico com validação condicional
11. **Sistema interativo** - Todas as funcionalidades core do Reddit implementadas

### Próximas Etapas 🚧

1. **Página de perfil** - Edição de dados do usuário
2. **Testes** - Cobertura de testes unitários e funcionais
3. **Otimizações** - Performance e cache adicional
4. **Features avançadas** - Notificações, moderação, etc.

## Trade-offs e Decisões

### SQLite vs PostgreSQL

**Escolha**: SQLite para desenvolvimento
**Justificativa**: Conforme recomendação do README para agilizar configuração. Estrutura permite migração fácil para PostgreSQL em produção.

### Cache vs Cálculo Real-time

**Escolha**: Cache de vote_score e comment_count
**Justificativa**: Performance superior, especialmente com muitos votos. Trade-off: complexidade adicional para manter consistência.

### Soft Delete vs Hard Delete (Comentários)

**Escolha**: Soft delete com flag `is_deleted`
**Justificativa**: Mantém integridade das threads de comentários, importante para UX do Reddit.

### Final Classes

**Escolha**: Todas as classes são `final`
**Justificativa**: Evita herança desnecessária, força composição, melhora performance. Trade-off: menos flexibilidade para extensão.

## Observações Técnicas

- **Conventional Commits**: Todos os commits seguem o padrão solicitado
- **Lint Staged**: Configurado para manter qualidade do código
- **Autoload otimizado**: Classes são autocarregadas de forma eficiente
- **Relacionamentos tipados**: PHPDoc com generics para melhor IDE support

## Status Atual

✅ **Funcional**: Painel administrativo completo para gerenciar subreddits e posts
✅ **Dados**: Seeders com conteúdo de exemplo funcionando
✅ **Qualidade**: Código com padrões rigorosos implementados
✅ **Frontend**: Páginas principais com design dark theme responsivo
✅ **Autenticação**: Sistema completo de login/registro/logout
✅ **Criação de Posts**: Formulário dinâmico com validação condicional
✅ **Sistema de Votos**: Upvote/downvote com AJAX e cache de scores
✅ **Sistema de Comentários**: Comentários aninhados e respostas
✅ **Interatividade**: Todas as funcionalidades core implementadas
🚧 **Perfil**: Página de edição de dados do usuário
🚧 **Testes**: Cobertura de testes unitários e funcionais

## Funcionalidades Implementadas

### 🎯 **Core Features do Reddit**

#### **1. Criação de Posts**

- ✅ Formulário dinâmico com tipos: texto, link, imagem
- ✅ Validação condicional baseada no tipo
- ✅ Suporte completo a Markdown
- ✅ Interface responsiva e intuitiva
- ✅ Botão de criação em cada subreddit

#### **2. Sistema de Comentários**

- ✅ Comentários em posts com formulário integrado
- ✅ Respostas aninhadas com sistema de profundidade
- ✅ Formulários dinâmicos (aparecem/desaparecem)
- ✅ Validação de conteúdo com limite de caracteres
- ✅ Interface hierárquica para discussões

#### **3. Sistema de Votos**

- ✅ Upvote/downvote em posts e comentários
- ✅ Interface AJAX sem reload da página
- ✅ Cache de scores para performance
- ✅ Feedback visual para votos ativos
- ✅ Sistema polimórfico flexível

#### **4. Navegação e UX**

- ✅ Design dark theme consistente
- ✅ Navegação intuitiva entre páginas
- ✅ Responsividade em todos os dispositivos
- ✅ Feedback visual para interações
- ✅ URLs amigáveis com slugs

### 🔧 **Problemas Resolvidos**

#### **Conflito de Rotas (404 Error)**

- **Problema**: Rota `/r/{subreddit:slug}/{post:slug}` capturava `/r/{subreddit:slug}/create`
- **Solução**: Reordenação das rotas para priorizar criação de posts
- **Resultado**: ✅ Funcionalidade funcionando perfeitamente

### 📊 **Métricas de Qualidade**

- **Conventional Commits**: ✅ Todos os commits seguem o padrão
- **Strict Types**: ✅ `declare(strict_types=1)` em todos os arquivos
- **PHPDoc**: ✅ Documentação completa com generics
- **Code Style**: ✅ Padrões PSR-12 seguidos
- **Type Safety**: ✅ Relacionamentos tipados com generics

## 🚀 **Como Testar a Aplicação**

### **Iniciando o Servidor**

```bash
cd /Users/muriloazarias/Documents/Devstuff/3points-test
php artisan serve --host=0.0.0.0 --port=8000
```

### **Acessando a Aplicação**

- **URL Principal**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Login**: http://localhost:8000/login
- **Registro**: http://localhost:8000/register

### **Fluxo de Teste Completo**

#### **1. Autenticação**

1. Acesse http://localhost:8000/register
2. Crie uma conta de usuário
3. Faça login em http://localhost:8000/login

#### **2. Navegação**

1. Explore a página inicial com posts
2. Clique em um subreddit (ex: r/laravel)
3. Visualize posts e comentários

#### **3. Criação de Posts**

1. Em qualquer subreddit, clique em "+ Criar Post"
2. Preencha o formulário:
    - **Título**: "Meu Primeiro Post"
    - **Tipo**: Selecione "Texto"
    - **Conteúdo**: Use Markdown para formatação
3. Clique em "Criar Post"

#### **4. Sistema de Comentários**

1. Em um post, role até o formulário de comentários
2. Digite um comentário e clique "Comentar"
3. Para responder um comentário, clique "Responder"
4. Teste o sistema de comentários aninhados

#### **5. Sistema de Votos**

1. Use os botões de upvote (↑) e downvote (↓)
2. Observe a atualização em tempo real dos scores
3. Teste em posts e comentários

### **Dados de Teste Disponíveis**

- **5 Subreddits**: Laravel, PHP, JavaScript, Programação, Tecnologia
- **Posts de Exemplo**: Com conteúdo em Markdown
- **Usuário Admin**: admin@example.com / password

### **Funcionalidades para Testar**

✅ **Criação de Posts** - Formulário dinâmico
✅ **Sistema de Votos** - AJAX interativo
✅ **Comentários** - Hierárquicos e aninhados
✅ **Navegação** - Entre subreddits e posts
✅ **Autenticação** - Login/registro/logout
✅ **Responsividade** - Teste em diferentes telas
