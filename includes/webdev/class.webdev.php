<?php
    class TFPCFG {
        public $tfp_assets_dir = "assets/";
        public $tfp_url = "";
        public $tfp_css_padrao = array(); // Arquivos CSS padrão
        public $tfp_js_padrao  = array(); // Arquivos JS padrão

        private $tfp_css_resultado = "";
        private $tfp_js_resultado  = "";

        /**
         * Minifica e retorna o CSS para ser inserido no <head>
         * @param array|null $tfp_arquivos Arquivos CSS adicionais (sem .css)
         * @return string
         */
        public function tfpCssMinify($tfp_arquivos = null)
        {
            $tfp_diretorio_base = $this->tfp_assets_dir . "css/";
            $this->tfp_css_resultado = "";

            // CSS padrão
            foreach ($this->tfp_css_padrao as $tfp_arquivo) {
                $tfp_caminho = $tfp_diretorio_base . $tfp_arquivo . ".css";
                if (is_file($tfp_caminho)) {
                    $this->tfp_css_resultado .= $this->tfpCarregaArquivo($tfp_caminho);
                }
            }

            // CSS específico da página
            if (!empty($tfp_arquivos)) {
                foreach ($tfp_arquivos as $tfp_arquivo) {
                    $tfp_caminho = $tfp_diretorio_base . $tfp_arquivo . ".css";
                    if (is_file($tfp_caminho)) {
                        $this->tfp_css_resultado .= $this->tfpCarregaArquivo($tfp_caminho);
                    }
                }
            }

            // Minificação CSS
            $css = $this->tfp_css_resultado;
            $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css); // remove comentários
            $css = str_replace(["\r", "\n", "\t"], '', $css);               // remove quebras/abas
            $css = preg_replace('/\s+/', ' ', $css);                        // reduz espaços
            $css = str_replace(['{ ', ' }', '; '], ['{', '}', ';'], $css);  // compacta

            return $css;
        }

        /**
         * Minifica e retorna o JS para ser inserido antes de </body>
         * @param array|null $tfp_arquivos Arquivos JS adicionais (sem .js)
         * @return string
         */
        public function tfpJsMinify($tfp_arquivos = null)
        {
            $tfp_diretorio_base = $this->tfp_assets_dir . "js/";
            $this->tfp_js_resultado = "";

            // JS padrão
            foreach ($this->tfp_js_padrao as $tfp_arquivo) {
                $tfp_caminho = $tfp_diretorio_base . $tfp_arquivo . ".js";
                if (is_file($tfp_caminho)) {
                    $this->tfp_js_resultado .= $this->tfpCarregaArquivo($tfp_caminho);
                }
            }

            // JS específico da página
            if (!empty($tfp_arquivos)) {
                foreach ($tfp_arquivos as $tfp_arquivo) {
                    $tfp_caminho = $tfp_diretorio_base . $tfp_arquivo . ".js";
                    if (is_file($tfp_caminho)) {
                        $this->tfp_js_resultado .= $this->tfpCarregaArquivo($tfp_caminho);
                    }
                }
            }

            // Minificação JS
            $js = $this->tfp_js_resultado;
            $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js); // remove comentários
            $js = preg_replace('/\s+/', ' ', $js);                        // remove espaços extras

            return $js;
        }

        /**
         * Carrega conteúdo bruto de um arquivo
         * @param string $tfp_caminho Caminho local do arquivo
         * @return string
         */
        public function tfpCarregaArquivo($tfp_caminho)
        {
            return file_exists($tfp_caminho) ? file_get_contents($tfp_caminho) : '';
        }

        /**
         * Imprime inline os scripts JS a partir do array informado,
         * lendo arquivos dentro de assets/js/
         * Cada arquivo deve ser passado sem a extensão .js, pode conter subpastas (ex: "customJS/slick_nav")
         * @param array $arquivos
         * @return void
         */
        public function imprimirScriptsInline(array $arquivos)
        {
            $base_dir = $this->tfp_assets_dir . "js/";

            foreach ($arquivos as $arquivo) {
                $caminho = $base_dir . $arquivo . ".js";
                if (is_file($caminho)) {
                    $conteudo = $this->tfpCarregaArquivo($caminho);
                    echo "<script>{$conteudo}</script>\n";
                }
            }
        }
    }
?>
