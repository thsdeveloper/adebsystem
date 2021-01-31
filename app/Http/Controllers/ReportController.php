<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use PHPJasper\PHPJasper;

class ReportController extends Controller
{
    private function getDataBaseConections()
    {
        $DATABASE_URL = parse_url(getenv("DATABASE_URL"));

        if (!App::environment('local')) {
            return [
                'driver' => 'postgres',
                'username' => env('DB_USERNAME', $DATABASE_URL['user']),
                'password' => env('DB_PASSWORD', $DATABASE_URL['pass']),
                'host' => env('DB_HOST', $DATABASE_URL['host']),
                'database' => env('DB_DATABASE', ltrim($DATABASE_URL['path'], '/')),
                'port' => env('DB_PORT', $DATABASE_URL['port']),
            ];
        }
        return [
            'driver' => 'postgres',
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'port' => env('DB_PORT'),
        ];
    }

    public function relatorioVisitantes()
    {
        //Extenção do relatório
        $extencao = 'pdf';

        //Nome do arquivo
        $nome = 'file_reports';

        // Nome do arquivo com time
        $fileName = $nome;

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/reports/' . $fileName;


        //Compila o arquivo jrxml
        $jasper = new PHPJasper;
        $jasper->compile(public_path() . '/reports/visitantes.jrxml', $output)->execute();

        $ArquivoJasper = public_path() . '/reports/' . $fileName . '.jasper';

        //Options do process
        $options = [
            'format' => ['pdf'],
            'params' => ['DescricaoNome' => 'Thiago'],
            'db_connection' => $this->getDataBaseConections(),
        ];


        //Executa o arquivo de relatorio
        $jasper->process($ArquivoJasper, $output, $options)->execute();

        $file = $output . '.' . $extencao;
        $path = $file;


        if (!file_exists($file)) {
            abort(404);
        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);


        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
//        $excluiArquivoPDF = unlink($path);
        $excluiArquivoJasper = unlink($output . '.jasper');

        if ($excluiArquivoJasper) {
            //Se a extenção for PDF exibir na tela
            if ($extencao == 'pdf') {
                return response($file, 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="testeJasper.pdf"');
            }
        }


    }
}
