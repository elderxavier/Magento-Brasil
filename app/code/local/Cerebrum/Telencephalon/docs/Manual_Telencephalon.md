![valid XHTML][checkmark]
[checkmark]: http://www.cerebrum.com.br/loja/skin/frontend/base/default/images/logo.png "CEREBRUM"

[ticket]: https://cerebrum.freshdesk.com/support/tickets/new
[markdown]: http://daringfireball.net/projects/markdown/

-
---

> Revisão: 16/04/2014 16:30:15
> Cópia: https://github.com/Telencephalon/Cerebrum/blob/master/Manual_Telencephalon.md

---

# MAGENTO

Dados recentes comprovam que o Magento Ecommerce é a plataforma de comércio eletrônico que mais cresce no mundo, devido a sua robustez, flexibilidade, ser modular, multi-idiomas, multi-lojas, multi-moedas, amigável para mecanismos de buscas, possuir ferramentas para desenvolver promoções, categorizar clientes por grupos e muito mais.

Sistema de demonstração

http://demo.magentocommerce.com/  
http://demo-admin.magentocommerce.com/index.php/admin/

## Instalação

O script a seguir é um modelo para a execução do procedimento

Os comandos a seguir devem ser executados via terminal, certifique de alterar o caminho modelo "/home/marcio/Dados/www/" para o seu ambiente

	// Download Magento + Extração + Permissões + Criação de Banco
	cd /home/marcio/Dados/www/;
	wget http://www.magentocommerce.com/downloads/assets/1.8.1.0/magento-1.8.1.0.tar.gz;
	tar -zxvf magento-1.8.1.0.tar.gz;
	mv magento magento-1.8.1.0-dev02;
	sudo chmod -R o+w /home/marcio/Dados/www/magento-1.8.1.0-dev02/media;
	sudo chmod -R o+w /home/marcio/Dados/www/magento-1.8.1.0-dev02/var;
	sudo chmod o+w /home/marcio/Dados/www/magento-1.8.1.0-dev02/app/etc;
	mysqladmin -u root -p CREATE 'magento-1.8.1.0-dev02';

	// Suporte a Sample_Data -  Opcional
	wget http://www.magentocommerce.com/downloads/assets/1.6.1.0/magento-sample-data-1.6.1.0.tar.gz;
	tar -zxvf magento-sample-data-1.6.1.0.tar.gz;
	cp -ri magento-sample-data-1.6.1.0/media/* magento-1.8.1.0-dev02/media/;
	sudo chmod -R o+w /home/marcio/Dados/www/magento-1.8.1.0-dev02/media;
	mysql -h 'localhost' -u 'root' -p 'magento-1.8.1.0-dev02' < 'magento-sample-data-1.6.1.0/magento_sample_data_for_1.6.1.0.sql';

Acesse o projeto do Magento via browser para iniciar processo de instalação e siga os processos até sua conclusão

No Backend do Magento, acesse o menu: System -> Cache Management -> Desative o Cache

No Backend do Magento, acesse o menu: System -> Index Management -> Reindexe os índices

No Backend do Magento, acesse o menu: System -> Configuration -> Sales -> Shipping Settings -> Origin -> Preencha os campos solicitados "Necessário para os métodos de entrega"

No Backend do Magento, acesse o menu: System -> Configuration -> Customers -> Customer Configuration -> Name and Address Options -> Sugiro deixar ativo os campos: "Show Date of Birth", "Show Tax/VAT Number", "Show Gender"  
Obs. o campo "taxvat" é geralmente usado para armazenar documentos como CPF/CNPJ

No Backend do Magento, acesse o menu: System -> Configuration -> Advanced -> Developer -> Log Settings ->  Enabled -> Yes

## Perguntas mais frequentes "FAQ"

**Módulos recomendados**

0. 
	wget http://connect.magentocommerce.com/community/get/o2ti_moip-1.0.7.tgz

1. 
http://www.magentocommerce.com/magento-connect/aschroder-com-smtp-pro-email-free-and-easy-magento-emailing-for-smtp-gmail-or-google-apps-email.html  
	Magento Connect 1.0: magento-community/ASchroder_SMTPPro  
	Magento Connect 2.0: http://connect20.magentocommerce.com/community/ASchroder_SMTPPro

2. 
O seguinte módulo apresenta os processos via CRON que devem ser executadas e que foram executados

http://www.magentocommerce.com/magento-connect/aoe-scheduler.html  
	Magento Connect 1.0: magento-community/Aoe_Scheduler  
	Magento Connect 2.0: http://connect20.magentocommerce.com/community/Aoe_Scheduler  
	http://ext.2magento.com/Aoe_Scheduler.html

3. 
http://www.magentocommerce.com/magento-connect/mage-monkey-mailchimp-integration-4865.html
	Magento Connect 1.0: magento-community/Ebizmarts_MageMonkey
	Magento Connect 2.0: http://connect20.magentocommerce.com/community/Ebizmarts_MageMonkey

4. 
IWD_OnepageCheckout

http://www.magentocommerce.com/magento-connect/one-page-checkout.html
	Magento Connect 2.0: http://connect20.magentocommerce.com/community/1213
	http://www.interiorwebdesign.com/magento/magento-one-step-checkout-module.html

**Cotação de Moedas, Magento Cambio**

:: Habilitando moedas

	Assim que instalamos o Magento, por padrão, ele carrega diversas moedas. Mas o normal seria utilizarmos apenas uma (ou duas) moedas no sistema.

	Então carregar menos moedas no sistema é mais inteligente e otimizado para sua loja. Para isso acesse:

	No Backend do Magento, acesse o menu: Sistema -> Configuração -> Avançado -> Sistema -> Moeda

	Na lista de moedas instaladas você deve selecionar apenas as que deseja usar no sistema, para que ele não carregue opções desnecessárias.

	Neste exemplo iremos trabalhar com Real Brasileiro e Dólar Norte-Americano.

:: Exibindo moedas na vitrine

	Por padrão, o sistema exibe apenas uma moeda na sua visão de loja, apenas a moeda padrão – informada durante a instalação do Magento.

	Para ter outras opções de moeda, você deve acessar:

	No Backend do Magento, acesse o menu: Sistema -> Configuração -> Geral -> Configuração de Moedas [Opções e Moeda]

	No campo "Moedas Permitidas" serão listados todas as moedas do sistema, aquelas que você configurou anteriormente. Basta selecionar as opções que deseja disponibilizar em frontend.

	O campo "Moeda Base" é referente à cobrança dos produtos, como os clientes devem considerar a compra/pagamento dos itens, então mesmo visualizando em outra moeda o formato válido para pagamento é o da moeda base. Por padrão você tem apenas uma moeda base para todo o sistema, caso queira ter uma moeda base para cada website, você deve primeiro ir em:

	No Backend do Magento, acesse o menu: Sistema -> Configuração -> Catálogo -> Catálogo [Preço]

	E alterar o escopo de preços para "Website".

	Em seguida você deve reindexar os índices das tabelas conforme solicitado pelo sistema.

	Se você alterar o escopo para "website" durante a criação/edição de um produto, pode definir preços diferentes para o mesmo produto. (exemplo no vídeo)

	Já o campo "Exibir Moeda Padrão" influencia apenas na forma como seus produtos serão apresentados durante a navegação do usuário. Assim que ele entrar na sua loja, antes dele escolher o formato de moeda que deseja visualizar, qual a moeda será apresentada? Você decide neste campo.

:: Fazendo a cotação

	Não basta apenas selecionar as opções de moedas para o sistema, é preciso informar o valor cambial de cada nova cifra. Para isso você precisa acessar:

	No Backend do Magento, acesse o menu: Sistema -> Gerenciar Moeda -> Tarifas

	Alguns campos estarão em branco para você preencher manualmente, ou… basta clicar no botão [+ Importar]. E a cotação será importada automaticamente do serviço Webservicex.

	Se você estiver de acordo com o valor informado, basta clicar em Salvar.

	Agora que o sistema conhece os valores de cada moeda, ele deve ser exibido na visão da sua loja as opções para o cliente escolher como deseja visualizar os preços.


:: Controle de câmbio

	Você provavelmente não deseja fazer esse controle manualmente, todo dia acessando o backend para atualizar os preços do dólar/euro/real, etc. Por isso vamos a mais algumas configurações, em:

	No Backend do Magento, acesse o menu: Sistema -> Configuração -> Geral -> Configuração de Moedas [Webservicex]

	Você tem apenas um campo, no qual não precisa se preocupar.

	tempo conexao webservicex

	Este campo informa em segundos, por quanto tempo ele vai tentar uma conexão com o webservice da Webservicex para obter atualização dos valores. Mas você pode aumentar esse número caso queira uma garantia maior de resposta do servidores deles.

	Agora a configuração que realmente interessa fica em:

	No Backend do Magento, acesse o menu: Sistema -> Configuração -> Geral -> Configuração de Moedas [Opções de Importação Agendadas]

	Aqui não tem muito o que explicar, é tudo bem sugestivo na verdade – sem truques.

	configuracoes de agendamento webservicex

	Basta “habilitar” o módulo. O serviço disponível é apenas o “Webservicex“, pelo menos até a versão 1.7.0.2 do Magento CE. A frequência normalmente será “Diariamente“, pois os valores são sempre atualizados. O horário é uma decisão mais administrativa, você pode fazer isso todo dia à meia-noite, ou então após o fechamento do pregão.

	Os últimos 3 (três) campos referentes ao campo email, são para os casos em que a cotação automática falhar – assim você pode ser avisado por email.

:: Os arquivos de leiaute

	No template padrão do Magento, este campo de seleção de moedas é apresentado sempre na coluna da esquerda. Caso queira modificar isso, saiba que o arquivo responsável por ele é o directory.xml que fica em:

	app -> design -> frontend -> base -> default -> layout -> directory.xml

	E o arquivo currency.phtml é quem carrega as informações na tela:

	app -> design -> frontend -> base -> default -> template -> directory -> currency.phtml

	Lembre-se de nunca alterar o arquivo em base/default, faça sempre uma cópia dele para default/default, ou então para seu template/tema customizado.

	E basicamente é isso que você precisa saber sobre o controle de moedas no Magento. Qualquer dúvida basta acessar o fórum da Escola Magento.

Fonte: http://mariosam.com.br/magento/cotar-moedas/

**Ativando CRON**

crontab -e

	MAILTO=suporte@cerebrum.com.br
	*/5 * * * * touch /home/marcio/dados/www/log-cron-touch
	#*/5 * * * * /bin/sh /home/marcio/dados/www/magento-1.8.0.0-dev02/cron.sh
	*/5 * * * * curl -s -o /dev/null http://localhost/magento-1.8.0.0-dev02/cron.php
	#*/5 * * * * php /home/marcio/dados/www/magento-1.8.0.0-dev02/cron.php


Para mais detalhes sobre a configuração da cron do magento, acesse:

http://www.magentocommerce.com/wiki/1_-_installation_and_configuration/how_to_setup_a_cron_job

**Sobre a tradução pt_BR**

Eu recomendo utilizar a tradução disponibilizada por "Mario SAM"

http://mariosam.com.br/magento/traducao-magento/

---

Observação:

No pacote de tradução em /app/locale/pt_BR/sql/ é disponibilizado um script SQL que vai traduzir diversas palavras armazenadas no banco de dados que estão em inglês

Sugiro analisar o arquivo e aplicar somente o necessário

Não execute o INSERT dos estados brasileiros presente nesse arquivo SQL, pois o módulo da Cerebrum já adiciona o suporte a estados brasileiros ao Magento

---

Informo que tem alguns item no pacote de tradução do MarioSam que está equivocado

em 

/app/locale/pt_BR/Mage_Api2.csv:"Company","Profissão"
/app/locale/pt_BR/Mage_Customer.csv:"Company","Profissão"
/app/locale/pt_BR/Mage_Checkout.csv:"Company","Profissão"

Edite os arquivos e atualize "Profissão" para "Empresa"

**Como faço para adicionar ao link /contacts/ para redirecionar para outro domínio?**

Edite o arquivo /app/design/frontend/base/default/layout/contacts.xml

Atualizando para

        <reference name="footer_links">
            <action method="addLink" translate="label title" module="contacts" ifconfig="contacts/contacts/enabled">
				<label>Contact Us</label>
				<url>https://cerebrum.freshdesk.com/support/tickets/new</url> 
				<title>Contact Us</title>
				<prepare/>
				<urlParams/> 
				<position>100</position>
				<liParams/>
				<aParams>target="_blank" class="top-link-example"</aParams>
				<beforeText></beforeText>
				<afterText></afterText>
			</action>
        </reference>

**Listando eventos do Observer**

