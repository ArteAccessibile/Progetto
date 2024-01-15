<?php
class TemplateEngine {
    protected $template;
    protected $data = [];
    protected $blocks = [];
    private $path = "view";

    public function loadTemplate($path) {
        // compose the file path
        $filePath = $this->path . "/" . $path .".html";
        
        if (file_exists($filePath)) {
            $this->template = file_get_contents($filePath);
        } else {
            throw new Exception("Template file not found.");
        }
    }

    public function assign($variable, $value) {
        $this->data[$variable] = $value;
    }

    protected function processLoops($output) {
        if (preg_match_all('/{% foreach (\w+) as (\w+) %}(.*?){% endforeach %}/s', $output, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $loopData = $this->data[$match[1]];
                $loopContent = '';
                foreach ($loopData as $item) {
                    $itemContent = $match[3];
                    foreach ($item as $key => $value) {
                        $itemContent = str_replace('{{' . $match[2] . '->' . $key . '}}', $value, $itemContent);
                    }
                    $loopContent .= $itemContent;
                }
                $output = str_replace($match[0], $loopContent, $output);
            }
        }
    
        return $output;
    }
    

    protected function processBlocks($output) {
        if (preg_match_all('/{% block (\w+) %}/s', $output, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $blockName = $match[1];
                $filePath = "view/" . $blockName . ".htm";
    
                if (file_exists($filePath)) {
                    $blockContent = file_get_contents($filePath);
                } else {
                    $blockContent = "File not found: " . $filePath;
                }
    
                $output = str_replace($match[0], $blockContent, $output);
            }
        }
    
        return $output;
    }

    protected function processIfStatements($output) {
        if (preg_match_all('/{% if (\w+) %}(.*?){% endif %}/s', $output, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $condition = $match[1];
                $condition = $this->data[$condition];
                $condition = $condition ? true : false;
                $conditionContent = $match[2];
    
                if (!$condition) {
                    $conditionContent = '';
                }
    
                $output = str_replace($match[0], $conditionContent, $output);
            }
        }
    
        return $output;
    }
    

    public function render() {
        $output = $this->template;
        $output = $this->processBlocks($output);
        $output = $this->processLoops($output);
        $output = $this->processIfStatements($output);

        foreach ($this->data as $key => $value) {
            if(!is_array($value)){
                $value = htmlspecialchars($value);
                $output = str_replace('{{' . $key . '}}', $value, $output);
            }
        }

        return $output;
    }
}
?>