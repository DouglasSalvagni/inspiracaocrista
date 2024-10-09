<?php

require_once(ABSPATH . 'vendor/autoload.php');


class Pdf_Generator
{
    private $pdf;

    public function __construct()
    {
        // Cria uma instância da classe TCPDF
        $this->pdf = new TCPDF();

        // Configurações do PDF
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Sua Empresa');
        $this->pdf->SetTitle('Documento do Plano');
        $this->pdf->SetSubject('Assunto do Documento');
        $this->pdf->SetKeywords('PDF, plano, cliente');

        // Remove o cabeçalho e rodapé padrão
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        // Define as margens
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    }

    public function generatePDF($htmlContent, $file_name = null)
    {
        // Obtém o diretório de uploads do WordPress
        $upload_dir = wp_upload_dir();
        $base_dir = $upload_dir['basedir'];
        $contratos_dir = $base_dir . '/contratos';

        // Verifica se a pasta 'contratos' existe, e cria se não existir
        if (!file_exists($contratos_dir)) {
            wp_mkdir_p($contratos_dir);
        }

        if($file_name) {
            $file_name =  $file_name . '.pdf';
        } else {
            // Gera um nome único para o arquivo PDF
            $file_name = 'contrato-' . uniqid() . '.pdf';
        }
        
        // Caminho completo para o arquivo PDF
        $pdfPath = $contratos_dir . '/' . $file_name;

        // Adiciona uma página
        $this->pdf->AddPage();

        // Define a fonte
        $this->pdf->SetFont('helvetica', '', 12);

        // Escreve o conteúdo HTML no PDF
        $this->pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Salva o PDF no caminho especificado
        $this->pdf->Output($pdfPath, 'F'); // 'F' salva no caminho especificado

        // Retorna o caminho completo do PDF gerado
        return $pdfPath;
    }

    public function sendEmailWithPDF($to, $subject, $body, $pdfPath)
    {
        // Headers para e-mail com anexo
        $headers = "From: suporte@wizer.digital\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        // Corpo da mensagem
        $message = "--boundary\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $message .= $body . "\r\n";

        // Anexo do PDF
        $fileContent = chunk_split(base64_encode(file_get_contents($pdfPath)));
        $message .= "--boundary\r\n";
        $message .= "Content-Type: application/pdf; name=\"documento.pdf\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"documento.pdf\"\r\n\r\n";
        $message .= $fileContent . "\r\n";
        $message .= "--boundary--";

        // Envio do e-mail
        mail($to, $subject, $message, $headers);
    }
    

    public function disparar_webhook_personalizado($package) {
        // URL do Webhook
        $url = 'https://n8n-webhook.wizer.digital/webhook/f78d443f-dea8-45bf-a5d7-b5662c6de342';
    
        // Dados que serão enviados no corpo da requisição
        $body = array(
            'event'        => 'adesao',
            'Nome'        => $package['name'],
            'CPF'         => $package['cpfCnpj'], 
            'Telefone'    => $package['phone'], 
            'Email'       => $package['email'],
            'nomeArquivo' => $package['file_name'],
            'pathArquivo' => $package['path'],
        );
    
        // Opções da requisição, incluindo o corpo e headers (caso necessário)
        $args = array(
            'body'    => wp_json_encode($body),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'method'  => 'POST',
        );
    
        // Executa a requisição POST
        $response = wp_remote_post($url, $args);
    
        // Verifica se a requisição foi bem-sucedida
        if (is_wp_error($response)) {
            // Tratamento de erro
            $error_message = $response->get_error_message();
            error_log("Erro ao disparar webhook: $error_message");
        } else {
            // Sucesso
            error_log("Webhook disparado com sucesso: " . wp_remote_retrieve_body($response));
        }
    }

    public function disparar_webhook_geral($package, $event = 'default_event') {
        // URL do Webhook
        $url = 'https://n8n-webhook.wizer.digital/webhook/f78d443f-dea8-45bf-a5d7-b5662c6de342';
    
        // Adiciona o evento ao pacote
        $package['event'] = $event;
    
        // Opções da requisição, incluindo o corpo e headers (caso necessário)
        $args = array(
            'body'    => wp_json_encode($package),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'method'  => 'POST',
        );
    
        // Executa a requisição POST
        $response = wp_remote_post($url, $args);
    
        // Verifica se a requisição foi bem-sucedida
        if (is_wp_error($response)) {
            // Tratamento de erro
            $error_message = $response->get_error_message();
            error_log("Erro ao disparar webhook: $error_message");
        } else {
            // Sucesso
            error_log("Webhook disparado com sucesso: " . wp_remote_retrieve_body($response));
        }
    }
    
}

// Exemplo de uso
// $htmlContent = "<h1>Obrigado por adquirir nosso plano!</h1><p>Seu plano foi ativado com sucesso.</p>";
// $pdfGenerator = new Pdf_Generator();
// $pdfPath = $pdfGenerator->generatePDF($htmlContent);

// Enviar o e-mail com o PDF
// $pdfGenerator->sendEmailWithPDF('douglassalvagni@gmail.com', 'Confirmação de Plano', 'Segue em anexo o seu documento.', $pdfPath);