grep -ri 'Mage::dispatchEvent' /home/marcio/Dados/www/magento-1.8.1.0-dev05/app/* > events.txt

https://github.com/Marko-M/magento-events-list/tree/master/magento-outofthebox

**Como compactar a pasta do meu projeto ?**

O script a seguir é um modelo para a execução do procedimento de backup a ser executado via terminal do servidor

	tar -cvpzf EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).tgz /DIRETORIO

**Como efetuar backup do banco de dados ?**

O script a seguir é um modelo para a execução do procedimento de backup a ser executado via terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' > 'COMPANY-mysql-21-02-2013.sql'

O script a seguir é um modelo para a execução do procedimento de backup compactado a ser executado via terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' | gzip > EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).sql.gz

**Ativar debug do template no backend**

Edite o arquivo /app/code/core/Mage/Core/etc/system.xml

Atualizando para

	<template_hints translate="label">
		<label>Template Path Hints</label>
		<frontend_type>select</frontend_type>
		<source_model>adminhtml/system_config_source_yesno</source_model>
		<sort_order>20</sort_order>
		<show_in_default>1</show_in_default>
		<show_in_website>1</show_in_website>
		<show_in_store>1</show_in_store>
	</template_hints>
	<template_hints_blocks translate="label">
		<label>Add Block Names to Hints</label>
		<frontend_type>select</frontend_type>
		<source_model>adminhtml/system_config_source_yesno</source_model>
		<sort_order>21</sort_order>
		<show_in_default>1</show_in_default>
		<show_in_website>1</show_in_website>
		<show_in_store>1</show_in_store>
	</template_hints_blocks>

**Sobre como cadastrar o peso do produto**

Peso preenchido no formato "Default" em Kilos
	Para um peso de 80 gramas, para isso devemos informar 0.0800
	Para um peso de 800 gramas, para isso devemos informar 0.8000
	Para um peso de 1 kilo, para isso devemos informar 1 onde deve ser convertido pelo Magento para 1.0000

Peso preenchido no formato "Alternativo" em gramas
	Para um peso de 80 gramas, para isso devemos informar 80.0000
	Para um peso de 800 gramas, para isso devemos informar 800.0000
	Para um peso de 1 kilo, para isso devemos informar 1000 onde deve ser convertido pelo Magento para 1000.0000

**Exibir horário corrente no backend**

Edite o arquivo /app/design/adminhtml/default/default/template/page/header.phtml

Atualizando

DE

$this->formatDate(null, 'full')

PARA

$this->formatDate(null, 'full', true)

**Ativar debug**

No Backend do Magento, acesse o menu: System -> Configuration -> Developer -> Debug -> Template Path Hints = Yes  

Para ser exibido a opção "Template Path Hints" em Debug, deve ser selecionado a configuração para o website, selecionando o mesmo no SelectBox "Configuration Scope:"

**Recriar banco de dados e importar o "Magento Sample Data DataBase"**

	mysqladmin -u root -p DROP 'magento-1.7.0.2-dev02';
	mysqladmin -u root -p CREATE 'magento-1.7.0.2-dev02';
	mysql -h 'localhost' -u 'root' -p'SENHA' 'magento-1.7.0.2-dev02' < '/home/marcio/Dados/www/magento-sample-data-1.6.1.0/magento_sample_data_for_1.6.1.0.sql';

	UPDATE `admin_user` SET `password` = MD5('123456a') WHERE `username` = 'admin';

**Habilitar exibição do erro no Magento**

No magento edite o arquivo index.php e atualize a linha 

DE

	#ini_set('display_errors', 1);

PARA

	ini_set('display_errors', 1);

**Desabilitando a compilação do Magento pelo código**

Para desabilitar a compilação sem ter acesso pelo admin do magento basta ir em /includes editar o arquivo chamado config.php comentando a linha abaixo com # na frente  

Com o compilador ligado

	define('COMPILER_INCLUDE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'src');

Com o compilador desligado

	#define('COMPILER_INCLUDE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'src');

**Forçar Recompilação do Magento pelo código**

A pasta que fica localizada dentro da pasta /includes chamada de SRC é onde se encontra todos os arquivos compilados pelo Magento, para forçar pelo código uma nova compilação do Magento, basta renomear essa pasta ou removela. 
Obs: (Recomendo antes só renomear e se tudo der certo e uma nova pasta SRC for criada automaticamente, ai sim pode remover ela)

**Obs. no uso do Compiler do Magento**

No processo "Compilação" nunca apenas clique no botão "Ativar" pois pode ser ativado uma versão em Cache

Sempre antes clique no botão "Executar o processo de compilação", dessa forma em seguida deve ser ativado automaticamente o Compiler do Magento

**Como limpar o cache do Magento?**

Se você tiver feito alterações em sua loja Magento, e elas não aparecerão imediatamente, pode ser necessário que você limpe o cache.  
O Magento mantém seu cache em /var/cache localizado dentro do diretório de instalação do Magento.  
Assim, por exemplo, se o Magento é instalado na pasta principal public_html/, o cache será em public_html/var/cache  
Para limpar o cache, simplesmente apague tudo do diretório public_html/var/cache e recarregue seu site no seu browser.  
Para limpar todas as sessões, você também pode excluir tudo do diretório public_html/var/session.

**Como depurar problemas Magento MySQL**

Assim como qualquer aplicação PHP moderna o Magento armazena a maioria de suas informações no banco de dados (exceto mídia e configurações XML).

Assim, para a depuração de problemas no Magento é útil saber algumas coisas:

1. Todas as consultas do MySQL podem ser registrados e analisados. 
Para este efeito, abra o arquivo lib/Varien/Db/Adapter/Pdo/Mysql.php e altere o valor da propriedade protegida $ _debug para true, também a propriedade protegida $_logAllQuerie para true. 

Você também pode alterar o valor de US $ _logQueryTime que é especialmente útil quando a depuração lentidão. Uma vez que você fizer essa alteração todas as consultas serão registradas no arquivo var/debug/sql.txt

**Como adicionar o rastreamento(tracking)?**

No Backend do Magento, acesse o menu: Sales -> Order -> Acesse o pedido em seguida clique no botão "Ship", no bloco "Shipping Information" clque no botão "Add Tracking Number", selecione o método de entrega e informe o número para rastreamento, adicione um comentário caso ache necessário e clique em "Submit Shipment"

No Backend do Magento, na visualização do pedido no bloco "Shipping & Handling Information" deve ser exibido o link "Track Order" onde clicando no mesmo deve ser aberto Popup apresentado o processo do rastreamento

No frontend do Magento, acessando o menu: My Account -> My Orders -> View Order -> deve ser exibido o link "Track your order" onde clicando no mesmo deve ser aberto Popup apresentado o processo do rastreamento

**Como redefinir a senha do administrador em Magento?**

	UPDATE `admin_user` SET `password` = MD5('NEWPASSWORD') WHERE `username` = 'ADMINUSERNAME';

**Exibir cabeçalho "Esta é uma loja de demonstração. ..."**

No Backend do Magento, acesse o menu: System > Configuration > General > Design -> HTML Head -> Display demo store notice = YES

**Mais info**

http://www.comunidademagento.com.br/  
http://kb.siteground.com/category/shopping-carts-faq/magento-faq/
http://www.webshopapps.com/blog/2010/11/resolving-magento-extension-conflicts/

### Erros comuns

**No heartbeat task found. Check if cron is configured correctly.**

Acesse a cron da seguinte forma

http://localhost/magento-1.8.0.0-dev02/cron.php

No Backend do Magento, acesse o menu: System -> Scheduler -> List View -> Deve ser exibido os processos a ser executado

Obs. No magento 1.8 não está funcional a Cron, veja como corrigir

http://www.magentocommerce.com/boards/viewthread/609113/
	Edite o arquivo cron.php
	Adicione a seguinte linha abaixo de "$isShellDisabled = (stripos(PHP_OS, 'win') === false) ? $isShellDisabled : true;"
		$isShellDisabled = true; 

**SERVER ERROR: "error 500" | "tela branca"**

A informação "error 500" se trata da omissão do erro devendo ser analisado o erro no log do servidor.  

Todo o erro gerado no servidor é gerado o log apontando a causa do erro  
Execute o seguinte comando no terminal do seu servidor  

	tail -f /var/log/apache2/error.log

Acesse a loja até gerar o erro  
Será exibido no log a causa do erro  
Agora é somente aplicar a devida correção sobre o seu servidor

**PHP Fatal error: Allowed memory size of xx bytes exhausted**

A ocorrência desse erro deve ser resolvida efetuando o procedimento para aumento de memoria no servidor.  
Sugiro que entre em contato com sua empresa de hospedagem para que seja feito o aumento de memoria no servidor.

Para aumentar a memoria sobre o php, altere o valor do memory_limit no php.ini, também pode ser preciso efetuar configuração de memory_limit no arquivo .htaccess  
Pode ser necessário reiniciar o servidor

Em seguida acesse o phpinfo em seu servidor e visualize a alteração do memory_limit

## Observações

1. Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

2. Quando é gerado erros no Magento é gerado o arquivo que é armazenado em /var/report/, no arquivo é apontado o motivo da ocorrência

---

# CEREBRUM

No mercado brasileiro desde 2005 a CEREBRUM vem se especializando exclusivamente em comércio eletrônico com foco desde 2008 na renomada plataforma de comércio eletrônico Magento Ecommerce.

CEREBRUM Comércio e Desenvolvimento de Sistemas de Informática Ltda ME - CNPJ 07.361.259/0001-07

# Cerebrum_Telencephalon

## Sobre

O software se trata de módulo para Magento desenvolvido pela CEREBRUM, contendo diversos produtos.  
O módulo foi desenvolvido para funcionar sobre a plataforma "Magento Community Edition" a partir da versão 1.4.x até 1.8.x

A CEREBRUM comercializa somente o direito de uso do(s) produto contido no(s) módulo(s).  
O arquivo de licença comercial libera o funcionamento do(s) produto(s) adquirido adicionando restrição ao DNS informado.  
Os Módulos para Magento desenvolvidos pela CEREBRUM é propriedade particular da CEREBRUM.

A CEREBRUM oferece módulo para teste, permitindo o cliente efetuar os devidos testes antes de pagar pelo produto.  

O módulo no modo "teste" é caracterizado quando não há o arquivo de licença.  
O módulo no modo "comercial" é caracterizado quando há o arquivo de licença.

O módulo no modo "teste" contempla as seguintes restrições:

- É exibido "alerta de módulo gratuito"  
- Após a expiração do modo "comercial" é exibido também anúncios do serviço "Google AdSense"

O módulo no modo "comercial" contempla as seguintes restrições:

Para o plano "Completo"
	- Restrição de um prazo em dias para utilização em formato comercial, ao expirar o prazo o módulo deve operar em modo "teste"
	- Restrição de DNS  

Para o plano "Individual"
	- Restrição de um prazo em dias para download de módulo atualizado
	- Restrição de DNS  
	- Restrição de Produtos ou Recursos presente no módulo  

A CEREBRUM não oferece garantia que:  
- o serviço será isento de falhas  
- o uso que você fizer do serviço será ininterrupto ou isento de falha  
- o serviço atenderá suas exigências ou expectativas  

A CEREBRUM não se responsabiliza por erros tipográficos ou de precificação na aplicação.  
Erros será corrigidos na medida que forem descobertos, e a CEREBRUM se reserva o direto de revogar qualquer oferta anunciada para corrigir quaisquer erros, imprecisões ou omissões

A CEREBRUM se reserva o direito de rastrear e reportar as atividades da aplicação, mesmo que anonimamente.

Aviso: Este programa de computador está protegido pela lei de direitos autorais e tratados internacionais. Reprodução ou distribuição não autorizada deste programa, ou qualquer parte dele, pode resultar em severas penalidades civis e criminais, e serão processados ​​sob a medida máxima possível sob a lei.

Os Módulos para Magento desenvolvidos pela CEREBRUM é criptografado usando o "Zend Guard Encoder".  
O "Zend Guard Encoder" encripta do código-fonte da linguagem php e seus derivados, impossibilitando a manipulação do código-fonte.  
Para funcionamento do módulo em seu servidor de hospedagem é necessário a instalação do componente "Zend Guard Loader".  
Consulte o seu fornecedor de hospedagem para instalação do componente "Zend Guard Loader" - http://www.zend.com/en/products/guard/runtime-decoders

Devido o módulo da CEREBRUM ser encriptado com o "Zend Guard Encoder", pode haver a ocorrência do erro "PHP Fatal error: Allowed memory size of" na ocorrência do mesmo deve ser feito aumento da memoria no seu servidor.  
Sugiro deixar não menos que 256MB, utilizar preferencialmente 512MB, conforme especificações para a plataforma Magento
http://www.magentocommerce.com/system-requirements

## Modelo comercial do módulo Cerebrum_Telencephalon

	http://www.cerebrum.com.br/website/assinatura

## Ambiente de demonstração da plataforma Magento e o módulo Cerebrum_Telencephalon

Para acesso ao backend

	http://www.cerebrum.com.br/demo_magento/index.php/admin/
	demo / 123456a

Para acesso ao frontend

	http://www.cerebrum.com.br/demo_magento/index.php/

## Recursos presente no módulo Cerebrum_Telencephalon

Abaixo segue lista das mais de 62 funcionalidades presente no módulo Cerebrum_Telencephalon, até o momento.

	Geral (20)

		Recursos (11)
			Ativar Logs Database
			E-bit
			Ativar miniaturas de produto no item agrupados
			Ativar efeito no Accordion em /checkout/onepage/
			Ativar Parcela do Produto na Vitrine
			Ativar Cálculo de Frete na Página do Produto
			Template usado no dispositivo móvel
			Informe o identificador na Central de Negócios BuscaPé "para uso do XML Sitemap"
			Ativar Suporte aos campos para "entrada de fala"
			Ativar STYLE: IWD_OnepageCheckout

		Bibliotecas de terceiros "CSS/JS" (6)
			Ativar jQuery
			Ativar Magic CSS
			Ativar Semantic-UI
			Ativar FavicoJs
			Ativar NProgress

		Endereçador Correios

		Cron
			Rastreamento automático para os "Correios"
			Consulta ao itaushopline para situação do pagamento

	Clientes (4)

		Ativar Icone Gravatar
		Ativar Suporte aos Formulários
		Ativar campos de endereço em /customer/account/create/
		Gerenciar Atributos de Clientes

	Métodos de entrega (6)

		Correios
		Correios Exporta Fácil
		Jadlog
		Jamef
		Braspress
		SisFrete

	Métodos de pagamentos (22)

		Integração junto a administradora de cartão de crédito (3)
			Redecard
			American Express
			Cielo
			e-Rede "Desenvolvimento"

		Integração junto a instituição financeira bancária (5)
			Itaú Shopline
			Banco do Brasil
			Bradesco
			Banrisul Banricompras
			Banrisul Boleto

		Integração junto a intermediador de pagamentos (3)
			Pagseguro
			Bcash
			Moip "Em homologação processo Moip Assinaturas"

		Integração junto a gateway de pagamentos (3)
			MeuCheckout BRASPAG®
			Pagador BRASPAG®
			MercadoPago

		Somente geração de boleto bancário (8)
			Boleto Bancário - Banco do Brasil
			Boleto Bancário - Banco Bradesco
			Boleto Bancário - Banco Itaú
			Boleto Bancário - Banco Santander-Banespa - (Carteira 102 - Sem registro)
			Boleto Bancário - Boleto Bancário - Banco Santander-Banespa - (Carteira COB - Sem registro)
			Boleto Bancário - Caixa Econômica Federal - SR (SICOB)
			Boleto Bancário - Banco HSBC
			Boleto Bancário - Bancoob

	Métodos de checagem de fraude (3)
		FControl
		Clearsale Start
		T-ClearSale, TG-ClearSale, A-ClearSale

	Métodos para geração de XML Sitemap "usado nos mecanismos de pesquisa e comparadores de preços" (3)
		Comparadores de preço "Buscapé"
		Comparadores de preço "QueBarato!"
		Comparadores de preço "Zoom"

	Ferramentas (3)
		Download & Extrai para você
		checkList
		Indicadores gráficos

	Logs (2)
		Magento
		Telencephalon

## Download do módulo Cerebrum_Telencephalon

http://www.cerebrum.com.br/website/instalacao-downloads-modulos-magento/

## Instalação / Atualização via FTP

1. 
Recomendo efetuar o processo em um projeto para de testes, após a comprovação da eficacia do módulo então instalar sobre o projeto em produção

2. 
Para segurança do seu projeto, recomendo efetuar o backup dos arquivos e banco de dados
O script a seguir é um modelo para a execução do procedimento de backup a ser executado via terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' | gzip > EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).sql.gz

	tar -cvpzf EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).tgz /SEU_DIRETORIO

3. 
Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado  
	No Backend do Magento, acesse o menu: System -> Tools -> Compilation -> Mantenha o recurso desativado  
	No Backend do Magento, acesse o menu: System -> Cache Management -> Desative todos os Cache  

Desative a compresão de CSS e JS   
	No Backend do Magento, acesse o menu: System -> Configuration -> Developer -> JavaScript/CSS Settings  -> Merge Files -> Não

4. 
O processo de "Instalação / Atualização" consiste em mesclar as pastas do módulo ao Magento

5. 
Caso venha a efetuar o Upload dos arquivos via FTP
	Antes de efetuar o Upload dos arquivos
		Configure no seu cliente de FTP o tipo de transferências padrão para binário.
			Dica: No FileZilla acesse o menu: Editar -> Configuraçoes -> Transferências -> Tipos de arquivo
	Em seguida efetue Upload dos arquivos

6. 
Observação:
Após o processo de instalação do módulo, no Backend do Magento, acesse o menu: Telencephalon -> Ferramentas -> "Deve ser exibido a dependência de diversas bibliotecas, clique no botão Atualizar para obter as bibliotecas de terceiros"

7. 
Caso o seu template não esteja sobre a estrutura "/base/" nativa do Magento, deve ser aplicado o suporte do módulo ao template

Pode ser necessário colocar suporte ao seu template.  
Para isso copie o conteúdo do módulo /Cerebrum_Telencephalon/app/design/frontend/base/default  
Mescle os diretórios layout e templates a pasta do seu template em /MAGENTO/app/design/frontend/BASE_TEMPLATE/

Pode ser necessário colocar suporte ao skin do seu template.  
Para isso copie o conteúdo do /NOSSO-MODULO/skin/frontend/base/default/  
Mescle os diretórios em /MAGENTO/skin/frontend/BASE_TEMPLATE/

8. 
"O trecho a seguir é para clientes antigos que já tenha em seu projeto os módulos antgos da Cerebrum"

Caso tenha os módulos antigos da Cerebrum em seu projeto

Recomendo desativar todos os módulos antigos, renomeando as pastas abaixo de /app/code/local/Cerebrum

Obs. 
Como no Magento é feito a relação do método de pagamento ao pedido, caso a pasta do módulo Cerebrum_Payments seja renomeada os pedidos feitos com esse método não deve funcionar, por isso para funcionar a visualização dos pedidos feito com os métodos de pagamentos antigos da Cerebrum, mantenha a pasta Payments, não renomeie a mesma abaixo de /app/code/local/Cerebrum

## Desativação de módulo(s)

1. Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

2. Caso queira desativar os módulos da CEREBRUM renomeie a seguinte pasta /app/code/local/Cerebrum

## Desinstalação de módulos

https://github.com/magento-hackathon/MageTrashApp

## Perguntas mais frequentes "FAQ"

**Como instalar o "Zend Guard Loader" em meu servidor?**

Ao efetuar o download e extração do "Zend Guard Loader", leia o arquivo o "README.txt", nele está contido a instrução para ativar o módulo para qualquer servidor

	http://www.zend.com/en/products/guard/runtime-decoders

Devido o "Zend Guard Loader" se tratar de ferramenta de terceiros, dúvidas ou problemas sugiro entrar em contato direto com a Zend, abrindo uma interação no forum do "Zend Guard"

	http://forums.zend.com/viewforum.php?f=57&sid=8556b95ded7978a11c27ca31de8592d4

Obs. 
	Na ocorrência de problemas de servidor, sugiro analisar o log do servidor onde deve ser apontado o motivo da ocorrência

Para usuários do "Zend Server" o módulo "Zend Guard Loader" já vem instalado no servidor, necessitando somente de ativar o mesmo.

	http://www.zend.com/en/products/server/

**O módulo para servidor "Zend Guard Loader" está ativo em meu servidor?**
**Qual a versão do "Zend Guard Loader" em meu Servidor?**

Usando qualquer editor de texto, crie um arquivo nomeado como "phpinfo.php" e adicione o seguinte script

	<?php phpinfo(); ?>

Salve o arquivo e efetue o upload para a pasta base no seu servidor

Acesse o arquivo via browser

Nesse ambiente deve ser exibido a versão do "Zend Guard Loader", caso o mesmo esteja instalado e ativo

**Onde deve ser colocado o arquivo de licença comercial "Cerebrum_Telencephalon_License.txt" ?**

O arquivo "Cerebrum_Telencephalon_License.txt" deve ficar no seguinte diretório do Magento

/app/code/local/Cerebrum/Telencephalon/docs/

**Como enviar uma massa de pedidos para serem analisados pelos sistemas de checagem de fraude ativo ?**

No Backend do Magento, acesse o menu: Vendas -> Pedidos -> Na grade de pedidos selecione a quantidade de pedidos

No elemento de "Ações", selecione a opção "Checar Fraude (powered by CEREBRUM)" e clique no botão enviar

Dessa forma desse ser enviado os pedidos em massa para serem analisados pelos sistemas de checagem de fraude ativo

**Método de entrega não está sendo exibido ou Processo rastreamento(tracking) retornando erro**

No Backend do Magento, acesse o menu: System -> Configuration -> Developer -> Log Settings -> Enabled = Yes  
No Magento os arquivos de log é armazenado em /var/log/  
Caso já exista o arquivo "cerebrum_jadlog.log", renomeie o mesmo para no próximo processo executado ser criado um novo arquivo 
Efetue processo novamente  
Verifique no arquivo de log os parâmetros enviados a transportadora
Tendo alguma dificuldade para interpretar o arquivo, envie o mesmo via e-mail para: suporte@cerebrum.com.br

**Como efetuo teste de validade de boleto**

Acessando os seguintes serviços é possível informar a "Linha Digitável" do boleto e ao pressionar "Calcular Barra" é feito o retorno da validade do boleto, quando é retornado erro é exibido alerta

http://evandro.net/codigo_barras.html
http://boletobancario-codigodebarras.blogspot.com.br/

**Modificando a tradução do módulo para o template**

Os arquivos de tradução do Magento é armazenado no diretório  
	/app/locale/pt_BR/

O módulo da CEREBRUM tem o seu arquivo de tradução com a mesma nomenclatura do módulo, o mesmo está presente no seguinte diretório  
	/app/locale/pt_BR/Cerebrum_Telencephalon.csv

Na necessidade de trocar a mensagem "Test" que é exibida no processo de pagamento pelo módulo Cerebrum_Telencephalon

Edite o arquivo translate.csv presente no diretório do seu template para ser exibido um novo resultado

	/app/design/frontend/default/default/locale/pt_BR/translate.csv

**Como não exibir as mensagem de erro retornada pelos métodos de entrega**

Deve ser exibido o retorno do erro para tanto o cliente como o administrador da loja visualizar o motivo da ocorrência do serviço

Mas caso deseje omitir a mensagem em seu projeto, aplique o seguinte script sobre o CSS do seu template

.sp-methods .messages { display: none; }

**Sobre a customização/personalização do módulo Cerebrum_Telencephalon**

Para a customização do módulo pode ser feito o uso do CSS e/ou Javascript

Sugiro utilizar o "Plugin do Firefox - Firebug" para obter os identificadores dos objetos da tela, dessa forma é possível aplicar o suporte de CSS ao devido objeto

Sugiro que entre em contato com o seu desenvolvedor para o mesmo efetuar analise e aplicar o devido suporte

O suporte do CSS deve ser aplicado ao template do projeto

Exemplo: Para modificar as cores dos elementos de herança da biblioteca semantic-ui
Aplique o seguinte CSS ao seu template:

	.ui.segment { border-top: 0.2em solid red  !important; }
	.ui.button { background-color: red !important; color: #FFFFFF !important; }
	.ui.ribbon.label { background-color: red !important; }
	.ui.label:before { background-color: red !important; }

Exemplo: Para não exibir determinado método do BradescoSPS
Aplique o seguinte CSS ao seu template:

	.td-bradesco-boleto-retorno {display:none;}
	.td-bradesco-pagto-eletronico {display:none;}

Exemplo: Para não exibir o bloco "mais informações" sobre o método de pagamento
Aplique o seguinte CSS ao seu template:

	#node-image-payment-form-cerebrum_cielo {display:none;}

## Alguma dúvida técnica ? Acesse nosso fórum !

[https://cerebrum.freshdesk.com/support/tickets/new] [ticket]:

---

# Geral (11)

---

# Ativar Logs Database

## Sobre

Armazena em banco de dados os processos executados pelo módulo Cerebrum_Telencephalon.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# e-bit

## Sobre

Exibe o recurso na visualização do pedido no frontend e no e-mail de finalização do pedido.

O selo da e-bit permite que seus clientes avaliem sua loja.

Para obter o selo siga os seguintes passos:

1. Realize seu cadastro no E-bit http://www.ebit.com.br/ e receba seu código E-bit.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Preencha o campo solicitado

---

# Ativar miniaturas de produto no item agrupados

## Sobre

Ativa imagens miniaturas de produto no item agrupados

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Ativar efeito no Accordion

## Sobre

No /checkout/ do Magento os processos é exibido sobre o objeto Accordion ative a possibilidade de efeito 

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Ativar parcela do produto na vitrine e página do produto

## Sobre

Na edição do produto ao preencher o atributo "parcelas" deve ser exibido no frontend a exibição das parcelas

Caso a parcela do produto não esteja sendo exibido na vitrine no frontend

No Backend do Magento, acesse o menu: Catalog -> Attributes -> Manage Attributes -> acesse o atributo "parcelas" -> atualize o registro para "Used in Product Listing = Yes", salve o registro em seguida atualize os índices

Obs.
	Tanto na vitrine como na página do produto deve ser exibido a tabela das parcelas com base no atributo "parcelas" do produto.
	A tabela de exibição das parcelas não tem relação com os métodos de pagamentos.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Ativar Cálculo de Frete na Página do Produto

## Sobre

É exibido na página de visualização do produto o formulário para calculo do frete do produto, onde é retornado os serviços de entrega com seus respectivos valores.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

## Perguntas mais frequentes "FAQ"

**Como usar o recurso em layout diferente**

1.

Para esconder o bloco de calculo de frete do módulo da Cerebrum

Aplique no CSS do seu template o seguinte

	.product-view .product-shop .segment { display: none; }

2.

Com o seu layout montado o exemplo a seguir pode ser usado como referencia

	<div>

	 <label for="cep_ajax">Frete:</label>
	 <input type="text" class="input-text" id="cep_ajax">

	 <button onclick="shippingProductView('cep_ajax','retorno-fretes');" class="button " title="Ok" type="button"><span><span>Ok</span></span></button>

	 <div id="retorno-fretes"></div>

	</div>


---

# Template usado no dispositivo móvel

## Sobre

Ao selecionar o template deve ser exibido o mesmo no acesso por dispositivo móvel

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Identificador na Central de Negócios BuscaPé "para uso do XML Sitemap"

## Sobre

Informe o identificador na Central de Negócios BuscaPé "para uso do XML Sitemap"

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> preencha o campo solicitado

---

# Ativar Suporte aos campos para "entrada de fala"

## Sobre

Deve ser aplicado aos campos INPUT e TEXTAREA o suporte a "entrada de fala" caso o browser tenha o suporte

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Ativar STYLE: IWD_OnepageCheckout

## Sobre

Com o método ativo, no checkout deve ser exibido nos blocos dos métodos o estilo definido tendo herança a seguinte biblioteca, http://semantic-ui.com/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Ative o campo solicitado

---

# Ativar jQuery

## Sobre

Deve ser carregado a seguinte biblioteca - http://jquery.com/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Bibliotecas de terceiros "CSS/JS" -> Ative o campo solicitado

## Perguntas mais frequentes "FAQ"

**Como retirar o carregamento do javascript em determinada página do CMS**

No CMS do Magento informe o seguinte XML para alteração do layout

<reference name="head">
	<action method="removeItem">
		<type>skin_js</type>
		<name>lib/jquery/jquery-1.11.0.min.js</name>
	</action>
</reference>

---

# Ativar Magic CSS

## Sobre

Deve ser carregado a seguinte biblioteca - http://www.minimamente.com/magic-css3-animations/

Essa biblioteca é usada para aplicar efeito no avatar exibido quando o usuário está logado

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Bibliotecas de terceiros "CSS/JS" -> Ative o campo solicitado

---

# Ativar Semantic-UI

## Sobre

Deve ser carregado a seguinte biblioteca - http://semantic-ui.com/

Essa biblioteca depende do framework jQuery

Essa biblioteca é usada para aplicar suporte ao template em algumas partes do projeto, no bloco de calculo de frete na pagina do produto é utilizado o suporte a esa biblioteca para aplicar o suporte ao bloco deixando o mais bonito e amigável, também é usado no checkout nos blocos de passos deixando o mais bonito e amigável, também é usado na finalização do pedido onde é exibido o método de pagamento

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Bibliotecas de terceiros "CSS/JS" -> Ative o campo solicitado

---

# Ativar FavicoJs

## Sobre

Deve ser carregado a seguinte biblioteca - http://lab.ejci.net/favico.js/

Essa biblioteca é usada nos processos em AJAX indicando no ícone do titulo da pagina o tempo de carregamento do processo

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Bibliotecas de terceiros "CSS/JS" -> Ative o campo solicitado

---

# Ativar NProgress

## Sobre

Deve ser carregado a seguinte biblioteca - http://ricostacruz.com/nprogress/

Essa biblioteca depende do framework jQuery

Essa biblioteca é usada como indicador do carregamento total da pagina, também é usado nos processos em AJAX indicando o carregamento do processo

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Bibliotecas de terceiros "CSS/JS" -> Ative o campo solicitado

---

# Endereçador Correios

## Sobre

Serviço de geração e impressão de rótulos e etiquetas, para endereçamento de encomendas e de cartas, com impressão do CEP em código de barras e possibilidade de validação de CEP pelo e-DNE - Diretório Nacional de Endereços. Possui versões on-line para Encomendas e para Cartas e uma versão instalável (Escritório), que gera rótulos tanto para Encomendas quanto para Cartas.

Saiba mais, acessando:

http://www.correios.com.br/enderecador/

Clique no link "Versão para Encomendas" para ver a base do recurso.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Geral -> Preencha os campos solicitados

---

# Cron (2)

---

# Rastreamento automático para os "Correios"

## Sobre

O processo utiliza o recurso "Cron/Agendamento" e está configurado para ser executado a cada 30 minutos

O processo deve ser executado para pedido com status "completo" e método de entrega "cerebrum_correios_4"

O processo envia notificações via e-mail ao cliente e administrador sobre a mudança de status da encomendas ou pacotes dos sites dos Correios

O retorno do Correios para cada pedido é armazenado no seguinte arquivo:
	/var/tmp/order_tracking.json

Nas seguintes requisições da CRON, caso haja modificação no registro do Correios com o registro local, deve ser disparado a notificação via e-mail

Também quando armazenado no pedido, no atributo "Fax", o número do celular é feito o envio desse registro ao novo serviço dos correios que envia as informações de rastreamento via SMS

## Perguntas mais frequentes "FAQ"

### Erros comuns

**e-mails de rastreamento sem suporte a tradução**

Deve ser exibido no e-mail algumas informações em ingles pois o arquivo nativo do Magento não está com o suporte a tradução
	/app/design/frontend/base/default/template/sales/order/trackinginfo.phtml

Obs. 
Sugiro aplicar o suporte ao seu template ao inves de editar o arquivo nativo do Magento  
Edite o arquivo do seu template e efetue a tradução
	/app/design/frontend/defautl/SEU-TEMPLATE/template/sales/order/trackinginfo.phtml

# Consulta ao itaushopline para situação do pagamento

## Sobre

O processo utiliza o recurso "Cron/Agendamento" e está configurado para ser executado a cada 30 minutos

O processo deve ser executado para pedido com status "pendente" e método de entrega "cerebrum_itaushopline"

O processo envia notificações via e-mail ao cliente e administrador sobre a mudança de status do pedido

Caso o status do pedido no Itaú esteja como pago, pode ser gerado a Fatura para o pedido, onde o status do pedido deve ser atualizado para "Processando"

O retorno do Itaú para cada pedido é armazenado no seguinte arquivo:
	/var/tmp/consulta_itau.json

Nas seguintes requisições da CRON, caso haja modificação no registro do Itaú com o registro local, deve ser disparado a notificação via e-mail

---

# Clientes (4)

---

# Ativar Icone Gravatar

## Sobre

Com o usuário logado no Magento, é feito acesso ao serviço gravatar, onde caso exista a imagem do usuário é exibida a mesma no frontend e/ou backend do Magento

https://pt.gravatar.com/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Clientes -> Preencha o campo solicitado

---

# Ativar Suporte aos Formulários

## Sobre

Recurso aplicado aos formulário adaptado para as necessidades do brasil com os seguintes procedimentos:

Os procedimentos de validação, reordenação e mascaramento dos campos é aplicados nos seguintes ambientes:  
customer_account_create, customer_account_edit, customer_address_form, checkout_onepage_index|onepagecheckout_index_index|opc_index_index, contacts_index_index

* Reordernação dos campos gender, dob, taxvat, postcode, country_id  
* Validador para o campo cep, máscara para preenchimento, preenchimento de endereço  
* Validador para o campo endereço, forçando o preenchimento no formato: Rua Nome da Rua, 123  
* Validador para o campo taxvat, forçando o preenchimento de CPF ou CNPJ  
* Validador para os campos: taxvat,cpf,cnpj , efetuando a checagem de documentos duplicados  
* Inclusão do Label Bairro e Validador para o campo street2  
* Inclusão do Label Complemento  
* Máscara para preenchimento do campo telefone
* Máscara para preenchimento do campo fax com suporte a 8 e 9 dígitos

## Perguntas mais frequentes "FAQ"

**Como funciona a consulta aos webservices de cep para preenchimento do endereço?**

É feito consulta aos WebService de CEP gratuito!

"Republica Virtual" onde caso não seja obtido o retorno dos dados é feito consulta ao "Correios" para nova tentativa

http://republicavirtual.com.br/
http://www.buscacep.correios.com.br/


## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Clientes -> Ative o campo solicitado

---

# Ativar campos de endereço em /customer/account/create/

## Sobre

Exibe os campos de endereço em /customer/account/create/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Clientes -> Preencha o campo solicitado

---

# Gerenciar Atributos de Clientes

## Sobre

Essa ferramenta gerencia os atributos de clientes, podendo aplicar ao formulário de cadastro de clientes o suporte a criação de ilimitados campos de diversos tipos.

## Perguntas mais frequentes "FAQ"

**Oque ocorre ao clicar no link "Gerar novos atributos"**

É aplicado o suporte dos atributos abaixo:

- Suporte a Pessoa Fisica e Juridica e condição para exibição dos campos:
    - R.G. - rg - text
    - C.N.P.J. - cnpj- text
    - C.P.F. - cpf- text
    - Escolaridade - escolaridade- text
    - Estado Civil - estado_civil - dropdown
        - Casado(a)
        - Divorciado(a)
        - Separado(a)
        - Solteiro(a)
        - Viúvo(a)
    - Inscrição Estadual - inscricao_estadual- text
    - Como chegou a nossa loja virtual ? - origem- dropdown
        - Google
        - Yahoo
        - Bing
        - Buscapê
        - Mercado Livre
        - Outros
    - Pessoa Física | Pessoa jurídica - pf_pj
    - Profissão - profissao- text

Após a geração dos novos atributos será necessário aplicar o suporte aos formulário de cadastro

Obs. Nunca modifique os novos atributos criado

Eexecute a implementação dos arquivos necessários nas pastas correspondentes, conforme instruções descritas no link a seguir ...

https://cerebrum.freshdesk.com/support/solutions/articles/183708-suporte-para-cadastramento-entre-pessoa-f-sica-e-jur-dica-com-campos-adicionais

**Como adicionar novos atributos ao formulário de cadastro em /customer/account/create/**

Ativando o debug do Magento vemos o arquivo que é carregado para cada formulario

Edite o arquivo correspondente ou então aplique o suporte sobre o seu template

Exemplo:

/app/design/frontend/base/default/template/persistent/customer/form/register.phtml

Modificando a linha onde contem os objetos "dob","taxvat","gender" de li para <div class="field">

E adicione o seguinte script que exibe os novos atributos criados pelo módulo Cerebrum_Telencephalon

Esse script deve ser colocado abaixo do li do password

	<!-- Cerebrum_Telencephalon -->

	<?php 
	echo Mage::app()->getLayout()->createBlock('telencephalon/customer_fields')->toHtml();
	?>

	<script type="text/javascript">
	//<![CDATA[

	//

	if( $('pf_pj') ){
		$('pf_pj').addClassName("validate-select");

		var label = smo_input_get_label($('pf_pj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__(" Pessoa Física | Pessoa Jurídica") ?>';
		}

		var element_pessoa = document.getElementById('pf_pj');
		var element_pessoa_parent = element_pessoa.parentNode;

		newElement = element_pessoa_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.appendChild(newElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode.parentNode;

		targetElement.insertBefore(newLI, targetElement.childNodes[0]);
	}

	//

	if( $('escolaridade') || $('origem')  ){
		var element_escolaridade = document.getElementById('escolaridade');
		var element_escolaridade_parent = element_escolaridade.parentNode;

		var element_origem = document.getElementById('origem');
		var element_origem_parent = element_origem.parentNode;

		escolaridadeElement = element_escolaridade_parent;
		origemElement = element_origem_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'escolaridade-origem';
		newLI.appendChild(escolaridadeElement);
		newLI.appendChild(origemElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('estado_civil') || $('profissao')  ){
		var element_estadocivil = document.getElementById('estado_civil');
		var element_estadocivil_parent = element_estadocivil.parentNode;

		var element_profissao = document.getElementById('profissao');
		var element_profissao_parent = element_profissao.parentNode;

		estadocivilElement = element_estadocivil_parent;
		profissaoElement = element_profissao_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'profissao-estadocivil';
		newLI.appendChild(estadocivilElement);
		newLI.appendChild(profissaoElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('cnpj') || $('inscricao_estadual')  ){
		var element_cnpj = document.getElementById('cnpj');
		var element_cnpj_parent = element_cnpj.parentNode;

		var element_ie = document.getElementById('inscricao_estadual');
		var element_ie_parent = element_ie.parentNode;

		cnpjElement = element_cnpj_parent;
		ieElement = element_ie_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'cnpj-ie';
		newLI.appendChild(cnpjElement);
		newLI.appendChild(ieElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('cpf') || $('cnpj')  ){
		var element_cpf = document.getElementById('cpf');
		var element_cpf_parent = element_cpf.parentNode;

		var element_rg = document.getElementById('rg');
		var element_rg_parent = element_rg.parentNode;

		cpfElement = element_cpf_parent;
		rgElement = element_rg_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'cpf-rg';
		newLI.appendChild(cpfElement);
		newLI.appendChild(rgElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('zip') ){
		var count = 0
		var elem = document.getElementById('form-validate').elements;
		for(var i = 0; i < elem.length; i++)
		{
			//console.log(elem[i].type + ', ' + elem[i].name + ', ' + elem[i].value);

			if(elem[i].name == 'company'){
				//console.log(count);
				count++;
				if (count > 1){
					var element_company_parent = elem[i].parentNode;
					element_company_parent.remove();
				}
			}

		}
	}else{
		if( $('company') ){
			var element_company = document.getElementById('company');
			var element_company_parent = element_company.parentNode;

			element_company_parent.hide();
		}
	}

	//

	if( $('nickname') ){
		var element_nickname = document.getElementById('nickname');
		var element_nickname_parent = element_nickname.parentNode;

		element_nickname_parent.hide();
	}

	//

	if( $('shortprofile') ){
		var element_shortprofile = document.getElementById('shortprofile');
		var element_shortprofile_parent = element_shortprofile.parentNode;

		element_shortprofile_parent.hide();
	}

	//

	function init() {
		$('cpf-rg').addClassName("no-display");
		$('cnpj-ie').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		if ($('pf_pj').getValue() == ''){
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(null);
		}else{
			pj_Event(null);
		}
	}

	init();

	//

	function pf_pj_Event(event) {
		var element = event.element();
		//alert(element.value);
		if (element.value == ''){
			init();
			if($('el-insert-pj')){$('el-insert-pj').remove();}
			if($('el-insert-pf')){$('el-insert-pf').remove();}
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(event);
		}else{
			pj_Event(event);
		}
	}

	$('pf_pj').observe('change', pf_pj_Event);

	//

	function pf_Event(event) {
		$('cnpj-ie').addClassName("no-display");

		$('cpf-rg').removeClassName("no-display");
		$('profissao-estadocivil').removeClassName("no-display");
		$('escolaridade-origem').removeClassName("no-display");


		$('cnpj').removeClassName("required-entry");
		$('cpf').addClassName("required-entry");
		if($('rg')){
		$('rg').addClassName("required-entry");
		}

		//Clean field
		$('cnpj').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('firstname'));
		if(label){//see if there is a label
			label.innerHTML='<em>*</em> <?php echo $this->__("Name") ?>';
		}
		var label = smo_input_get_label($('lastname'));
		if(label){//see if there is a label
			label.innerHTML='<em>*</em> <?php echo $this->__("Last Name") ?>';
		}
	}

	//

	function pj_Event(event) {
		$('cpf-rg').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		$('cnpj-ie').removeClassName("no-display");

		$('cpf').removeClassName("required-entry");
		if($('rg')){
		$('rg').removeClassName("required-entry");
		}

		$('cnpj').addClassName("required-entry");

		//Clean field
		$('cpf').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('firstname'));
		if(label){//see if there is a label
		label.innerHTML='<em>*</em> <?php echo $this->__("Officer Name") ?>';
		}
		var label = smo_input_get_label($('lastname'));
		if(label){//see if there is a label
		label.innerHTML='<em>*</em> <?php echo $this->__("Last name of the person responsible") ?>';
		}
	}

	//

	if($('cnpj')){
		var label = smo_input_get_label($('cnpj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("C.N.P.J.") ?>';
		}

		//
		function cnpj_Event(event) {
			var element = event.element();
			$('cnpj').maxLength = 18;
			$('cnpj').removeClassName("validate-cnpj");
			$('cnpj').addClassName("validate-cnpj");
		}

		$('cnpj').observe('focus', cnpj_Event);
		Event.observe('cnpj', 'keypress', function(event){ txtBoxFormat(this, '99.999.999/0001-13', event) });
	}

	//


	if($('cpf')){
		var label = smo_input_get_label($('cpf'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("C.P.F.") ?>';
		}

		//
		function cpf_Event(event) {
			var element = event.element();
			$('cpf').maxLength = 14;
			$('cpf').removeClassName("validate-cpf");
			$('cpf').addClassName("validate-cpf");
		}

		$('cpf').observe('focus', cpf_Event);
		Event.observe('cpf', 'keypress', function(event){ txtBoxFormat(this, '999.999.999-99', event) });
	}

	//

	if($('rg')){
		var label = smo_input_get_label($('rg'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("R.G.") ?>';
		}
	}

	//


	//]]>
	</script>

	<!-- / Cerebrum_Telencephalon -->

**Como adicionar novos atributos ao formulário de cadastro em /customer/account/edit/**

Ativando o debug do Magento vemos o arquivo que é carregado para cada formulario

Edite o arquivo correspondente ou então aplique o suporte sobre o seu template

Exemplo:

/app/design/frontend/base/default/template/customer/form/edit.phtml

Modificando a linha onde contem os objetos "dob","taxvat","gender" de li para <div class="field">

E adicione o seguinte script que exibe os novos atributos criados pelo módulo Cerebrum_Telencephalon

Esse script deve ser colocado abaixo do li do password

	<!-- Cerebrum_Telencephalon -->

	<?php 
	echo Mage::app()->getLayout()->createBlock('telencephalon/customer_fields')->toHtml();
	?>

	<script type="text/javascript">
	//<![CDATA[

	//

	if( $('pf_pj') ){
		$('pf_pj').addClassName("validate-select");

		var label = smo_input_get_label($('pf_pj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__(" Pessoa Física | Pessoa Jurídica") ?>';
		}

		var element_pessoa = document.getElementById('pf_pj');
		var element_pessoa_parent = element_pessoa.parentNode;

		newElement = element_pessoa_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.appendChild(newElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode.parentNode;

		targetElement.insertBefore(newLI, targetElement.childNodes[0]);
	}

	//

	if( $('escolaridade') || $('origem')  ){
		var element_escolaridade = document.getElementById('escolaridade');
		var element_escolaridade_parent = element_escolaridade.parentNode;

		var element_origem = document.getElementById('origem');
		var element_origem_parent = element_origem.parentNode;

		escolaridadeElement = element_escolaridade_parent;
		origemElement = element_origem_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'escolaridade-origem';
		newLI.appendChild(escolaridadeElement);
		newLI.appendChild(origemElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('estado_civil') || $('profissao')  ){
		var element_estadocivil = document.getElementById('estado_civil');
		var element_estadocivil_parent = element_estadocivil.parentNode;

		var element_profissao = document.getElementById('profissao');
		var element_profissao_parent = element_profissao.parentNode;

		estadocivilElement = element_estadocivil_parent;
		profissaoElement = element_profissao_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'profissao-estadocivil';
		newLI.appendChild(estadocivilElement);
		newLI.appendChild(profissaoElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('cnpj') || $('inscricao_estadual')  ){
		var element_cnpj = document.getElementById('cnpj');
		var element_cnpj_parent = element_cnpj.parentNode;

		var element_ie = document.getElementById('inscricao_estadual');
		var element_ie_parent = element_ie.parentNode;

		cnpjElement = element_cnpj_parent;
		ieElement = element_ie_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'cnpj-ie';
		newLI.appendChild(cnpjElement);
		newLI.appendChild(ieElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('cpf') || $('cnpj')  ){
		var element_cpf = document.getElementById('cpf');
		var element_cpf_parent = element_cpf.parentNode;

		var element_rg = document.getElementById('rg');
		var element_rg_parent = element_rg.parentNode;

		cpfElement = element_cpf_parent;
		rgElement = element_rg_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'cpf-rg';
		newLI.appendChild(cpfElement);
		newLI.appendChild(rgElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('company') ){
		var element_company = document.getElementById('company');
		var element_company_parent = element_company.parentNode;

		companyElement = element_company_parent;

		var newLI = document.createElement("li");
		newLI.className = 'fields';
		newLI.id = 'company-x';
		newLI.appendChild(companyElement);

		targetElement = $('firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newLI,targetElement);
	}

	//

	if( $('nickname') ){
		var element_nickname = document.getElementById('nickname');
		var element_nickname_parent = element_nickname.parentNode;

		element_nickname_parent.hide();
	}

	//

	if( $('shortprofile') ){
		var element_shortprofile = document.getElementById('shortprofile');
		var element_shortprofile_parent = element_shortprofile.parentNode;

		element_shortprofile_parent.hide();
	}

	//

	function init() {
		$('cpf-rg').addClassName("no-display");
		$('cnpj-ie').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		if ($('pf_pj').getValue() == ''){
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(null);
		}else{
			pj_Event(null);
		}
	}

	init();

	//

	function pf_pj_Event(event) {
		var element = event.element();
		//alert(element.value);
		if (element.value == ''){
			init();
			if($('el-insert-pj')){$('el-insert-pj').remove();}
			if($('el-insert-pf')){$('el-insert-pf').remove();}
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(event);
		}else{
			pj_Event(event);
		}
	}

	$('pf_pj').observe('change', pf_pj_Event);

	//

	function pf_Event(event) {
		$('cnpj-ie').addClassName("no-display");

		$('cpf-rg').removeClassName("no-display");
		$('profissao-estadocivil').removeClassName("no-display");
		$('escolaridade-origem').removeClassName("no-display");


		$('cnpj').removeClassName("required-entry");
		$('cpf').addClassName("required-entry");
		if($('rg')){
		$('rg').addClassName("required-entry");
		}

		//Clean field
		$('cnpj').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('firstname'));
		if(label){//see if there is a label
			label.innerHTML='<em>*</em> <?php echo $this->__("Name") ?>';
		}
		var label = smo_input_get_label($('lastname'));
		if(label){//see if there is a label
			label.innerHTML='<em>*</em> <?php echo $this->__("Last Name") ?>';
		}
	}

	//

	function pj_Event(event) {
		$('cpf-rg').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		$('cnpj-ie').removeClassName("no-display");

		$('cpf').removeClassName("required-entry");
		if($('rg')){
		$('rg').removeClassName("required-entry");
		}

		$('cnpj').addClassName("required-entry");

		//Clean field
		$('cpf').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('firstname'));
		if(label){//see if there is a label
		label.innerHTML='<em>*</em> <?php echo $this->__("Officer Name") ?>';
		}
		var label = smo_input_get_label($('lastname'));
		if(label){//see if there is a label
		label.innerHTML='<em>*</em> <?php echo $this->__("Last name of the person responsible") ?>';
		}
	}

	//

	if($('cnpj')){
		var label = smo_input_get_label($('cnpj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("C.N.P.J.") ?>';
		}

		//
		function cnpj_Event(event) {
			var element = event.element();
			$('cnpj').maxLength = 18;
			$('cnpj').removeClassName("validate-cnpj");
			$('cnpj').addClassName("validate-cnpj");
		}

		$('cnpj').observe('focus', cnpj_Event);
		Event.observe('cnpj', 'keypress', function(event){ txtBoxFormat(this, '99.999.999/0001-13', event) });
	}

	//


	if($('cpf')){
		var label = smo_input_get_label($('cpf'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("C.P.F.") ?>';
		}

		//
		function cpf_Event(event) {
			var element = event.element();
			$('cpf').maxLength = 14;
			$('cpf').removeClassName("validate-cpf");
			$('cpf').addClassName("validate-cpf");
		}

		$('cpf').observe('focus', cpf_Event);
		Event.observe('cpf', 'keypress', function(event){ txtBoxFormat(this, '999.999.999-99', event) });
	}

	//

	if($('rg')){
		var label = smo_input_get_label($('rg'));
		label.className = 'required';
		if(label){
			label.innerHTML='<em>*</em> <?php echo $this->__("R.G.") ?>';
		}
	}

	//


	//]]>
	</script>

	<!-- / Cerebrum_Telencephalon -->

**Como adicionar novos atributos ao formulário de cadastro no checkout**

Ativando o debug do Magento vemos o arquivo que é carregado para cada formulario

Edite o arquivo correspondente ou então aplique o suporte sobre o seu template

Exemplo para /checkout/onepage/:

/app/design/frontend/base/default/template/persistent/checkout/onepage/billing.phtml

Exemplo para /onepagecheckout/:

/app/design/frontend/base/default/template/onepagecheckout/onepage/billing.phtml

Exemplo para /onepage/:

/app/design/frontend/base/default/template/opc/onepage/billing.phtml

E adicione o seguinte script que exibe os novos atributos criados pelo módulo Cerebrum_Telencephalon

Esse script deve ser colocado abaixo do li do password


	<!-- Cerebrum_Telencephalon -->

	<?php 
	echo Mage::app()->getLayout()->createBlock('telencephalon/customer_fields')->toHtml();
	?>

	<script type="text/javascript">
	//<![CDATA[

	//

	if( $('pf_pj') ){
		$('pf_pj').addClassName("validate-select");

		var label = smo_input_get_label($('pf_pj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<?php echo $this->__(" Pessoa Física | Pessoa Jurídica") ?> <em>*</em>';
		}

		var element_pessoa = document.getElementById('pf_pj');
		var element_pessoa_parent = element_pessoa.parentNode;

		newElement = element_pessoa_parent;

		targetElement = $('billing:address_id').nextSibling.nextSibling;

		if( $('onepagecheckout_orderform') ){
			targetElement = targetElement.parentNode;

			type_object = 'div';
			class_object = 'two_fields';
		}else if ( $('opc-address-form-billing') ) {
			type_object = 'li';
			class_object = 'fields';
		}else{
			type_object = 'li';
			class_object = 'fields';
		}

		var newObject = document.createElement(type_object);
		newObject.className = class_object;
		newObject.appendChild(newElement);

		targetElement.insertBefore(newObject, targetElement.childNodes[0]);
	}

	//

	if( $('escolaridade') || $('origem')  ){
		var element_escolaridade = document.getElementById('escolaridade');
		var element_escolaridade_parent = element_escolaridade.parentNode;

		var element_origem = document.getElementById('origem');
		var element_origem_parent = element_origem.parentNode;

		escolaridadeElement = element_escolaridade_parent;
		origemElement = element_origem_parent;

		if( $('onepagecheckout_orderform') ){
			$('escolaridade').addClassName("t1");
			$('origem').addClassName("t1");

			$('escolaridade').style.width='90%';
			$('origem').style.width='90%';

			escolaridadeElement.className = 'short';
			origemElement.className = 'short';

			type_object = 'div';
			class_object = 'two_fields';
		}else if ( $('opc-address-form-billing') ) {
			type_object = 'li';
			class_object = 'fields';
		}else{
			type_object = 'li';
			class_object = 'fields';
		}

		var newObject = document.createElement(type_object);
		newObject.className = class_object;
		newObject.id = 'escolaridade-origem';
		newObject.appendChild(escolaridadeElement);
		newObject.appendChild(origemElement);

		targetElement = $('billing:firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newObject,targetElement);
	}

	//

	if( $('estado_civil') || $('profissao')  ){
		var element_estadocivil = document.getElementById('estado_civil');
		var element_estadocivil_parent = element_estadocivil.parentNode;

		var element_profissao = document.getElementById('profissao');
		var element_profissao_parent = element_profissao.parentNode;

		estadocivilElement = element_estadocivil_parent;
		profissaoElement = element_profissao_parent;

		if( $('onepagecheckout_orderform') ){
			$('estado_civil').addClassName("t1");
			$('profissao').addClassName("t1");

			$('estado_civil').style.width='90%';
			$('profissao').style.width='90%';

			estadocivilElement.className = 'short';
			profissaoElement.className = 'short';

			type_object = 'div';
			class_object = 'two_fields';
		}else if ( $('opc-address-form-billing') ) {
			type_object = 'li';
			class_object = 'fields';
		}else{
			type_object = 'li';
			class_object = 'fields';
		}

		var newObject = document.createElement(type_object);
		newObject.className = class_object;
		newObject.id = 'profissao-estadocivil';
		newObject.appendChild(estadocivilElement);
		newObject.appendChild(profissaoElement);

		targetElement = $('billing:firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newObject,targetElement);
	}

	//

	if( $('cnpj') || $('inscricao_estadual')  ){
		var element_cnpj = document.getElementById('cnpj');
		var element_cnpj_parent = element_cnpj.parentNode;

		var element_ie = document.getElementById('inscricao_estadual');
		var element_ie_parent = element_ie.parentNode;

		cnpjElement = element_cnpj_parent;
		ieElement = element_ie_parent;

		if( $('onepagecheckout_orderform') ){
			$('cnpj').addClassName("t1");
			$('inscricao_estadual').addClassName("t1");

			$('cnpj').style.width='90%';
			$('inscricao_estadual').style.width='90%';

			cnpjElement.className = 'short';
			ieElement.className = 'short';

			type_object = 'div';
			class_object = 'two_fields';
		}else if ( $('opc-address-form-billing') ) {
			type_object = 'li';
			class_object = 'fields';
		}else{
			type_object = 'li';
			class_object = 'fields';
		}

		var newObject = document.createElement(type_object);
		newObject.className = class_object;
		newObject.id = 'cnpj-ie';
		newObject.appendChild(cnpjElement);
		newObject.appendChild(ieElement);

		targetElement = $('billing:firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newObject,targetElement);
	}

	//

	if( $('cpf') || $('rg')  ){
		var element_cpf = document.getElementById('cpf');
		var element_cpf_parent = element_cpf.parentNode;

		var element_rg = document.getElementById('rg');
		var element_rg_parent = element_rg.parentNode;

		cpfElement = element_cpf_parent;
		rgElement = element_rg_parent;

		if( $('onepagecheckout_orderform') ){
			$('cpf').addClassName("t1");
			$('rg').addClassName("t1");

			$('cpf').style.width='90%';
			$('rg').style.width='90%';

			cpfElement.className = 'short';
			rgElement.className = 'short';

			type_object = 'div';
			class_object = 'two_fields';
		}else if ( $('opc-address-form-billing') ) {
			type_object = 'li';
			class_object = 'fields';
		}else{
			type_object = 'li';
			class_object = 'fields';
		}

		var newObject = document.createElement(type_object);
		newObject.className = class_object;
		newObject.id = 'cpf-rg';
		newObject.appendChild(cpfElement);
		newObject.appendChild(rgElement);

		targetElement = $('billing:firstname').parentNode.parentNode.parentNode.parentNode;

		insertAfter(newObject,targetElement);
	}

	//

	if( $('company') ){
		var element_company = document.getElementById('company');
		var element_company_parent = element_company.parentNode;

		element_company_parent.hide();

		//

		function company_Event(event) {
			var element = event.element();
			$('company').value = element.value;
		}

		if( $('onepagecheckout_orderform') ){
			$('company').observe('keypress', company_Event);
		}else if ( $('opc-address-form-billing') ) {

		}else{
			$('billing:company').observe('keypress', company_Event);
		}


	}

	//

	if( $('nickname') ){
		var element_nickname = document.getElementById('nickname');
		var element_nickname_parent = element_nickname.parentNode;

		element_nickname_parent.hide();
	}

	//

	if( $('shortprofile') ){
		var element_shortprofile = document.getElementById('shortprofile');
		var element_shortprofile_parent = element_shortprofile.parentNode;

		element_shortprofile_parent.hide();
	}

	//

	function init() {
		$('cpf-rg').addClassName("no-display");
		$('cnpj-ie').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		if ($('pf_pj').getValue() == ''){
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(null);
		}else{
			pj_Event(null);
		}
	}

	if( $('cpf') || $('rg')  ){
		init();
	}

	//

	function pf_pj_Event(event) {
		var element = event.element();
		//alert(element.value);
		if (element.value == ''){
			init();
			if($('el-insert-pj')){$('el-insert-pj').remove();}
			if($('el-insert-pf')){$('el-insert-pf').remove();}
		}else if($('pf_pj').getValue() == $('pf_pj').options[1].value){
			pf_Event(event);
		}else{
			pj_Event(event);
		}
	}

	if( $('pf_pj')  ){
		$('pf_pj').observe('change', pf_pj_Event);
	}

	//

	function pf_Event(event) {
		$('cnpj-ie').addClassName("no-display");

		$('cpf-rg').removeClassName("no-display");
		$('profissao-estadocivil').removeClassName("no-display");
		$('escolaridade-origem').removeClassName("no-display");


		$('cnpj').removeClassName("required-entry");
		$('cpf').addClassName("required-entry");
		if($('rg')){
		$('rg').addClassName("required-entry");
		}

		//Clean field
		$('cnpj').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('billing:firstname'));
		if(label){//see if there is a label
			label_str = '';
			if( $('co-billing-form') ){
				label_str += '<em>*</em> ';
			}
			label_str += '<?php echo $this->__("Name") ?>';

			label.innerHTML = label_str;
		}

		var label = smo_input_get_label($('billing:lastname'));
		if(label){//see if there is a label
			label_str = '';
			if( $('co-billing-form') ){
				label_str += '<em>*</em> ';
			}
			label_str += '<?php echo $this->__("Last Name") ?>';

			label.innerHTML = label_str;

		}
	}

	//

	function pj_Event(event) {
		$('cpf-rg').addClassName("no-display");
		$('profissao-estadocivil').addClassName("no-display");
		$('escolaridade-origem').addClassName("no-display");

		$('cnpj-ie').removeClassName("no-display");

		$('cpf').removeClassName("required-entry");
		if($('rg')){
		$('rg').removeClassName("required-entry");
		}

		$('cnpj').addClassName("required-entry");

		//Clean field
		$('cpf').value = '';

		//SWITCH LABEL NOME - SOBRENOME
		var label = smo_input_get_label($('billing:firstname'));
		if(label){//see if there is a label
			label_str = '';
			if( $('co-billing-form') ){
				label_str += '<em>*</em> ';
			}
			label_str += '<?php echo $this->__("Officer Name") ?>';

			label.innerHTML = label_str;
		}

		var label = smo_input_get_label($('billing:lastname'));
		if(label){//see if there is a label
			label_str = '';
			if( $('co-billing-form') ){
				label_str += '<em>*</em> ';
			}
			label_str += '<?php echo $this->__("Last name of the person responsible") ?>';

			label.innerHTML = label_str;
		}
	}

	//

	if($('cnpj')){
		var label = smo_input_get_label($('cnpj'));
		label.className = 'required';
		if(label){
			label.innerHTML='<?php echo $this->__("C.N.P.J.") ?> <em>*</em>';
		}

		//
		function cnpj_Event(event) {
			var element = event.element();
			$('cnpj').maxLength = 18;
			$('cnpj').removeClassName("validate-cnpj");
			$('cnpj').addClassName("validate-cnpj");
		}

		$('cnpj').observe('focus', cnpj_Event);
		Event.observe('cnpj', 'keypress', function(event){ txtBoxFormat(this, '99.999.999/0001-13', event) });
	}

	//


	if($('cpf')){
		var label = smo_input_get_label($('cpf'));
		label.className = 'required';
		if(label){
			label.innerHTML='<?php echo $this->__("C.P.F.") ?> <em>*</em>';
		}

		//
		function cpf_Event(event) {
			var element = event.element();
			$('cpf').maxLength = 14;
			$('cpf').removeClassName("validate-cpf");
			$('cpf').addClassName("validate-cpf");
		}

		$('cpf').observe('focus', cpf_Event);
		Event.observe('cpf', 'keypress', function(event){ txtBoxFormat(this, '999.999.999-99', event) });
	}

	//

	if($('rg')){
		var label = smo_input_get_label($('rg'));
		label.className = 'required';
		if(label){
			label.innerHTML='<?php echo $this->__("R.G.") ?> <em>*</em>';
		}
	}

	//

	//]]>
	</script>

	<!-- / Cerebrum_Telencephalon -->

**Como esconder os campos: escolaridade e origem, profissao e estado_civil, rg, company**

Aplique o suporte do script abaixo no final do arquivo phtml do formulário

	 <!-- Cerebrum_Telencephalon -->

	<script type="text/javascript">
	//<![CDATA[

		$('escolaridade-origem').hide();

		$('profissao-estadocivil').hide();

		var element_rg = document.getElementById('rg');
		var element_rg_parent = element_rg.parentNode;
		element_rg_parent.hide();

		var element_company = document.getElementById('company');
		var element_company_parent = element_company.parentNode.parentNode;
		element_company_parent.hide();

	//]]>
	</script>

	 <!-- / Cerebrum_Telencephalon -->

---

# Métodos de entrega (7)

---

# Correios

## Sobre

Utilizando o webservice dos Correios, o módulo realiza o cálculo de frete utilizando seu CEP de origem, o CEP de destino do seu cliente, o peso dos produtos e o volume do carrinho, para calcular o valor exato dos serviços:

* SEDEX
* SEDEX 10
* SEDEX 12
* SEDEX Hoje
* SEDEX a Cobrar
* PAC
* e-SEDEX

Além do prazo de entrega dos Correios.

A administração do módulo permite a configuração de quais serviços serão utilizados, formato da encomenda "Formato caixa/pacote, Formato rolo/prisma, Envelope" , unidade de medida do peso, contrato com os Correios, mão própria, aviso de recebimento, valor declarado, volume padrão dos produtos, taxa de postagem, adicionar dias ao prazo dos Correios e outras funcionalidades. 

Efetue o cálculo pelo site dos Correios - http://www.correios.com.br/webservices/  
Simulador dos Correios - http://www.correios.com.br/encomendas/prazo/

## Dados de contato - Correios

Para entrar em contato com os Correios

http://www.correios.com.br/servicos/falecomoscorreios/default.cfm

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> Correios -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Correios retornando: Peso excedido**

O serviço "PAC grandes formatos" se trata de um serviço para quem tem contrato com os Correios que contempla 

• Limite de peso interestadual de 30 kg.
• Limite de peso no âmbito estadual podendo chegar a 50 kg, desde que autorizado pelo Diretor Regional.

fonte:
http://www.correios.com.br/produtosaz/produto.cfm?id=8560360B-5056-9163-895DA62922306ECA

**Como calcular diversos produtos para 1 ou mais embalagens**
**Como funciona o fracionamento em mais de uma embalagem**

O nosso módulo não tem suporte a fracionamento de embalagem, onde para cada produto deve ser somado o valor do frete

Não tenho até o momento alternativa para calcular diversos produtos para 1 ou mais embalagens

Analisando referencias na NET

http://www.pteixeira.com.br/modulo-de-frete-para-magento-com-tracking-versao-4-2/
http://blog.correios.com.br/comercioeletronico/?p=155

Uma possível solução que o Pedro_Teixeira e os Correios indica seria dividir a compra em dois fretes

Até o momento o nosso módulo também não contem essa funcionalidade 

**Quais os atributos criados que devem ser usado pelos método de entrega?**

No processo de instalação do módulo "Cerebrum_Telencepahlon" é criado os seguintes atributos para Produto:

volume_comprimento = Comprimento (ou profundidade) da embalagem do produto (cm)
volume_largura = Largura da embalagem do produto (cm)
volume_altura = Altura da embalagem do produto (cm)
volume_diametro = Diâmetro da embalagem do produto (cm)

Os atributos "Comprimento, Largura, Altura" são parâmetros de envio aos Correios e também é utilizado para o calculo do peso cúbico, portanto sugiro editar cada produto informando suas medidas

O atributo "Diâmetro" só deve ser preenchido quando usado o tipo de embalagem "Rolo" pelo método de entrega "Correios"

http://www.correios.com.br/encomendas/prazo/Formato.cfm

http://www.correios.com.br/produtosaz/produto.cfm?id=8560360B-5056-9163-895DA62922306ECA

**Como conferir as informações enviada do módulo ao "Serviço de frete"**

No Backend do Magento, acesse o menu: ∞ Telencephalon ∞ -> Logs -> Telencephalon -> pesquise informando para as colunas "Identificador = cerebrum_correios" e "Titulo = Envio da solicitação de cálculo de frete", acesse o registro onde deve ser exibido a URL de acesso ao "Serviço de frete" com os seus parâmetros

**Como é feito o cálculo de preços**

Conforme URL  
	http://www.correios.com.br/encomendas/prazo/

Para calcular o preço da encomenda o sistema utiliza a distância origem/destino(CEP), o peso e as dimensões do objeto, aplicando a seguinte fórmula:
	(Comprimento x Altura x Largura)/6000cm³.
O preço adotado pelo sistema será o maior entre o peso cúbico e peso real.

**Como é calculado o peso cúbico?**

Regra: ((Comprimento x Largura x Altura) x Quantidade) / Coeficiente.

Coeficiente = 6000

Se o peso cúbico for maior que o peso do produto é esse que é enviado ao "Serviço de frete" e é esse que conta para o preço de frete, por isso é que existe na configuração do modulo a indicação dos valores padrão para altura / largura / comprimento.

Para cada produto deve ser informado sua dimensão, onde caso não seja informado, o calculo do peso cúbico deve ser feito com base nos valores padrão presente na configuração do módulo

**Compatível com módulos que exibe o calculo de frete na visualização do produto?**

http://www.magentocommerce.com/magento-connect/EcomDev/extension/3860/ecomdev_productpageshipping
http://www.alexbraga.net/calculo-de-frete-na-pagina-do-produto-no-magento.html

## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Rastreamento  
5. Registro em logs do envio e retorno  

## Manual

http://www.correios.com.br/webservices/  
http://www.correios.com.br/webServices/PDF/SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf  
http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf

http://blog.correios.com.br/comercioeletronico/
http://blog.correios.com.br/comercioeletronico/?p=404
http://blog.correios.com.br/comercioeletronico/?p=155

---

# Correios Exporta Fácil

## Sobre

Obs. o produto "Correios Exporta Fácil" não deve funcionar para o Brasil, por se tratar de um serviço de entrega internacional

Veja no link a seguir informações detalhadas referente ao serviço Exporta Fácil dos Correios  
http://www.correios.com.br/exportafacil

Mais informações acesse - http://www.correios.com.br/produtosaz/produto.cfm?id=5CFF5D83-BCDF-F199-992CC0A65742D7AA  
Efetue o cálculo pelo site dos Correios - http://www.correios.com.br/exportafacil/  
Simulador dos Correios - http://www.correios.com.br/internacional/cfm/precos/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> Correios Exporta Fácil -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Como é calculado o peso cúbico?**

Regra: ((Comprimento x Largura x Altura) x Quantidade) / Coeficiente.

Coeficiente = 6000

Se o peso cúbico for maior que o peso do produto é esse que é enviado ao "Serviço de frete" e é esse que conta para o preço de frete, por isso é que existe na configuração do modulo a indicação dos valores padrão para altura / largura / comprimento.

Para cada produto deve ser informado sua dimensão, onde caso não seja informado, o calculo do peso cúbico deve ser feito com base nos valores padrão presente na configuração do módulo

## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Registro em logs do envio e retorno

## Manual

http://www.youblisher.com/p/591529-Manual-de-integracao-Correios-Exporta-Facil/
http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2012/03/Consulta_ExportaFacil.pdf

---

# Jadlog

## Sobre

Jadlog: com 480 unidades (franquias) a Jadlog posiciona-se como uma das maiores transportadoras do Brasil e tem significativa capilaridade para atender todo o território nacional;

A JADLOG é a sua mais nova e completa opção de serviço de encomenda expressa em âmbito nacional e internacional. 
Atendendo desde documentos até cargas de grande volume, com ou sem valor comercial, tanto para pessoas físicas quanto jurídicas, a JADLOG oferece toda a comodidade e agilidade dos serviços de coleta e entrega a domicílio.

Possui também um sofisticado sistema de logística e parcerias que permitem atender a todo território nacional e internacional com excelentes prazos de entrega e tarifas competitivas.

O Web Service JADLOG foi desenvolvido no intuito de disponibilizar ao cliente serviços que possam facilitar a integração entre os sistemas proprietários do cliente com o banco de dados da JADLOG , fornecendo a este cliente um serviço diferenciado de informações quanto ao manifesto e posicionamento de suas cargas.

Disponibilizando este novo serviço (Web Service), a JADLOG estará facilitando para que seu cliente tenha o acesso a informações do banco de dados da JADLOG através da utilização da internet.

Para acessar este serviço o cliente irá precisar de um serviço a internet (Contratado ou por conta própria).

Com este serviço o cliente poderá manifestar cargas que ainda serão coletadas pela unidade JADLOG, cancelar cargas já manifestadas e que ainda não tenham sido embarcadas, bem como consultar os dados de rastreamento de suas encomendas.

Mas informações - http://www.jadlog.com.br  
Simulador - http://jadlog.com.br/simuleosvalores.html  
Simulador Corporativo - http://jadlog.com.br/simuladorcorp.html

## Dados de contato - Jadlog

Para que sejam encaminhadas as solicitações ao webservice da JADLOG.  
O cliente deverá efetuar o seu cadastro com o Departamento Comercial.  
Telefone: (11) 3563-2000  
Contatos: Vera Ramos / Debora / Simone / Flavia / João Pedro

Comercial - JadLog <comercial@jadlog.com.br>

Suporte - JadLog <helpdesk@jadlog.com.br>, Ricardo Fernandes <ricardo.fernandes@jadlog.com.br>

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> Jadlog -> Preencha os campos solicitados

## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Rastreamento  
5. Na visualização do pedido o bloco do processo Jadlog foi implantado os recursos:  

- Inserir: Seguindo o processo do manual:
Cadastra no banco de dados JALOG um pedido eletrônico referente a encomenda que ainda deverá ser coletada oi entregue a unidade JADLOG que irá lhe atender.

- Cancelar: Cancela no banco de dados JADLOG um pedido eletrônico, colocado o Status da mesma em Cancelada e colocando na Observação um texto avisando que o pedido foi cancelado pelo Web Service ou seja pelo cliente, bem como o motivo do cancelamento.

- Consultar: Consulta no banco de dados da JADLOG os eventos de rastreamento de um pedido eletrônico.

6. Registro em logs do envio e retorno

## Perguntas mais frequentes "FAQ"

**Retornando "Acesso negado ou senha incorreta"**

O "Password" ou "CNPJ" enviado a Jadlod está incorreto  
No logo é exibido a URL de acesso ao Webservice da Jadlog, confira os parâmetros enviados a Jadlog  
Tendo dificuldade envie a URL para a Jadlog apontando o acesso ao serviço e seu retorno

## Manual

http://www.youblisher.com/p/641712-Manual-de-integracao-JADLOG/

---

# Jamef

## Sobre

Jamef Encomendas Urgentes: a Jamef é uma empresa de transportes de carga referência no quesito qualidade. Além de entender todo o Brasil, a transportadora disponibiliza integração direta com o seu sistema para seus clientes e-commerce;

Com uma frota nova e 100% rastreada via satélite, a JAMEF atende a totalidade das regiões sul, sudeste, Goiás e Distrito Federal no transporte rodoviário.  
Já no transporte aéreo, a JAMEF cobre todas as cidades atendidas pela aviação comercial em território nacional.  
Toda a frota é rastreada via satélite, 24 horas por dia, e equipada com rádio de comunicação e sistema de telemetria, permitindo um monitoramento preciso e em tempo real.  
Tudo isso para garantir a agilidade e segurança na entrega das suas encomendas!

Saiba mais - http://www.jamef.com.br/

## Dados de contato - Jamef

Comercial - Jamef <comercial.bhz@bhz.jamef.com.br>

Entre em contato com o setor comercial da JAMEF  
Solicite a habilitação da sua conta como cliente para acesso ao webservice da JAMEF  
Fone: (31) 2102-8808  
Fax: (31) 2102-8803

TI - Jamef

suporte@sao.jamef.com.br

Em caso de dúvidas, favor entrar em contato com a equipe de TI da Jamef através do telefone (31) 2102-8904  
Bruno Ferreira de Almeida <bruno@bhz.jamef.com.br>  
(11) 2121-6250

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> Jamef -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"


## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Rastreamento  
5. Registro em logs do envio e retorno

## Manual

http://www.jamef.com.br/jamef/ecp/comunidade.do?evento=portlet&pIdPlc=ecpTaxonomiaMenuPortal&app=portal&tax=20087&lang=pt_BR&pg=20004&taxn=20037&taxp=0&

---

# Braspress

## Sobre

Braspress empresa líder nacional do transporte de encomendas, a única que atende 100% do território nacional com 99% da capilaridade atendida com recursos próprios.

A Braspress transporta somente mercadorias de pessoas jurídicas para pessoas jurídicas com peso máximo de 60kg e 1,20mts.

Segue breves informações sobre o perfil da Braspress.

A Braspress atende hoje a nível Brasil, com filiais em todos os estados. Somos especializados em cargas fracionadas com perfil de até 60kg/vl e dimensões máxima 1,2m.  
Trabalhamos com Peso / Cubagem de 300 kg / m³ou peso aferido eletronicamente.  
Nossa entregas obedecem nossa tabela de emprazamentos; exceção a grandes magazines, super mercados e/ ou locais com reconhecidas dificuldade de entrega.  
Reentregas geram um custo de 50% do total do frete original. Nosso faturamento é quinzenal com (18) dias para pagamento via boleto bancário.  
Conheça mais de perto a Braspress, empresa líder nacional do transporte de encomendas.  
A única que atende 100% do território nacional com 99% da capilaridade atendida com recursos própios.  
Anexa apresentação detalhada de nossa empresa. 

Mais informações acesse o site: http://www.braspress.com.br/

## Dados de contato - Braspress

Braspress Tranportes Urgentes LTDA – Tecnologia da Informação  
Wallace Cury – Gerente de Desenvolvimento de Sistemas  
(11) 3429-3386  
ti.wallace@braspress.com.br  
Celular: (11) 7897-5017  
ID: 55*100*139149

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> Braspress -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Rastreamento  
5. Registro em logs do envio e retorno

## Manual

http://www.youblisher.com/p/555901-Braspress-Servicos-Online/

---

# SisFrete

## Sobre

O Sisfrete é uma empresa terceirizada que gerencia exclusivamente os fretes da loja virtual.

## Dados de contato - SisFrete

Evan - Comercial
(14) 3432-2425
Skype: evan_sisfrete
comercial@sisfrete.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de entrega -> SisFrete -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

## Recursos

1. Acesso ao Webservice para obtenção de dados a ser exibido no processo de método de entrega  
2. Cálculo de frete na página do produto  
3. Possibilidade de criação de regra promocional por modalidade de postagem  
4. Registro em logs do envio e retorno

## Manual

http://www.sisfrete.com.br/

---

# Métodos de pagamentos (17)

---

# Integração junto a administradora de cartão de crédito (3)

---

# Redecard

## Sobre

Redecard integrado à sua Loja Virtual

Komerci - É uma solução prática e segura para aceitar pagamentos com os cartões de crédito MasterCard®, Visa e Diners Club International pela internet.

Existem duas modalidades na Redecard:

Komerci Integrado: Aceita somente integração Via Post e esta modalidade de afiliação é padrão gerada pela Mastercard Internacional.  
No Komerci Integrado o lojista envia apenas os dados relativos à compra, a captação dos dados do cartão ocorre no ambiente Redecard.

Komerci Webservice: Aceita integração Via Post e Via Webservice, por padrão a Redecard libera Komerci integrado, então para migrar a afiliação para Redecard Webservice basta cadastrar os IPs do Gateway de pagamentos pelo Portal da Redecard ou enviar um e-mail para: pool.credenciamento@redecard.com.br solicitando o cadastramento dos Ips do seu servidor.

Na modalidade Redecard Komerci WebService, o lojista é responsável por capturar todos os dados (incluindo os dados do cartão de crédito) e enviar ao Gateway de Pagamento.

## Dados de contato - REDECARD

Suporte Técnico Komerci  
REDECARD SA  
loja.virtual@redecard.com.br  
servicoatentoloja.virtual@redecard.com.br  
4001 4433 (capitais e regiões metropolitanas)  
0800 784433 (demais localidades)

Obs. Antes de entrar em contato, tenha em mãos seu número de filiação (estabelecimento), caso seja desenvolvedor informe o número do CNPJ da empresa

Havendo alguma ocorrência de erro sugiro enviar e-mail a Redecard informando a ocorrência, caso haja necessidade de efetuar alguma atualização o suporte da Redecard deve apontar o que deve ser feito

## AFILIAÇÃO E-COMMERCE - REDECARD

http://www.komerciredecard.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Redecard -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Dependências**

Para se afiliar à Redecard é necessário que o seu site tenha a página segura(SSL128=https).

**O que significam os códigos de erro**

Verifique no Manual de integração o motivo da ocorrência do erro

## Operações de Teste (Sandbox)

Apenas o Komerci Webservice permite a realização de testes. A Redecard recomenda que, para testar o Komerci Integrado, sejam realizadas compras em ambiente de produção e que se execute o estorno até o fim do mesmo dia.

## Processo de Homologação

Para a conclusão da configuração Komerci Webservice, deve ser analisado se o estabelecimento está habilitado para a função de captura WebService “SIM” e se os IP ́s estão cadastrados corretamente.

O cadastramento de IP ́s pode ser realizado através do portal de serviços Redecard na área restrita e pode ser efetuado o cadastramento de até 10 IP ́s.

Inicialmente, somente os web-métodos de testes estarão disponíveis, com transações de valor de (1) um centavos.

Para disponibilizar o sistema em produção o estabelecimento deve efetuar uma bateria de testes e os testes devem ser analisados no Relatório de Transações do Komerci.

Se a transação constar com o status “confirmado” significa que os testes foram efetuados com sucesso. Diferente deste status, o desenvolvimento deve ser revisto.

Para confirmar a integração realizada, o cliente deve fazer uma compra teste de 0,01. Após realização de compra, é necessário verificar se a mesma foi lançada em sua conta na Redecard.

## Manual

http://www.redecard.com.br/Documents/Manuais/Manual_Komerci_Integrado.pdf  
http://www.redecard.com.br/Documents/Manuais/Manual_Komerci_WebService.pdf

---

# American Express

## Sobre

American Express integrado à sua Loja Virtual

## Dados de contato - AMERICAN EXPRESS

1º PASSO - CADASTRAMENTO  
4004 5040

2º PASSO - LIBERAÇÃO DA FERRAMENTA  
Serviço de atendimento a soluções eletrônicas  
Rede de estabelecimentos American Express®  
Telefone: 4004-5010 (Capitais) ou 0800-728-5010 (Demais localidades)  
E-mail: webposbrazil_cca@hypercom.com

## AFILIAÇÃO E-COMMERCE - AMERICAN EXPRESS

http://www2.americanexpress.com.br/conteudo/servico_atendimento/faleconosco.aspx

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> American Express - Preencha os campos solicitados

## CONFIGURANDO O SISTEMA DA AMERICAN EXPRESS - GERENCIADOR DE VENDAS

Ao receber o e-mail da American Express com os dados de acesso ao sistema de Gerenciador de Vendas.

Acesse o sistema da American Express e efetue login como 'Administrator' deve ser criada a conta de venda acessando o menu: Configurações -> Usuários -> Criar um novo usuário do Administrador de Vendas -> Efetue o preenchimento das informações -> Para o preenchimentos dos checkbox não selecione as opções:  
	- Usuário Bloqueado  
	- Senha deve ser alterada no proximo logon  
	- Caracterisitcas avançadas do administrador de vendas habilitadas

Efetue Logoff no sistema da American Express

Efetue login como 'conta_venda' e acesse o menu: Configurações -> Detalhes de Configurações ->  obtenha o 'Código de Acesso' e 'Secure Hash Secret 1'

Atualize o Código de Acesso na configuração do módulo para Magento  
Abra o arquivo /magento/skin/frontend/base/default/lib/amex_php/VPC/3Party/PHP_VPC_3Party_Super_Order_DO.php e atualize o conteudo da variável $secureSecret com o 'Secure Hash Secret 1'

Enviar email para --> webposbrazil_cca@hypercom.com --> Solicitando homologação da loja sobre o ambiente de teste, envie no corpo do e-mail o link de acesso ao seu site e também um usuário e senha

Após receber os dados do ambiente de produção execute os mesmo procedimentos acima porem nessa etapa não é necessário a AMEX efetuar o processo de homologação sobre o ambiente de produção

## Perguntas mais frequentes "FAQ"

### Erros comuns

**E5000: Cannot form a matching secure hash based on the merchant's request using either of the two merchant's secrets**

É exibido o erro quando não for atualizado a variável $secureSecret em 

/magento/skin/frontend/base/default/lib/amex_php/VPC/3Party/PHP_VPC_3Party_Super_Order_DO.php

## Manual

http://www.cerebrum.com.br/forum/index.php?/topic/882-erro-na-captura-amex/page__view__findpost__p__1333
http://amxdocs.amxvpos.com/JAPA/

---

# Cielo

## Sobre

Cielo integrado à sua Loja Virtual

Existem duas modalidades na Cielo:

Buy Page Cielo – Os dados do cartão são digitados no ambiente seguro da Cielo.  
Buy Page Loja – Os dados do cartão são digitados no ambiente da loja.

## BENEFÍCIOS

Aumento de Conversão de Vendas (Sem Pop-up): A página de pagamento fica na mesma janela do site, evitando problemas de navegação do comprador, deixando assim o site mais amigável.

Estabilidade: O novo Cielo E-Commerce utiliza os mais modernos servidores preparados para atender o grande crescimento do E-Commerce no Brasil.

Autorização Multibandeira: O Cielo E-Commerce está pronto para processar transações das principais bandeiras de cartões de crédito: Visa, MasterCard e Elo.

Cartão de Débito:  O Visa Electron* é uma oportunidade para reduzir problemas operacionais com o Boleto Bancário, como a desistência da compra. Além do pagamento ser simples, o lojista recebe em até 2 dias, a taxa de comissão é menor e as transações são sempre autenticadas. - *disponível para cartões Bradesco.

Captura Posterior: As vendas pelo site ocorrem a qualquer hora todos os dias, e no ato do pagamento a transação de cartão de crédito pode ser autorizada em segundos, mas você está preparado para analisar os pedidos apenas em horário comercial. Então a solução é utilizar a Captura Posterior da transação, que é a confirmação do vendedor sobre uma transação autorizada pelo banco emissor do cartão. O prazo para a Captura é de até 5 dias corridos após a data da autorização da transação. Esse prazo é fundamental para prevenção à fraude e controle de estoque.

Captura Parcial: A captura da transação pode ser no valor total ou inferior ao valor autorizado pelo banco emissor do cartão. Esse recurso permite que o vendedor não perca um pedido com vários produtos, caso não tenha todos os produtos disponíveis para a entrega imediata, pode-se liberar o pedido e Capturar apenas o valor referente aos produtos entregues de fato.

 Autenticação do portador do cartão:  Nas vendas pela Internet, quanto mais segurança melhor será. Os programas de autenticação do portador no ato do pagamento, criado pelas maiores bandeiras estão presentes nesta plataforma. Os serviços de autenticação são: Verified by Visa (Visa) e Secure Code (MasterCard).

## Dados de contato - Cielo

Suporte Web  
E-Commerce Cielo   
cieloecommerce@cielo.com.br  
Tel: 4002-9700 (Capitais e regiões metropolitanas)  
0800-570-1700 (Demais localidades)

## AFILIAÇÃO E-COMMERCE - Cielo

http://www.cielo.com.br/portal/cielo/seja-um-cliente-cielo/credenciamento.html

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Cielo - Preencha os campos solicitados

## Processo de Homologação

No backend do Magento efetue a criação de um produto: "Produto de Teste" de R$ 1,00  
No frontend do Magento efetue processo de compra do "Produto de Teste" escolhendo o método de pagamento Cielo  
Na finalização do pedido deve ser aberto a janela DHTML onde é carregado o processo do pagamento junto a Cielo  
Sendo exibido a tela da Cielo ou "ambiente de envio"  
Clique no botão "Cancelar",  após esse envio a Cielo, a Cielo deve efetuar o redirecionamento para o "ambiente de retorno"  
Estando funcional o processo de envio e retorno a Cielo, deve ser solicitado o processo de homologação, primeiro sobre o ambiente de teste

Envie o seguinte email a Cielo

	A/C suporte Cielo
	CIELO - Número de afiliação: 1010441041 - http://telediu.web919.uni5.net/loja/
	Segue em anexo Formulário de Homologação
	Favor iniciar processo de homologação
	Fico no aguardo dos dados do ambiente de produção para prosseguirmos com processo de homologação

O Formulário de Homologação se encontra no "Kit E-commerce Cielo" e pode ser baixado em: http://www.cielo.com.br/portal/kit-e-commerce-cielo.html

O suporte da CIelo irá efetuar os devidos testes comprovando o funcionamento do produto e irão enviar email com os dados do ambiente de produção

Ao receber e-mail com os dados do ambiente de produção

No backend do Magento na configuração do produto Cielo, atualize o "Número de filiação" a "Chave" e "Ambiente de Teste"

Efetue processo de compra do "Produto de Teste" novamente

Estando funcional o processo de envio e retorno a Cielo, deve ser solicitado o processo de homologação, agora sobre o ambiente de produção

Envie o seguinte e-mail a Cielo

	A/C suporte Cielo

	Favor prosseguir com processo de homologação sobre o ambiente de produção,
	Conforme imagem em anexo o processo está funcional sobre esse ambiente

	- URL do produto de R$1,00;
	http://telediu.web919.uni5.net/loja/produto-de-teste.html

	- Usuário e senha (caso seja necessário) para conclusão do teste;
	suporte@cerebrum.com.br / 123456

	- URL do logotipo da loja, no formato GIF e tamanho de 112X25 pixels.
	http://telediu.web919.uni5.net/loja/library/logo-to-cielo.gif

	- Informar como foi desenvolvido o pagamento (0-não autorizar, 1-autorizar somente autenticada ou 2-autorizar autenticada e não autenticada) e se haverá captura automática.
	<autorizar>2</autorizar>
	<capturar>true</capturar>

Após os testes feito pela Cielo é enviado o e-mail de conclusão de homologação

## Capturar transação de forma manual pelo site da Cielo

**AVISO**

As transações deverão ser capturadas no prazo máximo de cinco (05) dias corridos após a transação para confirmação da mesma.  
Caso opte por não utilizar o sistema de captura automática, favor seguir os direcionamentos abaixo para a captura das transações.

**PROCESSO**

Através do site www.cielo.com.br, na área de acesso ao estabelecimento (e-Commerce), você poderá efetuar a captura das transações realizadas em sua loja virtual.  
Para acessar o site Cielo, você deverá efetuar um prévio cadastramento, utilizando um login e uma senha.  
Para realizar este cadastramento, basta entrar em contato com a Central de Atendimento Cielo e solicitar acesso ao site, informando seu número de estabelecimento.  
Com essas informações, a Central informará seu código de usuário e senha para o primeiro acesso.  
Com as informações (número do estabelecimento, código de usuário e senha) você deverá acessar o site Cielo, menu "Serviços On-line", opção "Cadastre-se no site".  
Será apresentado o termo de uso que deve ser aceito e na tela seguinte, deverá ser digitado as informações solicitadas para confirmar o cadastramento.  
Importante: Não esqueça de alterar sua senha após o primeiro acesso.  
Para os próximos acessos será solicitado apenas o número do estabelecimento, código de usuário e senha na página principal do site Cielo.  
Ao entrar na área do estabelecimento para capturar uma transação, deve ser acionado o menu Vendas pela Internet onde aparecerá Consultar Transação e Capturar Transação, para efetivar a captura, marque a transação que deve ser capturada e clique no botão Capturar.

**AVISO**
  
No link a seguir é informado algumas dicas preventivas que pode auxiliar nesta análise.  
http://www.youblisher.com/p/615475-Dicas-Preventivas-para-vendas-mais-seguras/

Analise as transações antes de capturá-las.  
Se suspeitar da venda e não entregar a mercadoria, não capture a transação.  
Caso tenha capturado, será obrigatório o cancelamento.  
Caso atualmente efetue a captura automática, sugerimos solicitar alteração para captura manual.  
Desta forma, a transação fraudulenta não capturada será desfeita evitando débitos futuros.  
Para maiores informações sobre como capturar uma transação no site Cielo, entre em contato com nossa Central de Atendimento, nos contatos informados logo abaixo:  
Telefones: 4002-5472 (capitais e regiões metropolitanas) - 0800-570-8472 (demais localidades) - Opção "7" Site Cielo  
E-mail: atendimento@cielo.com.br  
Horário de atendimento: Segunda a Sábado – das 8h00 às 22h00  
Para maiores informações técnicas entre em contato com nosso Suporte Web:  
Suporte Web:  
Telefone: 4002-9700 (Capitais e regiões metropolitanas) - 0800-570-1700 (demais localidades) - Opção "1" Suporte  
E-mail: cieloecommerce@cielo.com.br  
Atendimento 24x7  
Atenciosamente,  
Equipe e-Commerce Cielo

## Perguntas mais frequentes "FAQ"

**Dependências**

No uso da modalidade "Buy Page Loja" é necessário que o seu site tenha a página segura(SSL128=https).

**Requisitos para o uso da modalidade Buy Page Loja**

Para utilizar o Buy Page Loja sem gateway é necessário cumprir requisitos de segurança estabelecidos por um conselho denominado PCI Council.  
Estes requisitos são baseados no número de transações anuais do estabelecimento:  
- Acima de 6 milhões de transações ano:  
	necessária a certificação PCI (AOC) e scan de vulnerabilidade trimestral;  
- Entre 6 milhões e 1 milhão de transações ano:  
	Necessário o preenchimento de um questionário de autoavaliação(SAQ) e scan de vulnerabilidade trimestral (ambos podem ser adquiridos juntos com uma empresa ASV).  
- Abaixo de 1 milhão:  
	Recomendável o Scan de vulnerabilidades trimestral e seguir requisitos de segurança para os dados de cartão estabelecidos pelo PCI:  
	- Não armazenamento do código de segurança;  
	- Armazenamento do número do cartão somente quando estritamente necessário e armazenados de forma criptografada.  
	- Caso exista a necessidade de exibir os dados de cartão (digitalmente ou em papel), este deve sempre estar mascarado (**********123456).  

**O que significam os códigos de erro**

Verifique no Manual de integração o motivo da ocorrência do erro

**Sobre o recurso juros emissor/estabelecimento**

O recurso "Juros emissor" não é um recurso da operadora de cartão o mesmo foi desenvolvido na necessidade de adicionar juros ao pedido no Magento

O recurso "Juros estabelecimento" esse sim se trata de um recurso da operadora de cartão, o uso desse recurso não adiciona juros ao pedido no Magento

## Manual

http://www.cielo.com.br/portal/kit-e-commerce-cielo.html

---

# e-Rede

## Sobre

A nova solução de meio de pagamento online da Rede, denominada "e-Rede", oferece a melhor solução de vendas pela internet para seus clientes, priorizando sua estratégia na excelência dos meios de pagamento e avançado sistema de prevenção a fraude. Uma solução completa e robusta para todos os tipos de estabelecimento com novos serviços e aplicações.

## Dados de contato - e-Rede

suporte - loja.virtual@userede.com.br

João Mathor - joao.mathor@userede.com.br
Adriana Ferreira - adriana.ferreira@userede.com.br

Rafael Marques Dos Santos - rafaelmarques@brq.com

11 2121-1539

userede.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> e-Rede -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Testando o envio do XML**

http://www.hurl.it/

**Necessidade no uso do e-Rede**

No Backend do Magento, acesse o menu: Catálogo -> Atributos -> Gerenciar Atributos -> Adicionar Novo Atributo -> Crie um novo atributo "default" sendo o código "risco_produto_erede"

No Backend do Magento, acesse o menu: Catálogo -> Atributos -> Gerenciar Conjuntos de Atributos -> Adicione o novo atributo ao grupo de produtos

Dessa forma na edição do produto deve ser exibido o Novo atributo

Preenchendo esse atributo será enviado ao e-Rede essa informação para o parâmetro "CodTipoProdRisco", caso não seja preenchido a informação para o produto deve ser enviado o valor "Low"

Pode ser preenchido com os seguintes valores

Low = Baixo
Medium = Medio
High = Alto

## Manual

http://www.userede.com.br/pt-BR/produtosservicos/Paginas/ecommerce-manuais.aspx

---

# Integração junto a instituição financeira bancária (5)

---

# Itaú Shopline

## Sobre

Itaú Shopline integrado à sua Loja Virtual

Ao vender produtos ou serviços pela internet e disponibilizar o Itaú Shopline como meio de pagamento de sua loja virtual, você proporciona uma maneira simples, prática e segura para seus clientes efetuarem seus pagamentos e, também, a oportunidade de escolher entre as opções Itaú a mais conveniente.

O Itaú Shopline é uma plataforma de meios de pagamentos que oferece as seguintes opções aos compradores do seu site:

  * Pagamento à vista por transferência: Com esta opção, o cliente de sua loja virtual que é correntista do Itaú paga o valor de sua compra à vista, por transferência eletrônica de fundos para a conta corrente da loja. Sua empresa recebe on-line a informação do tipo de pagamento escolhido e, posteriormente, um crédito em conta corrente, identificado pelo número do pedido realizado na loja.

  * Crediário Automático Itaú: O cliente de sua loja virtual que é correntista do Itaú pode contratar um financiamento junto ao Itaú para o pagamento do valor de sua compra. Sua empresa recebe on-line a informação do tipo de pagamento escolhido e, posteriormente, um crédito em conta corrente, identificado pelo número do pedido realizado, no valor integral da compra e sem risco de crédito algum.

  * Cartão ItauCard: O cliente de sua loja virtual que tiver cartão de crédito ItauCard (Mastercard, Diners ou Visa) pode pagar suas compras utilizando seu cartão em ambiente seguro Itaú. Ao digitar sua agência, conta e senha eletrônica e escolher a opção Cartão ItauCard, o Banco Itaú lista os cartões disponíveis para aquele comprador, que escolhe qual cartão usar, sem digitar o número do cartão em momento algum. Para confirmar a operação, o comprador digita sua senha do banco. Neste momento, o Itaú Shopline se comunica com a operadora do cartão escolhido para autorizar o pagamento à sua loja. Sua empresa recebe on-line a informação do tipo de pagamento escolhido no Itaú Shopline, mas as informações referentes aos pagamentos via cartão de crédito serão disponibilizadas pelas próprias operadoras dos cartões. O crédito na conta de sua empresa será feito conforme acordo estabelecido com as bandeiras.

  * Boleto Bancário: O cliente de sua loja virtual, correntista ou não do Itaú, que escolher pagar o valor de sua compra por Boleto Bancário gera em sua própria tela um boleto para imprimir e efetuar o pagamento em qualquer agência bancária, sistema de home banking, equipamento de auto-atendimento ou serviço de atendimento por telefone. Além disso, Clientes Itaú com acesso ao Bankline contam com mais uma facilidade: a possibilidade de pagar ou agendar este boleto automaticamente após sua geração, apenas digitando sua agência, conta e senha eletrônica.

O Itaú Shopline executa a aquisição de dados sigilosos do usuário no ambiente do Itaú. Assim, não é necessário ter cuidado no tráfego de tais dados.

## Dados de contato - Itaú Shopline

Suporte Operacional Empresas  
0300 100 7575  
operemp@itau-unibanco.com.br  
Banco Itaú-Unibanco S.A.

## AFILIAÇÃO E-COMMERCE - Itaú Shopline

http://www.itau.com.br/itaushopline

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Itaú Shopline -> Preencha os campos solicitados

## Configurações no ambiente - Itaú Shopline

Para o método de Pagamento funcionar corretamente, é necessário configurar o domínio da url de retorno no ambiente do Itaú Shopline. Ele deve apontar para o seu domínio.

## Perguntas mais frequentes "FAQ"

**Dependências**

Para o perfeito funcionamento do produto ItauShopLine.  
É necessária a postagem de informações como BAIRRO e DOCUMENTO (CPF/CNPJ).  
O formulário de cadastro de clientes no Magento deverá conter as devidas validações nesses campos.  
No formulário de cadastro de clientes do Magento o campo BAIRRO se trata do campo "billing:street2", sugerimos aplicar as devidas validações.  
No formulário de cadastro de clientes do Magento o atributo "tax_vat" geralmente é usado para armazenar "CPF/CNPJ", sugerimos ativar o atributo "tax_vat" e aplicar as devidas validações.  
Veja mais informações no post a seguir  
http://www.cerebrum.com.br/forum/index.php?/topic/868-shopline-erro-08/page__p__2716#entry2716

**ERROR: "Problemas no processamento, tente mais tarde. (Erro 08) SOS - Itaú Bankline"**

Acesse o sistema administrativo, acesse o pedido, veja que no histórico é armazenado as variáveis de postagem ao itaushopline  
Caso alguma informação obrigatória não seja enviada é exibido pelo itau o erro 08

Quando é usado o formulário nativo do Magento deve ser aplicado o seguinte suporte ao formulário de cadastro no Magento  
http://www.cerebrum.com.br/forum/index.php?/topic/868-shopline-erro-08/page__view__findpost__p__2716

No post a seguir tem informações sobre essa ocorrência  
http://www.cerebrum.com.br/forum/index.php?/topic/868-shopline-erro-08/

No post a seguir tem informação sobre um procedimento que não recomendo  
http://www.cerebrum.com.br/forum/index.php?/topic/986-separar-numero-do-endereco/

	No formulário do magento o campo Bairro se trata do campo billing:street2  
	Quando separa o número do endereço, colocando o número sobre o campo billing:street2 percebe que quando é apresentado dados do endereço o número sai na linha de baixo do registro  
	Isso acontece em toda parte do Magento, tanto nos pedidos como fatura, descaracterizando o modelo comum de apresentação dos dados  
	Devido a esse caso o módulo da Cerebrum procura seguir algumas definições do modelo nativo do Magento

**ERROR: "Problemas na criptografia ou o campo valor está incorreto. Entre em contato com o SOS Itaú Bankline. SOS - Itaú Bankline"**

O erro está relacionado a Chave de Criptografia

Após a geração da Chave de Criptografia a mesma demora 24hrs para propagação

Sugiro aguardar o prazo para propagação e tentar novamente

Se o problema persistir sugiro entrar em contato com o Itaú apontando a ocorrência

**Observações**

1. 
O processo do método de pagamento é aberto em popup.  
Na eventualidade do navegador do usuário estiver habilitado o recurso de bloqueio de popup, será exibido um "aviso", induzindo o usuário ao clique para desbloqueio automático do popup.

## Manual

http://www.itaushopline.com.br/cadastrado/download/Manual_Tecnico_ItauShopline.pdf
http://download.itau.com.br/downloadcenter/arquivos/Manual_Tecnico_ItauShopline.pdf

---

# Banco do Brasil

## Sobre

O Banco do Brasil oferece uma solução de comércio eletrônico que permite a você receber pagamentos pela internet das seguintes formas:

  * Débito em Conta – Forma de pagamento à vista, mediante débito em conta corrente do comprador (Pessoa Física - B2C ou Jurídica - B2B) e crédito em conta corrente da empresa.

  * Boleto Bancário – Forma de pagamento que gera boleto de cobrança bancária impresso pelo próprio comprador (cobrança sem registro).

  * Crediário Internet - Forma de pagamento em que o correntista pode pagar em até 36x e o lojista recebe o valor à vista.

Para mais informações, acesse o site http://www.bb.com.br/ e procure por "Comércio Eletrônico".

Para implementar a solução é necessário, primeiramente, possuir conta corrente Pessoa Jurídica no BB. Em seguida, procure seu gerente de contas e formalize os convênios para comércio eletrônico.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Banco do Brasil -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Observações**

1. 
O processo do método de pagamento é aberto em popup.  
Na eventualidade do navegador do usuário estiver habilitado o recurso de bloqueio de popup, será exibido um "aviso", induzindo o usuário ao clique para desbloqueio automático do popup.

**O que significam os códigos de erro**

Verifique no Manual de integração o motivo da ocorrência do erro

## Manual

http://www.bb.com.br/docs/pub/emp/empl/dwn/Orientacoes.pdf

---

# Bradesco

## Sobre

Os meios de pagamento eletrônico Bradesco permitem receber pagamentos de quatro formas diferentes:

  * Boleto Bancário – Correntistas ou não correntistas Bradesco podem efetuar o pagamento das compras realizadas nas lojas virtuais utilizando o boleto bancário.

  * Pagamento Fácil – É a forma de pagamento que permite aos clientes Bradesco efetuarem pagamento com Cartões Bradesco de Crédito (Visa e MasterCard) e Débito (conta-corrente).

  * Transferência entre contas – Correntistas Bradesco podem efetuar on-line o débito do valor da compra diretamente na sua conta.

  * Financiamento – Clientes Bradesco com crédito pré-aprovado podem parcelar o valor da compra enquanto o lojista recebe o valor à vista.

B2C: Boleto Bancário, Pagamento Fácil, Transferência entre contas, Financiamento Eletrônico  
B2B: Pagamento Eletrônico

Todas as operações entre o Consumidor e o Lojista contam com sistemas de controle desenvolvidos pelo próprio Bradesco, que utilizam as mais recentes tecnologias de criptografia e protocolos de segurança.

## Dados de contato - SCOPUS TECNOLOGIA

Sistema de Pagamento Seguro  
Suporte Técnico  
Scopus Tecnologia  
(11) 3909-3482  
(11) 3909-3637  
kit@scopus.com.br

## AFILIAÇÃO E-COMMERCE - Bradesco

Para implantar os Meios de Pagamento Eletrônico Bradesco em seu site, é necessário possuir conta corrente pessoa jurídica. Entre em contato com seu gerente de contas e solicite Convênio para Comércio Eletrônico. Ou siga os passos abaixo:

Acesse o site http://www.bradescocomercioeletronico.com.br/ e preencha a proposta de adesão.  
Após o preenchimento e envio de sua proposta, a mesma será analisada pelo Bradesco, o qual estará entrando em contato com sua empresa.  
Uma vez preenchido o contrato, em poucos dias o Bradesco estará enviando as instruções para implementação dos pagamentos.

Também para a contratação do serviço Bradesco, pode ser realizado o contato via telefone: (11) 3684-9233

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Bradesco -> Preencha os campos solicitados

## Configurando o sistema do bradesco - Gerenciador de pagamentos e captura

Ao receber o e-mail do Bradesco com os dados de acesso ao gerenciador de pagamentos e captura.

Efetue login no sistema

http://mupteste.comercioeletronico.com.br/sepsManager/login.asp?merchantid=___

Para cadastrar formas de pagamentos para cartões:  
Acesse o gerenciador  
Ir ao Menu e selecionar o item "Formas de Pagamento Bradesco"  
Habilite a opção "Cartão de Débito" e clique em Salvar Configuração.  

Para configurar os retorno  
Acesse o gerenciador  
Ir ao Menu e selecionar o item "Configuração Bradesco"  
Para o campo "Página de confirmação de compra" preencher como http://www.SEU_DNS.com.br/index.php/telencephalon/payment/bradescoreturn/acao/confirmacao/  
Para o campo "Página de falha no pagamento" preencher como http://www.SEU_DNS.com.br/index.php/telencephalon/payment/bradescoreturn/acao/falha/  
Para os campos contendo "URL de notificação" preencher como http://www.SEU_DNS.com.br/index.php/telencephalon/payment/bradescoreturn/acao/notificacao/  
Para o campo "Post a ser enviado para a loja na notificação" preencher como numOrder=[%lid_m%]&merchantid=[%merchantid%]&cod=[%errorcod%]&cctype=[%cctype%]&ccname=[%ccname%]&ccemail=[%ccemail%]&numparc=[%numparc%]&valparc=[%valparc%]&valtotal=[%valtotal%]&prazo=[%prazo%]&tipopagto=[%tipopagto%]&assinatura=[%assinatura%]&  
Para o campo "Post a ser enviado para a loja na confirmação de compra" preencher como numOrder=[%lid_m%]&merchantid=[%merchantid%]&cod=[%errorcod%]&cctype=[%cctype%]&ccname=[%ccname%]&ccemail=[%ccemail%]&numparc=[%numparc%]&valparc=[%valparc%]&valtotal=[%valtotal%]&prazo=[%prazo%]&tipopagto=[%tipopagto%]&assinatura=[%assinatura%]&  
Para o campo "Post a ser enviado para a loja na falha da autorização" preencher como numOrder=[%lid_m%]&merchantid=[%merchantid%]&cod=[%errorcod%]&errordesc=[%errordesc%]&

## Processo de Homologação

No backend do Magento efetue a criação de um produto: "Produto de Teste" de R$ 1,00  
No frontend do Magento efetue processo de compra do "Produto de Teste" escolhendo o método de pagamento Bradesco  
Na finalização do pedido deve ser aberto a janela DHTML onde é carregado o processo do pagamento junto ao Bradesco  
Sendo exibido a tela do Bradesco efetue os testes clicando nas modalidades de pagamentos  
Estando funcional o processo junto ao Bradesco, deve ser solicitado o processo de homologação, primeiro sobre o ambiente de teste

Envie o seguinte e-mail ao Bradesco

	A/C homologacao@scopus.com.br

	Homologação - Bradesco - FELAP MAQUINAS E EQUIPAMENTOS LTDA

	Nome da loja: BERYLO OFICINA DE ARTE
	Número da loja: 17951
	CNPJ: 005.309.496/0001-01

	Segue URL de Produto de Teste de R$ 1
	http://loja.berylo.net/produto-de-teste.html

	Se logar como
	suporte@cerebrum.com.br / 123456

	Ambiente de teste configurado e feito teste na loja virtual onde conforme imagens está funcional

	Favor prosseguirem com processo de homologação

	Obs. favor liberar todas as formas de pagamentos, inclusive B2B conhecido como SPS Empresas

	No aguardo das assinaturas para o ambiente de produção

O suporte da Scopus irá efetuar os devidos testes comprovando o funcionamento do produto e irão enviar e-mail com os dados do ambiente de produção

Ao receber e-mail com os dados do ambiente de produção

No backend do Magento na configuração do produto Bradesco, atualize o "Número de filiação" a "Chave" e "Ambiente de Teste"

Efetue processo de compra do "Produto de Teste" novamente

Estando funcional o processo junto ao Bradesco, deve ser solicitado o processo de homologação, agora sobre o ambiente de produção

Envie o seguinte e-mail ao Bradesco

	A/C Suporte Scopus

	Favor prosseguir com processo de homologação sobre ambiente de produção onde conforme imagem está funcional

	Testar sobre todas as formas de pagamentos

	Segue URL de Produto de Teste de R$ 1
	http://loja.berylo.net/produto-de-teste.html

	Segue URL de Produto de Teste de R$ 20
	http://loja.berylo.net/produto-de-teste-20.html

	Se logar como
	suporte@cerebrum.com.br / 123456

Após os testes feito pela Scopus é enviado o e-mail de conclusão de homologação

## Perguntas mais frequentes "FAQ"

**Não está funcionando os métodos de pagamentos**

As URLs a seguir é usada para efetuar o debug, onde o bradesco acessa as URLs previamentes cadastradas

- Ambiente de teste

http://mupteste.comercioeletronico.com.br/paymethods/boletoret/model1dbg1/prepara_pagto.asp?merchantid=___&orderid=___&
http://mupteste.comercioeletronico.com.br/paymethods/transfer/model1dbg1/prepara_pagto.asp?merchantid=___&orderid=___&

- Ambiente de produção

http://mup.comercioeletronico.com.br/paymethods/boletoret/model1dbg1/prepara_pagto.asp?merchantid=___&orderid=___&
http://mup.comercioeletronico.com.br/paymethods/transfer/model1dbg1/prepara_pagto.asp?merchantid=___&orderid=___&

## Manual

Introdução

http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Loja_Demonstracao.zip
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Instalacao%20Loja%20Demonstracao.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Gerenciando%20Compras.pdf

Guia de Integração

http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integracao%20Boleto%20Bancario%20com%20retorno.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integracao%20Boleto%20Bancario.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integracao%20Financiamento.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integracao%20Pagamento%20Eletronico%20B2B.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integra%C3%A7%C3%A3o%20D%C3%A9bito%20Bradesco.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Guia%20de%20integracao%20Transferencia.pdf

Arquivo de Retorno

http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Boleto%20TXT.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Boleto%20Valor%20Pago%20TXT.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Boleto%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Boleto%20Valor%20Pago%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Financiamento%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Financiamento%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20PagtoFacil%20TXT.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20PagtoFacil%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Transferencia%20TXT.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20PagtoFacil%20XML.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Pagamento%20Eletr%C3%B4nico%20B2B%20TXT.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/Arquivo%20de%20retorno%20Pagamento%20Eletr%C3%B4nico%20B2B%20XML.pdf

Códigos de Erro

http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/errosComercio.pdf
http://mupteste.comercioeletronico.com.br/sepsManager/Download/Versao3/codigo_de_erros.zip

---

# Banrisul Banricompras

## Sobre

A integração da loja virtual com a forma de pagamentos Banrisul é realizada através do site: http://www.banrisul.com.br/, onde será descrito passo a passo todos os procedimentos para a integração.

## Dados de contato - Banrisul

https://ww4.banrisul.com.br/banricompras/

Everton Hartwig
everton_hartwig@banrisul.com.br
Automação Comercial
Fone (51) 3215-3625 
Banrisul S/A

Tecnologia_Homologacoes@banrisul.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Banrisul Banricompras -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Observações**

1. 
O processo do método de pagamento é aberto em popup.  
Na eventualidade do navegador do usuário estiver habilitado o recurso de bloqueio de popup, será exibido um "aviso", induzindo o usuário ao clique para desbloqueio automático do popup.

## Manual

https://ww4.banrisul.com.br/banricompras/
http://www.youblisher.com/p/652855-Manual-de-integracao-Banrisul-Banricompras/

---

# Banrisul Boleto

## Sobre

Recurso para clientes que desejam operar APENAS com o boleto bancário Banrisul.

## Dados de contato - Banrisul

Everton Hartwig
everton_hartwig@banrisul.com.br
Automação Comercial
Fone (51) 3215-3625 
Banrisul S/A

Tecnologia_Homologacoes@banrisul.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banrisul -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Observações**

1. 
O processo do método de pagamento é aberto em popup.  
Na eventualidade do navegador do usuário estiver habilitado o recurso de bloqueio de popup, será exibido um "aviso", induzindo o usuário ao clique para desbloqueio automático do popup.

## Manual

http://www.banrisul.com.br/bob/data/Instrucoes_para_utilizacao_de_Bloqueto_Bancario_Banrisul_em_sites_txtvrs04.pdf?cache=44

---

# Integração junto a intermediador de pagamentos (2)

	"intermediador de transações, ou seja, uma empresa de negócios e valores que recebe os pagamentos dos compradores e os repassa aos vendedores, de forma online, através de uma conta virtual."	

---

# Pagseguro

## Sobre

Venda pela internet com facilidade usando o PagSeguro: receba pagamentos com cartão de crédito, boleto bancário ou por e-mail. Comece a vender com PagSeguro já!

## Dados de contato - Pagseguro

desenvolvedores@pagseguro.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Pagseguro -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Como configurar a integração junto no PagSeguro**

No PagSeguro -> Integrações -> Página de redirecionamento -> Página fixa de redirecionamento -> Desativado

No PagSeguro -> Integrações -> Pagamentos via API -> Quero receber somente pagamentos via API -> Ativado

No PagSeguro -> Integrações -> Notificação de transações -> Desativado

No PagSeguro -> Integrações -> Retorno automático de dados -> Ativado -> https://www.cerebrum.com.br/loja/index.php/telencephalon/payment/pagseguroreturns/

**ERROR: "PagSeguroLibrary XML parsing error: (4) not well-formed (invalid token)"**

Erro registrado em

http://blogpagseguro.com.br/?p=10637

Aplicado automação para editar o arquivo 

/skin/frontend/base/default/lib/pagseguro_php/source/PagSeguroLibrary/utils/PagSeguroXmlParser.class.php

atualizando o seguinte trecho

		$str_replace = array(
			'$parser = xml_parser_create();' => '$parser = xml_parser_create();$xml = utf8_decode($xml);',
		);

## Manual

https://pagseguro.uol.com.br/v2/guia-de-integracao/downloads.html
https://github.com/pagseguro/php
https://github.com/pagseguro/magento

---

# Bcash

## Sobre

O Bcash é uma solução de pagamento que oferece serviços financeiros para quem deseja comprar ou vender pela internet. Com ele, é possível realizar transações utilizando mais de 14 formas de pagamento, entre cartões de crédito, transferência bancária, boleto bancário e a Carteira Bcash.

## Dados de contato - Bcash

integracao@bcash.com.br
atendimento@bcash.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Bcash -> Preencha os campos solicitados

## Manual

http://developer.buscape.com/api/manual-de-integracao-bcash/

---

# Moip

## Sobre

Moip Pagamentos S.A. é uma empresa prestadora de serviços de gestão e intermediação de pagamentos na internet, que atua como representante dos usuários dos seus serviços, por conta e ordem destes. O serviço prestado pelo Moip não é, e nem se destina, a ser comparável a serviços financeiros, nem a atividades privativas de instituições financeiras.

## Dados de contato - Moip

support@moip.zendesk.com
suporte@moip.com.br

integracao@moip.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Moip -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Configurações no sistema da Moip**

No Backend do Moip, acesse o menu: Ferramentas -> Api -> Chaves De Acesso -> Nesse ambiente voce obterá as informações: "Token de acesso" e "Chave de acesso"

Não precisa ser configurado na Moip a URL de retorno e Notificação, pois o módulo já informa as devidas URLs a Moip

**Necessidade no uso do Moip Assinaturas**

Na configuração do módulo deixei habilitado somente os métodos de cartão de crédito

No Backend do Magento, acesse o menu: Catálogo -> Atributos -> Gerenciar Atributos -> Adicionar Novo Atributo -> Crie um novo atributo "default" sendo o código "plano_moip"

No Backend do Magento, acesse o menu: Catálogo -> Atributos -> Gerenciar Conjuntos de Atributos -> Adicione o novo atributo ao grupo de produtos

Dessa forma na edição do produto deve ser exibido o Novo atributo

Preenchendo esse atributo será enviado ao Moip Assinaturas essa informação para o parâmetro "Código do Plano"

Obs. no uso do Moip Assinaturas não é possivel efetuar a compra de mais de 1 item por pedido 

**Gerenciando o Moip Assinaturas**

Para fazer login na Conta Assinaturas, basta acessar o link abaixo e utilizar seu Login e Senha do Moip:

https://assinaturas.moip.com.br/

## Manual

https://github.com/moiplabs/moipjs
https://github.com/moiplabs/assinaturas-js-demo
https://github.com/moiplabs/moip-php
https://labs.moip.com.br/blog/pergunta-do-usuario-como-obter-o-token-e-a-chave-de-acesso-da-api-do-moip/

https://labs.moip.com.br/integracao/transparente/
https://labs.moip.com.br/referencia/javascript_de_pagamento/

https://labs.moip.com.br/playground/

---

# Integração junto a gateway de pagamentos (2)

	 "gateway de pagamentos, ou seja, é um sistema web que faz a interconexão entre o seu comércio eletrônico e os sistemas dos principais meios de pagamento"

---

# MeuCheckout BRASPAG®

## Sobre

Uma solução de Checkout simplificada, desenhada para aumentar a conversão de suas vendas

## Dados de contato - MeuCheckout

Suporte <contato@meucheckout.com.br>

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> MeuCheckout BRASPAG® -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Configurar URLs**

URL de Retorno
	https://www.cerebrum.com.br/loja/index.php/telencephalon/payment/meucheckoutredirect/retorno/true/place/dhtml/

URL de Notificação
	https://www.cerebrum.com.br/loja/index.php/telencephalon/payment/meucheckoutnotification/

URL de Mudança de Status
	https://www.cerebrum.com.br/loja/index.php/telencephalon/payment/meucheckoutnotification/status/true/

## Manual

https://meucheckoutsandbox.braspag.com.br/Backoffice/Areas/Merchant/Content/documents/MeuCheckout%20-%20Procedimentos%20para%20Afilia%C3%A7%C3%A3o%20dos%20Meios%20de%20Pagamento%20v1.0.pdf

https://meucheckoutsandbox.braspag.com.br/Backoffice/Areas/Merchant/Content/documents/MeuCheckout%20-%20Tutorial%20do%20Lojista%20v1.2.pdf

https://meucheckoutsandbox.braspag.com.br/Backoffice/Areas/Merchant/Content/documents/MeuCheckout%20-%20Manual%20do%20desenvolvedor%20v1.2.pdf

---

# Pagador BRASPAG®

## Sobre

Braspag | Líder em Pagamento Digital Online para e-Commerce

## Dados de contato - Braspag

implantacao.operacoes@braspag.com.br

Rodrigo Santos
rsantos@braspag.com.br
(11) 3320-9050 - Ramal 5

Rodolfo de Lucena
rmoreira@braspag.com.br
(11) 3320-9058

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Braspag -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Configurações no sistema do Pagador BRASPAG®**

Deve ser informado a seguinte URL para Braspag que será usada para a mudança de status do pedido

	https://www.cerebrum.com.br/loja/index.php/telencephalon/payment/pagadornotification/

## Manual

http://www.youblisher.com/p/768847-Braspag-Pagador-Transaction-Autorizacao-Captura-Cancelamento-e-Estorno-v1-9-7/
http://www.youblisher.com/p/840410-Manual-de-Integracao-Pagador-Transaction-Autorizacao-Captura-Cancelamento-e-Estorno-v1-9-9-1/
http://www.youblisher.com/p/840416-Manual-de-Integracao-Pagador-Integracao-Post-v1-9-9-1/

---

# MercadoPago

## Sobre

Use a solução de pagamentos do MercadoLivre para as suas vendas no seu site, redes sociais, aplicativos para celulares e mais.

## Dados de contato - MercadoPago

crm.ml@mercadolivre.com
(11) 4153-7153

integradores@mercadopago.com.br

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> MercadoPago -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Como obter o (CLIENT_ID e CLIENT_SECRET)**

Get your CLIENT_ID and CLIENT_SECRET in the following address:

    Argentina: https://www.mercadopago.com/mla/herramientas/aplicaciones
    Mexico: https://www.mercadopago.com/mlm/herramientas/aplicaciones
    Brazil: https://www.mercadopago.com/mlb/ferramentas/aplicacoes
    Venezuela: https://www.mercadopago.com/mlv/herramientas/aplicaciones

## Manual

https://www.mercadopago.com.br/
http://developers.mercadopago.com/

---

# Somente geração de boleto bancário (8)

---

# Boleto Bancário - Banco do Brasil

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco do Brasil -> Preencha os campos solicitados

---

# Boleto Bancário - Banco Bradesco

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Bradesco -> Preencha os campos solicitados

---

# Boleto Bancário - Banco Itaú

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Itaú -> Preencha os campos solicitados

---

# Boleto Bancário - Banco Santander-Banespa - (Carteira 102 - Sem registro)

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Santander-Banespa -> Preencha os campos solicitados

---

# Boleto Bancário - Banco Santander-Banespa - (Carteira COB - Sem registro)

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Santander-Banespa -> Preencha os campos solicitados

---

# Boleto Bancário - Banco Caixa Econômica Federal

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Caixa Econômica Federal -> Preencha os campos solicitados

---

# Boleto Bancário - Banco HSBC

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco HSBC -> Preencha os campos solicitados

---

# Boleto Bancário - Bancoob

## Sobre

Entre em contato com o gerente responsável pela conta corrente de sua empresa.

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de pagamento -> Boleto Bancário - Banco Real -> Preencha os campos solicitados

---

# Métodos de checagem de fraude (3)

---

# FControl

## Sobre

FCONTROL - SOLUÇÕES EM GERENCIAMENTO DE RISCOS 

A FControl é a solução definitiva para a detecção de fraudes em vendas pela Internet. 

90% das lojas quebram devido às fraudes. 

O crescimento do comércio eletrônico tornou imperativa a necessidade de lojistas se protegerem contra os riscos de venda com cartão pela Internet. A FControl é a solução definitiva para a administração e detecção de fraudes em vendas pela Internet e Televendas. 

A FControl é um sofisticado sistema que utiliza redes neurais e inteligência artificial para detectar fraudes em tempo real. 

Entenda como milhares de lojistas virtuais estão utilizando o FControl para: 
	Detectar fraudes em tempo real
	Reduzir perdas financeiras
	Reduzir investimentos com equipes de análise de fraudes
	Proteger seus bons clientes
	Aumentar o reconhecimento de sua marca 

FCONTROL é uma empresa do GRUPO BUSCAPÉ: http://www.fcontrol.com.br

O FControl é uma solução para administração e detecção de fraudes em vendas pela Internet e Televendas. O FControl é um sistema que utiliza redes neurais e inteligência artificial para detectar fraudes em tempo real.

O FControl funciona de forma integrada ao sistema de gerenciamento de pedidos, analisando automaticamente os seus pedidos com cartão de crédito;  
O FControl indica, de maneira direta e clara, o grau de risco das mesmas bem como uma lista de justificativas e informações gerenciais sobre o pedido;  
Para os pedidos de risco médio ou alto, o FControl incorpora verificação de dados cadastrais, com consulta a banco de dados externos e auxilia no eventual contato com o cliente (consulta de CPF, telefone e endereço);  
Todas as regras do FControl podem ser ajustadas dinamicamente de forma a representar com precisão o modelo de negócio de cada cliente. Além disso, os modelos estatísticos e a rede neural aprendem constantemente com as transações e melhoram continuamente a precisão da análise;

## Benefícios do Sistema

- Aumento da confiança nas transações de compra não presenciais;
- Diminuição na revisão manual de pedidos;
- Redução do nível de fraude;
- Redução de rejeição de pedidos válidos;
- Redução da perda de lucratividade, devido diminuição de atrito com bons clientes;
- Regras e normas de analise de risco automatizadas;
- Aumento do desempenho da equipe do departamento de prevenção a fraude.

## Dados de contato - FControl

Mirian Ferracini  
Suporte Técnico  
FControl  
mirian@fcontrol.com.br  
Tel: +55 11 3848 8743  
Fax: +55 11 3848-8716  
Skype: mirian.ferracini

## AFILIAÇÃO - FControl

http://www.fcontrol.com.br/experimente.aspx

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de anti-fraude -> FControl -> Preencha os campos solicitados

## Processo de homologação

Acesse na Fcontrol -> Modo de Homologação -> Ativar Modo de Homologação -> Atualizar  
Na configuração do módulo informe para o parâmetro "Ambiente de Teste" = Sim  
No Backend do Magento, acessei qualquer pedido  
No iframe da Fcontrol deve ser exibido o selo da Fcontrol, clique no mesmo, deve ser aberto a janela na Fcontrol informando "Pedido de teste homologado com sucesso."  

Acesse na Fcontrol -> Modo de Homologação -> Desativar Modo de Homologação -> Atualizar  
Na configuração do módulo informe para o parâmetro "Ambiente de Teste" = Não  
No Backend do Magento, acessei qualquer pedido para visualizar o processo de integração junto a Fcontrol

## Manual

https://www.fcontrol.com.br/manuaisfcontrol/integracao/index.aspx

	Modelo de Exibição do Risco na própria tela de fechamento do Pedido - FRAME

---

# Clearsale

## Sobre

CLEARSALE - SOLUÇÕES EM GESTÃO DE RISCO DE FRAUDE E CRÉDITO

A ClearSale iniciou suas atividades em 2001, desenvolvendo a solução de gestão de risco para o e-commerce do Submarino. Em 2004, passou a gerenciar o risco da Americanas.com, maior varejista do mercado virtual brasileiro.

Em 11 anos de atuação, a ClearSale se tornou o principal player do mercado brasileiro de internet especializado na detecção de fraude e na minimização de risco em vendas não-presenciais. Hoje, a ClearSale é a empresa líder no mercado, com atuação sobre 70% do e-commerce nacional.

A ClearSale inovou na forma como trata a integração TI, Inteligência Estatística e Pessoas através da utilização de modelos de comportamento humano e de equilíbrio financeiro, entregando os melhores resultados em aprovação de pedidos e redução de fraude.

A empresa demonstrou excelência na construção de soluções específicas para Telefonia Celular (segmento mais arriscado), Magazine (operação crítica devido a concorrência no segmento) e Transporte Aéreo.

Soluções específicas para cada tipo de negócio: pequeno, médio e grande - de score gratuito (para iniciantes) à gestão completa.

Saiba mais: http://www.clearsale.com.br/

---

# Clearsale Start

## Sobre


## Dados de contato DA CLEARSALE

Danilo Camargo  
Departamento Comercial  
danilo.camargo@clearsale.com.br  
Tel.: + 55 11 3728-8788 Ramal 1351  
Cel.: + 55 11 8750-5764  
http://www.clearsale.com.br/

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de anti-fraude -> Clearsale Start -> Preencha os campos solicitados

## Perguntas mais frequentes "FAQ"

**Como visualizo as informações postadas a Clearsale**

Na visualização do pedido é exibido iframe onde é carregado o processo Clearsale Start

Visualize no código-fonte da página o formulário de envio a Clearsale

Para exibir código-fonte clique com o botão direito do mouse e escolha "Exibir código fonte" no firefox as teclas de atalhos "Ctrl+U"

## Manual

---

# T-Clearsale

## Sobre

Esse produto atende a opção T-ClearSale, TG-ClearSale, A-ClearSale.  

O mesmo método funciona para os 3 serviços ClearSale ( Total, Total Garantido e Aplicação)

Saiba mais - http://portal.clearsale.com.br/total/

## Dados de contato DA CLEARSALE

http://www.clearsale.com.br/

Tel.: + 55 11 3728-8788 Ramal 1351
Cel.: + 55 11 8750-5764

Danilo Camargo - Departamento Comercial | ClearSale <danilo.camargo@clearsale.com.br>  
Integração | ClearSale <integracao@clearsale.com.br>  
Indira Santos | ClearSale <indira.santos@clearsale.com.br>

## Configurando o produto

No Backend do Magento, acesse o menu: Sistema -> Configuração -> Cerebrum -> Métodos de anti-fraude -> T-Clearsale -> Preencha os campos solicitados

## Processo de Homologação

No Frontend, efetue a geração de 10 novos pedidos, na finalização de cada pedido efetue o logout da conta e repita novamente o processo de geração do novo pedido e nova conta.  
Obs. No formulário de cadastro, segure a tecla "Shift" em seguido de um "Duplo click" sobre o campo "Cidade", dessa forma deve ser auto-preenchido o formulário de cadastro com dados ficticios.  
Se possível utilize o máximo de browsers simultâneo para agilizar o processo da criação dos pedidos.

No Backend na grade de dados de pedidos deve ser exibido a coluna "session_id" com o seu devido registro  
Ao selecionar o(s) pedido(s) é possível disparar o processo para a "checagem de fraude"  
Sendo exibido o retorno da ClearSale  
Em seguida envie e-mail para o setor de integrações da ClearSale para que seja realizado a validação dos pedidos enviados
Caso não seja exibido o retorno da ClearSale, informe para que seja feita analise da ocorrência  

O parâmetro "Prazo de Entrega" deve ser enviado a ClearSale, caso no método de entrega houver o registro do prazo  
Os parâmetros para "Dados do Cartão" deve ser enviado caso o método de pagamento armazene o número do cartão de crédito e suas demais informações no padrão da plataforma Magento como é o caso do método nativo "Cartão de crédito salvo"

## Perguntas mais frequentes "FAQ"

**Como está definido o fluxo do programa "T-ClearSale" no módulo "Cerebrum_Telencephalon" ?**

O módulo está seguindo as definições presente no "Manual de Integração ClearSale v3.1"  
Nessa versão do "Manual de Integração" vemos que é solicitado o "session_id" do usuário que deve estar relacionado ao pedido  
O módulo aplica o suporte ao BD do Magento para armazenar o novo parâmetro "session_id" que deve ser relacionado ao pedido

:: No Frontend

No "checkout" foi adicionado o bloco de código HTML "tags de profiling ClearSale" que está sendo passado como parâmetro o "session_id" do usuário

:: No Backend

Na grade de dados de pedidos é exibido a coluna "session_id"  
Ao selecionar o(s) pedido(s) é possível disparar o processo para a "checagem de fraude"

**Analise de erro: "Debug"**

Quando for exibido a página contendo a mensagem "Server Error" se trata do ambiente da Clearsale, portanto está sendo postado os dados para a Clearsale, onde a Clearsale deve efetuar analise do erro para então aplicar a devida correção

Para analise da ocorrência:

No Backend do Magento, acesse o menu: Telencephalon -> Logs -> Telencephalon, acesse o registro "Requisição para Clearsale - SendOrders - " onde será apresentado dados como EntityCode e XML

Pode ser feito o teste sobre a URL abaixo, preenchendo com as informações do Debug os parâmetros solicitados
 
http://homologacao.clearsale.com.br/integracaov2/service.asmx?op=SendOrders

Copie o conteúdo do Debug para um arquivo de texto e envie para o suporte da Clearsale analisar

## Manual

http://www.youblisher.com/p/561945-Manual-de-integracao-T-Clearsale/
http://www.youblisher.com/p/743806-Manual-Integracao-T-ClearSale-v3-1/

---

# Métodos para geração de XML Sitemap "usado nos mecanismos de pesquisa e comparadores de preços" (3)

---

# Comparadores de preço "Buscapé"

## Sobre

http://www.buscape.com.br/

## Criando e gerando o XML sitemap no Magento

Crie uma pasta sitemap na raiz do projeto Magento

No Backend do Magento, acesse o menu: Telencephalon -> Sitemap -> clique em Criar Sitemap, preencha os campos em seguida clique no botão "Salvar e Gerar"

	Tipo de Mapa do Site = Buscape
	Nome do Arquivo = buscape
	Caminho do Diretório = sitemap
	Visão = Escolha a equivalente a seu projeto

Em seguida deve ser criado o XML sitemap

## Informando o XML sitemap ao comparador

Acesse sua conta Buscapé Company em: https://negocios.buscapecompany.com.

Ao entrar no painel, role a página para baixo e encontrará a aba "Campanhas de Busca", na parte inferior clique em "Pausar/ Reativar Campanhas".

Você será redirecionado para uma nova janela, clique na aba "opções de captura" e em seguida em "Captura automática", leia os termos atentamente antes de concordar.

Abra a página de seu magento e copie o endereço da coluna "link" (algo como: http://www.SuaLoja.com.br/sitemap/buscape.xml ).

Cole o link da URL do XML sitemap no campo "URL do seu XML"

## Manual

http://developer.buscape.com/ferramentas/2870/
http://developer.buscape.com/wp-content/uploads/2013/07/Buscap%C3%A9-Manual-de-Integra%C3%A7%C3%A3o-XML.pdf

---

# Comparadores de preço "QueBarato!"

## Sobre

http://www.quebarato.com.br/

## Informando o XML sitemap ao comparador

???

---

# Comparadores de preço "Zoom"

## Sobre

http://www.zoom.com.br

## Informando o XML sitemap ao comparador

Envie o link do XML sitemap para o e-mail "reinaldo.carvalho@zoom.com.br" solicitando que seja configurado o XML sitemap da loja virtual ao serviço comparador de preços "Zoom"

---

# Ferramentas (3)

---

# Download & Extrai para você

Utilize essa ferramenta também para fazer download do módulo Cerebrum_Telencephalon e atualizar em seu projeto.

## Perguntas mais frequentes "FAQ"

**Como obtenho a ultima versão do módulo Cerebrum_Telecenphalon**

No backend do Magento em notificações, deve ser informado sobre cada nova versão do módulo Cerebrum_Telencephalon

Sugiro utilizar módulos atualizados pois os mesmos sempre contem melhorias e correções

Foi disponibilizado as seguintes versão do módulo "Cerebrum_Telencephalon" atualizado, deve ser instalado o pacote compatível com a versão do seu PHP

https://dl.dropboxusercontent.com/u/4109497/Cerebrum_Telencephalon-0.1.1__16042014__ENCODED_PHP53.zip
https://dl.dropboxusercontent.com/u/4109497/Cerebrum_Telencephalon-0.1.1__16042014__ENCODED_PHP54.zip

Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

No Backend do Magento, acesse o menu: Telencephalon -> Ferramentas -> Download & Extrai para você -> Preencha o campo solicitado, informando a URL do módulo compatível com a versão do seu PHP, o caminho do projeto Magento é preenchido de forma automática em seguida clique no botão para atualizar.

Atualize a página e verifique a informação "Data Hora da versão do módulo" se coincide com a data do módulo correspondente.

Na eventualidade de não funcionar em seu servidor de hospedagem o processo de atualização automatizada, bastará efetivar download do pacote e efetivar a atualização via FTP.

**Como atualizo o módulo Cerebrum_Telecenphalon usando a ferramenta "Download & Extrai para você" ou via FTP**

1. 
Para segurança do seu projeto, recomendo efetuar o backup dos arquivos e banco de dados
O script a seguir é um modelo para a execução do procedimento de backup a ser executado no terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' | gzip > EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).sql.gz

	tar -cvpzf EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).tgz /DIRETORIO

2. 
Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

3. 
No Backend do Magento, acesse o menu: Telencephalon -> Ferramentas -> Download & Extrai para você -> Preencha o campo solicitado, informando a URL do módulo compatível com a versão do seu PHP, o caminho do projeto Magento é preenchido de forma automática em seguida clique no botão para atualizar.

4. 
No Backend do Magento, acesse o menu: Telencephalon -> Ferramentas -> Verifique a informação "Data Hora da versão do módulo" se coincide com a data do módulo correspondente.

5. 
Caso venha a efetuar o Upload dos arquivos via FTP
	Antes de efetuar o Upload dos arquivos
		Configure no seu cliente de FTP o tipo de transferências padrão para binário.
			Dica: No FileZilla acesse o menu: Editar -> Configuraçoes -> Transferências -> Tipos de arquivo
	Em seguida efetue Upload dos arquivos

# Seo Report

Utilize essa ferramenta para pesquisa sobre o seu DNS.

# checkList

Essa ferramenta deve exibir diversas informações sobre o projeto, inclusive possível conflito entre módulos.

# Indicadores gráficos

Utilize essa ferramenta para pesquisa sobre sobre os indicadores gráficos presente nesse módulo.


============

---

# Diversos

## Perguntas mais frequentes "FAQ"

### Ativando os Debug do Magento

Acesse o sistema administrativo -> Sistema -> Configuração -> Desenvolvedor

Quando você estiver na página de configuração, escolha a loja que você está trabalhando em cima à esquerda, usando o “Escopo da Configuração Atual:(Current Configuration Scope)”.

No sistema administrativo -> Sistema -> Configuração -> Desenvolvedor -> Debugar -> Exibir Caminho das Telas = Sim

Dessa forma no frontend deve ser exibido os caminhos de cada bloco carregado no template

### Erros do Magento

O arquivo do erro no Magento é armazenado em /var/report/

No arquivo é apontado o motivo da ocorrência

### Ativando os Logs do Magento

Acesse o sistema administrativo -> Sistema -> Configuração -> Desenvolvedor -> Configurações de Log -> Ativado = Sim

No Magento os logs é armazenado em /var/log/

### Efetuando Debug no Magento

Zend_Debug::dump($this->debug());
Zend_Debug::dump($this->getData());
Zend_Debug::dump(get_class($this));
Zend_Debug::dump(get_class_methods(get_class($this)));
Zend_Debug::dump(get_class_vars(get_class($this)));
Zend_Debug::dump(get_declared_classes());

$log_data=$this->getData();
Mage::log("\n".__FILE__." (".__LINE__.")\n".__METHOD__."\n".print_r($log_data,true),null,'cerebrum.log');

### Montagem de ambiente de desenvolvimento: Ubuntu 13.10 -> Zend-Server 6.2 -> Magento 1.8.0.0

No Ubuntu 13.10

Após a instalação do sistema operacional, instale os seguintes programas via terminal

	sudo apt-add-repository ppa:nemh/systemback && sudo apt-get update && sudo apt-get install systemback && sudo apt-get update

	sudo apt-get install mysql-server mysql-client icedtea-7-plugin openjdk-7-jre chromium-browser nautilus-dropbox p7zip-full filezilla keepassx meld curl && sudo apt-get update

Para instalar o Zend-Server 6.2, efetue download em

http://www.zend.com/en/products/server/downloads?src=infobox

Efetue o processo de instalação

	sudo ./install_zs.sh 5.4 nginx

Após o processo de instalação acesse o Zend-Server e conclua o processo de instalação

	http://localhost:10081/ZendServer

No Backendo do Zend-Server, clique no menu: Welcome -> Clique no botão "Install Demo"

No Backendo do Zend-Server, clique o menu: Configurations -> Components -> Ative o Zend Guard Loader

No Backendo do Zend-Server, clique no menu: Ajuda -> pesquise por "phpmyadmin", siga os passos para instalação
Obs. no passo "Application Details" para o campo "path" informe "phpmyadmin"
Após a finalização voce pode acessar da seguinte forma

	http://localhost/phpmyadmin/

No Backendo do Zend-Server, clique o menu: Applications -> Vitual Hosts -> Add Vitual Host -> 
	Em "Properties" -> "Virtual Host Name", informado "cerebrum.localhost"
	Em "Template" -> Selecione "Edit the virtual host configuration template", informe o seguinte script

De

server {

    listen  ${port};
    root    "${docroot}";
    server_name ${vhost};
    index index.php index.html index.htm;
    
    # include the folder containing the vhost aliases for zend server deployment
    include "${aliasdir}/*.conf";
    
    include fastcgi.conf;
}


Para

server {

	listen  ${port};
	root    "/home/marcio/dados/www";
	server_name ${vhost};
	index index.php index.html index.htm;

	# include the folder containing the vhost aliases for zend server deployment
	include "${aliasdir}/*.conf";

	include fastcgi.conf;



	# FIX: 504 Gateway Time-out
	fastcgi_read_timeout 900;

	## http://www.magentocommerce.com/wiki/1_-_installation_and_configuration/configuring_nginx_for_magento
	# FIX: Magento -> rewrite
	location ~ .php/ { ## Forward paths like /js/index.php/x.js to relevant handler
		rewrite ^(.*.php)/ $1 last;
	}
}

Criado o seguinte arquivo base do novo diretorio

	/home/marcio/dados/www/index.php

Editado o seguinte arquivo para efetuar o apontamento do novo subdominio.localhost

	sudo nano /etc/hosts

adicionado

127.0.0.1       cerebrum.localhost

Acesse

http://cerebrum.localhost/

Deve ser exibido o "phpinfo();", presente no arquivo index.php do novo diretório

Executado a seguinte linha no terminal para criar um projeto Magento

cd /home/marcio/dados/www/;wget http://www.magentocommerce.com/downloads/assets/1.8.0.0/magento-1.8.0.0.tar.gz;tar -zxvf magento-1.8.0.0.tar.gz;mv magento magento-1.8.0.0-dev02;sudo chmod -R o+w /home/marcio/dados/www/magento-1.8.0.0-dev02/media;sudo chmod -R o+w /home/marcio/dados/www/magento-1.8.0.0-dev02/var;sudo chmod o+w /home/marcio/dados/www/magento-1.8.0.0-dev02/app/etc;mysqladmin -u root -p CREATE 'magento-1.8.0.0-dev02';wget http://www.magentocommerce.com/downloads/assets/1.6.1.0/magento-sample-data-1.6.1.0.tar.gz;tar -zxvf magento-sample-data-1.6.1.0.tar.gz;cp -ri magento-sample-data-1.6.1.0/media/* magento-1.8.0.0-dev02/media/;sudo chmod -R o+w /home/marcio/dados/www/magento-1.8.0.0-dev02/media;mysql -h 'localhost' -u 'root' -p 'magento-1.8.0.0-dev02' < 'magento-sample-data-1.6.1.0/magento_sample_data_for_1.6.1.0.sql';

Após a conclusão, acesse:

	http://cerebrum.localhost/magento-1.8.0.0-dev02/

Deve ser iniciado o processo para instalação do Magento, efetue a configuração

Quando exibido o erro

"The URL "http://cerebrum.localhost/magento-1.8.0.0-dev02/" is not accessible. Error parsing body - doesn't seem to be a chunked message"

Selecione a opção "Skip Base URL Validation Before the Next Step" que deve ser possivel avançar o passo e concluiir a instalação do Magento

### Plugins Firefox

Recomendo instalar a(s) seguinte(s) extensões do firefox

	https://addons.mozilla.org/pt-br/firefox/addon/firebug/
	https://addons.mozilla.org/en-US/firefox/addon/qsnap/

### Ocorreu erro na loja ou processo não está se comportando como deveria

Sugiro seguir as orientações abaixo para resolução de ocorrências no Magento

:: PROCESSO RÁPIDO

A intenção é desativar todos os módulos de terceiros até encontar a causa da ocorrência  
A base dos módulos desenvolvidos por terceiros para a plataforma Magento é separado em 2 diretórios "community" e "local"  
Renomeie a seguinte pasta /app/code/community/, dessa forma todos os módulos do ambiente "community" não deve ser carregado no Magento  
Renomeie as pastas abaixo de /app/code/local/, não renomeie a pasta Cerebrum, dessa forma todos os módulos do ambiente "local" não deve ser carregado no Magento, com exceção dos módulos Cerebrum  
Efetue os testes  
Caso o processo venha a funcionar é provável estar ocorrendo conflitos entre módulos, então retorne um diretório de cada vez e efetue teste até encontrar o módulo causador da ocorrência  
Se o processo acima não funcionar tente o "Processo detalhado" abaixo

:: PROCESSO DETALHADO

Sugiro que faça o seguinte.  
Veja qual é a versão do Magento utilizada no desenvolvimento da sua loja virtual.  
Depois baixe essa mesma versão por intermédio do link a seguir, clicando na aba "Release Archives"  
http://www.magentocommerce.com/download  
Monte um ambiente de teste com o MAGENTO "Cru" e instale somente o módulo da Cerebrum e efetue os devidos testes.  
Se apresentar algum problema nos informe para analise da ocorrência.  
Em seguida você pode estar colocando cada módulo de terceiro e testando, dessa forma é possível encontrar a causa do problema  
Sugiro que entre em contato com o seu desenvolvedor para o mesmo efetuar analise e aplicar as devidas correções

:: COMPARÇÔES DE PROJETOS

Com o novo projeto de teste funcionando perfeitamente  
Agora caso queira falta encontrar a causa da ocorrência podendo ser algo em "banco de dados" ou nos "scripts do projeto"

Efetue o backup do banco de dados do projeto que tem a ocorrência do erro e crie um novo banco de dados importando esse backup.  
Configure o projeto de teste para utilizar esse novo banco de dados e efetue os testes, dessa forma é possível saber se a ocorrência está relacionada a algo no "banco de dados" ou nos "scripts do projeto"

Para comparação de scripts eu utilizo a Software Meld

### Sobre o processo de mudança de status ocasionado pelo método de pagamento

Somente os produtos relacionados a "Integração junto a administradora de cartão de crédito (3): que são Redecard, Cielo e AmericanExpress", como é retornado o status da transação, no caso de 'Transação autorizada' é feito a mudança de status do pedido para "Processando"

- Quando é finalizado o pedido o status fica "Pagamento Pendente"
- Quando é iniciado o método de pagamento o status fica "Pendente"
- Quando o pedido é autorizado pela operadora de cartão ou feito a captura é feito a mudança do status para "Processando"
- Após a conferencia do pedido, é sugerido gerar a Fatura, onde o status do pedido deve ser atualizado para "Processando"
- Por ultimo deve ser clicado no botão Entrega onde o status do pedido deve ser atualizado para "Completo"

### Assuntos não relacionado a CEREBRUM

Prestamos suporte somente a assuntos relativos a nossos módulos ou serviço prestado pela CEREBRUM  
Assuntos relativo ao funcionamento da plataforma Magento, sugiro postar a informação nos FÓRUM da Comunidade Magento em http://www.comunidademagento.com.br/forum/  
Assuntos relativo a módulos de terceiros, sugiro entrar em contato com o desenvolvedor do módulo  

### Informações sobre o módulo de compra em 1 passo

A CEREBRUM não comercializa nenhum módulo de compra em 1 passo

Mas recomendamos o uso do módulo gratuito "IWD_OnepageCheckout" 

http://www.magentocommerce.com/magento-connect/one-page-checkout.html

Você pode ver o funcionamento do módulo "IWD_OnepageCheckout" em 

http://demo.iwdextensions.com/opc-ee/furniture/living-room/couch.html

Como o formulário de cadastro do módulo "IWD_OnepageCheckout" é formatado para o mercado norte-americano o uso nativo desse módulo não contempla o preenchimento de endereço pelo CEP, validações e mascara paras os campos

Adquirindo o uso do nosso produto "Clientes" o módulo "Cerbrum_Telencephalon" deve extender algumas funcionalidades sobre o módulo "IWD_OnepageCheckout"


Caso queira instalar o módulo "IWD_Opc" em seu projeto:

Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

No backend do Magento acesse o Magento Connect Manager e informe a seguinte chave referente ao módulo IWD_Opc e inicie o processo de instalação do módulo

http://connect20.magentocommerce.com/community/1213

### Os recursos implementados pelo produto "Clientes" do módulo "Cerbrum_Telencephalon" ao módulo "IWD_OnepageCheckout" são:

* Ativar Suporte aos Formulários
	Com o método ativo, para o formulário de cadastro deve ser aplicado: preenchimento do endereço pelo CEP, máscara, validação, reordenação e suporte a novos campos

* STYLE: IWD_OnepageCheckout
	Com o método ativo, no checkout deve ser exibido nos blocos dos métodos o estilo definido tendo herança a seguinte biblioteca, http://semantic-ui.com/

* FIX: IWD_OnepageCheckout
	Com o método ativo, ao selecionar determinado método de entrega ou de pagamento é feito a atualização dos blocos "Payments e Review" dessa forma deve funcionar a exibição dos Descontos e/ou Juros e valores das parcelas

### O módulo Cerbrum_Telencephalon é compatível com os módulos de /checkout/ de terceiros

Sim é compatível !

Caso queira instale o seguinte módulo "IWD_OnepageCheckout" -> "Free Magento One Step / Page Checkout Extension" em seu projeto

http://www.interiorwebdesign.com/magento/magento-one-step-checkout-module.html
http://www.magentocommerce.com/magento-connect/one-page-checkout.html

A CEREBRUM disponibiliza o arquivo do módulo "IWD_OnepageCheckout" traduzido para o português do brasil

Efetue o download do arquivo

https://dl.dropboxusercontent.com/u/4109497/IWD_OnepageCheckout.csv

e coloque na pasta "/app/locale/pt_BR" do seu projeto Magento

:::::::::::::::::: Dicas ::::::::::::::::::

1. 
Recomendo efetuar o processo em um ambiente de teste, após a comprovação da eficacia do módulo então instalar sobre o ambiente de produção

2. 
Para segurança do seu projeto, recomendo efetuar o backup dos arquivos e banco de dados
O script a seguir é um modelo para a execução do procedimento de backup a ser executado no terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' | gzip > EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).sql.gz

	tar -cvpzf EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).tgz /DIRETORIO

3. 
Antes de efetuar qualquer processo que envolva atualização sobre o Magento é recomendado manter o Compiler e Cache desativado

4. 
Geralmente o processo de "Instalação / Atualização" de módulos para Magento consiste em mesclar as pastas do módulo ao Magento  
Mesmo assim recomendo seguir o processo de "Instalação / Atualização" do desenvolvedor do módulo

### Sobre transação não aprovada

Verifique no Manual de integração o motivo da ocorrência do erro

Caso o motivo da ocorrência não esteja no Manual, efetue o procedimento a seguir

Quando há o retorno da operadora de "transação não aprovada" o cliente deve entrar em contato com o banco emissor do cartão para informações da ocorrência, pode ser necessário entrar em contato com a operadora de cartão para informações da ocorrência

### Erros comuns

**Fatal error: Exception thrown without a stack frame in Unknown on line**

O erro "Fatal error: Exception thrown without a stack frame in Unknown on line" se trata de um erro intermitente gerado pelo Magento, não tem relação com o módulo da Cerebrum

Se for o caso sugiro pesquisar no google por "Magento Fatal error: Exception thrown without a stack frame in Unknown on line" e verá diversos tópicos relacionado ao erro

Quando é gerado o erro é armazenado no log do Magento o seguinte erro "General error: 2006 MySQL server has gone away"

Que indica que seu Servidor MySQL sofreu queda de conexão por isso o Magento dispara o erro

Creio que os seguintes artigos pode ajudar 

http://mariosam.com.br/magento/sqlstate-mysql/
http://www.cerebrum.com.br/forum/index.php?/topic/217-erro-sqlstate-mysql-nao-responde/

**Configuração não está sendo salva no backend mesmo sendo exibido o retorno "A configuração foi salva."**

No Zend-Server em: Monitor -> Logs, é exibido a ocorrência abaixo

	PHP Warning:  Unknown: Input variables exceeded 1000. To increase the limit change max_input_vars in php.ini. in Unknown on line 0

No Zend-Server em: Server Setup -> Directives -> All -> New / Unrecognized -> Informe para parâmetro "max_input_vars" o valor 2000

**Mage registry key "_singleton/telencephalon/observer" already exists**

Para processos de instalação/atualização é necessário manter o Cache e o Compiler desativado

Pode ser necessário apagar as pastas sob o Magento /var/cache e /var/session

Teve um caso que o arquivo observer estava vazio gerando a ocorrência do erro onde foi feito novamente o upload do módulo

**Problemas com caracteres**

O erro de caracteres é gerado por definição de charset no servidor onde o mesmo deve ser configurado para aceitar qualquer charset

Se você quiser alterar o charset no Apache no Ubuntu tente esse procedimento

	sudo gedit /etc/apache2/conf.d/charset

Em seguida, comente a linha

	#AddDefaultCharset UTF-8

salve e saia do arquivo

Agora você precisa reiniciar o servidor apache usando o seguinte comando

	sudo /etc/init.d/apache2 restart

**exception 'Mage_Core_Exception' with message 'Too late for the schedule**

Se trata de erro comum

Essa ocorrência é disparada quando o processo não é executado no horário agendado

Por exemplo

Existem serviços agendados a ser executado em determinado horário

Por algum motivo o servidor é desligado e o serviço agendado para executar em determinado horário não foi executado

Quando o servidor volta a iniciar e vê que o serviço agendado não foi executado no horário deve ser disparado o erro acima "Tarde demais para executar o processo"

Desconsidere esse tipo de ocorrência pois o servidor estando ativo a mesma não deve ocorrer

**Fatal error: require_once(): Failed opening required**

Aplique a permissão ao diretório para acesso ao recurso

**TypeError: console.groupCollapsed is not a function - semantic.min.js (linha 14)**

No Magento 1.6.x é exibido esse erro de javascript

Edite o arquivo /js/varien/js.js

Comente o seguinte trecho

	if (!("console" in window) || !("firebug" in console))
	{
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml",
		"group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];

		window.console = {};
		for (var i = 0; i < names.length; ++i)
		    window.console[names[i]] = function() {}
	}

Devendo ficar

	/*
	if (!("console" in window) || !("firebug" in console))
	{
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml",
		"group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];

		window.console = {};
		for (var i = 0; i < names.length; ++i)
		    window.console[names[i]] = function() {}
	}
	*/

