<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CargosMinisteriais;
use App\Models\City;
use App\Models\Departments;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Profession;
use App\Models\Schooling;
use App\Models\SituacoesMembro;
use App\Models\State;
use App\Models\TiposCadastros;
use App\Models\User;
use App\Models\UserDetail;
use App\Notifications\NovoMembroNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MembroController extends Controller
{
    public function inserir(Request $request)
    {
        $chars = array(".", "/", "-", "(", ")");
        $cpf = str_replace($chars, "", $request->form['cpf']);
        $cep = str_replace($chars, "", $request->endereco['cep']);
        $telefone = $request->form['phone'];

        try {
            $validator = Validator::make(array('cpf' => $cpf, 'email' => $request->form['email']), [
                'cpf' => 'required|unique:user_details|cpf|max:11',
                'email' => 'required|unique:users',
            ]);


            if ($validator->fails()) {
                $response_json = [
                    "code" => "REG003",
                    "msg" => "Um erro ocorreu na validação dos campos.",
                    "erros" => $validator->errors()->all()
                ];
                return response()->json($response_json, 422);

            }


            $state = State::where('uf', $request->endereco['uf'])->first();
            $city = City::where('name', $request->endereco['localidade'])->first(); //Cidade

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->form['name'];
            $user->email = $request->form['email'];
            $user->matricula = $user->getMatriculaMembro();
            $user->status_id = $request->form['status_id'];
            $user->password = Hash::make($cpf);

            if ($user->save()) {
                $address = new Address();
                $address->cep = $cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->endereco['logradouro'];
                $address->number = $request->endereco['numero'];
                $address->neighborhood = $request->endereco['bairro'];
                $address->user_id = $user->id;

                if ($address->save()) {
                    $user_detail = new UserDetail();
                    $user_detail->user_id = $user->id;
                    $user_detail->tipo_cadastro_id = $request->form['tipo_cadastro_id'];
                    $user_detail->data_nascimento = Carbon::createFromFormat('d/m/Y', $request->form['data_nascimento']);
                    $user_detail->cpf = $cpf;
                    $user_detail->rg = $request->form['rg'];
                    $user_detail->gender_id = $request->form['gender_id'];
                    $user_detail->profession_id = $request->form['profession_id'];
                    $user_detail->phone = $telefone;
                    $user_detail->marital_status_id = $request->form['marital_status_id'];
                    $user_detail->nome_conjuge = $request->form['nome_conjuge'];
                    $user_detail->nome_pai = $request->form['nome_pai'];
                    $user_detail->nome_mae = $request->form['nome_mae'];
                    $user_detail->data_conversao = ($request->form['data_conversao'] !== null) ? Carbon::createFromFormat('d/m/Y', $request->form['data_conversao']) : null;
                    $user_detail->data_batismo = ($request->form['data_batismo'] !== null) ? Carbon::createFromFormat('d/m/Y', $request->form['data_batismo']) : null;
                    $user_detail->schooling_id = $request->form['schooling_id'];
                    $user_detail->forma_ingresso_id = $request->form['forma_ingresso_id'];
                    $user_detail->observacao = $request->form['observacao'];
                    $user_detail->igreja_id = $request->form['igreja_id'];
                    $user_detail->endereco_id = $address->id;

                    if ($request->form['tipo_cadastro_id'] == 1) {
                        $state_naturalidade = State::where('uf', $request->form['uf_naturalidade'])->first();
                        $cidade_naturalidade = City::where('name', $request->form['cidade_naturalidade'])->first();

                        $user_detail->cargo_ministerial_id = $request->form['cargo_ministerial_id'];
                        $user_detail->uf_naturalidade_id = $state_naturalidade->id;
                        $user_detail->cidade_naturalidade_id = $cidade_naturalidade->id;
                        $user_detail->data_consagracao = ($request->form['data_consagracao'] !== null) ? Carbon::createFromFormat('d/m/Y', $request->form['data_consagracao']) : null;
                        $user_detail->curso_teologico_id = $request->form['curso_teologico_id'];
                        $user_detail->convencao_igreja = $request->form['convencao_igreja'];
                        $user_detail->cod_comadebg = $request->form['cod_comadebg'];
                        $user_detail->cod_cgadb = $request->form['cod_cgadb'];
                        $user_detail->situacao_ministerio_id = $request->form['situacao_ministerio_id'];
                    }
                    $user->igreja()->attach($request->form['igreja_id']);

                    $departaments = $request->form['departments'];
                    $trusts = $request->form['trusts'];

                    $depCount = (is_array($departaments) ? count($departaments) : 0);
                    if ($depCount > 0) {
                        $DepartamntosIds = [];
                        foreach ($departaments as $key => $departament) {
                            $DepartamntosIds[$key] = $departament['id'];
                        }
                        $user->departments()->attach($DepartamntosIds);
                    }

                    $truCount = (is_array($trusts) ? count($trusts) : false);
                    if ($truCount > 0) {
                        $TrustsIds = [];
                        foreach ($trusts as $key => $trust) {
                            $TrustsIds[$key] = $trust['id'];
                        }
                        $user->trusts()->attach($TrustsIds);
                    }

                    if ($user_detail->save()) {
                        $user->notify(new NovoMembroNotification());
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Membro cadastrado com sucesso!',
                            'user' => $user
                        ]);
                    }
                }
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function editar(Request $request)
    {
        $chars = array(".", "/", "-", "(", ")");
        $cpf = str_replace($chars, "", $request->form['cpf']);
        $cep = str_replace($chars, "", $request->endereco['cep']);
        $telefone = $request->form['phone'];

        try {

            $state = State::where('uf', $request->endereco['uf'])->first();
            $city = City::where('name', $request->endereco['localidade'])->first(); //Cidade

            DB::beginTransaction();

            $user = User::find($request->form['user_id']);


            $user->name = $request->form['name'];
            $user->email = $request->form['email'];
            $user->matricula = $user->getMatriculaMembro();
            $user->status_id = $request->form['status_id'];
            $user->password = Hash::make($cpf);

            if ($user->save()) {

                $address = Address::find($request->form['user_id']);
                $address->cep = $cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->endereco['logradouro'];
                $address->number = $request->endereco['numero'];
                $address->neighborhood = $request->endereco['bairro'];
                $address->user_id = $user->id;

                if ($address->save()) {
                    $user_detail = UserDetail::find($request->form['user_id']);
                    $user_detail->tipo_cadastro_id = $request->form['tipo_cadastro_id'];
                    $user_detail->data_nascimento = Carbon::createFromFormat('d/m/Y', $request->form['data_nascimento']);
                    $user_detail->cpf = $cpf;
                    $user_detail->rg = $request->form['rg'];
                    $user_detail->gender_id = $request->form['gender_id'];
                    $user_detail->profession_id = $request->form['profession_id'];
                    $user_detail->phone = $telefone;
                    $user_detail->marital_status_id = $request->form['marital_status_id'];
                    $user_detail->nome_conjuge = $request->form['nome_conjuge'];
                    $user_detail->nome_pai = $request->form['nome_pai'];
                    $user_detail->nome_mae = $request->form['nome_mae'];
                    $user_detail->data_conversao = (Carbon::createFromFormat('d/m/Y', $request->form['data_conversao']) !== null ? Carbon::createFromFormat('d/m/Y', $request->form['data_conversao']) : null);
                    $user_detail->data_batismo = (Carbon::createFromFormat('d/m/Y', $request->form['data_batismo']) !== null ? Carbon::createFromFormat('d/m/Y', $request->form['data_batismo']) : null);
                    $user_detail->schooling_id = $request->form['schooling_id'];
                    $user_detail->forma_ingresso_id = $request->form['forma_ingresso_id'];
                    $user_detail->observacao = $request->form['observacao'];
                    $user_detail->igreja_id = $request->form['igreja_id'];
                    $user_detail->endereco_id = $address->id;

                    if ($request->form['tipo_cadastro_id'] == 1) {
                        $state_naturalidade = State::where('uf', $request->form['uf_naturalidade'])->first();
                        $cidade_naturalidade = City::where('name', $request->form['cidade_naturalidade'])->first();

                        $user_detail->cargo_ministerial_id = $request->form['cargo_ministerial_id'];
                        $user_detail->uf_naturalidade_id = $state_naturalidade->id;
                        $user_detail->cidade_naturalidade_id = $cidade_naturalidade->id;
                        $user_detail->data_consagracao = (Carbon::createFromFormat('d/m/Y', $request->form['data_consagracao']) !== null ? Carbon::createFromFormat('d/m/Y', $request->form['data_consagracao']) : null);
                        $user_detail->curso_teologico_id = $request->form['curso_teologico_id'];
                        $user_detail->convencao_igreja = $request->form['convencao_igreja'];
                        $user_detail->cod_comadebg = $request->form['cod_comadebg'];
                        $user_detail->cod_cgadb = $request->form['cod_cgadb'];
                        $user_detail->situacao_ministerio_id = $request->form['situacao_ministerio_id'];
                    }
                    $user->igreja()->sync($request->form['igreja_id']);


                    $departaments = $request->form['departments'];
                    $trusts = $request->form['trusts'];


                    $depCount = (is_array($departaments) ? count($departaments) : 0);
                    if ($depCount > 0) {
                        $DepartamntosIds = [];
                        foreach ($departaments as $key => $departament) {
                            $DepartamntosIds[$key] = $departament['id'];
                        }
                        $user->departments()->sync($DepartamntosIds);
                    }

                    $truCount = (is_array($trusts) ? count($trusts) : false);
                    if ($truCount > 0) {
                        $TrustsIds = [];
                        foreach ($trusts as $key => $trust) {
                            $TrustsIds[$key] = $trust['id'];
                        }
                        $user->trusts()->sync($TrustsIds);
                    }


                    if ($user_detail->save()) {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Membro atualizado com sucesso!',
                            'user' => $user
                        ]);
                    }
                }
            }


        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }


    }

    public function enviarNotification()
    {
        $user = Auth::user();
        $user->notify(new NovoMembroNotification());
    }

    public function visualizarMembroPorId($id)
    {
        $member = User::where('id', $id)->with('addresses',
            'details.profession',
            'details.departamentos',
            'details.cargos',
            'details.igreja.setor',
            'details.endereco')->first();

        return response()->json($member);
    }

    public function getTiposCadastros()
    {
        $tipos_cadastros = TiposCadastros::all();
        return response()->json($tipos_cadastros);
    }

    public function getCargosMinisteriais()
    {
        $cargos = CargosMinisteriais::all();
        return response()->json($cargos);
    }

    public function desativarMembro(Request $request)
    {
        $membro = User::find($request->id_membro);
        if ($membro->delete()) {
            DB::table('users')->where('id', $membro->id)->update(['status_id' => Config::get('constants.USER.MEMBRO_INATIVO')]);
            return response()->json($membro);
        }
        return false;
    }

    public function situacoesMembros()
    {
        $situacoesMembro = SituacoesMembro::all();
        return response()->json($situacoesMembro);
    }

    public function getTesoureiros(Request $request)
    {
        dd($request->all());
    }

    public function getTiposEstadoCivil()
    {
        $maritalStatus = MaritalStatu::all();
        return response()->json($maritalStatus);
    }

    public function getGeneros()
    {
        $genders = Gender::all();
        return response()->json($genders);
    }

    public function getNiveisEscolaridade()
    {
        $schoolings = Schooling::all();
        return response()->json($schoolings);
    }

    public function getCadastroCpf(Request $request)
    {
        $chars = array(".", "/", "-", "(", ")");
        $cpf = str_replace($chars, "", $request->cpf);
        $userDetail = UserDetail::where('cpf', $cpf)->first();

        if ($userDetail) {
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function getNumeroMembros()
    {
        $users = User::get();
        $UsersCount = $users->count();
        return response()->json(['quantidade' => $UsersCount], 200);
    }

    public function getAniversariantes()
    {
        $doMes = now()->format('m');
        $dados = UserDetail::aniversariantesEntre('' . $doMes . '-01', '' . $doMes . '-31')->get();

        $total = $dados->count();

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dt = Carbon::now();
        $mes = $dt->formatLocalized('%B');

        return response()->json(['detalhes' => $dados, 'mesAtual'=> $mes, 'total'=> $total], 200);
    }

}
