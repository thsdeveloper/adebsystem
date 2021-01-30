<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JasperPHP;
use PdfReport;
use PHPJasper\PHPJasper;

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
            'jdbc_url' => 'jdbc:postgresql://' . env('DB_HOST') . ':5432/' . env('DB_DATABASE'),
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
        Log::info($fileName);

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/reports/' . $fileName;
        Log::info($output);

        //Compila o arquivo jrxml
        $compile = JasperPHP::compile(public_path() . '/reports/visitantes.jrxml')->execute();
        dd($compile);

        //Executa o arquivo de relatorio
        $process = JasperPHP::process(public_path() . '/reports/visitantes.jasper', $output, array($extencao), array('DescricaoNome' => 'Thiago'), $this->getDatabaseConfig())->execute();
        Log::info($process);


        $file = $output . '.' . $extencao;
        $path = $file;
        Log::info($path);


//        if (!file_exists($file)) {
//            abort(404);
//        }
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);


        //deleto o arquivo gerado, pois iremos mandar o conteudo para o navegador
        $excluiArquivo = unlink($path);
        Log::info($excluiArquivo);


        // Se a extenção for PDF exibir na tela
        if ($extencao == 'pdf') {
            return response($file, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="testeJasper.pdf"');
        }

    }

    public function displayReport(Request $request)
    {
        $fromDate = '2021-01-19 23:56:02';
        $toDate = '2021-01-28 20:20:26';
        $sortBy = 'nome';

        $title = 'Lista de Visitantes'; // Report title

        $meta = [ // For displaying filters description on header
            'Registered on' => $fromDate . ' To ' . $toDate,
            'Por ordem de' => $sortBy
        ];

        $queryBuilder = Visitante::select(['nome', 'email', 'evangelico', 'created_at']) // Do some querying..
        ->whereBetween('created_at', [$fromDate, $toDate])
            ->where('apresentado', '=', false)
            ->where('autoriza_apresentacao', '=', true)
            ->orderBy($sortBy);

        $columns = [ // Set Column to be displayed
            'Nome:' => 'nome',
            'Data do Cadastro:' => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            'Email:' => 'email',
            'Evangélico?' => function ($result) { // You can do if statement or any action do you want inside this closure
                return ($result->evangelico === true) ? 'Sim' : 'Não';
            }
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->setPaper('a4')
            ->editColumn('Registered At', [ // Change column class or manipulate its data for displaying to report
                'created_at' => function ($result) {
                    return $result->registered_at->format('d M Y');
                },
                'class' => 'left'
            ])
            ->editColumns(['Total Balance', 'Status'], [ // Mass edit column
                'class' => 'right bold'
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'Total Balance' => 'point' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->showMeta(false)
//            ->showHeader(false)
            ->limit(20) // Limit record to be showed
            ->showNumColumn(false)
            ->setCss([
                '.bolder' => 'font-weight: 300;',
                '.italic-red' => 'color: red;font-style: italic;'
            ])
//            ->setOrientation('landscape')
//            ->withoutManipulation()
            ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function relatorio3()
    {
        //Extenção do relatório
        $extencao = 'pdf';

        //Nome do arquivo
        $nome = 'visitantes';

        // Nome do arquivo
        $fileName = $nome . time();

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/reports/visitantes';


        $input = public_path() . '/reports/visitantes.jrxml';
        $jasper = new PHPJasper;
        $jasper->compile($input, $output)->execute();


        $input = public_path() . '/reports/visitantes.jasper';
        $output = public_path() . '/reports/';
        $options = [
            'format' => ['pdf']
        ];


         $jasper->process(
            $input,
            $output,
            $options
        )->execute();

        $file = $output . 'visitantes.pdf';
//        $path = $file;

        $file = file_get_contents($file);
//        dd($file);

        // Se a extenção for PDF exibir na tela
        if ($extencao == 'pdf') {
            return response($file, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="visitantes.pdf"');
        }
    }
}