Obs. no Magento 1.8.x já está comentado este trecho de script

**Fatal error:  Class 'ZipArchive' not found in .../myfile.php on line 0**

O erro informa que o servidor não é capaz de extrair arquivos zip

Entre em contato com o administrador do servidor solicitando a liberação do uso do recurso

**Can not open /DIRETORIO/skin/frontend/base/default/lib/maxmind_geoip/GeoLiteCity.dat**

Verifique se existe o arquivo

Pode ser necessário aplicar permissão de leitura do arquivo

Como um teste rápido você poderia tentar alterar as permissões do arquivos para 777

Exemplo:

	chmod 777 /DIRETORIO/skin/frontend/base/default/lib/maxmind_geoip/GeoLiteCity.dat

Caso exista na pasta somente o arquivo GeoLiteCity.dat.gz é porque não foi possivel extrair o mesmo, nesse caso execute o seguinte comando via terminal

	gunzip GeoLiteCity.dat.gz

**Fatal error: Maximum execution time of 30 seconds exceeded in .../myfile.php on line 0**

Analise o phpinfo em seu servidor veja a configuração do PHP "max_execution_time" se está muito baixa tempo para execução de processos

Sugiro que entre em contato com o administrador do servidor para alterar o "max_execution_time" para no minimo 300 que equivale a 5 minutos

