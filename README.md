# My Subscription Theme

## Estrutura de Pastas e Arquivos

### assets/
- **css/**
  - `style.css`: Estilos principais do tema.
- **js/**
  - `main.js`: Scripts principais do tema.
- **images/**: Imagens usadas no tema.

### template-parts/
- **checkout/**
  - `form-checkout.php`: Template do formulário de checkout.
- **modals/**
  - `terms-modal.php`: Template do modal para exibir os termos de adesão.

### inc/
- `custom-post-types.php`: Registro de tipos de post personalizados.
- `custom-fields.php`: Definição de campos personalizados para usuários.
- `api-integration.php`: Integração com a API do ASAAS.
- `webhooks.php`: Configuração de webhooks para eventos do ASAAS.
- `functions-checkout.php`: Funções relacionadas ao processo de checkout.
- `user-management.php`: Funções para gestão de usuários (titulares e dependentes).
- `helpers.php`: Funções auxiliares usadas em várias partes do tema.

### languages/
- `my-subscription-theme.pot`: Arquivo de tradução para internacionalização do tema.

### page-templates/
- `page-checkout.php`: Template da página de checkout.
- `page-dashboard.php`: Template do dashboard do usuário.

### Arquivos na raiz do tema
- `functions.php`: Arquivo principal de funções do tema, onde serão incluídos os arquivos de `inc/`.
- `style.css`: Arquivo de estilos principal do tema.
- `header.php`: Cabeçalho do tema.
- `footer.php`: Rodapé do tema.
- `index.php`: Arquivo índice do tema.
- `README.md`: Documentação do tema.

## Descrição

Este tema foi desenvolvido para gerenciar um sistema de assinaturas com dependentes no WordPress. Ele inclui integrações com a API do ASAAS para gestão de assinaturas e pagamentos, além de uma página de checkout personalizada que permite aos usuários adicionar dependentes e aceitar os termos de adesão. 

### Funcionalidades Principais

- **Gerenciamento de Titulares e Dependentes**: Utiliza `wp_users` e `wp_usermeta` para gerenciar dados de titulares e dependentes.
- **Integração com a API do ASAAS**: Criação, gestão e cobrança de assinaturas, além de configuração de webhooks para eventos importantes.
- **Página de Checkout Personalizada**: Campos dinâmicos para dependentes, validação de CPF, atualização dinâmica de preço e aceitação de termos de adesão.
- **Sistema de Indicação de Vendedores**: Links personalizados e split de pagamento para comissionamento automático de vendedores.

### Estrutura do Checkout

1. **Início do Checkout**:
   - Usuário acessa a página de checkout e insere seu CPF.
   - O sistema verifica se o CPF já está cadastrado na role 'assinante'.
   - Se o CPF estiver duplicado, o sistema retorna uma mensagem de erro.

2. **Seleção de Dependentes**:
   - Usuário seleciona o número de dependentes que deseja incluir.
   - Formulário é atualizado dinamicamente para adicionar campos de CPF e Nome para cada dependente.

3. **Preenchimento do Formulário**:
   - Usuário preenche todos os campos obrigatórios, incluindo dados pessoais e informações dos dependentes.
   - Valor da assinatura é atualizado dinamicamente baseado no número de dependentes.

4. **Aceitação dos Termos de Adesão**:
   - Usuário deve marcar um checkbox indicando que aceita os Termos de Adesão.
   - Link "Termos de Adesão" ao lado do checkbox, que abre um modal com o conteúdo do termo correspondente (individual ou com dependentes) ao ser clicado.

5. **Identificação do Vendedor**:
   - Se houver um cookie de vendedor presente, o sistema registra a ID do vendedor na transação.
   - Caso contrário, a venda não será atribuída a nenhum vendedor específico.

6. **Processamento do Pagamento**:
   - Usuário escolhe o método de pagamento e conclui a transação.
   - Se um vendedor for indicado, a função de split de pagamento do ASAAS é utilizada para transferir a comissão automaticamente.

7. **Criação de Usuários e Assinaturas**:
   - Sistema cria contas de usuário para o titular e os dependentes.
   - Informações são armazenadas nos campos personalizados e as relações entre titular e dependentes são definidas.

8. **Confirmação e Notificação**:
   - Usuário recebe confirmação da assinatura e detalhes do pagamento.
   - Sistema envia notificações conforme configurado (email, SMS, etc.).#   D N A - C R M  
 #   i n s p i r a c a o c r i s t a  
 