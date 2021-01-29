<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP;

class ReportController extends Controller
{
    /**
     * Reporna um array com os parametros de conexão
     * @return Array
     */
    public function getDatabaseConfig()
    {
        return [
            'driver' => 'postgres',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
            'jdbc_driver' => 'org.postgresql.Driver',
            'jdbc_url' => 'jdbc:postgresql://'.env('DB_HOST').':5432/'.env('DB_DATABASE'),
            'jdbc_dir' => base_path() . env('JDBC_DIR', '/vendor/cossou/jasperphp/src/JasperStarter/jdbc'),
        ];
    }

    public function index()
    {
        //Extenção do relatório
        $extencao = 'pdf';

        //Nome do arquivo
        $nome = 'file_reports_jasper';

        // Nome do arquivo
        $fileName = $nome . time();

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/reports/' . $fileName;

        //Compila o arquivo jrxml
        $compile = JasperPHP::compile(public_path() . '/reports/visitantes.jrxml')->execute();

        //Executa o arquivo de relatorio
        $process = JasperPHP::process(
            public_path() . '/reports/visitantes.jasper',
            $output,
            array($extencao),
            array(),
            $this->getDatabaseConfig()
        )->execute();


        $file = $output . '.' . $extencao;
        $path = $file;


        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);

        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        unlink($path);

        // Se a extenção for PDF exibir na tela
        if ($extencao == 'pdf') {
            return response($file, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="testeJasper.pdf"');
        }

    }
}