**Fatal error: Incompatible file format: The encoded file has format major ID 4, whereas the Loader expects 5 in .../myfile.php on line 0**

Verifique a versão do PHP utilizada em seu servidor e efetue o upload do módulo para a devida versão do PHP.

**Fatal error: Class 'Zend_Log' not found in .../myfile.php on line 0**

A ausência do arquivo de licença deve ser disparado esse erro

**Fatal error: Unable to read x bytes in .../myfile.php on line 0**

Isto significa que o arquivo foi enviado como texto ASCII.
Configure no seu cliente de FTP o tipo de transferências padrão para binário.
	Dica: No FileZilla acesse o menu: Editar -> Configurações -> Transferências -> Tipos de arquivo
Em seguida efetue upload novamente dos arquivos

**Fatal error: Corrupted encoded data detected in .../myfile.php on line 0**

Isto significa que o arquivo foi enviado como texto ASCII.
Configure no seu cliente de FTP o tipo de transferências padrão para binário.
	Dica: No FileZilla acesse o menu: Editar -> Configurações -> Transferências -> Tipos de arquivo
Em seguida efetue upload novamente dos arquivos

**Fatal error: Call to a member function toOptionArray() on a non-object in /app/code/core/Mage/Adminhtml/Block/System/Config/Form.php on line 463**

