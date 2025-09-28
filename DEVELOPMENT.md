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

## Processo de Desenvolvimento

### Etapas Concluídas ✅

1. **Setup inicial** - Configuração do ambiente Laravel + FilamentPHP
2. **Modelagem de dados** - Criação de Models, Migrations e relacionamentos
3. **Painel administrativo** - Resources do Filament configurados
4. **Dados de exemplo** - Seeders com conteúdo realista
5. **Controle de qualidade** - Strict types, PHPDoc, code style

### Próximas Etapas 🚧

1. **Frontend** - Páginas principais (Home, Subreddit, Post)
2. **Autenticação** - Sistema de login/registro para usuários
3. **Sistema de votos** - Implementação de upvote/downvote
4. **Comentários** - Interface para comentários aninhados
5. **Testes** - Cobertura de testes unitários e funcionais

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
🚧 **Frontend**: Próxima etapa principal
🚧 **Autenticação**: Sistema de usuários para frontend
🚧 **Interatividade**: Votos e comentários
