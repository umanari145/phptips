<?php

(new makeModel('model_source.csv'))->outPutGetterSetter();

class makeModel
{
    private $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function outPutGetterSetter(): void
    {
        $fp = fopen($this->file_path, 'r');
        $index = 0;
        $source = '';
        while ($res = fgetcsv($fp)) {
            if ($index >= 1) {
                $source .= $this->getterTemplate($res[0], $res[1], $res[2]);
                $source .= "\n";
                $source .= $this->setterTemplate($res[0], $res[1]);
                $source .= "\n";
            }
            $index++;
        }
        echo $source;
    }

    private function getterTemplate(string $param_name, string $mold, string $not_null_string = ""): string
    {
        $method_name = sprintf("get%s", $this->convCamelize($param_name));
        $null_flag = ($not_null_string === "") ? "?" : "";

        $template = <<< EOF
        /**
         * getter
         * @return ${mold}
        */
        public function ${method_name}(): {$null_flag}{$mold}
        {
            return \$this->${param_name};
        }

EOF;
        return $template;
    }

    private function setterTemplate(string $param_name, string $mold): string
    {
        $method_name = sprintf("set%s", $this->convCamelize($param_name));

        $template = <<< EOF
        /**
         * setter
         * @param {$mold} \${$param_name}
         */
        public function {$method_name}({$mold} \$${param_name})
        {
            \$this->${param_name} = \$${param_name};
        }

EOF;
        return $template;
    }

    private function convCamelize($str): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }
}