Para encontrar a causa da ocorrência

Conforme artigo

http://stackoverflow.com/questions/19574354/fatal-error-call-to-a-member-function-tooptionarray-on-a-non-object-in-mage

Edite o arquivo

	/app/code/core/Mage/Adminhtml/Block/System/Config/Form.php

encontre o seguinte item na linha 463

	$optionArray = $sourceModel->toOptionArray($fieldType == 'multiselect');

e substituía por:

	if(is_object($sourceModel)){
		$optionArray = $sourceModel->toOptionArray($fieldType == 'multiselect');
	} else {
		Mage::log($e->source_model);
	}

Veja no log do Magento o motivo da ocorrência em /var/log/

**IWD_OnepageCheckout com problemas nas colunas, não sendo exibidos lado a lado e sim uma abaixo da outra**

Aplique no CSS do template 

.col3-set .col-1 { float:left; width:32%; }
.col3-set .col-2 { float:left; width:32%; margin-left:2%; }
.col3-set .col-3 { float:right; width:32%; }

**Atualizar IWD_OnepageCheckout antigo pela nova versão IWD_Opc disponibilizada no Magento Connect**

Sugiro instalar a nova versão do módulo IWD_OnepageCheckout que se trata da versão: 3.1.3

http://www.magentocommerce.com/magento-connect/one-page-checkout.html

