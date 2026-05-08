# 🐾 Petshop Patinhas Felizes

Sistema de gerenciamento de petshop desenvolvido em **PHP puro** com **Programação Orientada a Objetos (POO)** e padrão **Singleton** para conexão com banco de dados. Permite o cadastro de tutores e pets, agendamento de serviços e administração do sistema.

---

## 📋 Tecnologias Utilizadas

- **PHP** (puro, sem frameworks)
- **MySQL** (banco de dados relacional)
- **HTML5 / CSS3** (frontend)
- **XAMPP** (servidor local Apache + MySQL)

---

## ✅ Pré-requisitos

Antes de começar, você precisará ter instalado:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html) — contém o Apache e o MySQL juntos
- [Git](https://git-scm.com/downloads) — para clonar o repositório

---

## 🪟 Instalação no Windows (passo a passo)

### 1. Instalar o XAMPP

1. Acesse [https://www.apachefriends.org](https://www.apachefriends.org/pt_br/index.html) e baixe o instalador para Windows
2. Execute o instalador e siga os passos (pode deixar as opções padrão)
3. Ao finalizar, abra o **XAMPP Control Panel**

### 2. Instalar o Git

1. Acesse [https://git-scm.com/downloads](https://git-scm.com/downloads) e baixe o instalador para Windows
2. Execute e avance com as opções padrão até concluir
3. Para verificar se funcionou, abra o **Prompt de Comando** (`cmd`) e digite:
   ```
   git --version
   ```
   Se aparecer a versão, está instalado corretamente ✅

### 3. Clonar o repositório

1. Abra o **Prompt de Comando** (`cmd`)
2. Navegue até a pasta `htdocs` do XAMPP:
   ```
   cd C:\xampp\htdocs\crud-pet-shop>
   ```
3. Clone o repositório:

   ```
   Tem que ficar dessa forma:

   C:\xampp\htdocs\crud-pet-shop> git clone https://github.com/brinatech/crud-pet-shop.git
   ```

### 4. Iniciar o servidor

1. Abra o **XAMPP Control Panel**
2. Clique em **Start** ao lado de **Apache**
3. Clique em **Start** ao lado de **MySQL**
4. Ambos devem ficar com fundo verde

### 5. Configurar o banco de dados

1. Abra o navegador e acesse:
   ```
   http://localhost/crud-pet-shop/setup.php
   ```
2. Se aparecer a mensagem **"Banco de Dados configurado com sucesso!"**, está tudo certo ✅
3. Se aparecer algum erro de conexão, veja a seção [Problemas Comuns](#-problemas-comuns) abaixo

### 6. Acessar o sistema

```
http://localhost/crud-pet-shop/index.php
```

**Credenciais de administrador criadas automaticamente pelo setup:**
| Campo | Valor |
|-------|-------|
| E-mail | `admin@patinhas.com` |
| Senha | `admin123` |

---

## 🐧 Instalação no Ubuntu/Linux (passo a passo)

### 1. Instalar o XAMPP

1. Acesse [https://www.apachefriends.org](https://www.apachefriends.org/pt_br/index.html) e baixe a versão Linux (`.run`)
2. Abra o terminal e torne o arquivo executável (substitua pelo nome exato do arquivo baixado):
   ```bash
   chmod +x xampp-linux-x64-*.run
   sudo ./xampp-linux-x64-*.run
   ```
3. Siga o assistente de instalação
4. Para iniciar o XAMPP:
   ```bash
   sudo /opt/lampp/lampp start
   ```

### 2. Instalar o Git

```bash
sudo apt update
sudo apt install git -y
```

Verifique:

```bash
git --version
```

### 3. Clonar o repositório

```bash
cd /opt/lampp/htdocs
sudo git clone https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git crud-pet-shop
```

> **Importante:** No Linux, nomes de pasta são **case-sensitive**. A pasta **deve** se chamar exatamente `crud-pet-shop`.

Dê permissão de escrita (necessário para o PHP funcionar):

```bash
sudo chmod -R 755 /opt/lampp/htdocs/crud-pet-shop
sudo chown -R daemon:daemon /opt/lampp/htdocs/crud-pet-shop
```

### 4. Criar usuário MySQL para o projeto

No Linux, o `root` do MySQL normalmente **não aceita senha em branco**. Você precisa criar um usuário:

```bash
sudo /opt/lampp/bin/mysql -u root
```

Dentro do MySQL, execute:

```sql
CREATE USER 'petshop'@'localhost' IDENTIFIED BY 'petshop123';
GRANT ALL PRIVILEGES ON petshop_db.* TO 'petshop'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5. Ajustar as credenciais no projeto

Edite os seguintes arquivos e substitua `root` / senha vazia pelas credenciais criadas acima:

**`classes/Conexao.php`** — localize e altere:

```php
$user = 'petshop';   // era 'root'
$pass = 'petshop123'; // era ''
```

**`setup.php`** — localize e altere:

```php
$user = 'petshop';    // era 'root'
$pass = 'petshop123'; // era ''
```

### 6. Configurar o banco e acessar

1. Com o XAMPP rodando, acesse no navegador:
   ```
   http://localhost/crud-pet-shop/setup.php
   ```
2. Após o sucesso, acesse:
   ```
   http://localhost/crud-pet-shop/index.php
   ```

---

## 🔐 Perfis de Usuário

| Perfil    | Acesso                                                |
| --------- | ----------------------------------------------------- |
| **Admin** | Gerencia tutores, pets, serviços e agendamentos       |
| **Tutor** | Cadastra e gerencia seus próprios pets e agendamentos |

Para criar um novo tutor, acesse a tela de **Cadastro** na página inicial.

---

## ⚠️ Problemas Comuns

### ❌ "Erro na configuração: Access denied for user 'root'"

O MySQL está rejeitando a conexão com senha vazia.

- **Windows:** Abra o phpMyAdmin (`http://localhost/phpmyadmin`) e verifique se o MySQL está rodando
- **Linux:** Crie um usuário com senha conforme descrito na seção de instalação Ubuntu acima

### ❌ CSS não aparece / página sem estilo

Verifique se a pasta do projeto se chama **exatamente** `crud-pet-shop` (tudo minúsculo, com hífens). Renomear a pasta resolve.

### ❌ Página em branco ou erro 404

Confirme que o **Apache** está iniciado no painel do XAMPP e que a URL está correta.

### ❌ "git clone" não é reconhecido no cmd

O Git não está instalado ou não foi adicionado ao PATH. Reinstale o Git marcando a opção "Add Git to PATH" durante a instalação.

---

## 📁 Estrutura do Projeto

```
crud-pet-shop/
├── admin/          # Páginas de administração
├── agendamentos/   # CRUD de agendamentos
├── assets/         # CSS e imagens
├── classes/        # Classes PHP (Conexao, Pet, Usuario...)
├── includes/       # Header e footer reutilizáveis
├── pets/           # CRUD de pets
├── index.php       # Tela de login
├── cadastro.php    # Tela de cadastro de tutor
├── dashboard.php   # Dashboard do tutor
├── setup.php       # Script de instalação do banco
└── logout.php      # Encerra a sessão
```