Para projeto que tenha o IWD_OnepageCheckout que não foi instalado pelo Magento Connect Manager será necessário desativar o módulo antigo, para isso renomeie as seguintes pastas e arquivos:

/app/code/local/IWD/
/app/design/frontend/base/default/layout/onepagecheckout.xml
/app/design/frontend/base/default/template/onepagecheckout/
/app/etc/modules/IWD_OnepageCheckout.xml
/app/locale/en_US/IWD_OnepageCheckout.csv
/app/locale/ru_RU/IWD_OnepageCheckout.csv
/app/locale/de_DE/IWD_OnepageCheckout.csv
/app/locale/nl_NL/IWD_OnepageCheckout.csv
/app/locale/es_ES/IWD_OnepageCheckout.csv
/lib/MaxMind/
/skin/frontend/base/default/css/onepagecheckout.css
/skin/frontend/base/default/images/onepagecheckout/

Em seguida no backend do Magento acesse o Magento Connect Manager e informe a seguinte chave referente ao módulo IWD_Opc e inicie o processo de instalação do módulo

http://connect20.magentocommerce.com/community/1213

**Regra de descontos e exibição dos valores das parcelas**

++ OCORRÊNCIA

Considerando uma regra promocional que o cliente ganha 10% de desconto nas compras acima de R$79,00 se pagar com determinado método de pagamento.

Se o cliente escolher 1 produto no valor de R$ 100,00 e escolher o método de pagamento contendo o desconto, o total do carrinho é de R$ 90,00.

O erro acontece nesses passos:

- Cliente adiciona item no carrinho (R$ 100,00);
- Cliente clica em fechar o pedido
- Cliente seleciona a forma de pagamento contendo o desconto
- Na tela de confirmação do pedido ele não confirma, ele clica para voltar na tela do carrinho (Apareceu R$ 90,00, está correto)
- Cliente clica novamente em fechar o pedido
- Agora o cliente seleciona outro método de pagamento que tenha a regra de desconto e que na seleção do método seja exibido o valor total do pedido, vemos que o valor total exibido no método de pagamento é exibido o valor com desconto

- Obs. avançando o processo para o passo "Confirmar pedido" e retornando para o passo "Escolha de frete", como já foi armazenado o método de pagamento escolhido e o mesmo não tem o desconto ao prosseguir com processo vemos que a ocorrência não deve ocorrer

++ SOLUÇÃO 1

Quando é carregado novamente a pagina como já está armazenado o desconto e previamente o método de pagamento do desconto, também o subtotal já está constando com o desconto visando essa ação

A exibição dos valores das parcelas é exibido com base no subtotal por isso do motivo da ocorrência

Você pode atualizar no arquivo de tradução do seu template para não exibir os valores variável das parcelas

Para isso informe no arquivo de tradução do seu template os seguintes itens

"1 x %s (Credit View) (No Interest)","1 x %n (à Vista) (Sem Juros)"
"%s x %s (Instalment Credit Shop) (No Interest) (%s)","%s x %n (Parcelado Loja) (Sem Juros)"
"%s x %s (Instalment Credit Shop) (With Interest) (Establishment %s a.m.) (%s) (%s)","%s x %n (Parcelado Loja) (Com Juros) (Estabelecimento %n a.m.) (%s)"
"%s x %s (Instalment Credit Shop) (With Interest) (Establishment %s a.m.) (%s) (%s) (%s)","%s x %n (Parcelado Loja) (Com Juros) (Estabelecimento %n a.m.) (%s)"

**Criando projeto de testes baseado no projeto original**

1. 
Para segurança do seu projeto, recomendo efetuar o backup dos arquivos e banco de dados
O script a seguir é um modelo para a execução do procedimento de backup a ser executado no terminal do servidor

	mysqldump -h 'HOST' -u 'USER' -p'PASS' 'DBNAME' | gzip > EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).sql.gz

	tar -cvpzf EMPRESA_$(date +%Y.%m.%d_%H.%M.%S).tgz /DIRETORIO

2. 
Recomendo não colocar o projeto do Magento direto na raiz da sua conta e sim criar uma pasta magento e centralizar o projeto nessa pasta

Caso o seu projeto magento esteja na pasta raiz da sua conta, via FTP crie uma pasta chamada magento e arraste somente as pastas do projeto Magento para essa nova pasta

Copie o arquivo .htaccess e index.php da nova pasta magento e coloque na raiz da conta

Crie os seguintes links simbolicos

ln -s /DIRETORIO/magento/app;
ln -s /DIRETORIO/magento/includes;
ln -s /DIRETORIO/magento/js;
ln -s /DIRETORIO/magento/media;
ln -s /DIRETORIO/magento/skin;
ln -s /DIRETORIO/magento/var;

Dessa forma já deve funcionar o seu projeto com a pasta magento centralizando o seu projeto

3.
Para copiar a sua pasta do projeto magento para uma nova pasta, execute o seguinte comando no terminal para efetuar a copia da pasta

cp -r magento magento_copia;

4.
Como já foi feito o backup do banco de dados e suponho que já foi feito a criação e importação para um novo banco de dados, será necessário alterar para o projeto "magento_copia" os novos dados do banco de dados e em seguida a URL do novo projeto:

Para alterar os dados do banco de dados, edite o arquivo /magento_copia/app/etc/local.xml, e atualize os dados do novo banco de dados, salve o arquivo e efetue upload

Para alterar URL do novo projeto, acesse o banco de dados via phpmyadmin, acesse a tabela "core_config_data" e atualize os registros: "web/unsecure/base_url" e "web/secure/base_url", informando no campo value a nova URL do projeto

Em seguida acesse o novo projeto

**Porque o meu website está lento**

Com o módulo da Cerebrum ativo, acesse o seguinte serviço e informe a URL do seu projeto

http://gtmetrix.com/

ou

http://www.webpagetest.org/

Desative o módulo da Cerebrum, acesse o serviço de testes e veja o comparativo do tempo de carregamento

Pelo módulo da Cerebrum é carregado algumas bibliotecas de terceiros que podem aumentar em 1 segundo ou menos o tempo de carregamento da pagina

**Falhas no módulo IWD_Opc**

Recentemente o desenvolvedor do módulo IWD fez algumas mudanças drásticas no módulo antes o módulo se chama IWD_OnepageCheckout e após a versão 2.2.21 o módulo começou a se chamar IWD_Opc onde foi feito diversas alterações tanto no visual como funcionamento

Vejo que essa nova versão do módulo IWD_Opc conflita com o seu template

Sugiro ou adequar o seu template para funcionar em conjunto com o módulo

Ou ao invés suar o módulo IWD_Opc versão 3.0.5

Usar o módulo IWD_OnepageCheckout 2.2.21

**Sobre o módulo OSC Brasil**

http://onestepcheckout.com.br/

Eu não recomendo o uso do módulo DeivisonArthur_OnepageCheckout, pois além do mesmo ser baseado em uma versão defasado no módulo IWD_OnePagCheckout o mesmo usa um procedimento que não recomendo que seria separar o número do endereço

No post a seguir tem informação sobre um procedimento que não recomendo 
http://www.cerebrum.com.br/forum/index.php?/topic/986-separar-numero-do-endereco/

Usando esse módulo não deve funcionar corretamente o módulo da ClearSale pois é passado como parâmetro bairro o atributo "street2 do Magento", no uso do módulo DeivisonArthur_OnepageCheckout o atributo "street2" é armazenado o numero do endereço

Efetuando a seguinte adequação no módulo DeivisonArthur_OnepageCheckout deve funcionar a integração junto a ClearSale
 
- Mudar o label Número para Bairro, 
- Mudar o label do Bairro para Complemento ou retirar o campo Bairro que se trata do campo billing:street4, nativo do Magento

### Cartão de testes

AMEX 376488977091001 cvv: 6938 Validade: 12/2011  
MASTERCARD 5555666677778884 cvv: 514 Validade: 12/2015  
DINERS 30111122223331 cvv: 741 Validade: 05/2013  
VISA 4073020000000002 cvv: 478 Validade: 10/2011  
HIPERCARD 3841001111222233334 cvv: 450 Validade: 12/2011
DISCOVER: 6011000990139424
JCB: 3566002020360505
SWITCH/SOLO: 6331101999990016

### Links simbólicos

ln -s /var/www/site/magento/app;
ln -s /var/www/site/magento/includes;
ln -s /var/www/site/magento/js;
ln -s /var/www/site/magento/media;
ln -s /var/www/site/magento/skin;
ln -s /var/www/site/magento/var;
ln -s /var/www/site/magento/sitemap;
ln -s /var/www/site/magento/library;

## Links Uteis

http://xmlbeautifier.com/

---

### Official Markdown project at Daring Fireball - [http://daringfireball.net/projects/markdown/] [markdown]:
